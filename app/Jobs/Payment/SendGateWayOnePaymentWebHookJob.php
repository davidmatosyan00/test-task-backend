<?php

namespace App\Jobs\Payment;

use App\Models\Payment;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendGateWayOnePaymentWebHookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Payment $payment;

    public const URL = 'http://localhost:8000/api/v1/payment-webhook';
    public const HASH_SEPARATOR = ':';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws GuzzleException
     */
    public function handle()
    {
        $data = [
            'amount' => $this->payment->amount,
            'amount_paid' => $this->payment->amount_paid,
            'merchant_id' => env('MERCHANT_ID'),
            'payment_id'  => $this->payment->id,
            'status' => Payment::STATUS_COMPLETED,
            'timestamp' => $this->payment->created_at,
        ];

        $hash = '';

        foreach ($data as  $value) {
            $hash .= $value . self::HASH_SEPARATOR;
        }

        $hash .= env('MERCHANT_KEY');

        $data['sign'] = hash('sha256', $hash);

        $this->payment->setSign($data['sign']);
        $this->payment->save();

        Http::post(self::URL, $data);
    }
}
