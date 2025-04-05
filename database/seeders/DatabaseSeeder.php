<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Campaign::factory()->create([
            'investment_multiple_fils' => 1000,
        ]);

        Campaign::factory(20)->create();
    }
}
