<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'no_kontrak',
        'tanggal_invoice',
        'nama_pelanggan',
        'alamat',
        'no_telp',
        'email',
        'total_harga',
        'status_pembayaran',
        'jatuh_tempo',
        'keterangan',
        'id_sales',
    ];

    protected $casts = [
        'tanggal_invoice' => 'date',
        'jatuh_tempo' => 'date',
        'total_harga' => 'decimal:2',
    ];

    // Relationships
    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class, 'id_sales');
    }

    public function detailInvoices(): HasMany
    {
        return $this->hasMany(DetailInvoice::class, 'id_invoice');
    }

    public function kuitansis(): HasMany
    {
        return $this->hasMany(Kuitansi::class, 'id_invoice');
    }
}
