<?php

namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;

class UserDomainService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // メールアドレスの形式をチェック
    public function isEmailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // メールアドレスが既に存在するかチェック
    public function isEmailUnique(string $email): bool
    {
        return $this->userRepository->findByEmail($email) === null;
    }
}
