<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if($user->hasRole('admin') || $user->hasRole('recepcionista')){
            $orders = Order::all();
        }elseif($user->hasRole('sastre')){
            $orders = Order::where('idSastre', Auth::user()->id)->get();
        }
        foreach ($orders as $order){
            $order->makeHidden(['created_at', 'updated_at']);
            $order->details->makeHidden(['created_at', 'updated_at']);
            $order->adminRecepcionista->makeHidden(['created_at', 'updated_at']);
            $order->cliente->makeHidden(['created_at', 'updated_at']);
            $order->sastre->makeHidden(['created_at', 'updated_at']);
        }
        return response()->json([
            'orders' => $orders
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = Order::create($request->all());
        foreach($request->details as $detail){
            $order->details()->create($detail);
        }
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
