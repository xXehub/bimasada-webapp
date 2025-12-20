<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailKuitansi extends Model
{
    protected $primaryKey = 'id_detail_kuitansi';
    public $incrementing = false;

    protected $fillable = [
        'id_detail_kuitansi',
        'id_kuitansi',
        'id_txtKtl',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function kuitansi(): BelongsTo
    {
        return $this->belongsTo(Kuitansi::class, 'id_kuitansi');
    }
}
