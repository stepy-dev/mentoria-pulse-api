<?php

namespace Database\Factories;

use App\Models\ProjectResource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectResource>
 */
class ProjectResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'type_id' => fake()->randomElement([
                ProjectResource::RESOURCE_TYPE_WEB,
                ProjectResource::RESOURCE_TYPE_API,
            ]),
            'name' => fake()->domainName(),
            'uptime' => fake()->randomFloat(2, 0, 100),
            'settings' => [],
            'checked_at' => fake()->dateTime(),
        ];
    }
}
