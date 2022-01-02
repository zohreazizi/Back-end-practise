<?php

use Illuminate\Support\Facades\DB;

class ReserveRepository
{
    public function totalSeats($param)
    {
        return DB::table('rides')
            ->join('buses', 'bus_id', '=', 'buses.id')
            ->where('rides.id', $param)->pluck('total_seats')->first();
    }

    public function seats()
    {
        return DB::table('reserves')->pluck('gender', 'seat_no');
    }

}
