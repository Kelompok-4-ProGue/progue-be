<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::where('role', 'company')->first();
        return [
            "user_id" => $user->id,
            "name" => $this->faker->company(),
            "address" => $this->faker->address(),
            "letter" => $this->faker->mimeType(),
            "company_logo_small" => $this->faker->file('public/company_logo', 'storage/public', true)
        ];
    }
}
