<?php

namespace KeithBrink\AffiliatesSpark\Events;

use Illuminate\Queue\SerializesModels;

class AffiliateUserCreated
{
    use SerializesModels;

    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
