<?php

namespace App\Models;

use App\Services\User\Dto\RegisterUserDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 *  \App\Models\User
 *  @package app
 *
 *  @property string $name
 *  @property string $email
 *  @property string $password
 *  @property string $api_key
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function createStatic(RegisterUserDto $dto): self
    {
        $user = new self();

        $user->setName($dto->name);
        $user->setEmail($dto->email);
        $user->setPassword($dto->password);
        $user->setApiKey($dto->apiKey);

        return $user;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->api_key = $apiKey;
    }
}
