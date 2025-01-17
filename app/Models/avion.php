<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class avion extends Model
{
    use HasFactory;
    protected $fillable = ['type_avion', 'capacite_avion', 'fabriquant_avion'];
}
