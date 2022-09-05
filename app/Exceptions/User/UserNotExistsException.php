<?php

namespace App\Exceptions\User;

use App\Exceptions\BusinessLogicException;

class UserNotExistsException extends BusinessLogicException
{
    public function getStatus(): int
    {
        return BusinessLogicException::USER_NOT_EXISTS;
    }

    public function getStatusMessage(): string
    {
        return __('errors.user.not_exists');
    }
}
