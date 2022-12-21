<?php

namespace Database\Factories;

use App\Models\PlatformUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PlatformUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlatformUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'platform' => $this->faker->randomElement(['line', 'discord', 'telegram']),
            'platform_id' => $this->faker->uuid(),
            'display_name' => $this->faker->name,
            'picture_url' => $this->faker->imageUrl(),
            'status_message' => $this->faker->word,
        ];
    }

    public function useLineUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'platform' => 'line',
                'platform_id' => sprintf('U%s', $this->faker->regexify('[0-9a-f]{32}')),
            ];
        });
    }
}
