@extends('admin.layouts.master')

@section('main-content')

{{-- NOTIFICATION --}}
<div class="row">
  <div class="col-md-12">
   @include('admin.layouts.notification')
  </div>
</div>

<div class="row">
  <div class="col-10 col-md-6 mx-auto">
    {{-- INFORMATION --}}
    <div class="card my-3">
      <h5 class="card-header text-capitalize">Inbox Information</h5>
      <div class="card-body">
        <div>
          Buyer:
          <br>
          Seller:
          <br>
          butang dari ang info
        </div>
      </div>
    </div>

    {{-- STATUS --}}
    <div class="card">
      <div class="card-body">
        <h5 class="text-capitalize">Messages</h5>
        <div class="message-container overflow-auto">
          @if ($messages)
            @php
              // INITIALIZE FIRST ITEM
              $first = true;
            @endphp
            @foreach ($messages as $message)
              @php
                // ADD USERNAME
                if ($message->sender == 'seller'){
                  $username = $users->seller_username;
                  $border = 'border-seller';
                  $font = 'custom-font-brown';
                }else{
                  $username = $users->buyer_username;
                  $border = 'border-buyer';
                  $font = 'custom-font-green';
                }
              @endphp
                <div class="mb-3">
                  <span class="text-capitalize {{$font}}" >{{$message->sender}}:</span>
                  <span class="{{$font}}">{{$username}}</span>
                  @if ($first)
                    <span class="badge badge-pill badge-primary">new</span>
                  @endif
                  <div class="ml-1 {{$border}}">
                    <span class="ml-1"> {{$message->message}}</span>
                    <br> 
                    <small class="ml-1">{{\Carbon\Carbon::parse($message->message_created_at)->diffForHumans()}}</small> 
                  </div>
                  {{-- <small class="font-italic">{{date("M j Y, g:i a", strtotime($message->message_created_at))}}</small> --}}
                </div>
                @php
                  $first = false;
                @endphp
            @endforeach 
          @else
            <h6 class="text-center">Inbox empty!</h6>
          @endif
        </div>
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