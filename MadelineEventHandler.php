<?php
class EventHandler extends \danog\MadelineProto\EventHandler
{
    private $db;

    private $usdAmount = 12;

    private $PaidSignal1 = 1268010485;

    private $myOwnID = 435474230;

    private $dudungpretID = 1331154859;

    private $cryptoHeight = 1138551377;

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

        if($debug==1)
        {
            if(file_exists("tmDEBUG.signal")) unlink("tmDEBUG.signal");
            file_put_contents("tmDEBUG.signal",$res."\r\n",FILE_APPEND);
        }

        $res = $this->jsonDecode($res);

        if($res["message"]!=""){
            $this->openDB();
            $channelId = $res["channel_id"];
            $signalId = $res["id"];

            $this->storeOriginalMessage($res);

            if($channelId == $this->PaidSignal1 || $channelId == $this->cryptoHeight || $channelId == $this->dudungpretID || $channelId == $this->myOwnID){
                if(!$this->isExistedSignal($signalId,$channelId )){
                    $this->processingMessage($res["message"], $channelId, $signalId);
                }
            }
            $this->closeDB();
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

    public function storeOriginalMessage($res){
        $sql = "select count(id) as count_id from messages";
        $this->db->query($sql);
        if($row = $this->db->fetch_assoc()){
            $countMessages = $row["count_id"];
        }
        if($countMessages >=100){
            $sql = "delete from messages";
            $this->db->query($sql);
        }

        $sql = "select id from messages order by id desc limit 1";
        $this->db->query($sql);
        $latestId = 0;
        if($row = $this->db->fetch_assoc()){
            $latestId = $row["id"];
        }
        if($latestId > 30000){
            $sql = "truncate messages";
            $this->db->query($sql);
        }

        $message = $this->cleanOriginalSignal($res["message"]);
        $sql = "insert into messages(message, channel_id, signal_id) values ('".$message."','".$res["channel_id"]."','".$res["id"]."')";
        $this->db->query($sql);
    }

    public function processingMessage($message, $channelId, $signalId){
        $startTrx = 1;
        $arrResult  = $this->processingSignals($message, $channelId, $signalId);
        if($arrResult && isset($arrResult["exchange"]) && isset($arrResult["coin"])){
            if($startTrx==0 && $channelId==$this->myOwnID){
                //DEBUG PURPOSE ONLY
                print_r($arrResult);
            }else{
                $exchange = $arrResult["exchange"];
                switch(strtolower($exchange)){
                    case "binance":
                        $arrSettings = array(
                            'exchangeName' => "binance",
                            'apiKey' => 'ZDaaBMAEmN2gDitsDcYESXA99QY9OZCeG2qvpyGyflC0BGb5MnqjqhG4MoPumUlN',
                            'secret' => 's30A0gl8wPOer6R5P8bOchU9Aqyt10rY09GMyUjq7SCyIjcUGFawNxt3wWKzdM07'
                        );
                        $this->makeBinanceTrx($arrResult,$arrSettings, $signalId);
                }
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

        if($debug){
            file_put_contents("tmDEBUG.signal",json_encode($arrResult)."\r\n",FILE_APPEND);
        }
        return $arrResult;
    }

    public function cleanOriginalSignal($message){
        $message = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $message);
        $message = preg_replace( '/[^[:print:]]/', ' ',$message);
        $message = preg_replace('/\s+/', ' ',$message);
        $message = str_replace("'","",$message);
        return $message;
    }

    public function cleansingSignals($message, $channelId, $signalId){
        $arrResult = array();

        if($channelId == $this->PaidSignal1){
            $message = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $message);
            $message = preg_replace( '/[^[:print:]]/', ' ',$message);
            $message = preg_replace('/\s+/', ' ',$message);
            $message = str_replace("'","",$message);
            $message = str_replace(","," ",$message);
            $message = str_replace("-"," ",$message);
            $message = preg_replace('/\s+/', ' ',$message);

            if(strpos(strtolower($message),"done")===false &&
                strpos(strtolower($message),"achieve")===false &&
                strpos(strtolower($message),"complete")===false &&
                strpos(strtolower($message),"finish")===false  &&
                strpos(strtolower($message),"buy")!==false &&
                strpos(strtolower($message),"sell")!==false &&
                strpos(strtolower($message),"#")!==false

            ){
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
                    if(strpos(strtolower($message),"sell")!==false){
                        $sell_index = $i;
                    }
                    if($buy_index >0 && $sell_index == 0 && intval($message) > 0 && $firstBuy == 0){
                        $arrResult["firstBuy"] = $message;
                        $firstBuy = 1;
                    }
                    if($buy_index >0 && $sell_index > 0 && intval($message) > 0  && $firstTarget == 0){
                        $arrResult["firstTarget"] = str_replace(",","",$message);
                        $firstTarget = 1;
                    }
                }

                $arrResult["coin"] = str_replace("#","",$arrResult["coin"]);
                $arrResult["exchange"] = "BINANCE";
                $this->insertSignal($signalId, $channelId, $arrResult);
            }


        }

        if($channelId == $this->cryptoHeight || $channelId == $this->myOwnID || $channelId == $this->dudungpretID){
            $message = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $message);
            $message = preg_replace( '/[^[:print:]]/', ' ',$message);
            $message = preg_replace('/\s+/', ' ',$message);
            $message = str_replace("'","",$message);
            $message = str_replace(","," ",$message);
            $message = str_replace("-"," ",$message);
            $message = preg_replace('/\s+/', ' ',$message);

            if(strpos(strtolower($message),"done")===false &&
                strpos(strtolower($message),"achieve")===false &&
                strpos(strtolower($message),"complete")===false &&
                strpos(strtolower($message),"finish")===false  &&
                strpos(strtolower($message),"buyingpoint")!==false &&
                strpos(strtolower($message),"sellingpoint")!==false &&
                strpos(strtolower($message),"binance")!==false &&
                strpos(strtolower($message),"shorttrade")!==false &&
                strpos(strtolower($message),"stoploss")!==false &&
                strpos(strtolower($message),"#")!==false

            ){
                //#ShortTrade #BAT #Binance #Bittrex #BuyingPoint: 0.000046 0.000047 ##SellingPoint: 0.00004950 0.000054 #Stoploss: 0.000045

                $arrMessage = explode(" ",$message);
                $i = 0;
                $firstBuy = 0;
                $firstTarget = 0;
                $buy_index = 0;
                $sell_index = 0;

                foreach($arrMessage as $message){
                    $i++;
                    if(strlen($message)<=5 && strtolower($message)!= "yobit") {
                        $arrResult["coin"] = $message;
                    }
                    if(strpos(strtolower($message),"buying")!==false){
                        $buy_index = $i;
                    }
                    if(strpos(strtolower($message),"selling")!==false){
                        $sell_index = $i;
                    }
                    if($buy_index >0 && $sell_index == 0 && intval($message) > 0 && $firstBuy == 0){
                        $arrResult["firstBuy"] = $message;
                        $firstBuy = 1;
                    }
                    if($buy_index >0 && $sell_index > 0 && intval($message) > 0  && $firstTarget == 0){
                        $arrResult["firstTarget"] = str_replace(",","",$message);
                        $firstTarget = 1;
                    }
                }

                $arrResult["coin"] = str_replace("#","",$arrResult["coin"]);
                $arrResult["exchange"] = "BINANCE";
                $this->insertSignal($signalId, $channelId, $arrResult);
            }


        }
        return $arrResult;
    }

    public function insertSignal($signalId, $channelId, $arrResult){
        $sql = "INSERT INTO `signals`(`signal_id`,`channel_id`,`exchange`,`coin`, `signal_buy_value`, `signal_sell_value`,`is_processed`, `is_rejected`, `reason`, `received_date`) VALUES ($signalId,$channelId,'".$arrResult['exchange']."','".str_replace('#','',$arrResult['coin'])."',".$arrResult['firstBuy'].",".$arrResult['firstTarget'].",1,0,'',now())";

        $this->db->query($sql);
        return $this->db->last_insert_id();
    }

    public function isExistedSignal($signalId, $channelId){
        $sql = "select * from signals where signal_id=$signalId and channel_id=$channelId";
        $this->db->query($sql);
        if($row = $this->db->fetch_assoc()){
            return true;
        }
        return false;
    }

    public function makeBinanceTrx($arrResult, $arrSettings, $signalId){
        $coin = $arrResult["coin"];
        $buySignal = $arrResult["firstBuy"];
        $exchangeSignal = $arrResult["exchange"];
        //later on need to enhance, get all apikey from the users table

        $exchange = new ExchangeService($arrSettings);
        $availableCoin = $exchange->checkMarket($coin,$exchangeSignal);
        if($availableCoin){
            $coin = $availableCoin;
            if(strpos(strtolower($availableCoin),"/btc")!==false){
                $baseCoinAmount = $exchange->getBaseCoinAmountFromUSD("BTC",$this->usdAmount);
            }elseif(strpos(strtolower($availableCoin),"/bnb")!==false){
                //$baseCoinAmount = $exchange->getBaseCoinAmountFromUSD("BNB",$this->usdAmount);
                $baseCoinAmount = 1;
            }

            //file_put_contents("tmDEBUG.signal",json_encode($exchange->fetch_markets())."\r\n",FILE_APPEND);exit;
            $ticker = $exchange->getCurrentPriceInfo($coin);
            $buyPrice = $ticker["ask"];
            if($buySignal <=($buySignal * 1.02) ){
                if($exchange->countLimitSell() < 20){
                    $buyAmount = floor($baseCoinAmount / $buyPrice);
                    $marketBuyInfo["id"] = 0;
                    $limitSellInfo["id"] = 0;
                    $marketBuyInfo = $exchange->market_buy($coin, number_format($buyAmount, 8));
                    $exchange->insertBuytoDB($signalId, $marketBuyInfo["id"],$coin,1,$buyPrice,$baseCoinAmount, "BINANCE");
                    $price = $buyPrice * 1.05;
                    $limitSellInfo = $exchange->limit_sell($coin,$marketBuyInfo["amount"], number_format($price, 8));
                    $exchange->insertPendingSelltoDB($signalId,$limitSellInfo["id"],$marketBuyInfo["id"],$coin,1,number_format($price, 8),$buyAmount, "BINANCE");

                    $emailMessage = "Coin: ".$coin."\r\n";
                    $emailMessage .= "Allocated Budget: $".$this->usdAmount."\r\n";
                    $emailMessage .= "Buy Price: ".$buyPrice."\r\n";
                    $emailMessage .= "Buy Amount: ".$buyAmount."\r\n";
                    $emailMessage .= "Sell Price: ".$price."\r\n";
                    $emailSubject = "Binusian CryptoBot, Buy ".$coin;
                    $emailRecipient = "wayang@wayangcorp.com";
                    $emailSender = "omkucingjoget@wayangcorp.com";
                    $headers = "From: $emailSender\r\n";
                    //mail($emailRecipient,$emailSubject,$emailMessage,$headers);
                }
            }
            exit;
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
}
