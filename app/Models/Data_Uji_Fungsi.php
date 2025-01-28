<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Uji_Fungsi extends Model
{
    protected $table = 'data_uji_fungsis';
    protected $fillable = [
        'no_seri',
        'item',
        'qty',
        'satuan',
        'foto',
        'no_order',
        'no_faktur',
        'tgl_faktur',
        'tgl_terima',
        'tgl_selesai',
        'id_teknisi',
        'status',
    ];
}
