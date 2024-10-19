<?php

namespace App\Infrastructure\Services;

use App\Domain\Entities\User;
use App\Interfaces\Gateways\EmailGatewayInterface;
use Illuminate\Support\Facades\Mail;

class EmailService implements EmailGatewayInterface
{
    public function sendRegistrationEmail(User $user): void
    {
        $data = ['name' => $user->getName()];

        Mail::send('emails.registration', $data, function ($message) use ($user) {
            $message->to($user->getEmail())
                ->subject('Welcome to Our Platform!');
        });
    }
}
