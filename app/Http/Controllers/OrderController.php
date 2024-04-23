<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRegistrationRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
    public function store(OrderRegistrationRequest $request)
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('recepcionista')){
            $request->validated();
            $data = $request->all();
            $adminRecepcionista = Auth::user()->id;
            $cliente = User::findOrFail($request->idCliente);
            $sastre = User::findOrFail($request->idSastre);
            if(!$sastre->hasRole('sastre') || !$cliente->hasRole('cliente')){
                return response()->json([
                    'status' => false,
                    'message' => 'Sastre or Cliente not corresponding',
                ]);
            }
            $data['idAdminRecepcionista'] = $adminRecepcionista;
            $data['idCliente'] = $cliente->id;
            $data['idSastre'] = $sastre->id;
            $order = Order::create($data);
            foreach($request->details as $detail){
                $order->details()->create($detail);
            }
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $order->setVisible(['startDate', 'endDate', 'description', 'priority']);
        $adminRecepcionista = $order->adminRecepcionista->setVisible(['name', 'lastname']);
        $cliente = $order->cliente->setVisible(['name', 'lastname']);
        $sastre = $order->sastre->setVisible(['name', 'lastname']);
        $details = $order->details->setVisible(['typeGarment', 'quantity', 'costUnit']);
        return response()->json([
            'order' => $order,
            'adminRecepcionista' => $adminRecepcionista,
            'cliente' => $cliente,
            'sastre' => $sastre,
            'details' => $details            
        ], 200);
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
