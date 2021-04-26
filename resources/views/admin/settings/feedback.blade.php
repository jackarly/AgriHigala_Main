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
      <h6 class="m-0 font-weight-bold text-primary float-left text-capitalize">Feedback</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if($feedbacks)
          <table class="table table-bordered" id="feedbacks-dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Feedback No.</th>
                <th>Email</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Platform</th>
                <th>Date</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Feedback No.</th>
                <th>Email</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Platform</th>
                <th>Date</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach($feedbacks as $feedback) 
                <tr>
                  {{-- FEEDBACK ID --}}
                  <td>{{$feedback->feedback_id}}</td>
                  
                  {{-- EMAIL --}}
                  <td>{{$feedback->email}}</td>

                  {{-- RATING --}}
                  <td>
                    <span>{{$feedback->rating}}</span>
                  </td>

                  {{-- COMMENT --}}
                  <td>
                    <span>{{$feedback->comment}}</span>
                  </td>

                  {{-- PLATFORM --}}
                  <td>{{$feedback->platform}}</td>

                  {{-- DATE --}}
                  <td>{{\Carbon\Carbon::parse($feedback->created_at)->diffForHumans()}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <span style="float:right">{{$feedbacks->links()}}</span>
        @else
          <h6 class="text-center">No feedback found!</h6>
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
      
      $('#feedbacks-dataTable').DataTable( {
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