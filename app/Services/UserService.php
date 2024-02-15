<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CreateUserData;
use App\Exceptions\OperationFailedException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Validator;
use Throwable;

class UserService
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function find(int $id): User
    {
        try {
            $user = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new OperationFailedException($e->getMessage(), 0, $e);
        }

        return $user;
    }

    public function validator(CreateUserData $data): Validator
    {
        return ValidatorFacade::make((array) $data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', Rules\Password::defaults()],
        ]);
    }

    public function create(CreateUserData $data): User
    {
        try {
            return $this->repository->create($data);
        } catch (Throwable $e) {
            throw new OperationFailedException($e->getMessage(), 0, $e);
        }
    }

    public function getUserData(User $user): User
    {
        return $this->repository->getUserData($user);
    }

    public function getUserOperations(User $user): Collection
    {
        return $this->repository->getOperations($user);
    }
}
