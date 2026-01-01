<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratPerjanjian extends Model
{
    protected $fillable = [
        'no_surat',
        'tanggal_surat',
        'nama_pelanggan',
        'alamat_pelanggan',
        'no_telp_pelanggan',
        'email_pelanggan',
        'tanggal_selesai',
        'nilai_kontrak',
        'syarat_ketentuan',
        'status_surat',
        'nama_pihak_pertama',
        'nama_pihak_kedua',
        'id_sales',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_selesai' => 'date',
        'nilai_kontrak' => 'decimal:2',
    ];

    // Relationships
    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class, 'id_sales');
    }

    public function detailSurats(): HasMany
    {
        return $this->hasMany(DetailSurat::class, 'id_surat');
    }
}
