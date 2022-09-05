<?php

namespace App\Models;

use App\Services\Payment\Dto\CreatePaymentWebhookDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  \App\Models\User
 *  @package app
 *
 *  @property integer $id
 *  @property integer $payment_id
 *  @property mixed $response
 *  @property string $created_at
 *  @property string $updated_at
 */
class PaymentWebhook extends Model
{
    use HasFactory;

    protected $fillable = [
      'payment_id',
      'response',
    ];

    protected $dates = [
      'created_at',
      'updated_at',
    ];

    public function setPaymentId(int $paymentId): void
    {
        $this->payment_id = $paymentId;
    }

    public function setResponse(array $response): void
    {
        $this->response = $response;
    }

    public static function createStatic(CreatePaymentWebhookDto $dto): self
    {
        $paymentWebhook = new static();

        $paymentWebhook->payment_id = $dto->paymentId;
        $paymentWebhook->response = $dto->response;

        return $paymentWebhook;
    }
}
