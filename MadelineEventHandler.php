<?php

include "ExchangeService.php";

class EventHandler extends \danog\MadelineProto\EventHandler
{
    private $db;

    private $vipSignals = 1242625451;

    private $cryptoVIPSignal = 1116205712;

    private $cryptoVIPPaidSignal = 1268010485;

    private $cryptopiaPump = 1217563156;

    private $hawkEyeBittrexSignal = 1056449684;

    private $myOwnID = 435474230;

    public function __construct($MadelineProto)
    {
        parent::__construct($MadelineProto);
    }
    public function onAny($update)
    {
        \danog\MadelineProto\Logger::log("Received an update of type ".$update['_']);
    }
    public function onUpdateNewChannelMessage($update)
    {
        $this->onUpdateNewMessage($update);
    }
    public function onUpdateNewMessage($update)
    {
        $debug=0;

        if (isset($update['message']['out']) && $update['message']['out']) {
            return;
        }
        $res = json_encode($update, JSON_PRETTY_PRINT);
        if ($res == '') {
            $res = var_export($update, true);
        }

        if(file_exists("tmDEBUG.signal")) unlink("tmDEBUG.signal");

        if($debug==1)
        {
            file_put_contents("tmDEBUG.signal",$res."\r\n",FILE_APPEND);
        }

        $res = $this->jsonDecode($res);

        if($res["message"]!=""){
            $this->processingMessage($res["message"], $res["channel_id"],$res["id"]);
        }
    }

    public function jsonDecode($res){
        $res = (json_decode($res, TRUE));
        $channelId = "";
        if(isset($res["message"]["to_id"]["chat_id"])) $channelId = $res["message"]["to_id"]["chat_id"];
        if(isset($res["message"]["to_id"]["channel_id"])) $channelId = $res["message"]["to_id"]["channel_id"];
        if(isset($res["message"]["to_id"]["user_id"])) $channelId = $res["message"]["to_id"]["user_id"];

        $message = "";
        if(isset($res["message"]["message"])) $message = $res["message"]["message"];

        $signalId = $res["message"]["id"];

        $retVal["id"] = $signalId;
        $retVal["message"] = $message;
        $retVal["channel_id"] = $channelId;

        return $retVal;
    }

    public function processingMessage($message, $channelId, $signalId){

        $this->openDB();
        if($channelId==$this->getVipSignals() || $channelId==$this->getMyOwnID() ){
           list($lastInsertID, $arrResult)  = $this->processingVIPSignals($message, $channelId, $signalId);
        }
        $buySignal = $arrResult["firstBuy"];
        $coin = $arrResult["coin"];

        //later on need to enhance, get all apikey from the users table
        $arrSettings = array(
            'exchangeName' => "binance",
            'apiKey' => 'zwhEjpIR3XzbQShM5p9jMNmPUOphCTehHEup1G6DlB9wA8wpdmjc7tTsUiHhCtiF',
            'secret' => 'UGVyb7Txko0t16DbCKjTxi1sI9fM2LK3oRf4WaRCTo6DIJVYSQySV5KOSVmyxzmU'
        );

        $exchange = new ExchangeService($arrSettings);
        $buyAmount = $exchange->calculateBuyAmount();
        $marketBuy = $exchange->market_buy($coin, $buyAmount);
        $
        $sellPrice = $marketBuy["price"] * 1.03;
        $exchange->limit_sell($coin,$buyAmount, $sellPrice);

        $exchange->insertBuytoDB($signalId,$coin,"1",$order["price"], $buyAmount);
        $exchange->insertPendingSelltoDB($signalId, $coin, "1", $sellPrice, $buyAmount);

        $emailMessage = implode("\r\n",$arrResult);
        $emailSubject = "Binusian CryptoBot, Buy ".$coin;
        $emailRecipient = "wayang@wayangcorp.com";
        $emailSender = "omkucingjoget@wayangcorp.com";
        mail($emailRecipient,$emailSubject,$emailMessage);
        $this->closeDB();
    }

    public function openDB(){
        $this->db = new db_mySQL;
        $this->db->init();
    }

    public function closeDB(){
        $this->db->close();
    }


    public function processingVIPSignals($message, $channelId, $signalId){
        $debug = 0;

        $arrResult = $this->cleansingMessageVIPSignals($message, $channelId, $signalId);

        if($debug){
            file_put_contents("tmDEBUG.signal",json_encode($arrResult)."\r\n",FILE_APPEND);
        }
        $exchange = strtoupper($arrResult["exchange"]);
        $lastInsertID = $this->insertSignal($signalId, $channelId, $exchange, $arrResult);
        return array($lastInsertID,$arrResult);
    }

    public function cleansingMessageVIPSignals($message, $channelId, $signalId){
        $message = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $message);

        $message = preg_replace( '/[^[:print:]]/', ' ',$message);

        $message = trim(str_replace("B NANCE","BINANCE",$message));

        $message = trim(rtrim($message));

        $arrMessage = explode(" ",$message);
        $buy_index = 0;
        $sell_index = 0;
        $arrResult = array();
        $i = 0;
        $firstBuy = 0;
        $firstTarget = 0;
        foreach($arrMessage as $message) {
            $i++;
            if(strpos($message,"#")!==false) {
                $arrResult["coin"] = $message;
            }
            if(strtolower($message)=="buy"){
                $buy_index = $i;
            }
            if(strtolower($message)=="sell"){
                $sell_index = $i;
            }
            if(strtolower($message)=="binance"){
                $arrResult["exchange"] = $message;
            }
            if($buy_index >0 && $sell_index == 0 && intval($message) > 0 && $firstBuy == 0){
                $arrResult["firstBuy"] = $message;
                $firstBuy = 1;
            }
            if($buy_index >0 && $sell_index > 0 && intval($message) > 0  && $firstTarget == 0){
                $arrResult["firstTarget"] = $message;
                $firstTarget = 1;
            }
        }

        return $arrResult;
    }

    public function insertSignal($signalId, $channelId, $exchange, $arrResult){
        $sql = "INSERT INTO `signals`(`signal_id`,`channel_id`,`exchange`,`coin`, `signal_buy_value`, `signal_sell_value`,`is_processed`, `is_rejected`, `reason`, `received_date`) VALUES ($signalId,$channelId,'$exchange','".str_replace('#','',$arrResult['coin'])."',".$arrResult['firstBuy'].",".$arrResult['firstTarget'].",0,0,'',now())";
        $this->db->query($sql);
        return $this->db->last_insert_id();
    }

    public function getMyOwnID()
    {
        return $this->myOwnID;
    }

    public function getVipSignals()
    {
        return $this->vipSignals;
    }

    public function setVipSignals($vipSignals)
    {
        $this->vipSignals = $vipSignals;
    }

    public function getCryptoVIPSignal()
    {
        return $this->cryptoVIPSignal;
    }

    public function setCryptoVIPSignal($cryptoVIPSignal)
    {
        $this->cryptoVIPSignal = $cryptoVIPSignal;
    }

    public function getCryptoVIPPaidSignal()
    {
        return $this->cryptoVIPPaidSignal;
    }

    public function setCryptoVIPPaidSignal($cryptoVIPPaidSignal)
    {
        $this->cryptoVIPPaidSignal = $cryptoVIPPaidSignal;
    }

    public function getCryptopiaPump()
    {
        return $this->cryptopiaPump;
    }

    public function setCryptopiaPump($cryptopiaPump)
    {
        $this->cryptopiaPump = $cryptopiaPump;
    }

    public function getHawkEyeBittrexSignal()
    {
        return $this->hawkEyeBittrexSignal;
    }

    public function setHawkEyeBittrexSignal($hawkEyeBittrexSignal)
    {
        $this->hawkEyeBittrexSignal = $hawkEyeBittrexSignal;
    }

    public function getDB()
    {
        return $this->db;
    }

    public function setDB($db)
    {
        $this->db = $db;
    }
}
