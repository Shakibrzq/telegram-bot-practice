<?php

$input = file_get_contents('php://input');
$update = json_decode($input, true);

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    exit("Bot is running");
}

// putting updates inside render logs

if (!empty($update)) {
    error_log(json_encode($update, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo $update['message']['message_id'];
}

if (!is_array($update)) {
    http_response_code(400);
    exit('Invalid JSON');
}



if (isset($update['message'])) {
    $message = $update['message'];

    $chatId = $message['chat']['id'] ?? null;
    $text = $message['text'] ?? '';

    if ($chatId !== null && $text === '/start') {
        $token = getenv('BOT_TOKEN');

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $postData = [
            'chat_id' => $chatId,
            'text' => 'سلام! ربات من با موفقیت اجرا شده است.'
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode($postData),
                'timeout' => 15
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
    }
}

http_response_code(200);
echo 'OK';