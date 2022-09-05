<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Services\Payment\Dto\CreatePaymentDto;

/**
 *   \App\Models\Payment
 *   @package app
 *
 *  @property int $id
 *  @property int $user_id
 *  @property string $status
 *  @property numeric $amount
 *  @property numeric $amount_paid
 *  @property int $card_last_four_digit
 *  @property string $type,
 *  @property string $sign,
 *  @property string $created_at
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'amount',
        'amount_paid',
        'card_last_four_digit',
        'type',
        'sign'
    ];

    protected $dates = [
      'created_at',
      'updated_at',
    ];

    public const GATE_WAY_ONE = 'gate_way_one';
    public const GATE_WAY_TWO = 'gate_way_two';

    public const GATE_WAYS  = [
      self::GATE_WAY_ONE,
      self::GATE_WAY_TWO,
    ];

    public const STATUS_NEW = 'NEW';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_COMPLETED = 'COMPLETED';
    public const STATUS_EXPIRED = 'EXPIRED';
    public const STATUS_REJECTED = 'REJECTED';

    public const PAYMENT_STATUSES = [
      self::STATUS_NEW,
      self::STATUS_PENDING,
      self::STATUS_COMPLETED,
      self::STATUS_EXPIRED,
      self::STATUS_REJECTED,
    ];

    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    public function setAmountPaid(string $amountPaid): void
    {
        $this->amount_paid = $amountPaid;
    }

    public function setSign(string $sign): void
    {
        $this->sign = $sign;
    }

    public static function createStatic(CreatePaymentDto $dto): self
    {
         $payment = new static();

         $payment->user_id = $dto->userId;
         $payment->status = $dto->status;
         $payment->amount = $dto->amount;
         $payment->amount_paid = $dto->amountPaid;
         $payment->card_last_four_digit = $dto->cardLastFourDigit;
         $payment->type = $dto->method;

         return $payment;
    }
}
