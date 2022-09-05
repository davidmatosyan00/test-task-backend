<?php

namespace App\Services\User\Dto;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUserDto
{
   public string $name;

   public string $email;

   public string $password;

   public string $apiKey;

   public static function fromRequest(RegisterRequest $request): self
   {
       $dto = new static();

       $dto->name = $request->getName();
       $dto->password = Hash::make($request->getPassword());
       $dto->email  = $request->getEmail();
       $dto->apiKey = Str::random(64);

       return  $dto;
   }
}
