@extends('../layouts.admin')
@section('sub-title','Orders')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-2">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-11">
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Orders</h4>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">RECEIPT</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ORDER ID</th>
                                    <th scope="col">PAYMENT OPTION</th>
                                    <th scope="col">SHIPPING OPTION</th>
                                    <th scope="col">SHIPPING FEE</th>
                                    <th scope="col">CUSTOMER NAME</th>
                                    <th scope="col">PRODUCT BUY</th>
                                    <th scope="col">AMOUNT</th>
                                    <th scope="col">ORDER AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <button type="button" name="status" status="{{  $order->id ?? '' }}"  action_type="STATUS"
                                                class="btn btn-sm 
                                                @if($order->status == 'PENDING')
                                                    btn-warning status
                                                @elseif($order->status == 'APPROVED')
                                                    btn-success status
                                                @else 
                                                    btn-danger
                                                @endif">
                                                {{$order->status}}
                                                
                                            </button>
                                            <br>
                                            @if($order->status == 'CANCELLED')
                                            <small> Reason of Cancel: {{$order->cancel_reason}}</small>
                                               
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status != 'CANCELLED')
                                                <button type="button" receipt="{{  $order->id ?? '' }}" 
                                                    class="btn btn-sm btn-success receipt">
                                                    RECEIPT
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status != 'CANCELLED')
                                                <button type="button" name="status" status="{{  $order->id ?? '' }}" action_type="PAID"
                                                    class="btn btn-sm 
                                                    @if($order->isPaid == true)
                                                        btn-success status
                                                    @else 
                                                        btn-warning status
                                                    @endif">
                                                    @if($order->isPaid == true)
                                                        PAID
                                                    @else 
                                                        NOT PAID
                                                    @endif
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            {{  $order->id ?? '' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{  $order->payment_option ?? '' }}</span>
                                            @if($order->payment_option == 'GCASH')
                                            <h6  class="text-s mt-2 text-uppercase">uploaded receipt:   <a target="_blank" href="/assets/img/resibo/{{$order->payment_receipt ?? ''}}">{{$order->payment_receipt ?? ''}}</a></h6>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{  $order->shipping_option ?? '' }}</span>
                                        </td>
                                        <td>
                                            ₱  {{ number_format($order->shipping_fee  ?? '' , 2, '.', ',') }}
                                        </td>
                                        <td>
                                            {{  $order->user->name ?? '' }}
                                        </td>
                                        <td>
                                         
                                            @foreach($order->orderproducts as $product_order)
                                                <span class="badge bg-success">{{$product_order->qty}} {{$product_order->product->name}} * {{$product_order->price}} = {{ number_format($product_order->amount ?? '' , 2, '.', ',') }}</span>
                                                
                                            
                                                <br>
                                            @endforeach
                                            
                                            
                                        </td>
                                        <td>
                                            ₱ {{ number_format($order->total_amount  ?? '' , 2, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('M j , Y h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
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
    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script> 
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
        pageLength: 100,
        });

        $('.datatable-table:not(.ajaxTable)').DataTable({ buttons: dtButtons });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
            });
    });

$(document).on('click', '.status', function(){
    var type = $(this).attr('action_type');
    var id = $(this).attr('status');

    $.ajax({
        url :"/admin/orders/status/"+id,
        dataType:"json",
        method: 'put',
        data: { _token: '{!! csrf_token() !!}' , type:type},
        beforeSend:function(){
          
        },
        success:function(data){
            if(data.success){
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
            }
        }
    })
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




