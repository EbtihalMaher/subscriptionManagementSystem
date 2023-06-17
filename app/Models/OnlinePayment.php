<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    use HasFactory;
    
    protected $table = 'online_payments';

    protected $fillable = ['client_id', 'amount', 'transaction_number', 'payment_method','promo_code_id'];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }
    
    public function scopeByEnterpriseID($query)
    {
        $enterpriseId = session('enterprise_id');
        return $query->where('enterprise_id', $enterpriseId);
    }
}
