<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->hasRole('recepcionista')){
            $users = User::role('cliente')->get();
        }elseif(auth()->user()->hasRole('admin')){
            $users = User::all();
        }
        foreach ($users as $user){
            $user->role = $user->getRoleNames();
            $user->makeHidden(['roles', 'email_verified_at', 'created_at', 'updated_at']);
        }
        return response()->json([
            'users' => $users,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegistrationRequest $request)
    {
        try{
            $request->validated();
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            if(auth()->user()->hasRole('admin')){
                $user->assignRole($request->role);
            }elseif(auth()->user()->hasRole('recepcionista')){
                $user->assignRole('cliente');
            }         
            
            return response()->json([
                'status' => true,
                'message' => 'User created successfully'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $user->makeHidden(['roles', 'email_verified_at', 'created_at', 'updated_at']);
        if(auth()->user()->hasRole('admin')){
            $role = $user->getRoleNames();
            return response()->json([
                'user' => $user,
                'role' => $role
            ], 200);
        }elseif(auth()->user()->hasRole('recepcionista')){
            if($user->hasRole('cliente')){
                return response()->json($user);
            }
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = (new UserEditRequest)->rules($id);
        $validatedData = $request->validate($rules);
        $user = User::where('id', $id)->firstOrFail();
        $user->update($validatedData);
        if(auth()->user()->hasRole('admin')){
            $user->assignRole($request->role);
        }elseif(auth()->user()->hasRole('recepcionista')){
            $user->assignRole('cliente');
        }
        return response()->json([
            'status' => true,
            'message' => 'User updated successfully'
        ], 200);         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function enable(string $id){
        if(auth()->user()->hasRole('admin')){
            $user = User::findOrFail($id);
            $user->active = true;
            return response()->json([
                'status' => 'true',
                'massage' => 'User enable'
            ], 200);
        }
        return response()->json([
            'status' => 'false',
            'message' => 'Error enable user'
        ],500);
    }

    public function disable(string $id){
        if(auth()->user()->hasRole('admin')){
            $user = User::findOrFail($id);
            $user->active = false;
            return response()->json([
                'status' => 'true',
                'massage' => 'User disable'
            ], 200);
        }
        return response()->json([
            'status' => 'false',
            'message' => 'Error disable user'
        ],500);
    }
}
