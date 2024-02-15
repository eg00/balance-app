<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

use function assert;

class CreateOperationCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testSuccessfulCreateOperation(): void
    {
        $user = User::factory()
            ->has(Balance::factory())
            ->create();
        $command = $this->artisan('create:operation', [
            'user_id' => $user->id,
            'value' => 100,
            'description' => 'Test operation',
        ]);
        assert($command instanceof PendingCommand);
        $command
            ->assertExitCode(0);
    }

    public function testBalanceNotEnough(): void
    {
        $user = User::factory()
            ->has(Balance::factory()->state(['value' => 0]))
            ->create();
        $command = $this->artisan('create:operation', [
            'user_id' => $user->id,
            'value' => '-100',
            'description' => 'Test operation',
        ]);
        assert($command instanceof PendingCommand);
        $command
            ->expectsOutputToContain('Balance is not enough')
            ->assertExitCode(1);
    }

    public function testUserNotFound(): void
    {
        $command = $this->artisan('create:operation', [
            'user_id' => random_int(1, 10),
            'value' => '-100',
            'description' => 'Test operation',
        ]);
        assert($command instanceof PendingCommand);
        $command
            ->expectsOutputToContain('User not found')
            ->assertExitCode(1);
    }
}
