<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ride(){
        return $this->belongsTo(Ride::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'transaction_id');
    }
}
