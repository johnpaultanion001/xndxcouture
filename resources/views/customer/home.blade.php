@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-5" style="
background: #0F2027;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #2C5364, #203A43, #0F2027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">
    <div class="container px-4 px-lg-5 my-2">
        <div class="text-center text-white">
            
            <p class="lead fw-normal text-white mb-0">All Productss</p>
            <br>
            <div class="row">
                    <div class="col-10 mx-auto">
                        <input type="text" id="search-bar" placeholder="Find a product?">
                        <img class="search-icon" src="{{URL::asset('/assets/img/search-icon.png')}}">
                        <br>
                        <br>
                        <h6 class="text-uppercase">Select a category</h6>
                       @foreach($categories as $category)
                           <button class="btn btn-primary btn-sm filter_category text-uppercase" filter="category" category_id="{{$category->id}}">{{$category->name ?? ''}}</button>
                       @endforeach<br><br>
                            <button class="btn btn-success btn-sm filter_category text-uppercase" filter="onhand">Products</button>
                            <button class="btn btn-info btn-sm filter_category text-uppercase text-white" filter="new_arrivals">New Arrivals</button>
                            
                            

                            <br><br>
                    </div>
                </div>
        </div>
    </div>
</header>
<section class="py-5" style="margin-top: -100px; min-height: 60vh;" >
        <div class="card" style="border: 1px solid #111;">
            <div class="card-body">
                
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-5 justify-content-center" id="product_list">
                    @foreach($products as $product)
                        <div class="col mb-5">
                            <div class="card h-100">
                               
                                <div class="badge bg-dark text-white position-absolute text-uppercase" style="top: 0.5rem; right: 0.5rem">{{$product->category->name ?? ''}}</div>
                              
                                <!-- Product image-->
                                <img class="card-img-top" width="200" height="190" src="/assets/img/products/{{$product->image ?? ''}}" alt="{{$product->image ?? ''}}" />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">{{$product->name ?? ''}}</h5>
                                        <small class="fw-bolder">{{$product->description ?? ''}}</small> <br>
                                        <small class="fw-bolder">₱ {{$product->unit_price ?? ''}}</small>
                                        <!-- Product price-->
                                        
                                        
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><button class="btn btn-primary mt-auto order" product_id="{{$product->id}}">ORDER</button></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
</section>

<form method="post" id="myForm">
    @csrf
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">PRODUCT DETAIL</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-primary"></i>
                 </button>
    
                </div>
                <div class="modal-body">
                  <div class="col-xl-12">
                    <div class="card ">
                        <div class="card-body p-4 row">
                            <div class="col-md-6">
                                
                                <div class="badge bg-dark text-white position-absolute text-uppercase" id="category" style="top: 0.5rem; right: 1.5rem">Category</div>
                                <img class="card-img-top" id="image" height="250" src="data:image/jpeg;base64,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" alt="IMAGE PRODUCT" />
                            </div>
                            <div class="col-md-6 mx-auto">
                                    <h5 class="fw-bolder" id="product_name">Product Name</h5>
                                    <small class="fw-bolder" id="description">Description</small> 
                                    <br>
                                    <small class="fw-bolder" id="price"></small>
                                    <br>
                                    <small class="fw-bolder" id="stock"></small>
                                    <br>
                            </div>
                            <div class="form-group mt-2">
                                <h6>QTY <span class="text-danger">*</span></h6>
                                <input type="number" name="qty" id="qty" class="form-control disabled" onfocus="focused(this)" onfocusout="defocused(this)">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-qty"></strong>
                                </span>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">CANCEL</button>
                    <input type="submit" name="action_button" id="action_button" class="btn  btn-primary" value="ORDER"/>
                </div>
            </div>
        </div>
    </div>
</form>

<footer class="text-white" style=" background: #0F2027;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #2C5364, #203A43, #0F2027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    " >
    <div class="container" >
        <div class= "row">
            <div class="col-2 p-1 pt-3">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/002/423/246/small/illustration-front-view-of-bull-head-surrounded-by-flames-it-is-signs-of-the-taurus-zodiac-good-use-for-symbol-mascot-icon-avatar-tattoo-t-shirt-design-logo-or-any-design-free-vector.jpg" alt="" width = "80%">
            </div>
            <div class="col-3 p-1 pt-3">
            <h1>{{ trans('panel.site_title') }}</h1>
            <p>testing test test test</p >
            </div>
            <div class="col-3 p-3 pt-3">
                <h1></h1>
                <h1></h1>
                <h1></h1>
            </div>
            <div class="col-3 p-3 pt-3">
                <h3>Contact us</h3>
                <a href="/"><img src="assets/img/Facebook-logo.webp" alt="" style = "width:20%;margin-left:-11px;">Facebook</a>
                <br>
                <a href="/"><img src="assets/img/instagram-Logo-PNG-Transparent-Background-download.webp" alt="" style = "width:14%;">Instagram</a>
                <br>
                <img src="assets/img/phone_logo.webp" alt="" style = "width:13%">+63-9516439050
            </div>
        </div>
    </div>
    <div class="copyright text-center text-sm text-white text-lg-center">
        © <script>
            document.write(new Date().getFullYear())
        </script>,
        Copyright {{ trans('panel.site_title') }} All Rights Reserved
    </div>
</footer>
@endsection

@section('script')
<script>
    var product_id = null;

    $(document).on('click', '.order', function(){
        $('#formModal').modal('show');
        $('#myForm')[0].reset();
        $('.form-control').removeClass('is-invalid');
        product_id = $(this).attr('product_id');

        $.ajax({
            url :"/customer/product/"+product_id,
            dataType:"json",
            beforeSend:function(){
                $("#action_button").attr("disabled", true);
                $("#action_button").attr("value", "LOADING..");  
            },
            success:function(data){
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "ORDER");
                $.each(data.product, function(key,value){
                    if(key == 'name'){
                        $('#product_name').text(value)
                    }
                    if(key == 'description'){
                        $('#description').text(value)
                    }
                    if(key == 'price'){
                        $('#price').text(value)
                    }
                    if(key == 'stock'){
                        $('#stock').text(value)
                    }
                   
                    if(key == 'category'){
                        $('#category').text(value)
                    }
                    
                    if(key == 'status_color'){
                        $('#status').removeClass(value);
                        $('#status').addClass(value);
                    }
                    
                    if(key == 'image'){
                        $('#image').attr("src", '/assets/img/products/' + value);
                    }
                })
               
                
            },
            error:function(){
                window.location.href = "/login";
            } 
        })

    });

    $('#formModal').on('shown.bs.modal', function () {
        $('#qty').focus();
    }) 

    $('#myForm').on('submit', function(event){
        event.preventDefault();
        $('.form-control').removeClass('is-invalid')

        $.ajax({
            url :"/customer/product/"+product_id,
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            beforeSend:function(){
                $("#action_button").attr("disabled", true);
                $("#action_button").attr("value", "LOADING..");  
            },
            success:function(data){
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "ORDER");

                if(data.errors){
                    $.each(data.errors, function(key,value){
                        if(key == $('#'+key).attr('id')){
                            $('#'+key).addClass('is-invalid')
                            $('#error-'+key).text(value)
                        }
                    })
                }
                if(data.errorstock){
                    $('#qty').addClass('is-invalid');
                    $('#error-qty').text(data.errorstock);
                }
                if(data.success){
                    $.confirm({
                    title: 'Confirmation',
                    content: data.success,
                    type: 'green',
                    buttons: {
                            
                            order: {
                                text: 'Order Again',
                                btnClass: 'btn-blue',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    location.reload();
                                }
                            },

                            checkout: {
                                text: 'Check Out',
                                btnClass: 'btn-primary',
                                action: function(){
                                    window.location.href = "/customer/orders";
                                }
                            },
                        }
                    });
                }
               
            },
        });
    });


    $('#search-bar').on("input", function() {
        var filter = 'search';
        var value = this.value;

        $.ajax({
        url: "/product/filter", 
        type: "get",
        dataType:"json",
        data: {
            filter:filter, value:value ,_token: '{!! csrf_token() !!}',
        },
        beforeSend: function() {
            
        },
        success: function(data){
                if(data.products){
                        var products = '';
                        $.each(data.products, function(key,value){
                            products += '<div class="col mb-5">'
                                products += '<div class="card h-100">'
                                    products += '<div class="badge  '+value.status_color+' text-white position-absolute text-uppercase" style="top: 0.5rem; left: 0.5rem">'+value.status+'</div>'
                                    products += '<div class="badge bg-dark text-white position-absolute text-uppercase" style="top: 0.5rem; right: 0.5rem">'+value.category+'</div>'
                                    products += '<img class="card-img-top" width="200" height="190" src="/assets/img/products/'+value.image+'" alt="'+value.image+'" />'
                                        products += '<div class="card-body p-4">'
                                            products += '<div class="text-center">'
                                                products += '<h5 class="fw-bolder">'+value.name+'</h5>'
                                                products += '<small class="fw-bolder">'+value.description+'</small> <br>'
                                                products += '<small class="fw-bolder"> ₱ '+value.price+'</small>'
                                            products += '</div>'
                                        products += '</div>'
                                    products += '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">'
                                    products += '<div class="text-center"><button class="btn btn-primary mt-auto order" product_id="'+value.id+'">ORDER</button></div>'
                                    products += '</div>'
                                products += '</div>'
                            products += '</div>'
                            
                        });
                        $('#product_list').empty().append(products);
                    }
                },
            });
    });


    $('.filter_category').on("click", function(event){
        var filter = $(this).attr('filter');
        var value = $(this).attr('category_id');

        $.ajax({
        url: "/product/filter", 
        type: "get",
        dataType:"json",
        data: {
            filter:filter, value:value ,_token: '{!! csrf_token() !!}',
        },
        beforeSend: function() {
            
        },
        success: function(data){
                    if(data.products){
                        var products = '';
                        $.each(data.products, function(key,value){
                            products += '<div class="col mb-5">'
                                products += '<div class="card h-100">'
                                    products += '<div class="badge  '+value.status_color+' text-white position-absolute text-uppercase" style="top: 0.5rem; left: 0.5rem">'+value.status+'</div>'
                                    products += '<div class="badge bg-dark text-white position-absolute text-uppercase" style="top: 0.5rem; right: 0.5rem">'+value.category+'</div>'
                                    products += '<img class="card-img-top" width="200" height="190" src="/assets/img/products/'+value.image+'" alt="'+value.image+'" />'
                                        products += '<div class="card-body p-4">'
                                            products += '<div class="text-center">'
                                                products += '<h5 class="fw-bolder">'+value.name+'</h5>'
                                                products += '<small class="fw-bolder">'+value.description+'</small> <br>'
                                                products += '<small class="fw-bolder"> ₱ '+value.price+'</small>'
                                            products += '</div>'
                                        products += '</div>'
                                    products += '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">'
                                    products += '<div class="text-center"><button class="btn btn-primary mt-auto order" product_id="'+value.id+'">ORDER</button></div>'
                                    products += '</div>'
                                products += '</div>'
                            products += '</div>'  
                        });
                        $('#product_list').empty().append(products);
                    }
                  
                },
            });
    });
    
</script>
@endsection






