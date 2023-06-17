<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'current_subscription_id',
        'start_date',
        'end_date',
        'package_id',
        'limit',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function currentSubscription()
    {
        return $this->belongsTo(Subscription::class, 'current_subscription_id');
    }
}
