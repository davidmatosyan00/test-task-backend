<?php

namespace App\Repositories\Read\User;

use App\Models\User;

interface UserReadRepositoryInterface
{
  public function getUserByEmail(string $email): User;
}
