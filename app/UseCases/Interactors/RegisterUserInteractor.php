<?php

namespace App\UseCases\Interactors;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\UserDomainService;
use App\Interfaces\Gateways\EmailGatewayInterface;

class RegisterUserInteractor
{
    private UserRepositoryInterface $userRepository;
    private UserDomainService $userDomainService;
    private EmailGatewayInterface $emailGateway;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserDomainService $userDomainService,
        EmailGatewayInterface $emailGateway
    ) {
        $this->userRepository    = $userRepository;
        $this->userDomainService = $userDomainService;
        $this->emailGateway      = $emailGateway;
    }

    public function handle(array $data): User
    {
        // 入力データのバリデーション
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            throw new \InvalidArgumentException('Name, email, and password are required.');
        }

        if (!$this->userDomainService->isEmailValid($data['email'])) {
            throw new \InvalidArgumentException('Invalid email address.');
        }

        if (!$this->userDomainService->isEmailUnique($data['email'])) {
            throw new \InvalidArgumentException('Email already exists.');
        }

        // ユーザーエンティティの作成
        $user = new User(null, $data['name'], $data['email'], $data['password']);
        $user->hashPassword();

        // ユーザーの保存
        $this->userRepository->save($user);

        // 登録完了メールの送信
        $this->emailGateway->sendRegistrationEmail($user);

        return $user;
    }
}
