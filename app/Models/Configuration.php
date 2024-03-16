<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'type',
        'domains',
        'source'
    ];

    protected $casts = [
        'domains' => 'array'
    ];

    /**
     * Determine the configuration to be used based on the request.
     */
    public static function determineConfiguration($request)
    {
        $configuration = json_decode(Storage::get("configurations/DEFAULT.json"));
        if ($request->exists('src')) {
            $db_config = self::where("source", $request->input('src'))->first();
            if ($db_config) {
                $additional_config = json_decode(Storage::get("configurations/" . $db_config->key . ".json"));
                $configuration = (object) array_merge((array) $configuration, (array) $additional_config);
            }
        } else if ($request->cookie('config_key')) {
            $db_config = self::where("key", $request->cookie('config_key'))->first();
            if ($db_config) {
                $additional_config = json_decode(Storage::get("configurations/" . $db_config->key . ".json"));
                $configuration = (object) array_merge((array) $configuration, (array) $additional_config);
            }
        } else {
            $domain = $request->getHost();
            $db_config = self::whereJsonContains("domains", $domain)->first();
            if ($db_config) {
                $additional_config = json_decode(Storage::get("configurations/" . $db_config->key . ".json"));
                $configuration = (object) array_merge((array) $configuration, (array) $additional_config);
            }
        }
        if (!$db_config) {
            $db_config = self::where("key", "DEFAULT")->first();
        }
        $configuration->key = $db_config->key;
        Config::set('petition', $configuration);
        cookie()->queue(cookie('config_key', $db_config->key, 24 * 365));
    }

    /**
     * Determine the locale to be used based on the configuration that's been determined.
     */
    public static function determineLocale()
    {
        switch (Config::get('petition')->langsetting) {
            case "domainbased":
                $domain = request()->getHost();
                if (isset(Config::get('petition')->domains->$domain)) {
                    $locale = Config::get('petition')->domains->$domain->locale;
                } else {
                    $locale = app()->getLocale();
                }
                break;
            default:
                $locale = app()->getLocale();
        }
        app()->setLocale($locale);
        return $locale;
    }
}
