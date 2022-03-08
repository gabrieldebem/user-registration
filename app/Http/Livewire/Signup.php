<?php

namespace App\Http\Livewire;

use App\Providers\Clients\ViaCep;
use App\Services\UserService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Signup extends Component
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
    public string $cpf;
    public string $rg;
    public string $birthDate;
    public string $phone;
    public string $cellphone;

    public string $zipcode;
    public string $address;
    public string $number;
    public string $complement;
    public string $district;
    public string $city;
    public string $state;


    private UserService $service;


    public function render()
    {
        return view('livewire.signup');
    }

    public function fillAddress()
    {
        dd('oi');
        $viaCep = new ViaCep();

        try {
            $fullAddress = $viaCep->findAddress($this->zipcode);
            $this->address = $fullAddress->logradouro;
            $this->district = $fullAddress->bairro;
            $this->city = $fullAddress->localidade;
            $this->state = $fullAddress->uf;
        } catch (\Throwable $exception) {
            throw  new \Exception('Não encontramos seu CEP', 404);
        }
    }

    public function create()
    {
        $this->service = app(UserService::class);
        try {
            $this->service
                ->create(
                    email: $this->email,
                    password: Hash::make($this->password),
                    first_name: $this->firstName,
                    last_name: $this->lastName,
                    cpf: $this->cpf,
                    rg: $this->rg,
                    birth_date: Carbon::parse($this->birthDate),
                    phone: $this->phone,
                    cellphone: $this->cellphone
                );
        } catch (\Throwable $exception) {
            throw  new \Exception('Houve um erro ao criar seu usuário', 400);
        }
    }
}
