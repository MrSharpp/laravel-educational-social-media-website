@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Profile Setting') }}</div>
       
                <div class="card-body">

                <a href="/profile" class="btn btn-primary">Profile</a>
                <a href="/pricing" class="btn btn-primary">Fee Structure</a>
                {!!Auth::user()->userType != 'tutor' ? '<a href="/galleryImages" class="btn btn-primary">Images</a>' : '' !!}
            

                @if(Session::get('success') != '')
                <div class="alert alert-success" role="alert">
                    Success, your profile is update but if you haevn't filled all information, you may still get error about filling all fields.
                </div>
                @endif


                @if ($user->listing == 'no')
                <div class="alert alert-danger" role="alert">
                    You are not listing or visible to anyone because you have not completed your profile basic information.
                </div>
                @else
                <div class="alert alert-success" role="alert">
                    Everything is all set! 
                </div>
                @endif
              
                

                <br>
                <h3>{{ ucfirst(Auth::user()->userType) }} Information</h3>
                <br>
                <form action="/updateProfile" method="POST" class="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                        @if ($errors->has('name'))
                           <p class="text-danger"> {{$errors->first('name')}}</p>
                         @endif
                      
                    </div>

                        

                    @if(Auth::user()->userType == 'tutor')
                    <div class="form-group">
                        <label for="">Qualification</label>
                        <input type="text" name="qualification" class="form-control" value="{{ $user->qualifications }}">
                    </div>
                    @else
                    <div class="form-group">
                        <label for="">{{ ucfirst(Auth::user()->userType) }} Name</label>
                        <input type="text" name="business_name" class="form-control" value="{{ $user->business_name }}">
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="">{{ Auth::user()->userType == 'tutor' ? 'Bio' : 'About' }}</label>
                        <textarea cols="30" name="bio" rows="2" class="form-control" maxlength="150" style="resize: none;" >{{ $user->bio }}</textarea>
                        <i>Max length is 150 Characters</i>
                    </div>

                    <div class="form-group">
                        @if ($user->profilePic != NULL)
                        <img src="images/{{$user->profilePic}}" width="200px"><br>
                        @endif
                        <label for="">Choose A {{ Auth::user()->userType == 'tutor' ? 'Profile Pic' : 'Logo' }}</label><br>
                        <input type="file" name="profilePic">
                        @if ($errors->has('profilePic'))
                           <p class="text-danger"> {{$errors->first('profilePic')}}</p>
                         @endif
                    </div>

                    <div class="form-group">
                        <label for="">{{ Auth::user()->userType == 'tutor' ? 'Location' : 'Address' }}</label>
                        <input type="text" name="location" class="form-control" value="{{ $user->location }}">
                        <i>Location in Aligarh</i>
                    </div>
                    <input type="submit" class="btn btn-success" value="Save Changes">
                    <p>Fill Class and Fees to Add</p>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection