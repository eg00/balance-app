<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Dto\CreateOperationData;
use App\Models\User;
use App\Services\BalanceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BalanceChangeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public CreateOperationData $operationData,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(BalanceService $service): void
    {
        $service->change($this->user->balance, $this->operationData);
    }
}
