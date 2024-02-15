<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Dto\CreateUserData;
use App\Exceptions\OperationFailedException;
use App\Services\UserService;
use Illuminate\Console\Command;

class UserCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint
     */
    protected $signature = 'create:user
                                {name? : Inject the new users name}
                                {email? : Inject the new users email}
                                {password? : Inject the new users password}
                                {--force : Do not ask confirmation}';

    /**
     * The console command description.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint
     */
    protected $description = 'Create a user';

    /**
     * Execute the console command.
     */
    public function handle(UserService $service): int
    {
        $userData = new CreateUserData(
            name: $this->argument('name') ?? $this->ask('User name:'),
            email: $this->argument('email') ?? $this->ask('User email:'),
            password: $this->argument('password') ? $this->argument('password') : $this->ask('User password:'),
        );
        $validator = $service->validator($userData);

        if ($validator->fails()) {
            $this->info('User not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        try {
            if ($this->option('force') === true || $this->confirm('Save this user?', true)) {
                $user = $service->create($userData);
                $this->info(sprintf('Created a user with id: %s', $user->id));

                return self::SUCCESS;
            }
        } catch (OperationFailedException) {
            $this->error('User not created');
        }

        return self::FAILURE;
    }
}
