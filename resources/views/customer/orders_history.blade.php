@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-2" style="
background: #0F2027;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #2C5364, #203A43, #0F2027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
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
                                                        <div class="badge ml-2  {{$product_order->product->status == 'ONHAND' ? 'bg-success':'bg-warning'}} text-white position-absolute text-uppercase">{{$product_order->product->status ?? ''}}</div>
                                                                    
                                                            
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
                    <input type="submit" name="action_button" id="action_button" class="btn  btn-primary" value="CANCEL"/>
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


</script>
@endsection






