@extends('admin.layouts.master')

@section('main-content')

 <!-- DataTables-->
 <div class="card shadow mb-4">
     <div class="row">
        <div class="col-md-12">
          @include('admin.layouts.notification')
        </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Stock Lists</h6>
      <a href="{{route('admin.stocks.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Stock</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($stocks)>0)
        <table class="table table-bordered" id="stock-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Product</th>
              <th>Category</th>
              <th>Description</th>
              <th>Seller</th> {{-- username & name --}}
              <th>Quantity</th> {{-- added & remaining --}}
              <th>Price</th>{{-- unit & discount --}}
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>Product</th>
              <th>Category</th>
              <th>Description</th>
              <th>Seller</th> {{-- username & name --}}
              <th>Quantity</th> {{-- added & remaining --}}
              <th>Price</th>{{-- unit & discount --}}
              <th>Image</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($stocks as $stock)  
              @php
                $price = \App\Price::getLatestPrice($stock->stock_id);
                $qty = \App\Stock::getQty($stock->stock_id); 
              @endphp
              <tr>
                <td>{{$stock->stock_id}}</td>
                <td>{{$stock->product_name}}</td>
                <td class="text-capitalize">{{$stock->product_type_name}}</td>
                <td>{{$stock->stock_description}}</td>
                <td>{{$stock->username}}</td>
                <td>
                  <span>{{$qty->stock}} <small>added</small> </span>
                  <br>
                  <span>{{$qty->remaining}} <small>remaining</small></span>
                </td>
                <td>
                  <span>&#8369;{{$price->stock_price}}<small>/{{$price->unit_name}} unit price</small></span>
                  <br>
                  @if ($price->discount_price)
                    <span>&#8369;{{$price->discount_price}}<small>/{{$price->unit_name}} discount price</small></span>
                  @endif
                  
                </td>
                <td><img src="/storage/stock/{{$stock->product_image}}" class="img-fluid" style="max-width:80px" alt="{{$stock->product_image}}"></td>
                <td>
                    <a href="{{route('admin.stocks.edit',[$stock->stock_id])}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('admin.stocks.destroy',[$stock->stock_id])}}">
                      @csrf 
                      @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$stock->stock_id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
              </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$stocks->links()}}</span>
        @else
          <h6 class="text-center">No stock found! Please create stock</h6>
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
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
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
      
      $('#stock-dataTable').DataTable( {
        "scrollX": false
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[10,11,12]
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