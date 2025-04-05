<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvestmentRequest;
use App\Http\Resources\InvestmentResource;
use App\Models\Campaign;
use App\Models\Investment;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    public function store(StoreInvestmentRequest $request)
    {
        $amount = $request->validated('amount_fils');
        $campaignId = $request->validated('campaign_id');

        $investment = DB::transaction(function () use ($amount, $campaignId) {
            $campaign = Campaign::lockForUpdate()->find($campaignId);

            $campaign->investors_count++;
            $campaign->incrementCurrentAmount($amount);
            $campaign->save();

            $investment = Investment::create([
                'amount_fils' => $amount,
                'campaign_id' => $campaignId,
            ]);

            return $investment;
        });


        return new InvestmentResource($investment);
    }
}
