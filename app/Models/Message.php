<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

        protected $fillable = ['emetteur_id' ,'recepteur_id' ,'contenue' ,'statut' ,'slug'] ;
    public function sender()
    {
        return $this->belongsTo(User::class, 'recepteur_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'emetteur_id');
    }
}
