<?php

namespace App\Console\Commands\Petition;

use App\Models\Supporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use function Laravel\Prompts\select;

class AssignLocaleBasedOnCanton extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'petition:assign-locales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign locales based on canton';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Assigning locales based on canton...');
        $dry_run = select('Do you want to run this command in dry-run mode?', ['Yes', 'No']);
        if ($dry_run === 'Yes') {
            $this->info('Running in dry-run mode. No changes will be saved.');
        }

        $supporters = Supporter::all();

        foreach ($supporters as $supporter) {
            if (isset($supporter->data["locale"])) {
                continue;
            }
            $this->info('Assigning locale to supporter ' . $supporter->id);

            if (!isset($supporter->data["zip"])) {
                $this->error('No zip code found for supporter ' . $supporter->id);
                continue;
            }
            $canton = $this->findCanton($supporter->data["zip"]);
            if (!$canton) {
                continue;
            }
            $locale = $this->determineLocale($canton);
            if (!$locale) {
                continue;
            }

            if ($dry_run === 'No') {
                $this->info('Assigning locale ' . $locale . ' to supporter ' . $supporter->id . ' based on canton ' . $canton);
                $supporter->data = array_merge($supporter->data, ["locale" => $locale]);
                $supporter->save();
            } else {
                $this->info('Would assign locale ' . $locale . ' to supporter ' . $supporter->id . ' based on canton ' . $canton);
            }

        }

        $this->info('Locales assigned successfully.');
    }

    /**
     * Find canton based on zip code.
     */
    private function findCanton($zip)
    {
        $canton = null;
        $zip = (int) $zip;
        $api = Http::get("https://openplzapi.org/ch/Localities?postalCode={$zip}")->json();
        if (count($api) > 0) {
            $canton = $api[0]["canton"]["code"];
            return $canton;
        } else {
            $this->error('No canton found for zip code ' . $zip);
            return null;
        }
    }

    /**
     * Determine locale based on canton.
     */
    private function determineLocale($canton)
    {
        $canton_locales = [
            "AG" => "de",
            "AI" => "de",
            "AR" => "de",
            "BE" => "de",
            "BL" => "de",
            "BS" => "de",
            "FR" => "fr",
            "GE" => "fr",
            "GL" => "de",
            "GR" => "de",
            "LU" => "de",
            "NE" => "fr",
            "NW" => "de",
            "OW" => "de",
            "SG" => "de",
            "SH" => "de",
            "SO" => "de",
            "SZ" => "de",
            "TG" => "de",
            "TI" => "it",
            "UR" => "de",
            "VD" => "fr",
            "ZG" => "de",
            "ZH" => "de",
        ];
        if (array_key_exists($canton, $canton_locales)) {
            return $canton_locales[$canton];
        } else {
            $this->error('No locale found for canton ' . $canton);
            return null;
        }
    }
}
