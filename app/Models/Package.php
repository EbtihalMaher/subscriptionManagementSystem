<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Package extends Model
{
    use HasFactory, HasRoles, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'duration_unit',
        'image',
        'is_unlimited',
        'limit',
        'active'

        
    ];


    public function is_unlimited(){
        return new Attribute(get:fn () =>$this->is_unlimited ? 'is_unlimited': 'limited');

    }




    public function active(){
        return new Attribute(get:fn () =>$this->active ? 'active': 'in_active');
    }

    public function userName(): Attribute
    {
        return new Attribute(get: fn () => $this->name);
    }

    public function enterprise () {
        return $this->belongsTo(Enterprise::class);
    }

    public function scopeByEnterprise ($query) {
        return $query->where('enterprise_id', auth()->user()->enterprise_id);
    }
}
