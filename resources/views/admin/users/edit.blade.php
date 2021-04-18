@extends('admin.layouts.master')

@section('main-content')
<div class="row">
  <div class="col-10 col-md-6 mx-auto">

    {{-- SET h5 & user_type --}}
    @php
      switch ($user->user_type) {
        case 2:
          $user_title = 'Seller ';
          break;
        case 3:
          $user_title = 'Rider ';
          break;
        case 4:
          $user_title = 'Buyer ';
          break;
      }
    @endphp

    <div class="card">
      <h5 class="card-header">Update {{$user_title}}Account</h5>
      <div class="card-body">
        <form method="post" action="{{route('admin.users.update', [$user->user_id])}}">
          {{csrf_field()}}

          {{-- USERNAME --}}
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Username</label>
            <input id="inputTitle" type="text" name="username" value="{{old('username', $user->username)}}" class="form-control">
            @error('username')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- PASSWORD --}}
          <div class="form-group">
            <label for="password" class="col-form-label">Password</label>
            <input id="password" type="password" name="password" value="{{old('password')}}" class="form-control" >
            @error('password')
              <span class="text-danger">{{$message}}</span>
            @enderror
            <small class="text-info">Default is mobile number</small>
          </div>
          
          {{-- EMAIL --}}
          <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
            <input id="inputEmail" type="email" name="email" value="{{old('email', $user->email)}}" class="form-control" >
            @error('email')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- FIRST NAME --}}
          <div class="form-group">
            <label for="first_name" class="col-form-label">First name</label>
            <input id="first_name" type="text" name="first_name" value="{{old('first_name', $user->f_name)}}" class="form-control" >
            @error('first_name')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- MIDDLE NAME --}}
          <div class="form-group">
            <label for="middle_name" class="col-form-label">Middle name</label>
            <input id="middle_name" type="text" name="middle_name" value="{{old('middle_name', $user->m_name)}}" class="form-control" >
            @error('middle_name')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- LAST NAME --}}
          <div class="form-group">
            <label for="last_name" class="col-form-label">Last name</label>
            <input id="last_name" type="text" name="last_name" value="{{old('last_name', $user->l_name)}}" class="form-control" >
            @error('last_name')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          {{-- MOBILE NUMBER --}}
          <div class="form-group">
            <label for="mobile_number" class="col-form-label">Mobile number</label>
            <input id="mobile_number" type="text" name="mobile_number" value="{{old('mobile_number', $user->mobile_number)}}" class="form-control" maxlength="11" >
            @error('mobile_number')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
  
          {{-- USER IMAGE --}}
          <div class="form-group">
            <label for="user_image" class="col-form-label">Upload image</label>
            <input type="file" name="user_image" id="user_image" class="form-control-file">
            @error('user_image')
              <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          {{-- ADDITIONAL DATA FOR DIFFERENT USERS --}}
          @switch($user->user_type)
            @case(2)
              {{-- ORGANIZATION LIST--}}
              <div class="form-group">
                @php 
                  $orgs=\App\Org::findAvailableOrgs();
                @endphp
                <label for="organization" class="col-form-label">Organization</label>
                <select name="organization" id="organization" class="form-control  @error('organization') is-invalid @enderror">  
                  <option value="{{$user->org_id}}" selected>{{$user->org_name}}</option>
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
                  {{old('schedule_online_time')}}
                  {{-- {{old('schedule_online_time', $user->schedule_online_time) }} --}}
                </textarea>
              </div>
              {{-- SELLER DESCRIPTION --}}
              <div class="form-group">
                <label for="seller_description" class="col-form-label">Seller description</label>
                <textarea name="seller_description" id="seller_description" class="form-control" rows="5">
                  {{old('seller_description', $user->seller_description) }}
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
                  {{old('rider_description', $user->rider_description) }}
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
          
          {{-- METHOD --}}
          @method('PUT')

          {{-- BUTTONS --}}
          <div class="form-group mb-3">
            <button type="submit" class="btn btn-success">Update</button>
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