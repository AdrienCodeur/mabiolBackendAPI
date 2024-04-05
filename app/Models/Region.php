<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    
    public $fillable =['nom' ,'pay_id'] ;
    public function pay ()
    {
        return $this->belongsTo(Pays::class, 'pay_id');
    }

}
