<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $project = \App\Models\Project::factory()->create([
            'user_id' => $user->id,
        ]);

        \App\Models\ProjectResource::factory(5)->create([
            'project_id' => $project->id,
        ]);
    }
}
