<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class ActivationCodeGroup extends Model
{
    use SoftDeletes;
    use HasFactory, HasRoles, Notifiable;
   
    protected $fillable = [
        'package_id',
        'group_name',
        'count',
        'start_date',
        'expire_date',
        'price',
    ];

    public function package() {
        return $this->belongsTo(Package::class);
    }

    public function scopeByEnterprise ($query) {
        return $query->where('enterprise_id', auth()->user()->enterprise_id);
    }

}
