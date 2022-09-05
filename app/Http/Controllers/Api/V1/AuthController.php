<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\Action\CreateUserAction;
use App\Services\User\Action\LoginUserAction;
use App\Services\User\Dto\LoginUserDto;
use App\Services\User\Dto\RegisterUserDto;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    private CreateUserAction $createUserAction;

    private LoginUserAction $loginUserAction;

    public function __construct(
        CreateUserAction $createUserAction,
        LoginUserAction $loginUserAction,
    ) {
        $this->createUserAction = $createUserAction;
        $this->loginUserAction = $loginUserAction;
    }

    public function login(LoginRequest $request): JsonResource
    {
        $dto = new LoginUserDto($request->toArray());

        return $this->loginUserAction->run($dto);
    }

    public function register(RegisterRequest $request): JsonResource
    {
        $dto  = RegisterUserDto::fromRequest($request);

        return $this->createUserAction->run($dto);
    }
}
