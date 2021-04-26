@extends('admin.layouts.master')

@section('main-content')
<div class="row">
  <div class="col-10 col-md-6 mx-auto">
    <div class="card">
      <h5 class="card-header">Customer Service</h5>
      <div class="card-body">
        <div class="mb-3">
          <span class="text-capitalize">User: {{$message->f_name}} {{$message->l_name}}</span>
          <small class="font-italic">({{$message->username}})</small>
          <span class="d-block mt-2">Message:</span>
          <div class="border-buyer">
            <span class="ml-1">
              {{$message->message}}

            </span>
          </div>
        </div>
        <form method="post" action="{{route('admin.customer-service.store')}}">
          {{csrf_field()}}
          {{-- Description --}}
          <div class="form-group">
            <textarea name="message" id="message" class="form-control" rows="3" placeholder="Reply here..." autofocus>{{old('message')}}</textarea>
            @error('message')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <input type="hidden" name="user" value="{{$message->user_id}}">
          {{-- BUTTONS --}}
          <div class="form-group mb-3">
            <button type="reset" class="btn btn-warning">Reset</button>
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
@endpush