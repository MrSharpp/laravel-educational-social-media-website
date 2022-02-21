<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class StudentsController extends Controller
{
    public function index(){
        $students = User::find(Auth::user()->id)->students;
        return view('students', ['students' => $students]);
    }
}
