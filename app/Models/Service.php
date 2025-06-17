<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'price',
        'duration',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function staff()
    {
        return $this->belongsToMany(User::class, 'service_staff', 'service_id', 'staff_id')
            ->where('role', 'staff');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
