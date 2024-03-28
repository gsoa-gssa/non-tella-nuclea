<?php

namespace App\Console\Commands\Petition;

use App\Models\Supporter;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Storage;

class AssignLocaleBasedOnSubcampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'petition:assign-locales-subcampaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign locales based on subcampaigns';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Assigning locales based on subcampaigns...');
        $dry_run = select('Do you want to run this command in dry-run mode?', ['Yes', 'No']);
        if ($dry_run === 'Yes') {
            $this->info('Running in dry-run mode. No changes will be saved.');
        }

        $supporters = Supporter::all();

        foreach ($supporters as $supporter) {
            $this->info('Assigning locale to supporter ' . $supporter->id);

            if (!isset($supporter->data["subcampaign"])) {
                $this->error('No subcampaign found for supporter ' . $supporter->id);
                continue;
            }

            $locale = $this->determineLocale($supporter->data["subcampaign"]);
            if (!$locale) {
                continue;
            }

            if (isset($supporter->data["locale"]) && $supporter->data["locale"] === $locale) {
                $this->info('Correct locale already assigned to supporter ' . $supporter->id);
                continue;
            } else if (isset($supporter->data["locale"])) {
                $this->info('Changing locale from ' . $supporter->data["locale"] . ' to ' . $locale . ' for supporter ' . $supporter->id . ' based on subcampaign ' . $supporter->data["subcampaign"]);
            } else {
                $this->info('Assigning locale ' . $locale . ' to supporter ' . $supporter->id . ' based on subcampaign ' . $supporter->data["subcampaign"]);
            }

            if ($dry_run === 'No') {
                $supporter->data = array_merge($supporter->data, ["locale" => $locale]);
                $supporter->save();
            }
        }
        $this->info('Done.');
    }

    /**
     * Determine the locale based on the subcampaign.
     *
     * @param string $subcampaign
     * @return string|null
     */
    private function determineLocale($subcampaign)
    {
        $locale = explode('-', $subcampaign);
        if (count($locale) !== 2) {
            $this->error('Invalid subcampaign format: ' . $subcampaign);
            return null;
        }
        if (!in_array($locale[1], ['de', 'fr', 'it'])) {
            $this->error('Invalid locale: ' . $locale[1]);
            return null;
        }
        return $locale[1];
    }
}
