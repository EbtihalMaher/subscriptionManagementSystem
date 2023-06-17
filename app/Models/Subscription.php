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
        'limit',
        'onlinepayment_id',
        'subscription_method',
        'paid_amount',
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
    
    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }
    
    public function scopeByEnterpriseID($query)
    {
        $enterpriseId = session('enterprise_id');
        return $query->where('enterprise_id', $enterpriseId);
    }

    public function clientProfile()
    {
        return $this->hasMany(ClientProfile::class, 'current_subscription_id');
    }

}
