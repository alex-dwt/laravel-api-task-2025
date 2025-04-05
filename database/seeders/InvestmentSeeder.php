<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Investment;
use Illuminate\Database\Seeder;

class InvestmentSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = Campaign::factory(20)->create();

        Investment::factory()
            ->count(2000)
            ->recycle($campaigns)
            ->create();
    }
}
