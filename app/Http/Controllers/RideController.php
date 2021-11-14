<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRideRequest;
use App\Models\Ride;
use Illuminate\Http\Request;
use Throwable;

class RideController extends Controller
{
    public function store(StoreRideRequest $request)
    {
        try {
            $data = $request->only('departure_place', 'departure_date', 'departure_time',
                'arrival_place', 'arrival_date', 'arrival_time', 'remaining_capacity', 'bus_id');
            $validator = $request->validated();
            // if there are some error's, show them to user
            $bus = Ride::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Saved successfully',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
