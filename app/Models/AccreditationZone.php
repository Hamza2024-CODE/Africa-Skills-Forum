<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccreditationZone extends Model
{
    protected $fillable = ['code', 'name_ar', 'name_fr', 'color_hex'];
}
