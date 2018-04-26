<?php
class EventHandler extends \danog\MadelineProto\EventHandler
{
    private $db;

    private $USDAmount = 20;

    private $VIPPaidSignal = 1268010485;

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

        $startTrx = 0;
        $arrResult = "";
        list($lastInsertID, $arrResult)  = $this->processingSignals($message, $channelId, $signalId);
        if($arrResult){

            if($startTrx==0 && $channelId==$this->getMyOwnID()){

                //DEBUG PURPOSE ONLY
                print_r($arrResult);
            }else{
                $this->openDB();
                $exchange = $arrResult["exchange"];
                switch(strtolower($exchange)){
                    case "binance":
                        $arrSettings = array(
                            'exchangeName' => "binance",
                            'apiKey' => 'zwhEjpIR3XzbQShM5p9jMNmPUOphCTehHEup1G6DlB9wA8wpdmjc7tTsUiHhCtiF',
                            'secret' => 'UGVyb7Txko0t16DbCKjTxi1sI9fM2LK3oRf4WaRCTo6DIJVYSQySV5KOSVmyxzmU'
                        );

                        $this->makeBinanceTrx($arrResult,$arrSettings);
                }



                $this->closeDB();
            }


        }
    }

    public function openDB(){
        $this->db = new db_mySQL;
        $this->db->init();
    }

    public function closeDB(){
        $this->db->close();
    }

    public function processingSignals($message, $channelId, $signalId){
        $debug = 0;

        $arrResult = $this->cleansingSignals($message, $channelId, $signalId);
        $lastInsertID = 0;

        if($debug){
            file_put_contents("tmDEBUG.signal",json_encode($arrResult)."\r\n",FILE_APPEND);
        }
        if(isset($arrResult["exchange"])){
            $exchange = strtoupper($arrResult["exchange"]);
            $lastInsertID = $this->insertSignal($signalId, $channelId, $exchange, $arrResult);

        }
        return array($lastInsertID,$arrResult);
    }

    public function cleansingSignals($message, $channelId, $signalId){
        $arrResult = array();

        if($channelId == $this->VIPPaidSignal){
            $message = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $message);
            $message = preg_replace( '/[^[:print:]]/', ' ',$message);
            $arrReplaced = array("-",":",",","(",")","@","SATs","SATS","SATOSHI","Satoshi","satoshi","sats");
            foreach($arrReplaced as $replaced){
                $message = str_replace($arrReplaced, " ",$message);
            }
            $message = preg_replace('/\s+/', ' ',$message);

            if(strpos(strtolower($message)," done")===false && strpos(strtolower($message)," sell")!==false && strpos(strtolower($message)," buy")!==false){


                echo "<pre>"; print_r($message);exit;
                $arrMessage = explode(" ",$message);
                $i = 0;
                $firstBuy = 0;
                $firstTarget = 0;
                $buy_index = 0;
                $sell_index = 0;
                foreach($arrMessage as $message){
                    $i++;
                    if(strpos($message,"#")!==false) {
                        $arrResult["coin"] = $message;
                    }
                    if(strtolower($message)=="buy" || strpos($message,"#")!==false){
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
                if($arrResult["exchange"]=="") $arrResult["exchange"]= "binance";
                $arrResult["coin"] = str_replace("#","",$arrResult["coin"]);
            }
        }
        return $arrResult;
    }

    public function insertSignal($signalId, $channelId, $exchange, $arrResult){
        $sql = "INSERT INTO `signals`(`signal_id`,`channel_id`,`exchange`,`coin`, `signal_buy_value`, `signal_sell_value`,`is_processed`, `is_rejected`, `reason`, `received_date`) VALUES ($signalId,$channelId,'$exchange','".str_replace('#','',$arrResult['coin'])."',".$arrResult['firstBuy'].",".$arrResult['firstTarget'].",0,0,'',now())";
        $this->db->query($sql);
        return $this->db->last_insert_id();
    }

    public function makeBinanceTrx($arrResult, $arrSettings){
        $coin = $arrResult["coin"];
        $buySignal = $arrResult["firstBuy"];
        $exchange = $arrResult["exchange"];
        //later on need to enhance, get all apikey from the users table

        $exchange = new ExchangeService($arrSettings);
        $availableCoin = $exchange->checkMarket($coin,$exchange);
        if($availableCoin){
            $coin = $availableCoin;
            $baseCoinAmount = $exchange->getBaseCoinAmountFromUSD("BNB",$this->getUSDAmount());
            //file_put_contents("tmDEBUG.signal",json_encode($exchange->fetch_markets())."\r\n",FILE_APPEND);exit;
            $ticker = $exchange->getCurrentPriceInfo($coin);
            $buyPrice = $ticker["ask"];
            if($buySignal <=($buySignal * 1.02) ){
                $buyAmount = floor($baseCoinAmount / $buyPrice);
                //$marketBuyInfo = $exchange->market_buy($coin, $buyAmount);
                $price = $buyPrice * 1.03;
                //$limitSellInfo = $exchange->limit_sell($coin,$marketBuyInfo["amount"], $price);

                $emailMessage = implode("\r\n",$arrResult);
                $emailSubject = "Binusian CryptoBot, Buy ".$coin;
                $emailRecipient = "wayang@wayangcorp.com";
                $emailSender = "omkucingjoget@wayangcorp.com";
                //mail($emailRecipient,$emailSubject,$emailMessage);
            }
        }

    }

    public function getDB()
    {
        return $this->db;
    }

    public function setDB($db)
    {
        $this->db = $db;
    }

    /**
     * @return int
     */
    public function getUSDAmount()
    {
        return $this->USDAmount;
    }

    /**
     * @param int $USDAmount
     */
    public function setUSDAmount($USDAmount)
    {
        $this->USDAmount = $USDAmount;
    }


}
