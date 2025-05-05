<?php

declare(strict_types=1);

namespace Modules\Auth\Infrastructure\Adapter\Out\Persistence\EloquentModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Domain\Entities\User as DomainUser;
use Modules\Auth\Domain\ValueObjects\Email;
use Illuminate\Notifications\Notifiable;
use Database\Factories\UserModelFactory;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function newFactory(): UserModelFactory
    {
        return UserModelFactory::new();
    }

    public function toDomain(): DomainUser
    {
        return new DomainUser(
            $this->id,
            $this->name,
            new Email($this->email),
            $this->password,
            true
        );
    }
}
