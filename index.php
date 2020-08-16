<?php
define('API_KEY', '1368666227:AAEoRSX2XyYGoVXnrjPJrMmpmlXCxS6XtHc');

function bot($method, $datas = []){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);

    if (curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function typing($ch){
    return bot('sendChatAction', [
        'chat_id'=>$ch,
        'action'=>'typing'
    ]);
}

$update = json_decode(file_get_contents("php://input"), true);
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;

echo "<pre>";
echo "Assalomu alaykuuum!!!";
print_r($update);

if (isset($text)){
    typing($chat_id);
}

$button = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>'Biz haqimizda'], ['text'=>'Manzil']],
        [['text'=>'Bizning xizmatlar'], ['text'=>'Aloqa']]
    ]
]);

if ($text == "/start"){
    bot('sendMessage', [
        'chat_id'=>$chat_id,
        'text'=>'Assalomu alaykum bizning botimizga xush kelibsiz',
        'parse_mode'=>'markdown',
        'reply_markup'=>$button
    ]);
}

if ($text == "Manzil"){
    bot('sendMessage', [
        'chat_id'=>$chat_id,
        'text'=>'Nima gaplar',
        'parse_mode'=>'markdown',
        'reply_markup'=>$button
    ]);
}
