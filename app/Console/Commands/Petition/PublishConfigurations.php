<?php

namespace App\Console\Commands\Petition;


use App\Models\Configuration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PublishConfigurations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'petition:publish-configurations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read configurations from configurations storage and publish them to the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $configurations = Storage::files('configurations');
        if (($key = array_search("configurations/DEFAULT.example.json", $configurations)) !== false) {
            unset($configurations[$key]);
        }

        foreach ($configurations as $configuration) {
            $key = preg_replace('/^configurations\/|\.json$/', '', $configuration);
            $dbConfiguration = Configuration::where('key', $key)->firstOrNew();
            $dbConfiguration->key = $key;
            $configuration = json_decode(Storage::get($configuration));
            if ($configuration->type == "domainbased") {
                $dbConfiguration->type = "domainbased";
                $dbConfiguration->domains = array_keys(get_object_vars($configuration->domains));
            } else {
                $dbConfiguration->type = "sourcebased";
                $dbConfiguration->source = $configuration->source;
            }
            $dbConfiguration->save();
        }
    }
}
