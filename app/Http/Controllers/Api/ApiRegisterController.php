<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6.6.18.
 * Time: 12.16
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class ApiRegisterController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        //$user = User::first();
        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token','user'));
    }
}