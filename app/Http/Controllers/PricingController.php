<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pricing;
use Auth;

class PricingController extends Controller
{
    public function index(){
        $pricing = Pricing::where('user_id', Auth::user()->id)->get()->toArray();
        return view('pricing', ['pricings' => $pricing]);
    }

    public function delete($id){
        Pricing::find($id)->delete();
        return redirect('/pricing');

    }

    public function addRecord(Request $request){
        $pricing = new Pricing([
            'className' => $request->all()['className'], 
            'fees' => $request->all()['fees'],
            'user_id' => Auth::user()->id
             ]);
        $pricing->save();
        return redirect('/pricing')->with('success', 'Sucess, Data Added');

    }
}
