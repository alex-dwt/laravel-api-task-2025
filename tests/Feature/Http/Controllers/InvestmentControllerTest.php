<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class InvestmentControllerTest extends TestCase
{
    use DatabaseTruncation;

    public function test_create_investment(): void
    {
        $campaign = Campaign::factory(1)->create();

        $amount = $campaign->value('investment_multiple_fils') * 2;

        $this
            ->postJson('/api/investments', [
                'amount_fils' => $amount,
                'campaign_id' => 1,
            ])
            ->assertStatus(201)
            ->assertJsonIsObject()
            ->assertJsonIsObject()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('data.id', 1)
                ->where('data.amount_fils', $amount)
            );

        // TODO check that fields in $campaign was changed correctly
    }
}
