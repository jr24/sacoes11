<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
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
            $token = $user->createToken('API TOKEN')->plainTextToken;
            return response()->json([
                'status' => true,
                'token' => $token,
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
        $rules = (new UserRegistrationRequest)->rules($id);
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
    public function destroy(string $id)
    {
        //
    }
}
