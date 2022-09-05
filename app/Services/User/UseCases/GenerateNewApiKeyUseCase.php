<?php

namespace App\Services\User\UseCases;

use App\Models\User;
use App\Repositories\Write\User\UserWriteRepositoryInterface;
use Illuminate\Support\Str;

class GenerateNewApiKeyUseCase
{
     private UserWriteRepositoryInterface $userWriteRepository;

     public function __construct(UserWriteRepositoryInterface $userWriteRepository)
     {
         $this->userWriteRepository = $userWriteRepository;
     }

     public function run(User $user): string
     {
         $user->setApiKey(Str::random(64));

         return $this->userWriteRepository->save($user)->api_key;
     }
}
