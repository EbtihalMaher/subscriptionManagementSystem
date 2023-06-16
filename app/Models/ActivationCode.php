<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class ActivationCode extends Model
{
    
    use HasFactory, HasRoles, Notifiable;
   
    protected $fillable = [
        'group_id',
        'number', 
    ];

   
    public function activationCodeGroup()
    {
        return $this->belongsTo(ActivationCodeGroup::class, 'activation_code_group_id');
    }

    public function scopeByEnterprise ($query) {
        return $query->where('enterprise_id', auth()->user()->enterprise_id);
    }
}
