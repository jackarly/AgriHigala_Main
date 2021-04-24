@extends('admin.layouts.master')

@section('main-content')

 <!-- DataTables -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
          @include('admin.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left text-capitalize">{{$title}} List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders))
          <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Order No.</th>
                <th>Buyer</th>
                <th>Seller</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Placed on</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Order No.</th>
                <th>Buyer</th>
                <th>Seller</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Placed on</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach($orders as $order)  
                @php
                  // SET BUYER
                  $buyer = \App\Buyer::getBuyer($order->buyer_id);

                  // SET SELLER
                  $seller = \App\Seller::getSellerFromPayment($order->payment_id);

                  // SET ORDER QUANTITY
                  $qty = \App\OrderLine::getOrderQuantity($order->order_id);

                  if ($order->completed_at) {
                    // SET STATUS FOR COMPLETE
                    if ($order->order_accepted_at == null) {
                      $status = 'Rejected';
                      $badge = 'badge-danger';
                    } elseif ($order->order_accepted_at != null && $order->packed_at == null) {
                      $status = 'Cancelled';
                      $badge = 'badge-danger';
                    } elseif ($order->return_denied_at != null) {
                      $status = 'Rejected';
                      $badge = 'badge-danger';
                    } else{
                      $status = 'Complete';
                      $badge = 'badge-success';
                    }
                  } else {
                    if ($order->return_created_at){
                      // SET STATUS FOR RETURN ORDER
                      if($order->return_accepted_at == null ){
                        $status = 'Requesting';
                        $badge = 'badge-secondary';
                      }elseif($order->return_accepted_at != null ){
                        $status = 'Pending';
                        $badge = 'badge-warning';
                      }
                    }else {
                      // SET STATUS FOR ORDER
                      if($order->order_accepted_at == null){
                        $status = 'Requesting';
                        $badge = 'badge-secondary';
                      }
                      elseif($order->order_accepted_at != null && $order->packed_at == null){
                        $status = 'Pending';
                        $badge = 'badge-warning';
                      }
                      elseif($order->packed_at != null && $order->delivered_at == null){
                        $status = 'Delivering';
                        $badge = 'badge-info';
                      }
                      elseif($order->delivered_at != null){
                        $status = 'Delivered';
                        $badge = 'badge-success';
                      }
                    }
                  }
                @endphp
                <tr>
                  {{-- ORDER ID --}}
                  <td>{{$order->order_id}}</td>

                  {{-- BUYER --}}
                  <td>
                    @if ($buyer)
                      <span class="text-capitalize">{{$buyer->f_name}} {{$buyer->l_name}}</span>
                      <br>
                      <small>{{$buyer->username}}</small>
                    @else
                      <span>Not found!</span>
                    @endif
                  </td>

                  {{-- SELLER --}}
                  <td>
                    @if ($seller)
                      <span class="text-capitalize">{{$seller->f_name}} {{$seller->l_name}}</span>
                      <br>
                      <small>{{$seller->username}}</small>
                    @else
                      <span>Not found!</span>
                    @endif
                  </td>

                  {{-- ORDER QUANTITY --}}
                  <td>{{$qty}}</td>

                  {{-- TOTAL AMOUNT --}}
                  <td>
                    <span>&#8369;{{number_format($order->payment_total,2)}}</span>
                    <br>
                    {{-- PAID? --}}
                    @if ($order->paid_at == null)
                      <small class="font-italic">not paid</small>
                    @else
                      <small class="font-italic">paid {{\Carbon\Carbon::parse($order->paid_at)->diffForHumans()}}</small>
                      
                    @endif
                  </td>

                  {{-- CREATED AT --}}
                  <td>{{\Carbon\Carbon::parse($order->created_at)->diffForHumans()}}</td>

                  {{-- STATUS --}}
                  <td>
                    @if ($order->return_created_at)
                      <span class="badge badge-primary">Return</span>
                      <br>
                    @endif
                    <span class="badge {{$badge}}">{{$status}}</span>
                  </td>

                  {{-- ACTION --}}
                  <td>
                    @if ($title == 'return order')
                      <a href="{{route('admin.returns.show',$order->order_id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                      <form method="POST" action="{{route('admin.returns.destroy',[$order->order_id])}}">
                        @csrf 
                        @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->order_id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form>
                    @else
                      <a href="{{route('admin.orders.show',$order->order_id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                      <form method="POST" action="{{route('admin.orders.destroy',[$order->order_id])}}">
                        @csrf 
                        @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->order_id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form>
                    @endif
                    
                  </td>
                </tr>  
              @endforeach
            </tbody>
          </table>
          <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">No {{$title}} found!</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[8]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush