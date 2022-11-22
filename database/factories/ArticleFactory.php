<?php

namespace Database\Factories;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->sentence(10),
            'body' => $this->faker->paragraphs($this->faker->numberBetween(1, 3), true),
            'created_at' => Carbon::now()->subSeconds($this->faker->numberBetween(100, 999)),
        ];
    }
}
