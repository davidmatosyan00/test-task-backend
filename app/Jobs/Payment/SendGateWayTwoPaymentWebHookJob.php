<?php

namespace App\Jobs\Payment;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendGateWayTwoPaymentWebHookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Payment $payment;

    public const URL = 'http://localhost:8000/api/v1/payment-webhook';
    public const HASH_SEPARATOR = '.';

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
     */
    public function handle()
    {
        $data = [
            'amount' => $this->payment->amount,
            'amount_paid' => $this->payment->amount_paid,
            'invoice' => $this->payment->id,
            'project' => env('APP_ID'),
            'rand' => Str::random(20),
            'status' => Payment::STATUS_COMPLETED,
        ];

        $hash = '';

        foreach ($data as  $value) {
            $hash .= $value . self::HASH_SEPARATOR;
        }

        $hash .= env('APP_KEY_GATE');

        $sign = md5($hash);

        $this->payment->setSign($sign);

        $this->payment->save();

        $headers = [
            'Authorization' => $sign
        ];

        Http::withHeaders($headers)->post(self::URL, $data);
    }
}
