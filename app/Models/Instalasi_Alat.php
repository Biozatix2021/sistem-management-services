<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instalasi_Alat extends Model
{
    protected $table = 'instalasi_alats';
    protected $fillable = [
        'id',
        'id_alat',
        'id_instalasi',
        'tanggal_instalasi',
        'tanggal_akhir',
        'status',
        'keterangan',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id', 'id');
    }

    public function rumah_sakit()
    {
        return $this->belongsTo(Rumah_Sakit::class, 'rumah_sakit_id', 'id');
    }

    public function teknisi()
    {
        return $this->belongsTo(Teknisi::class, 'teknisi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('id', 'like', '%' . $search . '%')
                ->orWhere('id_alat', 'like', '%' . $search . '%')
                ->orWhere('id_instalasi', 'like', '%' . $search . '%')
                ->orWhere('tanggal_instalasi', 'like', '%' . $search . '%')
                ->orWhere('tanggal_akhir', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%');
        });
    }
}
