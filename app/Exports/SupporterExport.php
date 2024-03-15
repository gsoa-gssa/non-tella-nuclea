<?php

namespace App\Exports;

use App\Models\Supporter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupporterExport implements FromCollection, WithHeadings
{
    public $supporters;

    public function __construct($supporters)
    {
        $this->supporters = $supporters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->supporters;
    }

    public function headings(): array
    {
        return array_keys($this->supporters->first()->toArray());
    }
}
