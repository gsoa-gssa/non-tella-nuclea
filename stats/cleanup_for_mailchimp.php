<?php
// Open __dir__ . "/data/supporters-2024-06-17-08-02-38.csv"
$file = fopen(__dir__ . "/data/supporters-2024-06-17-08-02-38.csv", "r");

// Read the first line of the file
$headers = fgetcsv($file);

$supporters = [];
// Read each line of the file
while (($line = fgetcsv($file)) !== false) {
    // Create an associative array from the headers and line
    $data = array_combine($headers, $line);

    // Add the data to the supporters array
    $supporters[] = $data;
}

// Close the file
fclose($file);

// Filter supporters where $supporter['optin'] is true
$optin_supporters = array_filter($supporters, function($supporter) {
    return $supporter['optin'] === 'TRUE' || $supporter['method'] === 'direct-sign';
});

// Create Array of email and pledgeemail columns
$emails = array_map(function($supporter) {
    if (isset($supporter['pledgeemail']) && $supporter['pledgeemail'] !== '') {
        return $supporter['pledgeemail'];
    } else {
        return $supporter['email'];
    }
}, $optin_supporters);

// Remove duplicate emails
$emails = array_unique($emails);

$final = [];
foreach ($emails as $email) {
    // Find the supporter where $optin_supporter['pledgeemail'] is $email
    $supporter = array_filter($optin_supporters, function($optin_supporter) use ($email) {
        return $optin_supporter['pledgeemail'] === $email;
    });

    if (empty($supporter)) {
        // Find the supporter where $optin_supporter['email'] is $email
        $supporter = array_filter($optin_supporters, function($optin_supporter) use ($email) {
            return $optin_supporter['email'] === $email;
        });
    }

    // Get the first supporter
    $supporter = reset($supporter);

    // Add the supporter to the final array
    $final[] = $supporter;
}

// Open __dir__ . "/data/cleaned_supporters.csv"
$file = fopen(__dir__ . "/data/cleaned_supporters.csv", "w");

// Write the headers to the file
fputcsv($file, $headers);

// Write each supporter to the file
foreach ($final as $supporter) {
    fputcsv($file, $supporter);
}

// Close the file
fclose($file);
