<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Carbon;

class UserService
{
    public User $user;

    /**
     * Set a user.
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get current user.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function create(
        string $email,
        string $password,
        string $first_name,
        string $last_name,
        string $cpf,
        string $rg,
        Carbon $birth_date,
        string $phone,
        string $cellphone
    ): self {
        $this->user = new User();
        $this->user->email = $email;
        $this->user->password = $password;
        $this->user->first_name = $first_name;
        $this->user->last_name = $last_name;
        $this->user->cpf = $cpf;
        $this->user->rg = $rg;
        $this->user->birth_date = $birth_date;
        $this->user->phone = $phone;
        $this->user->cellphone = $cellphone;
        $this->user->save();

        return $this;
    }

    public function update(array $userData): self {
        $this->user->update($userData);

        return $this;
    }
}
