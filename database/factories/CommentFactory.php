<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        return [
            'body' => $this->faker->paragraph($this->faker->numberBetween(1, 5)),
            'user_id' => $users->random()->id,
            'created_at' => Carbon::now()->subSeconds($this->faker->numberBetween(100, 999)),
        ];
    }
}
