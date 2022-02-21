<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use App\User;
use Auth;
use Redirect;
use Hash;
use Storage;
use File;
use App\Pricing;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);

            $user->bio == '' || 
            $user->qualifications == '' || 
            $user->location == '' || 
            $user->canTeach == '' || 
            $user->profilePic == '' ||
            $user->business_name == ''
             ? $user->listing = 'no' : $user->listing = 'yes';

        $user->save();

        return view('profile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        //Validate Requests
        $request->validate([
                'name' => 'required|string|max:30|min:4',
                'profilePic' => 'nullable|mimes:jpeg,jpg,png|max:1000'
            ]);

        // Validate Image
        if ($request->hasFile('profilePic')) {
            $file = $request->file('profilePic');
            $extension = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
            $imageName = time() . '.' . $name;
            $file->move(public_path('images'), $imageName);

            if ($user->profilePic != null) {
                File::delete('images/' . $user->profilePic);
            }
        } else {
            $imageName = $user->profilePic;
        }

        Auth::user()->userType == 'tutor' ? $qualification = $request->all()['qualification'] : $qualification = $user->qualifications;
        Auth::user()->userType == 'tutor' ? $business_name = $user->business_name : $business_name = $request->all()['business_name'];


        $user->name = $request->all()['name'];
        $user->bio = $request->all()['bio'];
        $user->location = $request->all()['location'];
        $user->qualifications = $qualification;
        $user->business_name = $business_name;
        $user->profilePic = $imageName;
        $user->save();


        return redirect('/profile')->with('success', 'Profile Updated Sucessfully');
    }

}
