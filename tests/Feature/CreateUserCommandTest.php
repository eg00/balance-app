<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exceptions\OperationFailedException;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\PendingCommand;
use Tests\TestCase;

use function assert;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testSuccessfulCreateUser(): void
    {
        $data = User::factory()->make();
        $command = $this->artisan('create:user');
        assert($command instanceof PendingCommand);
        $command
            ->expectsQuestion('User name:', $data->name)
            ->expectsQuestion('User email:', $data->email)
            ->expectsQuestion('User password:', 'password')
            ->expectsConfirmation('Save this user?', 'yes')
            ->expectsOutputToContain('Created a user with id')
            ->assertExitCode(0);
    }

    public function testValidationErrors(): void
    {
        $command = $this->artisan('create:user');
        assert($command instanceof PendingCommand);
        $command
            ->expectsQuestion('User name:', '')
            ->expectsQuestion('User email:', '')
            ->expectsQuestion('User password:', 'password')
            ->expectsOutputToContain('User not created. See error messages below:')
            ->assertExitCode(1);

        $this->assertDatabaseCount('users', 0);
    }

    public function testThrowsException(): void
    {
        $this->inject(UserService::class)->method('create')
            ->willThrowException(new OperationFailedException());

        $data = User::factory()->make();
        $command = $this->artisan('create:user');
        assert($command instanceof PendingCommand);
        $command
            ->expectsQuestion('User name:', $data->name)
            ->expectsQuestion('User email:', $data->email)
            ->expectsQuestion('User password:', 'password')
            ->expectsConfirmation('Save this user?', 'yes')
            ->expectsOutputToContain('User not created')
            ->assertExitCode(1);
    }
}
