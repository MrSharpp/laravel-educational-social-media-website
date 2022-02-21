@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
            Gallery Images
          </div>
          <div class="card-body">

          <a href="/profile" class="btn btn-primary">Profile</a>
                <a href="/pricing" class="btn btn-primary">Fee Structure</a>
                {!!Auth::user()->userType != 'tutor' ? '<a href="/galleryImages" class="btn btn-primary">Images</a>' : '' !!}

            <h4>Uploaded Image</h4>
            <div class="border row" id="images">
            @if($images != '')
                @foreach($images as $image)
                  <div>
                    <img src="images/{{$image}}" width="250px" height="250px" alt="" ><br>
                    <form action="/deleteImage" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$loop->index}}">
                    <input type="button" onclick="deleteImage(this)"  value="delete">
                    </form>
                  </div>
                @endforeach
            @else
                <span>0 Images</span>
            @endif
            </div>
            <form class="form" action="/addGalleryImage" method="POST" enctype="multipart/form-data">
            <br>
            <div class="form-group">
              <input type="file" id="uploadInput" name="galleryImage">
            </div>
            @if(Session::get('error') != '')
            <p style="color:red;"> {{ Session::get('error')}} </p>
            @elseif(Session::get('success') != '')
            <p style="color:green;">{{ Session::get('success') }}</p>
            @endif
            <div class="form-group">
              <input type="submit" class="btn btn-success" id="addButton" value="addImages" hidden>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
      count = {{$count}};
      if(count == 5) $("#uploadInput").remove();

      $('#uploadInput').change(function(){
        if(this.files.length == 0) return $("#addButton").prop('hidden', true);
        $("#addButton").prop('hidden', false);

      });

       function deleteImage(button){
        if(confirm('Are You Sure Want to delete this image?')) $(button).closest('form').submit();
      }
</script>
@endsection
