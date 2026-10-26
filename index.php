<?php

//BOT METHODS:

//getMe
//getUpdates
//setWebhook
//sendMessage ->
// to use this method we need a chatid parameter and text
// chatid -> either the chat id or username of the target which is normally 
// for channels

$input = file_get_contents('php://input');
$update = json_decode($input, true);

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    exit("Bot is running");
   
}

// putting updates inside render logs

if (!empty($update)) {
    error_log(json_encode($update, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
}

if (!is_array($update)) {
    http_response_code(400);
    exit('Invalid JSON');
}



if (isset($update['message'])) {

    $message = $update['message']['text'];
    //another form of writing
    //$message = $update->message->text
    $from_user_name = $update['message']['from']['username'];
    //$form_user_name = $update->message->form->username

    $chat_id = $update['message']['chat']['id'];

    error_log($message.'is from:'.$from_user_name);

    // $chatId = $message['chat']['id'] ?? null;
    // $text = $message['text'] ?? '';

    // if ($chatId !== null && $text === '/start') {
    //     $token = getenv('BOT_TOKEN');

    //     $url = "https://api.telegram.org/bot{$token}/sendMessage";

    //     $postData = [
    //         'chat_id' => $chatId,
    //         'text' => 'سلام! ربات من با موفقیت اجرا شده است.'
    //     ];

    //     $options = [
    //         'http' => [
    //             'method' => 'POST',
    //             'header' => "Content-Type: application/json\r\n",
    //             'content' => json_encode($postData),
    //             'timeout' => 15
    //         ]
    //     ];

    //     $context = stream_context_create($options);
    //     $response = file_get_contents($url, false, $context);
    // }
    //api.telegram.org/bot<token>/<methodname>
    // با استفاده از curl 
    //میتونیم درخواست ثبت کنیم که به صورت پست به تلگر ام ارسال کنه

    define("API_KEY",getenv('BOT_TOKEN'));

    // this function is for managing bot methods
    // data = method parameters
   

}
 function bot($method, $data=[]){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.API_KEY.'/'.$method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        return curl_exec($ch);
    }

$responce = bot('sendMessage', [
    'chat_id' =>672397132,
    'text'=>"Hi Shakiba"
]);

error_log('log responce', $responce);
// http_response_code(200);
// echo 'OK';