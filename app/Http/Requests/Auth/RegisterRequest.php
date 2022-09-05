<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    const NAME = 'name';
    const EMAIL = 'email';
    const PASSWORD = 'password';

    public function rules()
    {
       return [
          self::NAME => [
             'required',
             'string',
             'max:255',
          ],
          self::EMAIL => [
            'required',
            'email',
            'unique:users,email',
          ],
          self::PASSWORD => [
             'required',
             'string',
             'min:6',
          ],
       ];
    }

    public function getName(): string
    {
        return  $this->get(self::NAME);
    }

    public function getEmail(): string
    {
        return $this->get(self::EMAIL);
    }

    public function getPassword(): string
    {
        return $this->get(self::PASSWORD);
    }
}
