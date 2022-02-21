@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                @if(Auth::user()->userType != 'school' && Auth::user()->userType != 'coaching')
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Hello, {{ Auth::user()->name }} <br>
                    You are following no body, to follow someone go to home page.
                </div>
                
                @else
                <div class="card-body">
                Hello, {{ Auth::user()->name }} <br>
                Welcome to Dashboard. From Notices And Updates Section you can add post notices & Updates publicly and let them students and parents or visitors know them. <br> <br>
                And From Buttons and link section you can add downloadble form like Admission Form, Holiday homework or can add link like Onlin Classes Link, Online Form Link & and there are many more usage of them.
                </div>
                
                @endif
             </div>
            <br>
            @if(Auth::user()->userType == 'school' || Auth::user()->userType == 'coaching')
             <div class="card">
                <div class="card-header">{{ __('Notices And Updates') }}</div>
                
                <div class="card-body">
                @if(Session::get('AnnoucementPublished') != '')
                    <p style="color:green;">{{ Session::get('AnnoucementPublished') }}</p>
                @endif
                   <form  class="form" action="/annoucement" method="POST" id="annoucementForm">
                    @csrf
                        <div class="form-group">
                            <label for="" >Annoucement Type</label>
                            <select name="annoucementType" id="annoucementType" class="form-control">
                            <option value="0">Select Type</option>
                            <option value="notice">Notice</option>
                            <option value="update">Update</option>
                        

                            </select>
                            <p id="annoucementTypeError" style="color:red;"></p>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <input type="text" name="annoucementText" id="annoucementText" class="form-control" placeholder="Type Content Here">
                            <p id="annoucementTextError" style="color:red;"></p>
                        </div>

                        <input type="button" onclick="annoucement()" class="btn btn-primary" value="Publish">
                   </form>

                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Annoucement Type</td>
                                <td>Content</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>

                </div>
             </div>
             <br>
             <div class="card">
                <div class="card-header">{{ __('Buttons And Links') }}</div>
                
                <div class="card-body">
                @if(Session::get('ButtonPublished') != '')
                   <p style="color:green;"> {{  Session::get('ButtonPublished') }} </p>     
                   @endif
                   <form  class="form" action="/button" method="post" id="buttonForm" enctype='multipart/form-data'>
                   @csrf
                        <div class="form-group">
                            <label for="" ">Button Type</label>
                            <select id="buttonType" name="buttonType" class="form-control">
                            <option value="0">Select Type</option>
                            <option value="button">Button</option>
                            <option value="link">Link</option>
                            </select>
                           
                        </div>

                            <div class="form-group"  id="Abutton" >
                            <label >Choose a file</label>
                            <input type="file" name="uploadedFile" id="uploadedFile" class="form-control">
                            <p id="errorButton" style="color:red;"></p>
                            <label for="">Enter Button Text</label><br>
                            <input type="text" name="buttonText" id="buttonText" class="form-control">
                            <p id="errorContent" style="color:red;"></p>

                            </div>

                            <div class="form-group" id="url" >
                            <label >Url</label >
                            <input type="text" name="buttonUrl" id="buttonLink"  class="form-control" placeholder="Type Content Here">
                            <p style="color:red;" id="urlErrorURL"></p><br>
                            <label for="">Enter Url Text</label><br>
                            <input type="text" name="buttonText" id="buttonTextU" class="form-control">
                            
                            <p id="urlError" style="color:red;"></p>
                            </div>
                        

                        <input type="button" class="btn btn-primary" value="Add Button" onclick="addButton()">
                   </form>

                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Button Type</td>
                                <td>File/Url</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>

                </div>
               
             </div>
             @endif
        </div>
    </div>
</div>

<script>
    function buttonError(msg) {
        $("#uploadedFile").val('');
    $("#errorButton").html(msg); 
         }

        $("#uploadedFile").change(function(){
             if(this.files[0].size > 2000000) { return buttonError("The size of the file you have selected is greater than 2mb. Please choose a file which is less than 2mb");}
             sup = ['image/jpg', 'image/jpeg', 'application/pdf', 'image/png', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'application/x-zip-compressed', 'application/msword'];
            if(jQuery.inArray(this.files[0].type, sup) == -1) {return buttonError("Please upload a valid file. Supported File Type 'jpg', 'jpeg', 'pdf', 'png', 'ppt', 'docx', 'doc', 'xlsx', 'txt', 'zip', 'rar'");}
            
        });


    function addButton(){
        $("errorButton").html('');
        $("#buttonError").html('');
        $("#urlError").html('');
        $("#urlErrorURL").html('');
        if($("#buttonType").val() === "button"){
            if($("#uploadedFile").val() == '') {return buttonError('Please upload a file')};
            if($("#buttonText").val() == '') { return $("#errorContent").html('Please enter a button text to display what this button have'); }
            
            $("#buttonForm").submit();
        }else if($("#buttonType").val() === "link")
        {
            if($("#buttonLink").val() == '') {return $("#urlErrorURL").html("Please enter the link");}
            if($("#buttonTextU").val() == '') {return $("#urlError").html("Please enter the URL Text");}

            $("#buttonForm").submit();
        }   
    }



  $("#Abutton").hide();
            $("#url").hide();

    $("#buttonType").change(function(){
        if($(this).find(":selected").val() == 'button') {
            $("#Abutton").show();
            $("#url").hide();

        }else if($(this).find(":selected").val() == 'link') {
            $("#url").show();

            $("#Abutton").hide();
        }else
        {
            $("#Abutton").hide();
            $("#url").hide();
        }
    });
    
    function annoucement(){
        $("#annoucementTypeError").html('');
        $("#annoucementTextError").html('');
        if($("#annoucementType").val() == '0') {  return $("#annoucementTypeError").html('Please select annoucement Type'); }
        if($("#annoucementText").val() == '') {return $("#annoucementTextError").html('Please enter Annoucement Content'); }
        $("#annoucementForm").submit();
    }
    
</script>
@endsection
