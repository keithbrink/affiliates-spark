<?php

namespace KeithBrink\AffiliatesSpark\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AffiliateUserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user_email;
    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_email, $password)
    {
        $this->user_email = $user_email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Affiliate Account Approved')
            ->markdown('affiliates-spark::emails.affiliate-user')
            ->with([
                'user_email' => $this->user_email,
                'password' => $this->password,
            ]);
    }
}
