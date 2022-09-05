<?php

namespace App\Exceptions\User;

use App\Exceptions\BusinessLogicException;

class UserNotSaveException extends BusinessLogicException
{
    public function getStatus(): int
    {
        return BusinessLogicException::USER_NOT_SAVED;
    }

    public function getStatusMessage(): string
    {
        return __('errors.user.not_saved');
    }
}
