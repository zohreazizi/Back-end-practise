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
                'arrival_place', 'arrival_date', 'arrival_time', 'remaining_capacity', 'bus_id', 'price');
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

    public function edit(StoreRideRequest $request, $id)
    {

        try {
            $bus = Ride::query()->findOrFail($id);

            $data = $request->only('departure_place', 'departure_date', 'departure_time',
                'arrival_place', 'arrival_date', 'arrival_time', 'remaining_capacity', 'bus_id', 'price');

            $bus->departure_place = $request->departure_place;
            $bus->departure_date = $request->departure_date;
            $bus->departure_time = $request->departure_time;
            $bus->arrival_place = $request->arrival_place;
            $bus->arrival_date = $request->arrival_date;
            $bus->arrival_time = $request->arrival_time;
            $bus->remaining_capacity = $request->remaining_capacity;
            $bus->bus_id = $request->bus_id;
            $bus->price = $request->price;
            $bus->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Updated successfully',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
