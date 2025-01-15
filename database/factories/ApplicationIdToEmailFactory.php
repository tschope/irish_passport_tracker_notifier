<?php

namespace Database\Factories;

use App\Models\ApplicationIdToEmail;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationIdToEmail>
 */
class ApplicationIdToEmailFactory extends Factory
{

    protected $model = ApplicationEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'applicationId' => $this->faker->unique()->numberBetween(400000000000, 99999999999),
            'email' => encrypt($this->faker->safeEmail),
            'send_time_1' => $this->faker->optional()->time('H:i:s'),
            'send_time_2' => $this->faker->optional()->time('H:i:s'),
            'weekends' => $this->faker->boolean,
        ];
    }
}
