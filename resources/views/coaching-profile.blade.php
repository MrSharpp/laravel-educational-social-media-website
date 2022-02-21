@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Profile Setting') }}</div>


                <div class="card-body">

                @if(Request::get('message') != '')
                <div class="alert alert-success" role="alert">
                    Success, your profile is update but if you haevn't filled all information, you may still get error about filling all fields.
                </div>
                @endif


                @if ($listing == 'no')
                <div class="alert alert-danger" role="alert">
                    You are not listing or visible to anyone because you have not completed your profile basic information.
                </div>
                @else
                <div class="alert alert-success" role="alert">
                    Everything is all set!
                </div>
                @endif



                <br>
                <h3>Coaching Information</h3>
                <br>
                <form action="/updatecProfile" method="POST" class="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                        @if ($errors->has('name'))
                           <p class="text-danger"> {{$errors->first('name')}}</p>
                         @endif

                    </div>

                    <div class="form-group">
                        <label for="">Coaching Name</label>
                        <input type="text" class="form-control" name="businessname" value="{{ $user->businessName }}">
                    </div>

                    <div class="form-group">
                        <label for="">Coaching Introduction</label>
                        <textarea cols="30" name="bio" rows="3" class="form-control" maxlength="300" style="resize: none;" >{{ $user->bio }}</textarea>
                        <i>Max length is 300 Characters</i>
                    </div>

                    <div class="form-group">
                        @if ($user->profilePic != NULL)
                        <img src="images/{{$user->profilePic}}" width="200px"><br>
                        @endif
                        <label for="">Choose A Coaching's Logo</label><br>
                        <input type="file" name="profilePic">
                        @if ($errors->has('profilePic'))
                           <p class="text-danger"> {{$errors->first('profilePic')}}</p>
                         @endif
                    </div>
                    <hr>
                    <div class="form-group">
                      @if($galleryImagesLinks != 0)
                      <b>Uploaded Images</b>
                        <div class="row">
                          @foreach($galleryImagesLinks as $galleryLink)
                            <div ><img class="border" height="200px" width="200px" src="{{asset('images/')}}/{{$galleryLink}}"></div>
                          @endforeach
                        </div>
                        @endif

                      @if($imageCount != 0)
                      <div id="galleryImageForm">
                        <br><hr>

                        <lable><b>Add a coaching Image</b></label><br><br>
                          <div id="imageInputs">

                          </div>



                        </div>
                        <br><hr>
                          <b>Images To Upload</b>
                            <div class="row" id="allGalleryImages">

                            </div>
                          <br><hr>
                          @endif
                        <p style="color:gray;">Max: 6 Images Min: 1 Image</p>
                        @if ($errors->has('galleryImage'))
                           <p class="text-danger"> {{$errors->first('galleryImage')}}</p>
                         @endif
                    </div>

                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="location" class="form-control" value="{{ $user->location }}">
                        <i>Address of the coaching</i>
                    </div>
                    <div class="form-group">
                        <label for="">Fees Structure</label>

                        <div class="row">
                        @csrf
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="class" placeholder="Class">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" id="fees" placeholder="Fees ( In Rupees)">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="button" Value="Add" id="addFee" onclick="addScheme();"  disabled>
                                </div>
                            </div>
                        </div>

                        <i>Min Required:1 , Max: 10</i>
                    </div>
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <td><b>Class Name</b></td>
                                <td><b>Fees (In Rupees)</b></td>
                                <td><b>Action</b></td>
                            </tr>
                        </thead>
                        <tbody id="schemeBody">

                        </tbody>
                    </table>
                    <input type="submit" class="btn btn-success" value="Save Changes">
                    <p>Fill Class and Fees to Add</p>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
var imageCount = {{$imageCount}};

    $(document).ready(function(){
      if(imageCount != 0)
      {
            creatImageInput(imageCount);
      }
    });

    function creatImageInput(count){
      $('#imageInputs').append('<input type="file" name="galleryImage'+imageCount+'" id="galleryImage'+imageCount+'" onchange="validateImage()" id="galleryImage">');

    }

      function validateImage(){
        ext = $('#galleryImage'+imageCount).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['png', 'jpeg', 'jpg', 'bmp']) == -1)
        {
          $("#galleryImage"+imageCount).val('');
          return alert('Invalid File Type. File Type supported png, jpeg, jpg, bmp only');
        }

        if($('#galleryImage'+imageCount)[0].files[0].size > 2000000)
        {
          $("#galleryImage"+imageCount).val('');
          return alert('The uploaded image size should be under 1mb');
        }

        imageUrl = window.URL.createObjectURL($('#galleryImage'+imageCount)[0].files[0]);
        $("#galleryImage"+imageCount).hide();
        imageCount = imageCount - 1;

        if(imageCount != 0)
        {
          creatImageInput(imageCount);
        }else {
          $('#galleryImageForm').hide();
        }

        $('#allGalleryImages').append('<div ><img class="border" height="200px" width="200px" src="'+imageUrl+'"></div>');
      }

    getfee();
    function addScheme()
    {
        if($('#class').val() != '' && $("#fees").val() != '')
        {

            $.ajax({
                url: '/addFee',
                method: 'POST',
                data: {"_token": "{{ csrf_token() }}", "class": $("#class").val(), "fees": $("#fees").val()},
                success: function(res){
                    $('#class').val('')
            $('#fees').val('')
            $("#addFee").prop('disabled', true)
                    if(res.success == 'yes')
                    {
                        getfee()
                    }else
                    {
                        alert('Error. Please Try to contact administrator.');
                    }

                    if(res.error == 'yes')
                    {
                        alert('You Cannot add more then 10 Record.');
                    }
                }
            });
        }else
        {
            $("form#addFee").prop('disabled', true);
        }
    }

    function getfee()
    {
        $.ajax({
            url: '/getFee',
            method: "GET",
            success: function(res)
            {
                vu = res.data;
                $('#schemeBody').html('');
                for(var i =0; i < vu.length; i++)
                {
                    data = vu[i];

                $("#schemeBody").append('<tr><td>'+ data['className'] + '</td><td>Rs.' + data['fees'] + ' / Month</td><td><a href="javascript:void(0)" data-id="'+data['id']+'" onclick="deletePrice(this);">Delete</a></td></tr>');

                }
            }
        })
    }

    $(document).on('keypress', function(){
        if($('#class').val() != '' && $("#fees").val() != '')
        {
            $("#addFee").prop('disabled', false);
        }else
        {
            $("#addFee").prop('disabled', true);
        }
    });

    function deletePrice(obj){
        id = $(obj).data('id');

        $.ajax({
            url: "/delFee/",
            method: 'post',
            data: {id:id},
            success: function(res) {
                getfee();
                if(!res.success == 'yes')
                {
                    alert('Error please try contactintg administrator');
                }
            }
        })
    }


</script>
@endsection
