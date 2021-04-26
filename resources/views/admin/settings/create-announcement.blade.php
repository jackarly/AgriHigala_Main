@extends('admin.layouts.master')

@section('main-content')
<div class="row">
  <div class="col-10 col-md-6 mx-auto">
    <div class="card">
      <h5 class="card-header">Announcement</h5>
      <div class="card-body">
        <form method="post" action="{{route('admin.announcements.store')}}">
          {{csrf_field()}}

          {{-- Description --}}
          <div class="form-group">
            <textarea name="announcement" id="announcement" class="form-control" rows="5" placeholder="Type here...">{{old('announcement')}}</textarea>
            @error('announcement')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
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