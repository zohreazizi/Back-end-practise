<?php

namespace App\Http\Controllers;

use App\Http\Requests\RideRequest;
use App\Http\Requests\StoreRideRequest;
use App\Models\Ride;
use App\Models\User;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Throwable;

class RideController extends Controller
{
    use Responses;

    public function show(RideRequest $request)
    {
        try {
            $departure_place = $request->departure_place;
            $departure_date = $request->departure_date;
            $arrival_place = $request->arrival_place;

            $available_rides = Ride::query()->where('departure_place', $departure_place)
                ->where('arrival_place', $arrival_place)->where('departure_date', $departure_date)
                ->where("remaining_capacity", ">", 0)->orderBy('departure_time', 'asc')->get();
            return $this->success($available_rides, 'results for your search', 200);
        } catch (Throwable $e) {
            return $this->failure($e->getMessage(), 401);
        }
    }

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
