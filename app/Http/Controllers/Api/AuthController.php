<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'content' => $validator->errors()
            ], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->token = $user->createToken('AppName')->accessToken;

        return response()->json([
            'success' => true,
            'content' => $user,
        ], 200);
    }
    
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $user->token = $user->createToken('AppName')-> accessToken;
            return response()->json([
                'success' => true,
                'content' => $user,
            ], 200); 
        } else{ 
            return response()->json([
                'success' => false,
                'content'=>'Unauthorised',
            ], 401); 
        }
    }

    public function user() {
        return response()->json([
            'success' => true,
            'content' => Auth::user(),
            'token' => Auth::user()->token(),
        ], 200);
    }
}
