<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bien extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function typeBien()
    {
        return $this->belongsTo(TypeBien::class, 'typeBien_id');
    }
    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }
    public function ville()
    {
        return $this->belongsTo(ville::class, 'ville_id');
    }
    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }
}
