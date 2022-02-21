<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Redirect;
use Hash;
use Storage;
use File;
use App\Pricing;

class CoachingProfileController extends Controller
{
    public function updateProfile(Request $request)
    {

        $request->validate([
                'name' => 'required|string|max:30|min:4',
                'profilePic' => 'nullable|mimes:jpeg,jpg,png|max:1000',
                'galleryImage' => 'nullable|mimes:jpeg,jpg,png,bmp|max:2000'
            ]);

        $user = User::find(Auth::user()->id);
        $user->gallery != null ? $count = count(json_decode($user->gallery)) : $count = 0;
        $GalleryImages = json_decode($user->gallery);

        if ($GalleryImages == null) {
            $GalleryImages = [];
        }

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


        $user->name = $request->all()['name'];
        $user->bio = $request->all()['bio'];
        $user->location = $request->all()['location'];
        $user->gallery = json_encode($GalleryImages);
        $user->profilePic = $imageName;
        $user->save();

        return redirect()->route('profile', ['message' => 'Successfully ']);
    }

    public function galleryImages()
    {
        $user = User::find(Auth::user()->id);
        $galleryImages = json_decode($user->gallery);
        gettype($galleryImages) == 'array' ? $count = count($galleryImages) : $count = 0;
        $count == 0 ? : $user->gallery = null;
        return view('galleryImage', ['images' => $galleryImages, 'count' => $count]);
    }

    public function addGalleryImage(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $dbGalleryImages = json_decode($user->gallery) ?? array();
        if ($request->hasFile('galleryImage')){
            $galleryImage = $request->file('galleryImage');
            $extension = $galleryImage->getClientOriginalExtension();
            $name = $galleryImage->getClientOriginalName();
            $galleryImageName = time() . '.' . $name;
            $galleryImage->move(public_path('images'), $galleryImageName);

            array_push($dbGalleryImages, $galleryImageName);

            $user->gallery = json_encode($dbGalleryImages);
            $user->save();
            return redirect('/galleryImages')->with('success','Success, Your image is uploaded');
        }else return redirect('/galleryImages')->with('error','Please coose an Image to upload');
    }

    public function deleteImage(Request $request){
        $user = User::find(Auth::user()->id);
        $galleryImages = json_decode($user->gallery);
        $imageName = $galleryImages[$request->all()['id']];
        File::delete("images/".$imageName);
        unset($galleryImages[$request->all()['id']]);
        $user->gallery = json_encode(array_values($galleryImages));
        $user->save();
        return redirect('/galleryImages')->with('success', 'Success, Image is deleted sucessfully');
    }
    
}
