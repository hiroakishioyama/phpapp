<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    private string $table = 'users';

    public function findById(int $id): ?User
    {
        $record = DB::table($this->table)->where('id', $id)->first();

        if ($record === null) {
            return null;
        }

        return $this->mapToEntity($record);
    }

    public function findByEmail(string $email): ?User
    {
        $record = DB::table($this->table)->where('email', $email)->first();

        if ($record === null) {
            return null;
        }

        return $this->mapToEntity($record);
    }

    public function save(User $user): void
    {
        if ($user->getId() === null) {
            // 新規作成
            $id = DB::table($this->table)->insertGetId([
                'name'     => $user->getName(),
                'email'    => $user->getEmail(),
                'password' => $user->getPassword(),
            ]);
            $user->setId($id);
        } else {
            // 更新
            DB::table($this->table)
                ->where('id', $user->getId())
                ->update([
                    'name'     => $user->getName(),
                    'email'    => $user->getEmail(),
                    'password' => $user->getPassword(),
                ]);
        }
    }

    public function delete(int $id): void
    {
        DB::table($this->table)->where('id', $id)->delete();
    }

    private function mapToEntity($record): User
    {
        return new User(
            $record->id,
            $record->name,
            $record->email,
            $record->password
        );
    }
}
