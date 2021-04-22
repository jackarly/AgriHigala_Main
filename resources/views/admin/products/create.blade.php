@extends('admin.layouts.master')

@section('main-content')

<div class="row">
  <div class="col-10 col-md-6 mx-auto">
    <div class="card">
      <h5 class="card-header">New Product</h5>
      <div class="card-body">
        <form method="post" action="{{route('admin.products.store')}}">
          {{csrf_field()}}

          {{-- PRODUCT NAME --}}
          <div class="form-group">
            <label for="product_name" class="col-form-label">Product name</label>
            <input id="product_name" type="text" name="product_name" value="{{old('product_name')}}" class="form-control"  autofocus>
            @error('product_name')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- CATEGORIES --}}
          <div class="form-group">
            @php 
                $categories=\App\ProductType::getCategoryList();
            @endphp
            <label for="category" class="col-form-label">Category</label>
            <select name="category" id="category" class="form-control text-capitalize @error('category') is-invalid @enderror">  
                <option value="" selected disabled>--- Select Category ---</option>
                @if ($categories)
                  @foreach($categories as $category)
                  <option value="{{$category->product_type_id}}">{{$category->product_type_name}}
                  </option>
                  @endforeach
                @else
                  <option value="" disabled>No available category</option>
                @endif
            </select>
            @error('category')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-row">
            {{-- SRP --}}
            <div class="col-6">
              <label for="srp" class="col-form-label">SRP</label>
              <input id="srp" type="text" name="srp" value="{{old('srp')}}" class="form-control"  autofocus>
              @error('srp')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            {{-- UNIT --}}
            <div class="col-6">
              @php 
                $units=\App\Unit::all();
              @endphp
              <label for="unit" class="col-form-label">Unit</label>
              <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror">  
                  <option value="" selected disabled>--- Select Unit ---</option>
                  @if ($units)
                    @foreach($units as $unit)
                    <option value="{{$unit->unit_id}}">per {{$unit->unit_description}} ({{$unit->unit_name}})
                    </option>
                    @endforeach
                  @else
                    <option value="" disabled>No available unit</option>
                  @endif
              </select>
              @error('unit')
                <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>

          {{-- PRODUCT DESCRIPTION --}}
          <div class="form-group">
            <label for="product_description" class="col-form-label">Product description</label>
            <textarea name="product_description" id="product_description" class="form-control" rows="5">{{old('product_description')}}</textarea>
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

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
@endpush