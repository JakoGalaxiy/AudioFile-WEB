<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancion extends Model
{
    protected $fillable = ['titulo', 'artista', 'duracion'];
}