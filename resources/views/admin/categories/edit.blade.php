@extends('admin.layouts.master')

@section('main-content')
<div class="row">
  <div class="col-10 col-md-6 mx-auto">
    <div class="card">
      <h5 class="card-header">Add Category</h5>
      <div class="card-body">
        <form method="post" action="{{route('admin.categories.update', [$category->product_type_id])}}">
          {{csrf_field()}}

          {{-- Title --}}
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Title</label>
            <input id="inputTitle" type="text" name="title" value="{{old('title', $category->product_type_name)}}" class="form-control" autofocus>
            @error('title')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- Description --}}
          <div class="form-group">
            <label for="description" class="col-form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="2">{{old('description', $category->product_type_description)}}</textarea>
            @error('description')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- IMAGE --}}
          <div class="form-group">
            <label for="image" class="col-form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control-file">
            @error('image')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- METHOD --}}
          @method('PUT')
          
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