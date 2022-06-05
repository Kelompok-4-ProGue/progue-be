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
            "company_name" => $this->faker->company(),
            "company_address" => $this->faker->address(),
            "company_letter" => $this->faker->mimeType(),
        ];
    }
}
