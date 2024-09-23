<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if ($panel->getId() === 'administrador') {
            return $this->isAdmin();
        }

        return true;
    }

    const ADMIN = "1";
    const USER = "0";

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'number_phone',
        'position',
        'area_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'password' => 'hashed',
        ];
    }

    public function role(): string
    {
        return (string) $this->role;
    }
    public static function isAdmin(): bool
    {
        $user = Auth::user();
        return $user->role() === self::ADMIN;
    }
    public function isUser(): bool
    {
        return $this->role() === self::USER;
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
