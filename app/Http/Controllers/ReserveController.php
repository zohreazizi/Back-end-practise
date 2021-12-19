<?php

namespace App\Http\Controllers;


use Throwable;
use App\Models\Ride;
use App\Models\Reserve;
use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Jobs\DeleteReservation;
use App\Http\Requests\SeatRequest;
use Illuminate\Support\Facades\DB;


class ReserveController extends Controller
{
    use Responses;

    public function show(SeatRequest $request)
    {
        try {

            $total_seats = DB::table('rides')->where('rides.id', $request->id)
                ->join('buses', 'bus_id', '=', 'buses.id')
                ->pluck('total_seats')->first();

            $seats = DB::table('reserves')->where('ride_id', $request->id)->pluck('gender', 'seat_no')->toArray();

            $all_seats = [];
            for ($i = 1; $i <= $total_seats; $i++) {
                $all_seats[$i] = "_";
                if (array_key_exists($i, $seats)) {
                    $all_seats[$i] = $seats[$i];
                }
            }
            //TODO message in another file (lang => info text)
            return $this->success($all_seats, 'status of all the seats in this bus', 200);
        } catch (Throwable $e) {
            return $this->failure($e->getMessage(), 401);
        }

    }

    public function store(Request $request)
    {

        try {

            $array = json_decode($request->getContent(), true);
            $cost = Ride::query()->find($request->ride_id)->price;
            foreach ($array as $seats) {
                $keys = array_keys($seats);
                for ($x = 0; $x < count($seats); $x++) {
                    $reservation = new Reserve();
                    $reservation->seat_no = $keys[$x];
                    $reservation->gender = $seats[$keys[$x]];
                    $reservation->user_id = auth('api')->user()->id;
                    $reservation->ride_id = $request->ride_id;
                    $reservation->cost = $cost * count($seats);
                    $reservation->save();
                }
                $passenger_no = count($seats);
            }


            $receipt = [
                'number of passengers' => $passenger_no,
                'cost of each ticket' => $cost,
                'total cost' => $passenger_no * $cost
            ];

            $this->dispatch((new DeleteReservation($reservation))->delay(now()->addMinutes(15)));

            return $this->success($receipt, 'saved', 200);
        } catch (Throwable $e) {
            return $this->failure($e->getMessage(), 401);

        }
    }




















//    public function test()
//    {
//-----------------to get users with the role of company-----------------//
//        $user = DB::table('users')
//            ->join('role_user', function ($join) {
//                $join->on('users.id', '=', 'role_user.user_id')
//                    ->where('role_user.role_id', '=', 3);
//            })
//            ->get();
//            return response()->json($user);
//---------------to get the rides of each bus---------------------------//
//        $bus = Bus::query()->find(2);
//        return response()->json($bus->rides);
//----------------to get the bus of each ride----------------------------//
//        $ride = Ride::query()->find(16);
//        return response()->json($ride->bus);
//----------------to get the specific ride with its bus properties-------//
//        $rides = DB::table('rides')
//            ->join('buses', 'bus_id', '=', 'buses.id')
//            ->where('departure_place', 'تهران')
//            ->where('arrival_place', 'رشت')
//            ->where('departure_date', '2021-11-25')
//            ->where("remaining_capacity", ">", 0)
//            ->orderBy('departure_time', 'asc')->get();
//        return response()->json($rides);
//----------------to get user_id----------------------------------------//
//        return response()->json(auth('api')->user());
//    }
}
