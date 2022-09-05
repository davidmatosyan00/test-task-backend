<?php

namespace App\Exceptions;

abstract class BusinessLogicException extends \Exception
{
    const USER_NOT_SAVED = 600;
    const USER_NOT_EXISTS = 601;
    const PAYMENT_NOT_SAVED = 602;
    const PAYMENT_NOT_FOUND = 603;
    const PAYMENT_WEBHOOK_NOT_SAVED = 604;

    abstract public function getStatus(): int;

    abstract public function getStatusMessage(): string;
}
