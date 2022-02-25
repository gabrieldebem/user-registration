<?php

namespace App\Models;

use App\Enums\State;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'zipcode',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
        'state' => State::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope('user', function (Builder $query) {
            $query->where('user_id', currentUser()->id);
        });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
