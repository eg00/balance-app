<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Balance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Money\Money;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BalanceOperation>
 */
class BalanceOperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'balance_id' => Balance::factory(),
            'value' => Money::parse(random_int(-2_000_00, 2_000_00)),
        ];
    }
}
