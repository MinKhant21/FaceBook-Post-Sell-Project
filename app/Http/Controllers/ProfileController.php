<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Error;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile.index');
    }

    public function store(Request $request)
    {
        $v =   Validator($request->all(),[
            'name' => 'required',
            'email' => 'required'
        ]);

        if($v->fails())
        {
            throw new Error($v->errors());
        }
        
        try{
            $profile = User::find(Auth::id());
            $profile->name = $request->name;
            $profile->save();
            $msg = "Successfully Changed";
            return array('status' => 200 , 'msg' => $msg );
        }catch(Expression $ex){
            $msg = 'error';
            $arr = array("status" => 400, "msg" => $msg,"result" => array() );
            return $arr;
        }



    }
}
