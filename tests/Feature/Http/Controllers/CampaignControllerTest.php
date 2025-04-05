<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CampaignControllerTest extends TestCase
{
    use DatabaseTruncation;

    public function test_get_all_campaigns(): void
    {
        Campaign::factory(3)->create();

        $this
            ->getJson('/api/campaigns')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has("links")
                ->has("meta")
                ->has("data", 3, fn(AssertableJson $json) => $json->hasAll([
                    'id',
                    'name',
                    'image_url',
                    'target_amount_fils',
                    'percentage_raised',
                    'city_area',
                    'country_code',
                    'investors_count',
                    'investment_multiple_fils',
                ]))
            );
    }

    public function test_get_campaigns_filtered_by_country_code(): void
    {
        Campaign::factory(3)->create(['country_code' => 'BT']);
        Campaign::factory(1)->create(['country_code' => 'US']);

        $this
            ->getJson('/api/campaigns?country_code=us')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has("data", 1, fn(AssertableJson $json) => $json->where('country_code', 'US')->etc())
                ->etc()
            );
    }

    public function test_get_campaigns_filtered_by_investors_count(): void
    {
        Campaign::factory(10)->create();
        Campaign::factory(2)->create(['investors_count' => 5]);

        $this
            ->getJson('/api/campaigns?investors_count=5')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has("data", 2, fn(AssertableJson $json) => $json->where('investors_count', 5)->etc())
                ->etc()
            );
    }

    public function test_get_one_campaign(): void
    {
        Campaign::factory(5)->create();

        $this
            ->getJson('/api/campaigns/2')
            ->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasAll([
                    'data.id',
                    'data.name',
                    'data.image_url',
                    'data.target_amount_fils',
                    'data.percentage_raised',
                    'data.city_area',
                    'data.country_code',
                    'data.investors_count',
                    'data.investment_multiple_fils',
                ])
                ->where('data.id', 2)
            );
    }
}
