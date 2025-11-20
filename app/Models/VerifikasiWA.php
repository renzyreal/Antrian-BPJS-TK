<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VerifikasiWA extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_wa';
    protected $fillable = ['no_hp', 'kode_verifikasi', 'terverifikasi', 'expired_at'];

    protected $casts = [
        'expired_at' => 'datetime',
        'terverifikasi' => 'boolean'
    ];

    // Scope untuk kode yang masih valid
    public function scopeValid($query)
    {
        return $query->where('expired_at', '>', Carbon::now())
                    ->where('terverifikasi', false);
    }

    // Scope untuk verifikasi yang masih berlaku (24 jam)
    public function scopeTerverifikasiBaru($query)
    {
        return $query->where('terverifikasi', true)
                    ->where('created_at', '>=', Carbon::now()->subHours(24));
    }
}