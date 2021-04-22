@extends('admin.layouts.master')

@section('main-content')

<div class="row">
  <div class="col-10 col-md-6 mx-auto">
    
    @php
        $categoryList=\App\ProductType::getCategoryList();
        
        if ($category){
          $disabled = '';
        }
        else {
          $disabled = 'disabled';
        }
    @endphp

    {{-- CATEGORY --}}
    <div class="card my-3">
      <h5 class="card-header">New Stock</h5>
      <div class="card-body">
        <span>Category:</span>
        <ul class="list-inline mt-2">
          @foreach ($categoryList as $categoryItem)
              <li class="list-inline-item"><a href="{{route('admin.stocks.create', [$categoryItem->product_type_id])}}" class="btn btn-sm {{$category == $categoryItem->product_type_id ? 'btn-primary' : 'btn-outline-primary'}} text-capitalize">{{$categoryItem->product_type_name}}</a></li>
          @endforeach
        </ul>
        
        {{-- WARNING --}}
        @if ($category == null)
          <div class="form-group">
            <span class="text-danger font-italic">*select category to proceed</span>
          </div>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <form method="post" action="{{route('admin.stocks.store')}}">
          {{csrf_field()}}

          {{-- SELLER LIST --}}
          <div class="form-group">
            @php 
                $sellers=\App\Seller::getActiveSeller();
            @endphp
            <label for="seller" class="col-form-label">Seller</label>
            <select name="seller" id="seller" class="form-control text-capitalize  @error('seller') is-invalid @enderror"   autofocus {{$disabled}}>  
                <option value="" {{old('seller') ? '' : 'selected'}} disabled>--- Select Seller ---</option>
                @if ($sellers)
                  @foreach($sellers as $seller)
                  <option value="{{$seller->seller_id}}" {{old('seller') == $seller->seller_id ? 'selected' : ''}}>{{$seller->f_name}} {{$seller->l_name}}:{{$seller->username}}
                  </option>
                  @endforeach
                  <option value=""disabled>--- End of results ---</option>
                @else
                  <option value="" disabled>No available seller</option>
                @endif
            </select>
            @error('seller')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- PRODUCT & QUANTITY --}}
          <div class="form-group">
            <div class="form-row">
              {{-- PRODUCT --}}
              <div class="col-6">
                @php 
                $products=\App\Product::getProductByProductType($category);
                @endphp
                <label for="product" class="col-form-label">Product</label>
                <select name="product" id="product" class="form-control text-capitalize @error('product') is-invalid @enderror" {{$disabled}}>  
                    <option value="" {{old('product') ? '' : 'selected'}} disabled>--- Select Product ---</option>
                    @if ($products)
                      @foreach($products as $product)
                      <option value="{{$product->product_id}}" {{old('product') == $product->product_id ? 'selected' : ''}}>{{$product->product_name}}
                      </option>
                      @endforeach
                    @else
                      <option value="" disabled>No available product</option>
                    @endif
                </select>
                @error('product')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              {{-- STOCK QUANTITY --}}
              <div class="col-6">
                <label for="stock_quantity" class="col-form-label">Stock quantity</label>
                <input id="stock_quantity" type="text" name="stock_quantity" value="{{old('stock_quantity')}}" class="form-control" @error('stock_quantity') is-invalid @enderror {{$disabled}}>
                @error('stock_quantity')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
          </div>

          {{-- PRICE & UNIT --}}
          <div class="form-group">
            <div class="form-row">
              {{-- PRICE --}}
              <div class="col-6">
                <label for="price" class="col-form-label">Price</label>
                <input id="price" type="text" name="price" placeholder="&#8369;" value="{{old('price')}}" class="form-control" @error('price') is-invalid @enderror {{$disabled}}>
                @error('price')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              {{-- UNIT --}}
              <div class="col-6">
                @php 
                  $units=\App\Unit::all();
                @endphp
                <label for="unit" class="col-form-label">Unit</label>
                <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" {{$disabled}}> 
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
          </div>

          {{-- EXPIRATION & IMAGE --}}
          <div class="form-group">
            <div class="form-row">
              {{-- EXPIRATION --}}
              <div class="col-6">
                <label for="expiration" class="col-form-label">Expiration date</label>
                <input id="expiration" type="date" name="expiration" value="{{old('expiration')}}" class="form-control" @error('expiration') is-invalid @enderror {{$disabled}}>
                @error('expiration')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              {{-- STOCK IMAGE --}}
              <div class="col-6">
                <label for="stock_image" class="col-form-label">Image</label>
                <input type="file" name="stock_image" id="stock_image" class="form-control-file" {{$disabled}}>
                @error('stock_image')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>
          </div>
          
          {{-- STOCK DESCRIPTION --}}
          <div class="form-group">
            <label for="stock_description" class="col-form-label">Description</label>
            <textarea name="stock_description" id="stock_description" class="form-control" rows="3" {{$disabled}}>{{old('stock_description')}}</textarea>
          </div>

          <input type="hidden" name="category" value="{{$category}}">
        
          {{-- BUTTONS --}}
          <div class="form-group mb-3">
            <button type="reset" class="btn btn-warning" {{$disabled}}>Reset</button>
            <button type="submit" class="btn btn-success" {{$disabled}}>Submit</button>
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