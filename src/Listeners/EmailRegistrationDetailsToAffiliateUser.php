<?php

namespace KeithBrink\AffiliatesSpark\Listeners;

use KeithBrink\AffiliatesSpark\Mail\AffiliateUserCreated as UserCreatedMail;
use KeithBrink\AffiliatesSpark\Events\AffiliateUserCreated;
use Mail;

class EmailRegistrationDetailsToAffiliateUser
{
    public function handle(AffiliateUserCreated $event)
    { 
        Mail::to($event->user->email)->queue(new UserCreatedMail(
            $event->user->email,
            $event->password,
        ));
    }
}
