@extends('admin.layouts.master')

@section('main-content')

{{-- NOTIFICATION --}}
<div class="row">
  <div class="col-md-12">
   @include('admin.layouts.notification')
  </div>
</div>

<div class="row">
  <div class="col-10 col-md-8 mx-auto">

    @php
      // GET RIDERS
      $riders = App\Rider::getRiderBySeller($order->seller_id);

      // GET REASONS
      $reasons = App\Reason::all();

      // SET BUTTONS
      $request_btn = false;
      $request_disable = 'disabled';
      $pending_btn = false;
      $pending_disable = 'disabled';
      $delivering_btn = false;
      $delivering_disable = 'disabled';
      $delivered_btn = false;
      $delivered_disable = 'disabled';
      $return_btn = false;
      $return_disable = 'disabled';
      $return_pending_btn = false;
      $return_pending_disable = 'disabled';

      if ($order->completed_at) {
        // SET STATUS FOR COMPLETE
        if ($order->order_accepted_at == null) {
          $status = 'Rejected';
          $status_btn = 'badge-danger';
        } elseif ($order->order_accepted_at != null && $order->packed_at == null) {
          $status = 'Cancelled';
          $status_btn = 'badge-danger';
        } elseif ($order->return_denied_at != null) {
          $status = 'Rejected';
          $status_btn = 'badge-danger';
        } else{
          $status = 'Complete';
          $status_btn = 'badge-success';
        }
      } else {
        if ($order->return_created_at){
          // SET STATUS FOR RETURN ORDER
          if($order->return_accepted_at == null ){
            $return_btn = true;
            $return_disable = '';
            $status = 'Requesting';
            $status_btn = 'badge-secondary';
          }elseif($order->return_accepted_at != null ){
            $return_pending_btn = true;
            $return_pending_disable = '';
            $status = 'Pending';
            $status_btn = 'badge-warning';
          }
        }else {
          // SET STATUS FOR ORDER
          if($order->order_accepted_at == null){
            $request_btn = true;
            $request_disable = '';
            $status = 'Requesting';
            $status_btn = 'badge-secondary';
          }
          elseif($order->order_accepted_at != null && $order->packed_at == null){
            $pending_btn = true;
            $pending_disable = '';
            $status = 'Pending';
            $status_btn = 'badge-warning';
          }
          elseif($order->packed_at != null && $order->delivered_at == null){
            $delivering_btn = true;
            $delivering_disable = '';
            $status = 'Delivering';
            $status_btn = 'badge-info';
          }
          elseif($order->delivered_at != null){
            $delivered_btn = true;
            $delivered_disable = '';
            $status = 'Delivered';
            $status_btn = 'badge-success';
          }
        }
      }

      // if($order->order_accepted_at == null && $order->completed_at == null && $title == 'order'){
      //   $request_btn = true;
      //   $request_disable = '';
      //   $status = 'Requesting';
      //   $status_btn = 'badge-secondary';
      // }
      // elseif($order->order_accepted_at != null && $order->packed_at == null && $order->completed_at == null && $title == 'order'){
      //   $pending_btn = true;
      //   $pending_disable = '';
      //   $status = 'Pending';
      //   $status_btn = 'badge-warning';
      // }
      // elseif($order->packed_at != null && $order->delivered_at == null && $title == 'order'){
      //   $delivering_btn = true;
      //   $delivering_disable = '';
      //   $status = 'Delivering';
      //   $status_btn = 'badge-info';
      // }
      // elseif($order->delivered_at != null && $order->completed_at == null && $title == 'order'){
      //   $delivered_btn = true;
      //   $delivered_disable = '';
      //   $status = 'Delivered';
      //   $status_btn = 'badge-success';
      // }
      // elseif($order->return_accepted_at == null && $order->completed_at == null){
      //   $return_btn = true;
      //   $return_disable = '';
      //   $status = 'Requesting';
      //   $status_btn = 'badge-secondary';
      // }
      // elseif($order->return_accepted_at != null && $order->completed_at == null){
      //   $return_pending_btn = true;
      //   $return_pending_disable = '';
      //   $status = 'Pending';
      //   $status_btn = 'badge-warning';
      // }
      // elseif($order->delivered_at != null && $order->completed_at != null ){
      //   $status = 'Complete';
      //   $status_btn = 'badge-success';
      // }
    @endphp

    {{-- INFORMATION --}}
    <div class="card my-3">
      <h5 class="card-header text-capitalize">{{$title}} Information</h5>
      <div class="card-body">
        <div>
          Order: {{$order->order_id}}
          <br>
          butang dari ang info
          <br>
          @if ($order->return_created_at)
            <span class="badge badge-primary">Return</span>
            <br>
          @endif
          <span class="badge {{$status_btn}}">{{$status}}</span>
        </div>
      </div>
    </div>

    {{-- STATUS --}}
    <div class="card">
      <div class="card-body">
        <h5 class="text-capitalize">{{$title}} Status</h5>
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="30%">Status</th>
              <th width="20%">User</th>
              <th width="50%">Action</th>
            </tr>
          </thead>

          <tbody>
            {{-- ORDER REQUEST --}}
            <tr>
              <td>
                <span class="font-weight-bold">Order Request</span>
                <br>
                @if ($order->order_created_at)
                  <small>{{date('M d Y, g:i a', strtotime($order->order_created_at))}}</small>
                  <br>
                  <small class="font-italic">{{\Carbon\Carbon::parse($order->order_created_at)->diffForHumans()}}</small>
                @else
                  <span>---</span>
                @endif
              </td>
              <td>Seller</td>
              <td>
                {{-- REQUEST: ACCEPT --}}
                <form class="d-inline" method="POST" action="{{route('admin.orders.response',[$order->order_id])}}">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="response" value="accept">
                  <input type="submit" value="Accept" class="btn btn-sm {{$request_btn == true ? 'btn-success' : 'btn-secondary'}}" {{$request_disable}}>
                </form>
                {{-- REQUEST: REJECT --}}
                <form class="d-inline" method="POST" action="{{route('admin.orders.response',[$order->order_id])}}">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="response" value="reject">
                  <input type="submit" value="Reject" class="btn btn-sm {{$request_btn == true ? 'btn-danger' : 'btn-secondary'}}" {{$request_disable}}>
                </form>
              </td>
            </tr>
            
            {{-- PENDING: PACKED --}}
            <tr>
              <td rowspan="2">
                <span class="font-weight-bold">Pending</span> 
                <br>
                @if ($order->order_accepted_at)
                  <small>{{date('M d Y, g:i a', strtotime($order->order_accepted_at))}}</small>
                  <br>
                  <small class="font-italic">{{\Carbon\Carbon::parse($order->order_accepted_at)->diffForHumans()}}</small>
                @else
                  <span>---</span>
                @endif
              </td>
              <td>Seller</td>
              <td>
                <form class="form-inline" method="POST" action="{{route('admin.orders.packed',[$order->order_id])}}">
                  @csrf
                  <input type="hidden" name="response" value="packed">
                  <input type="submit" value="Packed" class="btn btn-sm {{$pending_btn == true ? 'btn-info' : 'btn-secondary'}}" {{$pending_disable}}>
                  <select name="rider" id="" class="form-control form-control-sm ml-auto" {{$pending_disable}}>
                    <option disabled selected>--- Select Rider ---</option>
                    @if ($riders)
                      @foreach ($riders as $rider)
                        <option value="{{$rider->rider_id}}">{{$rider->f_name}} {{$rider->l_name}}</option>
                      @endforeach
                    @endif
                  </select>
                  @error('rider')
                    <span class="text-danger">{{$message}}</span>
                  @enderror
                  @method('PUT')
                  
                </form>
              </td>
            </tr>
            
            {{-- PENDING: CANCEL --}}
            <tr>
              <td>Buyer</td>
              <td>
                <form class="d-inline" method="POST" action="{{route('admin.orders.cancel',[$order->order_id])}}">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="response" value="cancel">
                  <input type="submit" value="Cancel" class="btn btn-sm {{$pending_btn == true ? 'btn-danger' : 'btn-secondary'}}" {{$pending_disable}}>
                </form>
              </td>
            </tr>
            
            {{-- DELIVERING --}}
            <tr>
              <td>
                <span class="font-weight-bold">Delivering</span>
                <br>
                @if ($order->packed_at)
                  <small>{{date('M d Y, g:i a', strtotime($order->packed_at))}}</small>
                  <br>
                  <small class="font-italic">{{\Carbon\Carbon::parse($order->packed_at)->diffForHumans()}}</small>
                @else
                  <span>---</span>
                @endif
              </td>
              <td>Rider</td>
              <td>
                <form class="d-inline" method="POST" action="{{route('admin.orders.delivered',[$order->order_id])}}">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="response" value="delivered">
                  <input type="submit" value="Delivered" class="btn btn-sm {{$delivering_btn == true ? 'btn-info' : 'btn-secondary'}}" {{$delivering_disable}}> 
                </form>
              </td>
            </tr>
            
            {{-- DELIVERED --}}
            <tr>
              <td>
                <span class="font-weight-bold">Delivered</span>
                <br>
                @if ($order->delivered_at)
                  <small>{{date('M d Y, g:i a', strtotime($order->delivered_at))}}</small>
                  <br>
                  <small class="font-italic">{{\Carbon\Carbon::parse($order->delivered_at)->diffForHumans()}}</small>
                @else
                  <span>---</span>
                @endif
              </td>
              <td>Buyer</td>
              <td>
                {{-- DELIVERED: RECEIVED --}}
                <div class="my-1">
                  <form method="POST" action="{{route('admin.orders.received',[$order->order_id])}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="response" value="received">
                    <input type="submit" value="Received" class="btn btn-sm {{$delivered_btn == true ? 'btn-success' : 'btn-secondary'}}" {{$delivered_disable}}>
                  </form>
                </div>
                {{-- DELIVERED: RETURN --}}
                <div class="my-1">
                  <form class="form-inline" method="POST" action="{{route('admin.returns.store')}}">
                    @csrf
                    <input type="hidden" name="response" value="return">
                    <input type="hidden" name="order" value="{{$order->order_id}}">
                    <input type="submit" value="Return" class="btn btn-sm {{$delivered_btn == true ? 'btn-warning' : 'btn-secondary'}}" {{$delivered_disable}}>
                    <select name="reason" id="" class="form-control form-control-sm ml-auto" {{$delivered_disable}}>
                      <option disabled selected>--- Select Reason ---</option>
                      @if ($reasons)
                        @foreach ($reasons as $reason)
                          <option value="{{$reason->reason_id}}">{{$reason->reason_name}}</option>
                        @endforeach
                      @endif
                    </select>
                    @error('reason')
                      <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="form-group mt-1" style="width: 100%">
                      <textarea name="description" id="description" rows="3" class="form-control" style="width: 100%" {{$delivered_disable}}></textarea>
                    </div>
                  </form>
                </div>
              </td>
            </tr>
            
            @if ($order->return_created_at)
              {{-- RETURN REQUEST --}}
              <tr>
                <td>
                  <span class="font-weight-bold">Return Request</span>
                  <br>
                  @if ($order->return_created_at)
                    <small>{{date('M d Y, g:i a', strtotime($order->return_created_at))}}</small>
                    <br>
                    <small class="font-italic">{{\Carbon\Carbon::parse($order->return_created_at)->diffForHumans()}}</small>
                  @else
                    <span>---</span>
                  @endif
                </td>
                <td>Seller</td>
                <td>
                  {{-- RETURN: ACCEPT --}}
                  <form class="d-inline" method="POST" action="{{route('admin.returns.response',[$order->order_id])}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="response" value="accept">
                    <input type="submit" value="Accept" class="btn btn-sm {{$return_btn == true ? 'btn-success' : 'btn-secondary'}}" {{$return_disable}}>
                  </form>
                  {{-- RETURN: REJECT --}}
                  <form class="d-inline" method="POST" action="{{route('admin.returns.response',[$order->order_id])}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="response" value="reject">
                    <input type="submit" value="Reject" class="btn btn-sm {{$return_btn == true ? 'btn-danger' : 'btn-secondary'}}" {{$return_disable}}>
                  </form>
                </td>
              </tr>
              
              {{-- PENDING: RETURN ORDER --}}
              <tr>
                <td>
                  <span class="font-weight-bold">Pending: Return</span>
                  <br>
                  @if ($order->return_accepted_at)
                    <small>{{date('M d Y, g:i a', strtotime($order->return_accepted_at))}}</small>
                    <br>
                    <small class="font-italic">{{\Carbon\Carbon::parse($order->return_accepted_at)->diffForHumans()}}</small>
                  @else
                    <span>---</span>
                  @endif
                </td>
                <td>Rider</td>
                <td>
                  <form class="d-inline" method="POST" action="{{route('admin.returns.delivered',[$order->order_id])}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="response" value="delivered">
                    <input type="submit" value="Delivered" class="btn btn-sm {{$return_pending_btn == true ? 'btn-primary' : 'btn-secondary'}}" {{$return_pending_disable}}>
                  </form>
                </td>
              </tr>
            @endif

            {{-- COMPLETE --}}
            <tr>
              <td>
                <span class="font-weight-bold">Complete</span>
                <br>
              </td>
              <td colspan="3">
                @if ($order->completed_at)
                  <small>{{date('M d Y, g:i a', strtotime($order->completed_at))}}</small>
                  <small class="font-italic">{{\Carbon\Carbon::parse($order->completed_at)->diffForHumans()}}</small>
                @else
                  <span>---</span>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>
@endpush