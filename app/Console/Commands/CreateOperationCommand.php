<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Dto\CreateOperationData;
use App\Exceptions\OperationFailedException;
use App\Jobs\BalanceChangeJob;
use App\Services\BalanceService;
use App\Services\UserService;
use Cknow\Money\Money;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function assert;

class CreateOperationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint
     *
     * @var string
     */
    protected $signature = 'create:operation
                                {user_id : User id}
                                {value : Inject the new operation value}
                                {description? : Inject the new operation description}';

    /**
     * The console command description.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint
     *
     * @var string
     */
    protected $description = 'Create new operation for user';

    public function handle(BalanceService $service, UserService $userService): int
    {
        try {
            $user = $userService->find((int) $this->argument('user_id'));
        } catch (ModelNotFoundException) {
            $this->error('User not found');

            return self::FAILURE;
        } catch (OperationFailedException) {
            return self::FAILURE;
        }

        $value = Money::parseByDecimal($this->argument('value'), $user->balance->currency);
        assert($value instanceof Money);

        $operationData = new CreateOperationData(
            value: $value,
            description: $this->argument('description'),
        );

        if (!$service->check($user->balance, $operationData)) {
            $this->error('Balance is not enough');

            return self::FAILURE;
        }

        BalanceChangeJob::dispatch($user, $operationData);

        return self::SUCCESS;
    }
}
