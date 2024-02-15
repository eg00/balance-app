<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\CreateOperationData;
use App\Models\Balance;
use App\Models\BalanceOperation;

class OperationRepository
{
    public function create(CreateOperationData $data, Balance $balance): BalanceOperation
    {
        $operation = new BalanceOperation();
        $operation->fill([
            'balance_id' => $balance->id,
            'value' => $data->value,
            'description' => $data->description,
        ]);
        $operation->save();

        return $operation;
    }
}
