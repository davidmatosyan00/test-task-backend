<?php

namespace App\Repositories\Read\User;

use App\Exceptions\User\UserNotExistsException;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserReadRepository implements UserReadRepositoryInterface
{
    private function query(): Builder
    {
       return User::query();
    }

    /**
     * @throws UserNotExistsException
     */
    public function getUserByEmail(string $email): User
    {
        $user = $this->query()
             ->where('email', '=', $email)
             ->first();

        if (!$user) {
            throw new UserNotExistsException();
        }

        return $user;
    }
}
