<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kuitansi extends Model
{
    protected $fillable = [
        'tanggal_kuitansi',
        'nama_pelanggan',
        'alamat',
        'no_telp',
        'total_bayar',
        'invoice_pembayaran',
        'keterangan',
        'id_sales',
        'id_invoice',
    ];

    protected $casts = [
        'tanggal_kuitansi' => 'date',
        'total_bayar' => 'decimal:2',
    ];

    // Relationships
    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class, 'id_sales');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'id_invoice');
    }

    public function detailKuitansis(): HasMany
    {
        return $this->hasMany(DetailKuitansi::class, 'id_kuitansi');
    }
}
