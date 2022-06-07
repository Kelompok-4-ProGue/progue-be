<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

class JobTrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "company_id" => Company::first()->id,
            "title" => $this->faker->jobTitle(),
            "description" => $this->faker->catchPhrase(),
            "requirement" => $this->faker->word(1, 4),
            "additional_requirement" => $this->faker->word(2),
            "city" => $this->faker->city(),
            "price" => $this->faker->numberBetween(3000000, 20000000),
            "is_online" => $this->faker->boolean()
        ];
    }
}
