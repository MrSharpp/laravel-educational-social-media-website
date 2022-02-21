<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class PageController extends Controller
{
    public function index($id)
    {
        $user = User::findOrfail($id);
        $user == null ? : redirect()->back();

        return view('page', ['user' => $user]);
    }

}
