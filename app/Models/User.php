<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isOnline(): bool
    {
        if (!$this->last_seen) {
            return false;
        }

        $lastSeen = Carbon::parse($this->last_seen);
        
        return $lastSeen->greaterThan(now()->subMinutes(5));
    }

    public function lastSeenHuman(): string
    {
        if (!$this->last_seen) {
            return 'Never seen';
        }

        $lastSeen = Carbon::parse($this->last_seen);

        return $lastSeen->diffForHumans();
    }
}
