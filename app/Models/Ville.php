<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    public function biens()
    {
        return $this->hasMany(Bien::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
