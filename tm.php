<?php
require 'madeline.phar';
include 'dblib.inc.php';
include 'MadelineEventHandler.php';
include 'ccxt.php';

date_default_timezone_set ('UTC');

$api_id = 232561;
$api_hash = 'b17c837bbd88c075ce927a6e112d768b';
$settings = ['app_info' => ['api_id' => $api_id, 'api_hash' => $api_hash]];
/*
try {
    $MadelineProto = new \danog\MadelineProto\API('bot.madeline', $settings);
} catch (\danog\MadelineProto\Exception $e) {
    \danog\MadelineProto\Logger::log($e->getMessage());
    unlink('bot.madeline');
    $MadelineProto = new \danog\MadelineProto\API('bot.madeline', $settings);
}
$MadelineProto->start();
$MadelineProto->setEventHandler('\EventHandler');
$MadelineProto->loop();
*/





$MadelineProto = new \danog\MadelineProto\API('session.madeline', ['app_info' => ['api_id' => $api_id, 'api_hash' => $api_hash]]);
$MadelineProto->start();

$id = "channel#1268010485";

$arrChannelId = array("channel#1268010485", "channel#1242625451", "channel#1116205712");

$Chat = $MadelineProto->messages->getAllChats(['except_ids' => [], ]);
echo "<pre>"; print_r($Chat);exit;

$inputMessageID = [2];

$messages_Messages = $MadelineProto->channels->getMessages(['channel' => $id, 'id' => $inputMessageID, ]);

//$Chat = $MadelineProto->get_pwr_chat($id);

//$inputMessageID = [2];

$messages_PeerDialogs = $MadelineProto->messages->getPeerDialogs(['peers' => $arrChannelId, ]);

foreach($messages_PeerDialogs["messages"] as $message){
    echo "id = ".$message["id"].", message=".$message["message"]."\r";
}
*/

