<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class aeroport extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_aeroport',
        'ville_aeroport',
        'pays_aeroport',
    ];

    public function volsDepart()
    {
        return $this->hasMany(Vol::class, 'id_aeroport_depart');
    }

    public function volsArrivee()
    {
        return $this->hasMany(Vol::class, 'id_aeroport_arrivee');
    }
}
