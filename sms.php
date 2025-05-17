<?php
function sendSms($receiver_number, $message) {
  $client = new GuzzleHttp\Client();
  $apiKey = 'uk_amG_hB7AfEE6Jn_DrAQ9kG67x4bW_6REbbbugwjcHwbNHS4-wXzSE2UQ_QjBBlfr';
  $devApiKey = 'uk_ir-RizoshRhFu2X-IxEoQBY_aRb56AWfUG85YFnbO-IyDzAUJRD3hMZNouQh05oj';

  $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
    'headers' => [
      'x-api-key' => $apiKey,
    ],
    'json'    => [
      'content' => $message,
      'from'    => '+639187885334', //default
      'to'      => $receiver_number
    ]
  ]);
}


function sendReminderSms($event_id, $receiver_number) {
  $client = new GuzzleHttp\Client();
  $apiKey = 'uk_amG_hB7AfEE6Jn_DrAQ9kG67x4bW_6REbbbugwjcHwbNHS4-wXzSE2UQ_QjBBlfr';
  $devApiKey = 'uk_ir-RizoshRhFu2X-IxEoQBY_aRb56AWfUG85YFnbO-IyDzAUJRD3hMZNouQh05oj';

  $message = "Your event with an ID: $event_id is tomorrow, please coordinate with Queens And Knights Event Services.";

  $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
    'headers' => [
      'x-api-key' => $apiKey,
    ],
    'json'    => [
      'content' => $message,
      'from'    => '+639187885334', //default
      'to'      => $receiver_number
    ]
  ]);
}
