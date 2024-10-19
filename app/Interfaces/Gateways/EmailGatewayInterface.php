<?php

namespace App\Interfaces\Gateways;

use App\Domain\Entities\User;

interface EmailGatewayInterface
{
    public function sendRegistrationEmail(User $user): void;
}
