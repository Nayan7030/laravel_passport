<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
class AuthController extends Controller
{
    //

    public function register(Request $request){

    	$users = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => \Hash::make($request->password)
    	]);

    	$token = $users->createToken('Token')->accessToken;

    	return response()->json(['token'=>$token,'data' => $users]);

    }

    public function login(Request $request){

    	$data = [
    		'email' => $request->email,
    		'password' => $request->password
    	];

    	if(auth()->attempt($data)){
    		$token = auth()->user()->createToken('Token')->accessToken;
    		return response()->json(['token'=>$token],201);
    	}
    	else{
    		return response()->json(['error'=> 'unauthorized'],401);
    	}
    }

    public function userinfo(){
    	$user = auth()->user();
    	if($user){
    		return response()->json(['user'=>$user],201);
    	}
    	else{
    		return response()->json(['error'=> 'unauthorized'],401);
    	}
    	
    }
}
