<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
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
            ->expectsOutputToContain('Created a user with id');
    }

    public function testValidationErrors(): void
    {
        $command = $this->artisan('create:user');
        assert($command instanceof PendingCommand);
        $command
            ->expectsQuestion('User name:', '')
            ->expectsQuestion('User email:', '')
            ->expectsQuestion('User password:', 'password')
            ->expectsOutputToContain('User not created. See error messages below:');

        $this->assertDatabaseCount('users', 0);
    }
}
