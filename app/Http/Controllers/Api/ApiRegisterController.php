<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6.6.18.
 * Time: 12.16
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegister;
use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

/**
 * Class ApiRegisterController
 * @package App\Http\Controllers\Api
 */
class ApiRegisterController extends Controller
{
    /**
     * User registration with validation and setting a token
     * @param UserRegister $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegister $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);
        $user = new \App\Http\Resources\User($user);
        return response()->json(compact('token', 'user'));
    }
}