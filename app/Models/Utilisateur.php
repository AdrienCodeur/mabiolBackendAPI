<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Model implements Authenticatable
{
    use HasFactory ,HasApiTokens;

     public $fillable =['email' ,'password' ,'sexe' ,'login' ,'telephone' ,'typeUser' , 'adresse' ,'slug' ,'nom'] ;
    public function typeUser()
    {
        return $this->belongsTo(TypeUser::class,'type_user' ,'id');
    }
    public function  contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
