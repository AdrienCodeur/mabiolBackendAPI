<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function typeBien()
    {
        return $this->belongsTo(TypeBien::class, 'type_bien');
    }

    public function ville()
    {
        return $this->belongsTo(ville::class, 'ville');
    }
    public function finances()
    {
        return $this->hasMany(Finance::class);
    }


}
