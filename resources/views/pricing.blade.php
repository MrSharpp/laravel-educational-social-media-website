@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
            Fees Structure
          </div>
          <div class="card-body">

          <a href="/profile" class="btn btn-primary">Profile</a>
                <a href="/pricing" class="btn btn-primary">Fee Structure</a>
                {!!Auth::user()->userType != 'tutor' ? '<a href="/galleryImages" class="btn btn-primary">Images</a>' : '' !!}

          <form action="/addRecord" id="addRecord" method="POST" >
          @csrf
            <div class="form-group">
              <label for="">Class Name</label>
              <input type="text" class="form-control" name="className">
            </div>
            <div class="form-group">
              <label for="">Monthly Fee (In Rupees)</label>
              <input type="number" class="form-control" name="fees">
            </div>
            <p style="color:red;" id="error"></p>
            <input class="btn btn-success" type="button" value="Add" onclick="addFee();">
          </form>
          @if(Session::get('success') != '')  <p style="color:green;">{{ Session::get('success') }}</p> @endif
          <table class="table table-border">
                        <thead>
                            <tr>
                                <td><b>Class Name</b></td>
                                <td><b>Fees Monthly</b></td>
                                <td><b>Action</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pricings as $pricing)
                              <tr><td>{{$pricing['className']}}</td><td>{{$pricing['fees']}}</td><td><a href="/deleteRecord/{{$pricing['id']}}">Delete</a></td></tr>
                            @endforeach
                        </tbody>
                    </table>
          </div>
        </div>
      </div>
    </div>
</div>

<script>
  function addFee(){
    if($("[name='className']").val() == '' || $("[name='fees']").val() == '') return $("#error").html('Please enter Class Name and fee price to Add.');
    $("#addRecord").submit();
  }
</script>
@endsection
