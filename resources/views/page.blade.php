@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        
                        <h3 style="font-family:arial;"><b>{{ $user->userType == 'tutor' ? $user->name : $user->business_name }}</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="border col-md-5">
                                <img src="{{URL::to('/') . '/images/' . $user->profilePic }}" style="display: block;margin: auto;max-width: 100%;"  height="300px"  alt="">
                                <br>
                                
                                <span style="padding-left:130px;font-weight:bold;font-size:20px;">{{ $user->userType == 'tutor' ? $user->name : $user->business_name }}</span>
                                <br>
                                <p>{{$user->bio}}</p>
                                Location: {{$user->location}}
                            </div>
                            <div class="col-md-6">
                                DATA
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection