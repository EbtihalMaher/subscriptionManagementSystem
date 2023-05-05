<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class ActivationCode extends Model
{
    use HasFactory, HasRoles, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'number', 
    ];

    public function activationCodeGroup() {
        return $this->belongsTo(ActivationCodeGroup::class);
    }

    public function scopeByEnterprise ($query) {
        return $query->where('enterprise_id', auth()->user()->enterprise_id);
    }
}
