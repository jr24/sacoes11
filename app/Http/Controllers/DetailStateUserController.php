<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRegistrationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Detail;
use App\States\DetailState;
use App\States\Pending;

class DetailStateUserController extends Controller
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
    public function store(StateRegistrationRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $user = User::findOrFail($data['idUser']);
        $detail = Detail::findOrFail($data['idDetail']);

        $initialState = $detail->users()->wherePivot('idUser', $user->id)->first()->pivot->state->transitionTo(Pending::class);
        if($detail->users()->wherePivot('idUser', $user->id)->exists()){
            $currentState = $detail->users()->wherePivot('idUser', $user->id)->first()->pivot->state;

            if($currentState->canTransitionTo($data['state'])){
                return response()->json([
                    'success' => false,
                    'message' => 'State not allowed'
                ]);
            }elseif(!$initialState->canTransitionTo($data['state'])){
                return response()->json([
                    'success' => false,
                    'message' => 'State not allowed'
                ]);
            }
        }
        /*if(!$detail->state->canTransitionTo($data['state'])){
            return response()->json([
                'success' => false,
                'message' => 'State not allowed'
            ]);
        }*/
        $user->details()->attach($detail, [
            'state' => $data['state'],
            'date' => $data['date'],
            'observation' => $data['observation']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'State created successfully'
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
