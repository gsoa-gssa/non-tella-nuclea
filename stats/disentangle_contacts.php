<?php
require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$mailchimp = new MailchimpMarketing\ApiClient();

$mailchimp->setConfig([
  'apiKey' => $_ENV['MC_KEY'],
  'server' => $_ENV['MC_SERVER']
]);

// // Get all campaigns
// $response = $mailchimp->campaigns->list(
//     count: 100,
//     offset: 0,
//     status: 'sent',
//     sort_field: 'send_time',
//     sort_dir: 'DESC'
// );
// $campaigns = $response->campaigns;

// // Put into csv all the campaigns
// $fp = fopen('campaigns.csv', 'w');
// foreach ($campaigns as $campaign) {
//     $id = $campaign->id;
//     $web_id = $campaign->web_id;
//     $title = $campaign->settings->title;
//     fputcsv($fp, [$id, $title, $web_id]);
// }
// fclose($fp);

// Get recepients of campaigns 3c026db495,b75aad7cc9,6e074d3e8e,0fd6bbeee2,3e84b76a9a,ad3a8edd95,8b73dbbe12,a4c2a1c3e9,6d67f40de6
// $campaigns = ['3c026db495', 'b75aad7cc9', '6e074d3e8e', '0fd6bbeee2', '3e84b76a9a', 'ad3a8edd95', '8b73dbbe12', 'a4c2a1c3e9', '6d67f40de6'];

// Open recepients.csv
// $fp = fopen('recepients.csv', 'a');

// foreach ($campaigns as $campaign_id) {
//     print("Processing campaign $campaign_id\n");
//     $response = $mailchimp->reports->getCampaignRecipients($campaign_id);
//     $total_recipients = $response->total_items;
//     $iterations = ceil($total_recipients / 1000);
//     for ($i = 0; $i < $iterations; $i++) {
//         print("Processing $i of $iterations\n");
//         $response = $mailchimp->reports->getCampaignRecipients(
//             campaign_id: $campaign_id,
//             count: 1000,
//             offset: $i * 1000
//         );
//         $recipients = $response->sent_to;
//         foreach ($recipients as $recipient) {
//             $email = $recipient->email_address;
//             fputcsv($fp, [$email]);
//         }
//     }
//     print("Done processing campaign $campaign_id\n");
// }

// var_dump($contacts);

// Open recepients.csv
$fp = fopen('recepients.csv', 'r');

$contacts = [];
// For each recepient
while ($row = fgetcsv($fp)) {
    $email = $row[0];
    if (in_array($email, $contacts)) {
        print("Skipping \t \t $email\n");
        continue;
    } else {
        $contacts[] = $email;
        try {
            $mailchimp->lists->updateListMemberTags(
                $_ENV['MC_LIST_ID'],
                md5(strtolower($email)),
                [
                    'tags' => [
                        ['name' => 'pledge_received', 'status' => 'active']
                    ]
                ]
            );
            print("Tagged \t \t $email\n");
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                print("Not found \t $email\n");
            } else {
                print("Error \t \t $email\n");
                die();
            }
        }
    }
}
