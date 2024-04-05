<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnee extends Model
{
    use HasFactory;
    public $fillable = ['statut' ,'utilisateur_id'  ,"typeabonnement_id" ,"slug"]   ;

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
    public function typeAbonnee ()
    {
        return $this->belongsTo(TypeAbonnement::class, 'typeabonnement_id');
    }


}
