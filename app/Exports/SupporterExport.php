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
        $headings = ["id", "created_at", "updated_at", "deleted_at", "uuid", "email", "pledgeemail", "email_verification_token", "email_verified_at", "public", "configuration", "optin"];
        $dataFields = Supporter::findDataFields();
        return array_merge($headings, $dataFields);
    }
}
