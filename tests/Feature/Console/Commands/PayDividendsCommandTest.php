<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Tests\TestCase;

class PayDividendsCommandTest extends TestCase
{
    use DatabaseTruncation;

    public function test_no_investments_to_pay_dividends(): void
    {
        $campaign = Campaign::factory()->create();

        $campaignId = $campaign->value('id');
        $this
            ->artisan("app:pay-dividends --campaign_id=$campaignId --amount=500.00")
            ->expectsOutput('investment_id,investment_amount,dividends_percent_to_pay,dividends_amount_to_pay')
            ->assertSuccessful();
    }

    public function test_dividends_paid_correctly(): void
    {
        $campaign = Campaign::factory()->create([
            'investment_multiple_fils' => 1000,
        ]);

        $campaignId = $campaign->value('id');

        foreach ([1000, 2000, 3000, 4000] as $amount) {
            // TODO it's better if creation investment logic was written in a separate service, and use this service here
            $this
                ->postJson('/api/investments', ['amount_fils' => $amount, 'campaign_id' => $campaignId])
                ->assertStatus(201);
        }

        $this
            ->artisan("app:pay-dividends --campaign_id=$campaignId --amount=500.00")
            ->expectsOutputToContain('investment_id,investment_amount,dividends_percent_to_pay,dividends_amount_to_pay')
            ->expectsOutputToContain('1,10.00,10,50.00')
            ->expectsOutputToContain('2,20.00,20,100.00')
            ->expectsOutputToContain('3,30.00,30,150.00')
            ->expectsOutputToContain('4,40.00,40,200.00')
            ->assertSuccessful();
    }
}
