<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private const int ITEMS_PER_PAGE_COUNT = 10;

    public function index(Request $request)
    {
        $builder = Campaign::orderBy('id');

        if ($request->filled('country_code')) {
            $builder = $builder->withCountryCode($request->input('country_code'));
        }
        if ($request->filled('investors_count')) {
            $builder = $builder->withInvestorsCount($request->input('investors_count'));
        }

        return CampaignResource::collection($builder->paginate(self::ITEMS_PER_PAGE_COUNT));
    }

    public function show(Campaign $campaign)
    {
        return new CampaignResource($campaign);
    }
}
