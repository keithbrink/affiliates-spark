<?php

namespace KeithBrink\AffiliatesSpark\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AffiliateWithdrawalRequest extends Mailable
{
    use Queueable, SerializesModels;

    private $user_email, $amount, $paypal_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_email, $amount, $paypal_email)
    {
        $this->user_email = $user_email;
        $this->amount = $amount;
        $this->paypal_email = $paypal_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('affiliates-spark::emails.withdrawal')
            ->with([
                'user_email' => $this->user_email,
                'amount' => $this->amount,
                'paypal_email' => $this->paypal_email,
            ]);
    }
}