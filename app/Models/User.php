<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all PKS/Surat Perjanjian created by this user (as Sales)
     */
    public function suratPerjanjians()
    {
        return $this->hasMany(SuratPerjanjian::class, 'id_sales');
    }

    /**
     * Get all invoices created by this user (as Sales)
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'id_sales');
    }

    /**
     * Get all kuitansi related to user's invoices
     */
    public function kuitansis()
    {
        return $this->hasManyThrough(Kuitansi::class, Invoice::class, 'id_sales', 'id_invoice');
    }
}
