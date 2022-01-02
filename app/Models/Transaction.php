<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    const STATUS_SUCCESS = 2;
    const STATUS_PENDING = 1;
    const STATUS_FAILED = 0;

    protected $guarded = [
        'id'
    ];

    public function reserve()
    {
        return $this->belongsTo(Reserve::class, 'reserve_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
