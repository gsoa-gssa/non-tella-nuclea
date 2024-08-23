<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rnw extends Model
{
    use HasFactory;
    public $sum = 0;
    public $percentage = 0;
    public $missing = 0;

    public function getSum()
    {
        $apiResponse = $this->getTransactions();
        $this->sumTransactions($apiResponse["result"]["transactions"]);
        if ($apiResponse["result"]["additional_info"]["total_pages"] > 1) {
            for ($i = 2; $i <= $apiResponse["result"]["additional_info"]["total_pages"]; $i++) {
                $apiResponse = $this->getTransactions($i);
                $this->sumTransactions($apiResponse["result"]["transactions"]);
            }
        }
        if($this->sum > 25000) {
            $this->sum = 25000;
        } elseif ($this->sum < 1312) {
            $this->sum = 1312;
        }
        $this->percentage = $this->sum / 25000 * 100;
        $this->missing = 25000 - $this->sum;
    }

    private function getTransactions($page = 1)
    {
        return Http::withBasicAuth(env("RAISENOW_API_USER"), env("RAISENOW_API_PASSWORD"))
            ->get(
                "https://api.raisenow.com/epayment/api/gsoas-3b26/transactions/search", [
                "page" => $page,
                'sort' => [
                    [
                        'field_name' => 'created',
                        'order' => 'desc',
                    ],
                ],
                'filters' => [
                    [
                        'field_name' => 'stored_campaign_name',
                        'type' => 'fulltext',
                        'value' => 'tpnw_tagesanzeiger',
                    ],
                    [
                        'field_name' => 'last_status',
                        'type' => 'term',
                        'value' => 'final_success',
                    ],
                ],
            ])
            ->json();
    }

    private function sumTransactions($transactions)
    {
        array_map(function ($transactions) {
            $this->sum += $transactions["amount"] / 100;
        }, $transactions);
    }
}
