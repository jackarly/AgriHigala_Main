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
      <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
      <a href="{{route('admin.products.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($products)>0)
        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Name</th>
              <th>Description</th>
              <th>Category</th>
              <th>SRP</th>
              {{-- <th>Image</th> --}}
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>Name</th>
              <th>Description</th>
              <th>Category</th>
              <th>SRP</th>
              {{-- <th>Image</th> --}}
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
           
            @foreach($products as $product)  
              @php
                $srp = \App\SRP::getLatestSRP($product->product_id);
              @endphp
              <tr>
                <td>{{$product->product_id}}</td>
                <td>{{$product->product_name}}</td>
                <td>{{$product->product_description}}</td>
                <td class="text-capitalize">{{$product->product_type_name}}</td>
                @if ($srp)
                  <td>&#8369; {{$srp->product_price}} per {{$srp->unit_name}}</td>
                @else
                  <td>No SRP</td>
                @endif
                
                {{-- <td><img src="/storage/stock/{{$product->product_image}}" class="img-fluid zoom" style="max-width:80px" alt="{{$product->product_image}}"></td> --}}
                <td>
                    <a href="{{route('admin.products.edit',[$product->product_id])}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('admin.products.destroy',[$product->product_id])}}">
                      @csrf 
                      @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$product->product_id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
              </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$products->links()}}</span>
        @else
          <h6 class="text-center">No Products found!!! Please create Product</h6>
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
      
      $('#product-dataTable').DataTable( {
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