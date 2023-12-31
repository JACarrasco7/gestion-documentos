<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *@var string
     */
    protected $model = Worker::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nif' => fake()->unique()->text(9),
            'contact_info_id' => fake()->numberBetween(1, 3),
            'company_id' => 1,
        ];
    }
}
