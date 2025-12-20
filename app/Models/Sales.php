<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    protected $fillable = [
        'id_sales',
        'nama_sales',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'id_sales');
    }

    public function kuitansis(): HasMany
    {
        return $this->hasMany(Kuitansi::class, 'id_sales');
    }

    public function suratPerjanjians(): HasMany
    {
        return $this->hasMany(SuratPerjanjian::class, 'id_sales');
    }
}
