@extends('admin.layouts.master')

@section('main-content')
<div class="row">
  <div class="col-10 col-md-6 mx-auto">

    {{-- SET h5 & user_type --}}
    @php
      $disabled = '';

      switch ($user_type) {
        case 1:
          $user_title = 'Admin ';
          break;
        case 2:
          $user_title = 'Seller ';
          break;
        case 3:
          $user_title = 'Rider ';
          break;
        case 4:
          $user_title = 'Buyer ';
          break;
        
        default:
          $user_title = '';
          $disabled = 'disabled';
          break;
      }
    @endphp
    <div class="card my-3">
      <div class="card-body">
        <ul class="list-inline">
          <li class="list-inline-item">Select user type: </li>
          <li class="list-inline-item"><a href="{{route('admin.users.create', 2)}}" class="btn btn-sm btn-primary shadow">Seller</a></li>
          <li class="list-inline-item"><a href="{{route('admin.users.create', 3)}}" class="btn btn-sm btn-success shadow">Rider</a></li>
          <li class="list-inline-item"><a href="{{route('admin.users.create', 4)}}" class="btn btn-sm btn-warning shadow">Buyer</a></li>
          <li class="list-inline-item"><a href="{{route('admin.users.create', 1)}}" class="btn btn-sm btn-info shadow">Admin</a></li>
          
        </ul>
      </div>
    </div>

    <div class="card">
      <h5 class="card-header">New {{$user_title}}Account</h5>
      <div class="card-body">
        <form method="post" action="{{route('admin.users.store')}}">
          {{csrf_field()}}

          {{-- WARNING --}}
          @if ($user_type == 0)
            <div class="form-group">
              <span class="text-danger font-italic">*select user type to proceed</span>
            </div>
          @endif

          {{-- USERNAME --}}
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Username</label>
            <input id="inputTitle" type="text" name="username" value="{{old('username')}}" class="form-control" {{$disabled}} autofocus>
            @error('username')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- PASSWORD --}}
          <div class="form-group">
            <label for="password" class="col-form-label">Password</label>
            <input id="password" type="password" name="password" value="{{old('password')}}" class="form-control" {{$disabled}}>
            @error('password')
              <span class="text-danger">{{$message}}</span>
            @enderror
            <small class="text-info">Default is mobile number</small>
          </div>
          
          {{-- EMAIL --}}
          <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
            <input id="inputEmail" type="email" name="email" value="{{old('email')}}" class="form-control" {{$disabled}}>
            @error('email')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- FIRST NAME --}}
          <div class="form-group">
            <label for="first_name" class="col-form-label">First name</label>
            <input id="first_name" type="text" name="first_name" value="{{old('first_name')}}" class="form-control" {{$disabled}}>
            @error('first_name')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- MIDDLE NAME --}}
          <div class="form-group">
            <label for="middle_name" class="col-form-label">Middle name</label>
            <input id="middle_name" type="text" name="middle_name" value="{{old('middle_name')}}" class="form-control" {{$disabled}}>
            @error('middle_name')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- LAST NAME --}}
          <div class="form-group">
            <label for="last_name" class="col-form-label">Last name</label>
            <input id="last_name" type="text" name="last_name" value="{{old('last_name')}}" class="form-control" {{$disabled}}>
            @error('last_name')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- MOBILE NUMBER --}}
          <div class="form-group">
            <label for="mobile_number" class="col-form-label">Mobile number</label>
            <input id="mobile_number" type="text" name="mobile_number" value="{{old('mobile_number')}}" class="form-control" maxlength="11" {{$disabled}}>
            @error('mobile_number')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
  
          {{-- USER IMAGE --}}
          <div class="form-group">
            <label for="user_image" class="col-form-label">Upload image</label>
            <input type="file" name="user_image" id="user_image" class="form-control-file" {{$disabled}}>
            @error('user_image')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- ADDITIONAL DATA FOR DIFFERENT USERS --}}
          @switch($user_type)
            @case(2)
              {{-- ORGANIZATION LIST--}}
              <div class="form-group">
                @php 
                  $orgs=\App\Org::findAvailableOrgs();
                @endphp
                <label for="organization" class="col-form-label">Organization</label>
                <select name="organization" id="organization" class="form-control  @error('organization') is-invalid @enderror">  
                  <option selected disabled>--- Select Organization ---</option>
                  @foreach($orgs as $org)
                    <option value="{{$org->org_id}}">{{$org->org_name}}</option>
                  @endforeach 
                  <option disabled>--- End of results ---</option>
                </select>
                @error('organization')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              {{-- SCHEDULED ONLINE TIME --}}
              <div class="form-group">
                <label for="schedule_online_time" class="col-form-label">Schedule online time</label>
                <textarea name="schedule_online_time" id="schedule_online_time" class="form-control" rows="2">
                  {{old('schedule_online_time') }}
                </textarea>
              </div>
              {{-- SELLER DESCRIPTION --}}
              <div class="form-group">
                <label for="seller_description" class="col-form-label">Seller description</label>
                <textarea name="seller_description" id="seller_description" class="form-control" rows="5">
                  {{old('seller_description') }}
                </textarea>
              </div>
              @break

            @case(3)
                {{-- SELLER LIST --}}
                <div class="form-group">
                @php 
                    $sellers=\App\Seller::getActiveSeller();
                @endphp
                <label for="seller" class="col-form-label">Seller</label>
                <select name="seller" id="seller" class="form-control  @error('seller') is-invalid @enderror">  
                    <option value="" selected disabled>--- Select Seller ---</option>
                    @if ($sellers)
                      @foreach($sellers as $seller)
                      <option value="{{$seller->seller_id}}" class="text-capitalize">{{$seller->f_name}} {{$seller->l_name}}:{{$seller->username}}
                      </option>
                      @endforeach
                      <option value=""disabled>--- End of results ---</option>
                    @else
                      <option value="" disabled>No available sellers</option>
                    @endif
                </select>
                @error('seller')
                  <span class="text-danger">{{$message}}</span>
                @enderror
                </div>
              {{-- RIDER DESCRIPTION --}}
              <div class="form-group">
                <label for="rider_description" class="col-form-label">Rider description</label>
                <textarea name="rider_description" id="rider_description" class="form-control" rows="5">
                  {{old('rider_description') }}
                </textarea>
              </div>
              @break

            @case(4)
              {{-- BIRTHDATE --}}
              <div class="form-group">
                <label for="birthdate" class="col-form-label">Birthdate</label>
                <input id="birthdate" type="date" name="birthdate" value="{{old('birthdate')}}" class="form-control" @error('birthdate') is-invalid @enderror>
                @error('birthdate')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              
              {{-- GENDER --}}
              <div class="form-group">
                <label for="gender" class="col-form-label">Gender</label>
                <select name="gender" id="gender" class="form-control  @error('gender') is-invalid @enderror">  
                  <option value="" selected disabled>--- Select Gender ---</option> 
                  <option value="male" >Male</option> 
                  <option value="female" >Female</option>
                  <option value="prefer not to say" >Prefer not to say</option>
                </select>
                @error('gender')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              {{-- BARANGAY --}}
              <div class="form-group">
                @php 
                  $brgys=\App\Brgy::all();
                @endphp
                <label for="brgy" class="col-form-label">Barangay</label>
                <select name="brgy" id="brgy" class="form-control  @error('brgy') is-invalid @enderror">  
                  <option value="" selected disabled>--- Select Barangay ---</option>
                  @foreach($brgys as $brgy)
                    <option value="{{$brgy->brgy_id}}"> {{$brgy->brgy_name}}</option>
                  @endforeach
                </select>
                @error('brgy')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              {{-- ADDRESS --}}
              <div class="form-group">
                <label for="address" class="col-form-label">Address</label>
                <input id="address" type="text" name="address" value="{{old('address')}}" class="form-control" >
                @error('address')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              @break
                  
          @endswitch
          
          <input type="hidden" name="user_type" value="{{$user_type}}">
          {{-- BUTTONS --}}
          <div class="form-group mb-3">
            <button type="reset" class="btn btn-warning">Reset</button>
            <button type="submit" class="btn btn-success" {{$disabled}}>Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush