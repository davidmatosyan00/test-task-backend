<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\BaseRequest;
use App\Models\Payment;
use Illuminate\Validation\Rule;

class CreatePaymentRequest extends BaseRequest
{
    public const AMOUNT = 'amount';
    public const AMOUNT_PAID = 'amountPaid';
    public const CARD_NUMBER = 'cardNumber';
    public const METHOD = 'method';

    public function rules(): array
    {
        return [
          self::AMOUNT => [
            'required',
            'numeric',
          ],
          self::AMOUNT_PAID => [
             'required',
             'numeric',
          ],
          self::CARD_NUMBER => [
            'required',
            'int',
          ],
          self::METHOD => [
            'required',
            Rule::in(Payment::GATE_WAYS),
          ],
        ];
    }

    public function getAmount(): string
    {
        return $this->get(self::AMOUNT);
    }

    public function getAmountPaid(): string
    {
        return $this->get(self::AMOUNT_PAID);
    }

    public function getCardNumber(): string
    {
        return $this->get(self::CARD_NUMBER);
    }

    public function getMethod(): string
    {
        return $this->get(self::METHOD);
    }
}
