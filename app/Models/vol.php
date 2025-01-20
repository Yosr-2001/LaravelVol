<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vol extends Model
{ use HasFactory;

    protected $fillable = [
        'numero_vol',
        'heure_depart',
        'heure_arrivee',
        'statut',
        'porte',
        'type_avion',
        'prix',
        'id_aeroport_depart',
        'id_aeroport_arrivee',
    ];

    public function aeroportDepart()
    {
        return $this->belongsTo(Aeroport::class, 'id_aeroport_depart');
    }

    public function aeroportArrivee()
    {
        return $this->belongsTo(Aeroport::class, 'id_aeroport_arrivee');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_vol');
    }
}
