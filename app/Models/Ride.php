<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ride extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function reserves(){
        return $this->hasMany(Reserve::class);
    }

    public function scopeSort($query, $param)
    {
        return $query->orderBy($param);
    }


}
