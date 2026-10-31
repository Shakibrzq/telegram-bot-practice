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
// if you want to use syntax error delete true parameter
$update = json_decode($input, true); //array

error_log(json_encode($update,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ));

//upadte is in array syntax
//so we use indexing syntax not the object syntax $update->message->...

if(isset($update['message'])){
    //base
    $message = $update['message']['text'];
    $message_id = $update['message']['message_id'];

    //from
    $from_id = $update['message']['from']['id'];
    $is_bot = $update['message']['from']['is_bot'];
    $first_name = $update['message']['from']['first_name'];
    $lang_code= $update['message']['from']['language_code'];

    //chat
    $chat_name = $update['message']['chat']['first_name'];
    $chat_username = $update['message']['chat']['username'];
    $type = $update['message']['chat']['type'];
    $chat_id = $update['message']['chat']['id'];
    //location

}



define("API_KEY",getenv('BOT_TOKEN'));
function bot($method, $data = []) {
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.API_KEY.'/'.$method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // اجرای درخواست
    $response = curl_exec($ch);
    // ذخیره خطای احتمالی در لاگ
    if ($response === false) {
        error_log('cURL Error: ' . curl_error($ch));
    } else {
        error_log('Telegram Response: ' . $response);
    }


    return $response;
}
if(isset($update['message']['location'])){
    $latitude = $update['message']['location']['latitude'];
    $longitude = $update['message']['location']['longitude'];

    bot('sendMessage', [
        'chat_id'=>$chat_id,
        'reply_to_message_id'=>$message_id,
        'text'=>"<u>latitude:$latitude'\n'Longitude:$longitude</u>",
        'parse_mode'=>'HTML'
    ]);
}

// if(isset($update['message'][''])){
//     //
// }
if($message == '/start' && $type == 'private'){
    bot('sendMessage', [
    'chat_id' => $chat_id,
    'text' => '<b>Hi welcome to the bot</b>',
    'parse_mode' => 'HTML',
    //reply_parameters
    'reply_to_message_id'=>$message_id,
    //getting keyboards for our bot using replymarkup parameter 
    'reply_markup'=>json_encode([
        //Array of Array of
         'keyboard'=>[
            [['text'=>'Location button','request_location'=>true],['text'=>'getmobile button','request_contact'=>true], ['text'=>'Delete button']
            ,['text'=>'glass button'], ['text'=>'glass button2']]
         ],
         'resize_keyboard'=>true,
         //کیبورد بعد استفاده بسته میشه
        //  'one_time_keyboard'=>true
        'input_field_placeholder'=>'Select one of the buttons'
        
        

    ])

]);
}elseif($message == '/help'){
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "This is my bot guide\n<code>/info</code>\n<code>/info_chat</code>",
            'parse_mode' => 'HTML',
            'reply_to_message_id' => $message_id
    ]);
}elseif($message == '/info'){
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "from id:$from_id\nis_bot:$is_bot\nfirstname:$chat_name\nlanguage_code:$lang_code",

        'reply_to_message_id' => $message_id
    ]);
}elseif($message == '/info_chat'){
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "chat id:$chat_id\nis_bot:$is_bot\nchatname:$chat_name\nusername:$chat_username\ntype:$type",
        'reply_to_message_id' => $message_id
    ]);
}elseif($message == 'first button' and $type == 'private'){
    bot('sendMessage', [
        'chat_id'=>$chat_id,
        'text'=>"you've pressed the first button"
    ]);
}elseif($message == "Delete button" && $type == "private"){
    bot('sendMessage', [
        'chat_id'=> $chat_id,
        'reply_to_message_id'=> $message_id,
        'text'=>'All buttons deleted successfully',
        'reply_markup'=>json_encode([
            'remove_keyboard'=>true
        ])
    ]);
    //inline keyboard markup
}elseif($message =="glass button"){
    bot("sendMessage", [
        'chat_id'=> $chat_id,
        'reply_to_message_id'=> $message_id,
        'text'=>'Displaying glass buttons',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                //when user press the button the url will be open
                [['text'=>'Hello world',
                 'url'=>'https://youtube.com'
                 
                 ]
                 
                ]
            ]
        ])
    ]);
}elseif($message == 'glass button2'){
    bot('sendMessage', [
        'chat_id'=> $chat_id,
        'reply_to_message_id'=> $message_id,
        'text'=> 'Displaying glass buttons',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'callback button',
                'callback_data'=>'1234']]
            ]
        ])
    ]);
}





