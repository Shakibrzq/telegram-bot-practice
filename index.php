<?php

//BOT METHODS:

//getMe
//getUpdates
//setWebhook
//sendMessage ->
// to use this method we need a chatid parameter and text and parse_mode
//parse_mode ia sending mode wchich is for text :bold-italic-spoiler,..
// To use this mode, pass MarkdownV2 in the parse_mode field
//To use this mode, pass HTML in the parse_mode field
// chatid -> either the chat id(int) or username(str) of the target which is normally 
// for channels

// $input = file_get_contents('php://input');
// $update = json_decode($input, true);

// // putting updates inside render logs

// if (!empty($update)) {
//     error_log(json_encode($update, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
// }

// if (isset($update['message'])) {

//     $message = $update['message']['text'];
//     //another form of writing
//     //$message = $update->message->text
//     $from_user_name = $update['message']['from']['username'];
//     $chat_id = $update['message']['chat']['id'];
//     define("API_KEY",getenv('BOT_TOKEN'));
  
// }

//  // this function is for managing bot methods
// // data = method parameters
//  function bot($method, $data=[]){
//     // با استفاده از curl 
//     //میتونیم درخواست ثبت کنیم که به صورت پست به تلگر ام ارسال کنه
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.API_KEY.'/'.$method);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//         return curl_exec($ch);
//     }

// $responce = bot('sendMessage', [
//     'chat_id' => 672397132,
//     'text' => '<i>Hi Shakiba</i>',
//     'parse_mode' => 'HTML'
// ]);

// designing a mini bot which answers to these messages
// start
//info ->returns account information
//info_chat -> returns chat info
//help-> shows these statements(messages user can send to bot)



$input = file_get_contents('php://input');
$update = json_decode($input, true);
error_log(json_encode($update,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ));


if(isset($update->message)){

    $message = $update->message->text;

}



define("API_KEY",getenv('BOT_TOKEN'));
function bot($method, $data = []){

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,'https://api.telegram.org/bot'.API_KEY.'/'.$method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    return curl_exec($ch);

}

bot('sendMessage', [
    'chat_id' => 672397132,
    'text' => '<b>Hi welcome to the bot</b>',
    'parse_mode' => 'HTML'

]);