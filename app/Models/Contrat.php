<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    public function typeCharge()
    {
        return $this->belongsTo(TypeEchange::class, 'type_charge_id');
    }
    public function typePaiement()
    {
        return $this->belongsTo(TypePaiment::class, 'type_paiement_id');
    }
    public function typeContrat()
    {
        return $this->belongsTo(TypeContrat::class, 'type_contrat_id');
    }
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
