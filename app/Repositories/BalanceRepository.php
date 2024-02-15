<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Balance;
use App\Models\User;
use Cknow\Money\Money;

class BalanceRepository
{
    public function createForUser(User $user): Balance
    {
        $balance = new Balance(['value' => 0]);
        $user->balance()->save($balance);

        return $balance;
    }

    public function change(Balance $balance, Money $operationValue): void
    {
        $balance->value = $balance->value->add($operationValue);

        $balance->save();
    }

    public function check(Balance $balance, Money $operationValue): bool
    {
        $newValue = $balance->value->add($operationValue);

        return $newValue->isZero() || $newValue->isPositive();
    }
}
