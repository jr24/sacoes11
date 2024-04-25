<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Detail;
use App\Http\Requests\DetailRequest;
use App\Models\Order;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DetailRequest $request)
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('recepcionista')){
            $request->validated();
            Detail::create($request->all());
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $detail = Detail::findOrFail($id);
        $detail->setVisible(['typeGarment', 'quantity', 'costUnit']);
        return response()->json([
            'detail' => $detail
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DetailRequest $request, string $id)
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('recepcionista')){
            $request->validated();
            $detail = Detail::findOrFail($id);
            $detail->update($request->all());
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail updated successfully',
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
