<?php

namespace App\Services\User\Action;

use App\Exceptions\User\UserNotExistsException;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\User\UserResource;
use App\Repositories\Read\User\UserReadRepositoryInterface;
use App\Services\User\Dto\LoginUserDto;
use App\Services\User\UseCases\GenerateNewApiKeyUseCase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginUserAction
{
    private UserReadRepositoryInterface $userReadRepository;

    private GenerateNewApiKeyUseCase $generateNewApiKeyUseCase;

    public function __construct(
        UserReadRepositoryInterface $userReadRepository,
        GenerateNewApiKeyUseCase $generateNewApiKeyUseCase,
    ) {
      $this->userReadRepository = $userReadRepository;
      $this->generateNewApiKeyUseCase = $generateNewApiKeyUseCase;
    }

    public function run(LoginUserDto $dto): UserResource | ErrorResource
    {
        try {
            $user = $this->userReadRepository->getUserByEmail($dto->email);

            if (!Hash::check($dto->password, $user->password)) {
                $error = [
                    "message" => "Password mismatch",
                    "code" => Response::HTTP_UNPROCESSABLE_ENTITY,
                ];

                return new ErrorResource($error);
            }
        } catch (UserNotExistsException $e) {
            return new ErrorResource(['message' => $e->getMessage(), 'code' => $e->getStatus()]);
        }

        $user['api_token'] = $this->generateNewApiKeyUseCase->run($user);

        return new UserResource($user);
    }
}
