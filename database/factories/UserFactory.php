<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $images = [
            'https://www.svgrepo.com/show/2013/user.svg',
            'https://www.svgrepo.com/show/2014/user.svg',
            'https://www.svgrepo.com/show/2015/user.svg',
            'https://www.svgrepo.com/show/2016/user.svg',
            'https://www.svgrepo.com/show/8966/user.svg',
            null
        ];

        return [
            'username' => str_replace('.', '', $this->faker->unique()->userName),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'bio' => $this->faker->sentence,
            'image' => array_rand($images, 1),
        ];
    }
}
