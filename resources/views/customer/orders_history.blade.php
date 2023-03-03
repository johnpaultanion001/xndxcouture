@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-2 banner">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center">
            <h4 class="">ORDERS HISTORY</h4>
        </div>
    </div>
</header>

<section class="py-5" >
    <div class="row m-2">
        <div class="col-md-6 mt-4 mx-auto">
            
            <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3 bg-warning">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-0 text-uppercase text-white">Your Pending Orders</h6>
                            </div>
                        
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                @forelse($orders as $order)
                                    <li class="list-group-item ">
                                        <div class=" row">
                                            <div class="col-md-6">
                                                <h6 class="mb-1 text-dark text-sm">
                                                    @foreach($order->orderproducts as $product_order)
                                                        <span class="badge bg-warning">{{$product_order->qty ?? ''}} {{$product_order->product->name ?? ''}} * {{$product_order->price ?? ''}} = {{$product_order->amount ?? ''}} </span>
                                                        <div class="badge ml-2  {{$product_order->product->status == 'ONHAND' ? 'bg-success':'bg-warning'}} text-white position-absolute text-uppercase">{{$product_order->product->status ?? ''}}</div>

                                                        <br>
                                                    @endforeach
                                                </h6>
                                                <h6 class="text-xs text-uppercase"> {{ $order->created_at->format('M j , Y h:i A') }}</h6>
                                                
                                               
                                            </div>
                                            <div class="col-md-6">
                                                <h6  class="text-s mt-2">SUBTOTAL: <span class="text-primary"> ₱  {{number_format($order->orderproducts->sum->amount?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2">SHIPPING FEE: <span class="text-primary"> ₱  {{number_format($order->shipping_fee ?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2">TOTAL: <span class="text-primary"> ₱  {{number_format($order->total_amount ?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2 text-uppercase">SHIPPING OPTIONS:   <span class="badge bg-primary"> {{$order->shipping_option}} </span></h6>
                                                <h6  class="text-s mt-2 text-uppercase">PAYMENT OPTIONS:   <span class="badge bg-primary"> {{$order->payment_option}} </span></h6>
                                                <h6  class="text-s mt-2 text-uppercase">PAYMENT STATUS:   
                                                    <span class="badge 
                                                    @if($order->payment_status == 'PAID')
                                                        bg-success 
                                                    @elseif($order->payment_status == 'DECLINED')
                                                        bg-danger 
                                                    @else 
                                                        bg-warning 
                                                    @endif">{{$order->payment_status}} </span>
                                                </h6>
                                                @if($order->payment_option == 'GCASH')
                                                <h6  class="text-s mt-2 text-uppercase">uploaded receipt:   <a target="_blank" href="/assets/img/resibo/{{$order->payment_receipt ?? ''}}">{{$order->payment_receipt ?? ''}}</a></h6>
                                                @endif
                                                <button class="btn btn-danger btn-sm cancel" cancel="{{$order->id}}">CANCEL</button>
                                            </div>
                                            
                                            
                                        </div>
                                        
                                    </li>
                                    <hr>
                                @empty
                                <div class="text-center">
                                    <h6 class="mb-0">NO PENDING ORDER FOUND</h6>
                                </div>
                                @endforelse
                            </ul>
                    </div>
            </div>
        </div>

        <div class="col-md-6 mt-4 mx-auto">
            
            <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3 bg-success">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-0 text-uppercase text-white">Your Approved Orders</h6>
                            </div>
                        
                        </div>
                    </div>
                    <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                @forelse($orders_approved as $order)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="mb-1 text-dark text-sm">
                                                        @foreach($order->orderproducts as $product_order)
                                                            <span class="badge bg-success">{{$product_order->qty ?? ''}} {{$product_order->product->name ?? ''}} * {{$product_order->price ?? ''}} = {{$product_order->amount ?? ''}}</span> 
                                                            <br> 
                                                        @php
                                                            $isStar = App\Models\Review::where('order_id', $product_order->order_id)->where('product_id', $product_order->product->id ?? '')
                                                                                            ->where('user_id', auth()->user()->id)->first();
                                                        @endphp
                                                        <a id="reviews_count{{$product_order->product->id ?? ''}}" class="link-primary" data-toggle="collapse" href="#collapseExample{{$product_order->product->id ?? 
                                                        ''}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                            {{$isStar == null ? 'Add your review':'Edit your review'}}   
                                                        </a>      
                                                         <br>
                                                        <div class="collapse mt-3" id="collapseExample{{$product_order->product->id ?? ''}}">
                                                            <div class="card card-body text-left">
                                                                <form method="post" class="myReviewForm">
                                                                    @csrf
                                                                    <div class="input-group">
                                                                        
                                                                        <i class="bi bi-star-fill m-3 isStar {{$isStar->isStar ?? '' == true ? 'text-warning':''}}" product_id="{{$product_order->product->id ?? ''}}" id="isStarIcon{{$product_order->product->id ?? ''}}" style="cursor: pointer;"></i>
                                                                        <input type="hidden" class="form-control" id="isStar{{$product_order->product->id ?? ''}}" name="isStar"  value="{{$isStar->isStar ?? '0'}}" readonly>
                                                                        <input type="text" class="form-control review" name="review" placeholder="Enter a message" required>
                                                                        <input type="hidden" class="form-control" name="product_id" value="{{$product_order->product->id ?? ''}}" readonly>
                                                                        <input type="hidden" class="form-control" name="order_id" value="{{$product_order->order_id}}" readonly>
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><button  type="submit" class="btn text-primary" style="background-color:transparent;" >SUBMIT</button></span>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <div id="review_section{{$product_order->product->id ?? ''}}" style="max-height: 300px; overflow-y : auto;">
                                                                        @if($product_order->product->reviews()->count() < 1)
                                                                        <hr>
                                                                            <b> NO REVIEW FOUND</b>  <br>
                                                                        @else
                                                                        @foreach($product_order->product->reviews()->get() as $review)
                                                                        <hr>
                                                                            <div class="row">
                                                                                <div class="col-2">
                                                                                    <i class="bi bi-star-fill m-3 {{$review->isStar == true ? 'text-warning':''}}"></i>
                                                                                </div>
                                                                                <div class="col-10">
                                                                                    <b> {{$review->user->name ?? ''}}</b>  <br>
                                                                                    <h6>{{$review->review ?? ''}}</h6> <br>
                                                                                    <small class="mb-0">{{$review->created_at->diffForHumans()}}</small>
                                                                                </div>
                                                                            </div>
                                                                           
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>                          
                                                        @endforeach
                                                    </h6>
                                                    <h6 class="text-xs text-uppercase"> {{ $order->created_at->format('M j , Y h:i A') }}</h6>
                                                    
                                                    <button type="button" receipt="{{  $order->id ?? '' }}" 
                                                    class="btn btn-sm btn-success receipt">
                                                    RECEIPT
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <h6  class="text-s mt-2">SUBTOTAL: <span class="text-primary"> ₱  {{number_format($order->orderproducts->sum->amount?? '' , 2, '.', ',')}}</span> </h6>
                                                 <h6  class="text-s mt-2">SHIPPING FEE: <span class="text-primary"> ₱  {{number_format($order->shipping_fee ?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2">TOTAL: <span class="text-primary"> ₱  {{number_format($order->total_amount ?? '' , 2, '.', ',')}}</span> </h6>
                                                <h6  class="text-s mt-2 text-uppercase">SHIPPING OPTIONS:   <span class="badge bg-primary"> {{$order->shipping_option}} </span></h6>
                                                <h6  class="text-s mt-2 text-uppercase">PAYMENT OPTIONS:   <span class="badge bg-primary"> {{$order->payment_option}} </span></h6>
                                                <h6  class="text-s mt-2 text-uppercase">PAYMENT STATUS:   
                                                    <span class="badge 
                                                    @if($order->payment_status == 'PAID')
                                                        bg-success 
                                                    @elseif($order->payment_status == 'DECLINED')
                                                        bg-danger 
                                                    @else 
                                                        bg-warning 
                                                    @endif">{{$order->payment_status}} </span>
                                                </h6>
                                                @if($order->payment_option == 'GCASH')
                                                <h6  class="text-s mt-2 text-uppercase">uploaded receipt:   <a target="_blank" href="/assets/img/resibo/{{$order->payment_receipt ?? ''}}">{{$order->payment_receipt ?? ''}}</a></h6>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        
                                    </li>
                                    <hr>
                                @empty
                                <div class="text-center">
                                    <h6 class="mb-0">NO APPROVED ORDER FOUND</h6>
                                </div>
                                @endforelse
                                
                            </ul>
                    </div>
            </div>
        </div>
    </div>
    
</section>

<form method="post" id="cancelForm">
    @csrf
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                CANCEL ORDER
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-primary"></i>
                </button>
    
                </div>
                <div class="modal-body">
                  <div class="col-xl-12">
                    <div class="card row">
                        <!-- Product details-->
                        <div class="card-body p-4">
                            
                                <div class="form-group">
                                    <h6>Cancel Reason? <span class="text-danger">*</span></h6>
                                    <textarea name="reason" id="reason"class="form-control"></textarea>
                                </div>
                               
                           
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="action_button" id="action_button" class="btn  btn-primary" value="SUBMIT"/>
                </div>
            </div>
        </div>
    </div>
</form>

<div  class="modal fade" id="receiptModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title-receipt">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times text-primary"></i>
            </button>

            </div>
            <div class="modal-body">
                <div id="receipt_data">

                </div>
                
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button type="button" class="btn btn-success" id="btn_print">Print</button>
                
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    

   var id = null;
   $(document).on('click', '.cancel', function(){
        id = $(this).attr('cancel');
        $('#cancelModal').modal('show');
        $('#cancelForm')[0].reset();
        $('.form-control').removeClass('is-invalid');
    });

    $('#cancelForm').on('submit', function(event){
        event.preventDefault();
        
        $.ajax({
            url: "/customer/orders/cancel/"+id,
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            beforeSend:function(){

            },
            success:function(data){
                $("#action_button").attr("disabled", false);
                
                if(data.errors){
                    $.each(data.errors, function(key,value){
                        if(key == $('#'+key).attr('id')){
                            $('#'+key).addClass('is-invalid')
                            $('#error-'+key).text(value)
                        }
                     
                    })
                }
                if(data.success){
                    $('.form-control').removeClass('is-invalid')
                  
                    $.confirm({
                    title: 'Confirmation',
                    content: data.success,
                    type: 'green',
                    buttons: {
                            confirm: {
                                text: 'confirm',
                                btnClass: 'btn-blue',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    location.reload();
                                }
                            },
                            
                        }
                    });
                    $('#cancelModal').modal('hide');
                }
            }
        });
    });

    $(document).on('click', '.receipt', function(){
    var id = $(this).attr('receipt');
    $('#receiptModal').modal('show');
    $.ajax({
        url :"/admin/orders/receipt/"+id,
        type: "get",
        dataType: "HTMl",
        beforeSend: function() {
            $('.modal-title-receipt').text('Loading Records...');
        },
        success: function(response){
            $('.modal-title-receipt').text('Receipt');
            $("#receipt_data").html(response);
        }	
    })
});

$(document).on('click', '#btn_print', function(){
    var contents = $("#receipt_data").html();
    var frame1 = $('<iframe />');
    frame1[0].name = "frame1";
    frame1.css({ "position": "absolute", "top": "-1000000px" });
    $("body").append(frame1);
    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
    frameDoc.document.open();
    //Create a new HTML document.
    frameDoc.document.write('<html><head><title>Title</title>');
    frameDoc.document.write('</head><body>');
    //Append the external CSS file. 
    frameDoc.document.write('<link href="/admin/css/material-dashboard.css" rel="stylesheet" type="text/css" />');
    frameDoc.document.write('<style>size: A5 portrait;</style>');
    var source = 'bootstrap.min.js';
    var script = document.createElement('script');
    script.setAttribute('type', 'text/javascript');
    script.setAttribute('src', source);
    //Append the DIV contents.
    frameDoc.document.write(contents);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function () {
    window.frames["frame1"].focus();
    window.frames["frame1"].print();
    frame1.remove();
    }, 500);
});

$(document).on('click', '.isStar', function(){
    var id = $(this).attr('product_id');
    if($('#isStar'+id).val() == 1){
        $('#isStar'+id).val('0');
        $('#isStarIcon'+id).removeClass('text-warning');
    }else{
        $('#isStar'+id).val('1');
        $('#isStarIcon'+id).addClass('text-warning');
    }
});

$('.myReviewForm').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url: "/customer/review",
            method:"GET",
            data:$(this).serialize(),
            dataType:"json",
            beforeSend:function(){

            },
            success:function(data){
                var reviews = '';
                $.each(data.reviews, function(key,value){
                    reviews += '<hr>';
                    reviews += '<div class="row">';
                        reviews += '<div class="col-2">'
                            if(value.isStar == true){
                                reviews += '<i class="bi bi-star-fill m-3 text-warning"></i>'
                            }else{
                                reviews += '<i class="bi bi-star-fill m-3"></i>'
                            }
                        reviews += '</div>'
                        reviews += '<div class="col-10">'
                            reviews += '<b>'+value.name+'</b> <br>';
                            reviews += '<h6>'+value.review+'</h6> <br>';
                            reviews += '<h6>'+value.date_time+'</h6> <br>';
                        reviews += '</div>'
                    reviews += '</div>';

                    
                                  
                });
                $('#review_section'+data.product_id).empty().append(reviews);
                $('.review').val('');
            }
        });
    });

</script>
@endsection






