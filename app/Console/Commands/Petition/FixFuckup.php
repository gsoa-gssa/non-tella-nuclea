<?php

namespace App\Console\Commands\Petition;

use App\Models\Supporter;
use Illuminate\Console\Command;

class FixFuckup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'petition:fix-fuckup';

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
        Supporter::truncate();
        // Read from Storage output.csv file
        $lines = file(storage_path("app/supporters/output.csv"));

        //Read the first line and convert them into a headers array
        $headers = array_shift($lines);
        $headers = str_getcsv($headers);

        $supporters = [];
        foreach ($lines as $line) {
            // Convert line to array
            $data = str_getcsv($line);

            // Combine headers and data into associative array
            $row = array_combine($headers, $data);

            // Add row to supporters array
            $supporters[] = $row;
        }


        foreach ($supporters as $supporter) {
            $new = new Supporter();
            $new->created_at = strtotime($supporter["created_at"]);
            $new->updated_at = strtotime($supporter["updated_at"]);
            $new->deleted_at = NULL;
            $new->uuid = $supporter["uuid"];
            $new->email = $supporter["email"];
            $new->email_verification_token = $supporter["email_verification_token"];
            $new->email_verified_at = ($supporter["email_verified_at"]) ? strtotime($supporter["email_verified_at"]) : NULL;
            $new->public = (bool) $supporter["public"];
            $new->configuration = $supporter["configuration"];
            $new->optin = (bool) $supporter["optin"];
            $new->data = json_decode($supporter["data"], true);
            $new->save();
        }
    }
}
