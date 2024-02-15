<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Balance;
use App\Models\User;

class BalanceRepository
{
    public function createForUser(User $user): Balance
    {

        $balance = new Balance(['value' => 0]);
        $user->balance()->save($balance);

        return $balance;
    }
}
