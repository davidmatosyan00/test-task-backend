<?php

namespace App\Repositories\Write\User;

use App\Exceptions\User\UserNotSaveException;
use App\Models\User;

class UserWriteRepository implements UserWriteRepositoryInterface
{
    /**
     * @throws UserNotSaveException
     */
    public function save(User $user): User
    {
        if (!$user->save()) {
            throw new UserNotSaveException();
        }

        return $user;
    }
}
