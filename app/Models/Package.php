<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Package extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'image', 'title', 'tracking_number', 'driver_name', 'delivery_address', 'delivery_status', 'special_instructions', 'payment_reference'];
                    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
