<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'phone_number', 
        'enterprise_id'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

}
