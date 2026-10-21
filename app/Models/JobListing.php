<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'nama_usaha',
        'posisi',
        'slug',
        'deskripsi',
        'syarat',
        'lokasi',
        'tipe_pekerjaan',
        'gaji',
        'nomor_wa',
        'is_premium',
        'bukti_pembayaran',
        'status',
        'approved_at',
        'expires_at',
        'views_count',
        'clicks_count',
    ];

    protected $casts = [
        'is_premium'  => 'boolean',
        'approved_at' => 'datetime',
        'expires_at'  => 'datetime',
    ];

    // ─── Relasi ─────────────────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Scopes ─────────────────────────────────────────────────────

    /**
     * FASE 3: Loker aktif, Premium di atas, urut tanggal terbaru.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->orderBy('is_premium', 'desc')
            ->orderBy('approved_at', 'desc')
            ->orderBy('created_at', 'desc');
    }

    // ─── Accessors ──────────────────────────────────────────────────

    /**
     * Format nomor WA → format internasional 62xxx
     */
    public function getFormattedWaNumberAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->nomor_wa);

        if (Str::startsWith($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    /**
     * Link WA dengan pesan otomatis
     */
    public function getWaLinkAttribute(): string
    {
        $phone = $this->formatted_wa_number;
        $pesan = "Halo {$this->nama_usaha}, saya bermaksud melamar untuk posisi *{$this->posisi}* yang saya lihat di Info Loker UMKM. Apakah posisi ini masih tersedia?";

        return "https://wa.me/{$phone}?text=" . urlencode($pesan);
    }
}
