<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

class Campaign extends Model
{
    /** @use HasFactory<\Database\Factories\CampaignFactory> */
    use HasFactory;

    public function incrementCurrentAmount(int $amount): void
    {
        $this->current_amount_fils += $amount;
        $this->percentage_raised = floor($this->current_amount_fils * 100 / $this->target_amount_fils);
    }

    #[Scope]
    protected function withCountryCode(Builder $query, string $countryCode): void
    {
        $query->where('country_code', strtoupper($countryCode));
    }

    #[Scope]
    protected function withInvestorsCount(Builder $query, int $investorsCount): void
    {
        $query->where('investors_count', $investorsCount);
    }
}
