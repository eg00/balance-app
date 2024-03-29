<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property int             $id
 * @property int             $balance_id
 * @property Money           $value
 * @property string|null     $description
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read Balance $balance
 * @property-read User    $user
 */
class BalanceOperation extends Model
{
    use HasFactory;
    use HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
        'description',
        'balance_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => MoneyIntegerCast::class,
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public function balance(): BelongsTo
    {
        return $this->belongsTo(Balance::class);
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Balance::class);
    }
}
