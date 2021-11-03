<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween(1,3);
        return [
            'title' => $user_id . ':' . $this->faker->realText(rand(15, 40)),
            'is_done' => $this->faker->boolean(10),
            'user_id' => $user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
