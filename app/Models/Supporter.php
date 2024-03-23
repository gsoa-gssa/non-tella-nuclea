<?php

namespace App\Models;

use App\Mail\VerifyEmail;
use App\Exports\SupporterExport;
use Illuminate\Support\Facades\Mail;
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
    public function sendEmailVerificationNotification()
    {
        Mail::to($this->email)->send(new VerifyEmail($this));
    }

    /**
     * Export supporters to XLSX file.
     */
    public static function exportToXlsx($supporters, $filename)
    {
        return Excel::download(new SupporterExport($supporters), $filename . ".xlsx");
    }

    /**
     * Export supporters to CSV file.
     */
    public static function exportToCsv($supporters, $filename)
    {
        return Excel::download(new SupporterExport($supporters), $filename . ".csv", \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export supporters to JSON file.
     */
    public static function exportToJson($supporters, $filename)
    {
        return response()->streamDownload(function () use ($supporters) {
            echo $supporters->toJson();
        }, $filename . ".json");
    }

    /**
     * Find all possible data fields for supporters.
     */
    public static function findDataFields()
    {
        $fields = [];
        $supporters = Supporter::all();
        foreach ($supporters as $supporter) {
            foreach ($supporter->data as $key => $value) {
                if (!in_array($key, $fields)) {
                    $fields[] = $key;
                }
            }
        }
        return $fields;
    }
}
