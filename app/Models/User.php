<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Concerns\HasImages;
use App\Observers\UserObserver;
use App\Traits\ChecksUserType;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy([UserObserver::class])]
#[Guarded(['remember_token'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, ChecksUserType, HasApiTokens, HasImages;

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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function slug(): string
    {
        return Str::slug($this->name);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
