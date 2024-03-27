<?php

namespace App\Console\Commands\Petiton;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;

class SyncWeCollectSignatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'petition:sync-wecollect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync signatures from WeCollect webpage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dom = new Dom();
        $html = Http::get('https://wecollect.ch/projekte/offener-brief-beat-jans')->body();
        $dom->loadStr($html);
        $signatures_from_wecollect = (int)str_replace("’", "", $dom->find('.campaign__hero__meta')[0]->find('span')[1]->text());
        Storage::put('signatures/wecollect.txt', $signatures_from_wecollect);
    }
}
