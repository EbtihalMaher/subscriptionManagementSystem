<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;
    
    public function role () {
        return $this->belongsTo('App\Models\model_has_permission')->where('model_type','=','App\Models\Admin');
    }
}
