<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public function locataire()
    {
        return $this->belongsTo(Utilisateur::class ,'locataire_id');
    }
    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class ,'utilisateur_id');
    }
    public function contrat()
    {
        return $this->belongsTo(Contrat::class ,'contrat_id');
    }



}
