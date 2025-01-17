<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class reservation extends Model
{  use HasFactory;

    protected $fillable = [
        'id_passager',
        'id_vol',
        'date_reservation',
        'statut_reservation',
        'prix_reservation',
    ];

    public function passager()
    {
        return $this->belongsTo(Passager::class, 'id_passager');
    }

    public function vol()
    {
        return $this->belongsTo(Vol::class, 'id_vol');
    }
}
