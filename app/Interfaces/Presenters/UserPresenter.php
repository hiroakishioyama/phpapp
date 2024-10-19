<?php

namespace App\Interfaces\Presenters;

use App\Domain\Entities\User;

class UserPresenter
{
    public function format(User $user): array
    {
        return [
            'id'    => $user->getId(),
            'name'  => $user->getName(),
            'email' => $user->getEmail(),
            // パスワードは含めない
        ];
    }
}
