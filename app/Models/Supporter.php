<?php

namespace App\Models;

use App\Exports\SupporterExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supporter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "uuid",
        "email",
        "data",
        "email_verification_token",
        "email_verified_at",
        "public",
        "configuration",
        "optin",
    ];

    protected $casts = [
        "data" => "array",
        "email_verified_at" => "datetime",
        "public" => "boolean",
        "optin" => "boolean",
    ];

    /**
     * Send email verification to the supporter.
     */
    public static function sendEmailVerification()
    {
        
    }

    /**
     * Export supporters to XLSX file.
     */
    public static function exportToXlsx($supporters)
    {
        return Excel::download(new SupporterExport($supporters), "supporters.xlsx");
    }

    /**
     * Export supporters to CSV file.
     */
    public static function exportToCsv($supporters)
    {
        return Excel::download(new SupporterExport($supporters), "supporters.csv", \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export supporters to JSON file.
     */
    public static function exportToJson($supporters)
    {
        return response()->streamDownload(function () use ($supporters) {
            echo $supporters->toJson();
        }, "supporters.json");
    }
}
