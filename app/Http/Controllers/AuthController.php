<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        try{
            $request->validated();

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Password does not match with our record.',
                ], 401);
            }

            if(Auth::user()->active == false){
                return response()->json([
                    'status' => false,
                    'message' => 'User not active',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $roles = $user->getRoleNames();
            $permissions = $user->getPermissionsViaRoles()->pluck('name');
            $token = $user->createToken('API TOKEN')->plainTextToken;
            return response()->json([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'user' => [
                    'name' => $user->name,
                    'lastname' => $user->lastname
                ],
                'status' => true,
                'roles' => $roles,
                'permissions' => $permissions,
                'message' => 'Login success',
                'token' => $token
            ], 200);
        }
        catch(\Throwable $th){
            return response()->json([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Logout success'
            ], 200);
        }
        catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
