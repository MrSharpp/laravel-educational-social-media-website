<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    public function home()
    {
        $tutors = User::where('bio', '!=', '')->where('qualifications', '!=', NULL)->where('location', '!=', NULL)->where('canTeach', '!=', NULL)->where('profilePic', '!=', NULL)->get();

        return view('home', ['tutors' => $tutors]);
    }

    public function follow(Request $request){
        // Add In Targetted Followers
        $targetUser = User::find($request->all()['id']);
        $targetUserFollowers = $targetUser->followers;
        if($targetUserFollowers == '') $targetUserFollowers = [];
        array_push($targetUserFollowers, Auth::user()->id);
        $targetUser->followers = $targetUserFollowers;
        $targetUser->save();

        //Add Own Following
        $user = User::find(Auth::user()->id);
        $userFollowing = $user->following;
        if($userFollowing == '') $userFollowing = [];
        array_push($userFollowing, $request->all()['id']);
        $user->following = $userFollowing;
        $user->save();

        return response()->json('s');
    }

    public function unfollow(Request $request){
        // Add In Targetted Followers
        $targetUser = User::find($request->all()['id']);
        $targetUserFollowers = $targetUser->followers;
        $key = array_search(Auth::user()->id, $targetUserFollowers);
        unset($targetUserFollowers[$key]);
        $targetUser->followers = $targetUserFollowers;
        $targetUser->save();

        //Add Own Following
        $user = User::find(Auth::user()->id);
        $userFollowing = $user->following;
        $key = array_search($request->all()['id'], $userFollowing);
        unset($userFollowing[$key]);
        $user->following = $userFollowing;
        $user->save();

        return response()->json('s');
    }

    public function button(Request $request){
        if($request->buttonType == 'button'){
        $user = User::find(Auth::user()->id);
        $buttons = json_decode($user->buttons) ?? [];
        $file = $request->file('uploadedFile');
        $name = $file->getClientOriginalName();
        $fileName = time() . '.' . $name;
        array_push($buttons, ['button' => ['buttonText',$name]]);
        $user->buttons = $buttons;
        $user->save();
        $file->move(public_path('images'), $fileName);
        return redirect()->back()->with('ButtonPublished', 'Button Added, check it on your profile page');
        }elseif($request->buttonType == 'link'){
            $url = $request->buttonUrl;
            $user = User::find(Auth::user()->id);
            $buttons = json_decode($user->buttons);
            array_push($buttons, ['url' => [$request->buttonText, "'".$url."'"]]);
            $user->buttons = $buttons;
            $user->save();
            return redirect()->back()->with('ButtonPublished', 'Url Added, check it on your profile page');
        }
    }

    public function annoucement(Request $request){
        $user = User::find(Auth::user()->id);
        $annoucements = json_decode($user->annoucements) ?? [];
        array_push($annoucements, $request->annoucementType);
        $user->annoucements = $annoucements;
        $user->save();
        return redirect()->back()->with('AnnoucementPublished', 'Annoucement Published, Visit Your Page to check');
    }
}
