<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'client_subscriptions';

    protected $fillable = [
        'client_id',
        'package_id', 
        'enterprise_id',
        'start_date', 
        'end_date',
        'limit'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
