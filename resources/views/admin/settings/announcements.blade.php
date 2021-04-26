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
      <h6 class="m-0 font-weight-bold text-primary float-left text-capitalize">{{$title}}</h6>
      @if ($title == 'announcement')
        <a href="{{route('admin.announcements.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Announcement</a>
      @endif
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($announcements))
          <table class="table table-bordered" id="announcements-dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Date</th>
                <th>User</th>
                <th>Message</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Date</th>
                <th>User</th>
                <th>Message</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach($announcements as $announcement) 
                <tr>
                  {{-- ANNOUNCEMENT ID --}}
                  <td>{{$announcement->customer_service_id}}</td>

                  {{-- DATE --}}
                  <td>
                    <span>{{date("M j Y, g:i a", strtotime($announcement->announcement_created_at))}}</span>
                    <br>
                    <small class="font-italic">{{\Carbon\Carbon::parse($announcement->announcement_created_at)->diffForHumans()}}</small>
                  </td>
                  
                  {{-- USER --}}
                  <td>
                    @if ($announcement->user_id)
                      <span class="text-capitalize">{{$announcement->f_name}} {{$announcement->l_name}}</span>
                      <br>
                      <small>{{$announcement->username}}</small>
                    @else
                      <small class="font-italic">(sent to all users)</small>
                    @endif
                  </td>

                  {{-- MESSAGE --}}
                  <td>
                    <span>{{$announcement->message}}</span>
                  </td>

                  {{-- ACTION --}}
                  <td>
                    @if ($announcement->user_id)
                      <a href="{{route('admin.customer-service.reply',$announcement->customer_service_id)}}" class="btn btn-success btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="reply" data-placement="bottom"><i class="fa fa-reply"></i></a>
                    @else
                      <form method="POST" action="{{route('admin.announcements.destroy',[$announcement->customer_service_id])}}">
                        @csrf 
                        @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$announcement->customer_service_id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <span style="float:right">{{$announcements->links()}}</span>
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
      
      $('#announcements-dataTable').DataTable( {
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