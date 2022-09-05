<?php

namespace App\Services\User\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class LoginUserDto extends DataTransferObject
{
    public string $email;

    public string $password;
}
