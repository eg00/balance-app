<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserBalanceOperationsResource;
use App\Http\Resources\UserBalanceResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(protected readonly UserService $userService)
    {
    }

    public function index(Request $request): JsonResource
    {
        $user = $request->user();
        assert($user instanceof User);
        $data = $this->userService->getUserData($user);

        return new UserBalanceResource($data);
    }

    public function operations(Request $request): Response
    {
        $user = $request->user();
        assert($user instanceof User);

        return Inertia::render('Operations', [
            'operations' => UserBalanceOperationsResource::collection(
                $this->userService->getUserOperations($user),
            ),
        ]);
    }
}
