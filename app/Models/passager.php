<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class passager extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_passager',
        'prenom_passager',
        'email_passager',
        'date_naissance',
        'telephone_passager',
        'numero_passeport',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_passager');
    }
}
