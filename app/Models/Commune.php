<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $fillable = ['wilaya_id', 'name_ar', 'name_fr'];

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }
}
