<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CreateOperationData;
use App\Models\Balance;
use App\Repositories\BalanceRepository;
use App\Repositories\OperationRepository;
use Illuminate\Database\DatabaseManager;
use Psr\Log\LoggerInterface;
use Throwable;

class BalanceService
{
    public function __construct(
        protected readonly BalanceRepository $balanceRepository,
        protected readonly OperationRepository $operationRepository,
        protected readonly DatabaseManager $databaseManager,
        protected readonly LoggerInterface $logger,
    ) {
    }

    public function change(Balance $balance, CreateOperationData $operationData): void
    {
        try {
            $this->databaseManager->beginTransaction();

            $this->balanceRepository->change($balance, $operationData->value);
            $this->operationRepository->create($operationData, $balance);

            $this->databaseManager->commit();
        } catch (Throwable $e) {
            $this->databaseManager->rollBack();
            $this->logger->error($e->getMessage());
        }
    }

    public function check(Balance $balance, CreateOperationData $operationData): bool
    {
        return $this->balanceRepository->check($balance, $operationData->value);
    }
}
