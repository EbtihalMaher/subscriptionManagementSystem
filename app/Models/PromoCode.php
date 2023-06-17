<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class PromoCode extends Model
{
    use SoftDeletes;
    use HasFactory, HasRoles, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'package_id',
        'discount_percent',
    ];

    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'promo_code_id');
    }

    public function scopeByEnterprise ($query) {
        return $query->where('enterprise_id', auth()->user()->enterprise_id);
    }
    
    public function scopeByEnterpriseID($query)
    {
        $enterpriseId = session('enterprise_id');
        return $query->where('enterprise_id', $enterpriseId);
    }
}
