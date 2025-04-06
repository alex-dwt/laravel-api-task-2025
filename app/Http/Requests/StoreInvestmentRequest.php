<?php

namespace App\Http\Requests;

use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvestmentRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'campaign_id' => 'required|exists:campaigns,id',
            'amount_fils' => [
                'required',
                'integer',
                'gt:0',
                function ($attribute, $value, $fail) {
                    $campaign = Campaign::find($this->validated('campaign_id'));
                    $multiplier = $campaign->investment_multiple_fils;
                    if ($value % $multiplier !== 0) {
                        $fail('Amount must be with multiplier ' . $multiplier); //todo Add translation if needed
                    }
                },
            ],
        ];
    }
}
