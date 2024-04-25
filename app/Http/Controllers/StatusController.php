<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Detail;
use App\Http\Requests\StatusRequest;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $idDetail)
    {
        $statuses = Status::where('idDetail', $idDetail)->get();
        $statuses->makeHidden(['created_at', 'updated_at']);
        return response()->json([
            'statuses' => $statuses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusRequest $request)
    {
        if(!Auth::user()->hasRole('cliente')){
            $request->validated();
            $data = $request->all();
            $detail = Detail::findOrFail($data['idDetail']);
            $data['idUser'] = Auth::user()->id;
            $data['idDetail'] = $detail->id;
            $status = $detail->statuses->last();
            if($status == null && $data['state'] != "pending"){
                return response()->json([
                    'status' => false,
                    'message' => 'State initial not corresponding',
                ], 422);
            }elseif($status != null && !$status->state->canTransitionTo($data['state'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'State transition not allowed',
                ], 422);
            }
            //$status->state->transitionTo($data['state']);
            Status::create($data);
        }
        return response()->json([
            'status' => true,
            'message' => 'Status created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idDetail, string $id)
    {
        $statuses = Status::where('idDetail', $idDetail)->get();
        $status = $statuses->find($id);
        $status->makeHidden(['created_at', 'updated_at']);
        return response()->json([
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusRequest $request, string $id)
    {
        if(!Auth::user()->hasRole('cliente')){
            $request->validated();
            $status = Status::findOrFail($id);
            $status->update($request->all());
        }
        return response()->json([
            'status' => true,
            'message' => 'Status updated'
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
