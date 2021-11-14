<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id', 'id');
    }

}
