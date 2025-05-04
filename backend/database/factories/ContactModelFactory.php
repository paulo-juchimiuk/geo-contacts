<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Contact\Infrastructure\Adapter\Out\Persistence\EloquentModels\ContactModel;

class ContactModelFactory extends Factory
{
    protected $model = ContactModel::class;

    public function definition(): array
    {
        return [
            'user_id'  => 1,
            'name'     => $this->faker->name(),
            'cpf'      => $this->validCpf(),
            'phone'    => $this->faker->phoneNumber(),
            'address'  => $this->faker->streetAddress(),
            'latitude' => $this->faker->latitude(-30, -15),
            'longitude'=> $this->faker->longitude(-60, -40),
        ];
    }

    private function validCpf(): string
    {
        $base = collect(range(0,8))
            ->map(fn() => random_int(0,9))
            ->implode('');

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += (int) $base[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            $base .= $d;
        }
        return $base;
    }
}
