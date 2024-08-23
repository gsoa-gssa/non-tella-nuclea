<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AssignCantonsToSupporters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supporters:cantons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ob_start();
        $this->info('Assigning cantons to supporters...');
        // Open file __DIR__ . /../../../stats/data/cleaned_supporters.csv

        $handle = fopen(__DIR__ . '/../../../stats/data/cleaned_supporters.csv', 'r');

        // Get headers
        $headers = fgetcsv($handle);

        // Get data into array
        $supporters = [];
        while (($row = fgetcsv($handle)) !== false) {
            $supporters[] = array_combine($headers, $row);
        }

        // Close file
        fclose($handle);

        // Loop through supporters
        for ($i = 0; $i < count($supporters); $i++) {
            $supporter = $supporters[$i];
            $this->info("Assigning canton to supporter {$supporter["email"]}...");
            $zipCode = $supporter["zip"];

            if (!$zipCode || empty($zipCode)) {
                $this->error("No zip code found for supporter {$supporter["email"]}");
                $supporter["canton"] = null;
                $supporters[$i] = $supporter;
                continue;
            }

            // Get canton from zip code
            $response = \Illuminate\Support\Facades\Http::get("https://openplzapi.org/ch/Localities", [
                "postalCode" => $zipCode,
            ])->json();

            $canton = $response[0]["canton"]["code"] ?? null;

            if ($canton === null) {
                $this->error("No canton found for zip code {$zipCode}");
            }

            // Add canton to supporter
            $supporter["canton"] = $canton;

            // Update supporter in array
            $supporters[$i] = $supporter;
        }

        // Open file __DIR__ . /../../../stats/data/cleaned_supporters_with_cantons.csv
        $handle = fopen(__DIR__ . '/../../../stats/data/cleaned_supporters_with_cantons.csv', 'w');
        $headers = array_keys($supporters[0]);
        fputcsv($handle, $headers);
        foreach ($supporters as $supporter) {
            fputcsv($handle, $supporter);
        }
        fclose($handle);

        $this->info('Cantons assigned to supporters!');
        $this->info('File created: ' . __DIR__ . '/../../../stats/data/cleaned_supporters_with_cantons.csv');

        // Write output to file
        file_put_contents(__DIR__ . '/../../../stats/output.txt', ob_get_clean());
    }
}
