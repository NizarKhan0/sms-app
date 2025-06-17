<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Teacher;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    public function isSuperAdmin()
    {
        return $this->role === 'super-admin';
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Solusi sementara: return true untuk testing
        return true; // HATI-HATI, hanya untuk debugging!
        // Production: hanya domain tertentu
        // return str_ends_with($this->email, '@solofux.xyz');
        // Izinkan SEMUA user di environment local
        // if (app()->environment('production')) {
        //     return true;
        // }

        // // Untuk production (dan environment lainnya), berikan akses khusus
        // return str_ends_with($this->email, '@solofux.xyz');
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

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
}
