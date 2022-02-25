<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use \Illuminate\Auth\Authenticatable;
    use Authorizable;

    protected $fillable = [
        'id',
        'email',
        'password',
        'first_name',
        'last_name',
        'cpf',
        'rg',
        'birth_date',
        'phone',
        'cellphone',
    ];

    protected $dates = [
        'birth_date',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birth_date' => 'date:Y-m-d',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    /**
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(UserAddress::class);
    }
}
