@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>
                <div class="card-body">
                <div class="row">
                   @foreach($tutors as $tutor)
                        <div class="border col-md-3">
                        <img src="images/{{$tutor['profilePic']}}" width="150px"><br>
                            Name: {{$tutor['name']}} <br>
                            Bio: {{ $tutor['bio'] }}    <br>
                            Qualification: {{$tutor['qualifications']}} <br>
                            Location: {{$tutor['location']}} <br>
                            CanTeach: {{$tutor['canTeach']}} <br>
                            <a href="/page/{{$tutor['id']}}" class="btn btn-success">Open</a>
                            @if(Auth::user()->userType == 'normal')
                            <button class="btn btn-primary" onclick="follow(this)" data-id="{{$tutor->id}}">Follow</button>
                            @endif
                        </div>
                   @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     function follow(button)
    {
        id = $(button).data('id');
        $(button).prop('disabled', true);
        if($(button).text() == 'Follow')
        {
        $(button).text('UnFollow');
        $.ajax({
            url: '/follow',
            method: 'post',
            data: {id:id},
            success: function(res){
                if(res != 's') $(button).text('Follow');
                $(button).prop('disabled', false);
            },  
            error: function(res){
                console.log(res);
                alert('Something went wrong. Please refresh page or try contacting administrator');
            }
        })
        }else
        {
        $(button).text('Follow');
        $.ajax({
            url: '/unfollow',
            method: 'post',
            data: {id:id},
            success: function(res){
                if(res != 's') $(button).text('Follow');
                $(button).prop('disabled', false);
            },  
            error: function(res){
                console.log(res);
                alert('Something went wrong. Please refresh page or try contacting administrator');
            }
        })
        }
    }
</script>
@endsection