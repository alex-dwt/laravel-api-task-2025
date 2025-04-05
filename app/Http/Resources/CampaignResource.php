<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'target_amount_fils' => $this->target_amount_fils,
            'percentage_raised' => $this->percentage_raised,
            'city_area' => $this->city_area,
            'country_code' => $this->country_code,
            'investors_count' => $this->investors_count,
            'investment_multiple_fils' => $this->investment_multiple_fils,
        ];
    }
}
