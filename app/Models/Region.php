<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['code', 'name_ar', 'name_fr'];

    public function wilayas()
    {
        return $this->hasMany(Wilaya::class);
    }
}
