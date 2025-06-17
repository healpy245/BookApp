<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function staffs()
    {
        return $this->hasMany(User::class, 'vendor_id')->where('role', 'staff');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    
}
