<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Investment;
use Illuminate\Console\Command;

class PayDividendsCommand extends Command
{
    private const int INVESTMENTS_CHUNK_ITEMS_COUNT = 500;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pay-dividends {--campaign_id=} {--amount=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distributes funds pro-rata across investors in a given property campaign';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $amount = floatval($this->option('amount'));
        if ($amount <= 0) {
            $this->fail('Wrong amount provided (must be greater than 0).');
        }

        $amountFilsToShare = $amount * 100;

        $campaignId = intval($this->option('campaign_id'));
        if ($campaignId <= 0) {
            $this->fail('Wrong campaign_id provided (must be greater than 0).');
        }

        $campaign = Campaign::find($campaignId);
        if (!$campaign) {
            $this->fail('Campaign not found.');
        }

        $headerFields = [
            'investment_id',
            'investment_amount',
            'dividends_percent_to_pay',
            'dividends_amount_to_pay',
        ];
        $this->getOutput()->writeln($this->csvstr($headerFields));

        $campaignFullAmount = $campaign->current_amount_fils;

        Investment::where('campaign_id', $campaign->id)->chunk(
            self::INVESTMENTS_CHUNK_ITEMS_COUNT,
            function ($investments) use ($campaignFullAmount, $amountFilsToShare) {
                foreach ($investments as $investment) {
                    $dividendsPercent = floor($investment->amount_fils * 100 / $campaignFullAmount);
                    $dividendsAmount = floor($dividendsPercent * $amountFilsToShare / 100);

                    $this->getOutput()->writeln($this->csvstr([
                        $investment->id,
                        $this->formatAmount($investment->amount_fils),
                        $dividendsPercent,
                        $this->formatAmount($dividendsAmount),
                    ]));
                }
            }
        );
    }

    private function formatAmount(int $amountFils): string
    {
        return number_format($amountFils / 100, 2, '.', ',');
    }

    // TODO quick solution how to do pretty output of result
    // https://www.php.net/manual/en/function.fputcsv.php#121950
    private function csvstr(array $fields): string
    {
        $f = fopen('php://memory', 'r+');
        if (fputcsv($f, $fields) === false) {
            throw new \RuntimeException('Failed to write csv stream.');
        }
        rewind($f);
        $csv_line = stream_get_contents($f);
        return rtrim($csv_line);
    }
}
