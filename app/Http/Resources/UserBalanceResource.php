<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'balance' => [
                'amount' => $this->balance->value->formatByDecimal(),
                'currency' => $this->balance->currency,
                'updated_at' => $this->balance->updated_at?->format(DATE_RFC7231),
            ],
            'operations' => UserBalanceOperationsResource::collection($this->operations),
        ];
    }
}
