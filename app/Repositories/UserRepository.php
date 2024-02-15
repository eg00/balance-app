<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\CreateUserData;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function __construct(protected BalanceRepository $balanceRepository)
    {
    }

    public function find(int $id): User
    {
        /** @var User */
        return User::query()->with(['balance'])->findOrFail($id);
    }

    public function create(CreateUserData $data): User
    {
        $user = new User();
        $user->fill([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
        $user->save();
        $this->balanceRepository->createForUser($user);

        return $user;
    }

    public function getUserData(User $user, int $operationsLimit = 5): User
    {
        return $user->load([
            'balance',
            'operations' => fn ($q) => $q->limit($operationsLimit)->orderBy('created_at', 'desc')]);
    }

    public function getOperations(User $user): Collection
    {
        return $user->operations()->get();
    }
}
