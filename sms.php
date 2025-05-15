<?php
function sendSms($receiver_number, $message) {
  $client = new GuzzleHttp\Client();
  $apiKey = 'uk_ir-RizoshRhFu2X-IxEoQBY_aRb56AWfUG85YFnbO-IyDzAUJRD3hMZNouQh05oj';

  $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
    'headers' => [
      'x-api-key' => $apiKey,
    ],
    'json'    => [
      'content' => $message,
      'from'    => '+639939002627', //default
      'to'      => $receiver_number
    ]
  ]);
}
