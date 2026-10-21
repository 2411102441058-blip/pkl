<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ─── Role Helpers ───────────────────────────────────────────────
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isPemilikUsaha(): bool
    {
        return $this->role === 'pemilik_usaha';
    }

    // ─── Relasi ─────────────────────────────────────────────────────
    public function businessProfile()
    {
        return $this->hasOne(BusinessProfile::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }
}
