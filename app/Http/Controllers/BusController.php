<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Bus;
use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBusRequest;

class BusController extends Controller
{
    use Responses;
    public function store(StoreBusRequest $request)
    {
        try {
            $data = $request->only('name', 'plate_number', 'total_seats', 'company_name');

            $bus = Bus::create($data);
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

    public function edit(StoreBusRequest $request, $id)
    {

        try {
            $bus = Bus::query()->findOrFail($id);

            $data = $request->only('name', 'plate_number', 'total_seats', 'company_name');
            //request for edit
            $bus->name = $request->name;
            $bus->plate_number = $request->plate_number;
            $bus->total_seats = $request->total_seats;
            $bus->company_name = $request->company_name;
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

    public function destroy($id)
    {
        try {
            $bus = Bus::find($id);
            $bus->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Archived successfully',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }

    }
}
