<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;
    public function  proprietaire()
    {
        return $this->belongsTo(Utilisateur::class ,'utilisateur_id'); 
    }
    public function  bien()
    {
        return $this->belongsTo(Bien::class ,'bien_id'); 
    }
    public function  typePaiment()
    {
        return $this->belongsTo(TypePaiment::class ,'type_paiment_id'); 
    }
}
