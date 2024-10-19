<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\UserRepository;
use App\Interfaces\Gateways\EmailGatewayInterface;
use App\Infrastructure\Services\EmailService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // リポジトリのバインディング
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // メールゲートウェイのバインディング
        $this->app->bind(EmailGatewayInterface::class, EmailService::class);
    }

    public function boot()
    {
        // 必要な初期化処理があればここに記述
    }
}
