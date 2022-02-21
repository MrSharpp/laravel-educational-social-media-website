@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Students
                    </div>
                    <div class="card-body">
                        @foreach($students as $student)
                            {{$student}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection