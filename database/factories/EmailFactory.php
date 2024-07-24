<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Email>
 */
class EmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'from'    => $this->faker->email,
            'to'      => $this->faker->email,
            'subject' => $this->faker->sentence,
            'body'    => $this->faker->paragraph,
            'is_sent'    => $this->faker->boolean(),

        ];
    }
}
