<?php

namespace App\Services\User\Action;

use App\Exceptions\User\UserNotSaveException;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Write\User\UserWriteRepositoryInterface;
use App\Services\User\Dto\RegisterUserDto;

class CreateUserAction
{
    private UserWriteRepositoryInterface $userWriteRepository;

    public function __construct(UserWriteRepositoryInterface $userWriteRepository)
    {
        $this->userWriteRepository = $userWriteRepository;
    }

    public function run(RegisterUserDto $dto): UserResource | ErrorResource
    {
        $user = User::createStatic($dto);

        try {
            $user = $this->userWriteRepository->save($user);
        } catch (UserNotSaveException $e) {
            return new ErrorResource(['message' => $e->getMessage(), 'code' => $e->getStatus()]);
        }

        return new UserResource($user);
    }
}
