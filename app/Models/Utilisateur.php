<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Model 
{
    use HasFactory ,HasApiTokens;

     public $fillable =['email' ,'password' ,'sexe' ,'login' ,'telephone' ,'type_user' , 'addresse' ,'slug' ,'nom'] ;
    public function typeUser()
    {
        return $this->belongsTo(TypeUser::class,'type_user' ,'id');
    }
    public function  contrats()
    {
        return $this->hasMany(Contrat::class);
    }
    public function setSlugAttribute($value)
    {
        // Utilisez Str::slug pour générer un slug à partir du titre
        
        $this->attributes['slug'] = Str::slug($value);
    }

    public function locataires()
    {
        return $this->hasManyThrough(Utilisateur::class, Location::class, 'utilisateur_id', 'id', 'id', 'locataire_id');
    }
   
    public function proprietaires()
    {
        return $this->hasManyThrough(
            Utilisateur::class, // La table finale
            Location::class,    // La table intermédiaire
            'locataire_id',     // Clé étrangère sur la table intermédiaire
            'id',               // Clé primaire sur la table finale
            'id',               // Clé primaire sur la table principale
            'utilisateur_id'    // Clé étrangère sur la table intermédiaire
        );
    }

}
