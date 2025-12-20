<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailSurat extends Model
{
    protected $primaryKey = 'id_detail_surat';
    public $incrementing = false;

    protected $fillable = [
        'id_detail_surat',
        'id_surat',
        'id_txtKtl',
        'jumlah',
        'harga_satuan',
        'spesifikasi',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function suratPerjanjian(): BelongsTo
    {
        return $this->belongsTo(SuratPerjanjian::class, 'id_surat');
    }
}
