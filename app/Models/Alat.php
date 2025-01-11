<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alats';
    protected $fillable = ['nama', 'type'];

    public function sop_alat()
    {
        return $this->hasMany(sop_alat::class);
    }
}
