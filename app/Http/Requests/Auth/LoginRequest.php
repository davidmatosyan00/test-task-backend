<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public const EMAIL = 'email';
    public const PASSWORD = 'password';

    public function rules(): array
    {
        return [
           self::EMAIL => [
             'required',
             'email',
             'exists:users,email',
           ],
           self::PASSWORD => [
             'required',
             'string',
             'min:6',
           ],
        ];
    }
}
