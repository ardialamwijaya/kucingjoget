<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 31/03/2018
 * Time: 07.54
 */
class ExchangeService
{
    private $db;

    private $exchange;

    private $apiKey;

    private $apiSecret;

    private $exchangeName;

    public function __construct($arrParams){
        $this->exchangeName = $arrParams["exchangeName"];
        $this->apiKey = $arrParams["apiKey"];
        $this->apiSecret = $arrParams["secret"];
        $this->init();
        $this->openDB();

    }

    public function init(){
        switch(strtolower($this->exchangeName)){
            case "binance":
                $this->exchange = new \ccxt\binance(array(
                    "apiKey" => $this->apiKey,
                    "secret" => $this->apiSecret
                ));
                $this->exchange->options['adjustForTimeDifference'] = true; // auto-adjust the time difference
                $this->exchange->options['recvWindow'] = 50000;
                break;
        }
    }

    public function getTicker($coin){
        return $this->exchange->fetch_ticker(strtoupper($coin));
    }

    public function getCurrentPriceInfo($coin,$satoshi = false){
        $ticker = $this->getTicker($coin);
        $satoshiMultiplier = ($satoshi == false) ? 1: 100000000;
        return array(
            "high" => ($ticker["info"]["highPrice"] * $satoshiMultiplier),
            "low" => ($ticker["info"]["lowPrice"] * $satoshiMultiplier),
            "bid" => ($ticker["info"]["bidPrice"] * $satoshiMultiplier),
            "ask" => ($ticker["info"]["askPrice"] * $satoshiMultiplier)
        );
    }

    public function openDB(){
        $this->db = new db_mySQL;
        $this->db->init();
    }

    public function closeDB(){
        $this->db->close();
    }

    public function getLastBalance(){
        $sql = "select balance from user_balance order by id desc limit 0,1";
        $this->db->query($sql);
        $lastBalance = 0;
        if($row = $this->db->fetch_assoc()) {
            $lastBalance = $row["balance"];
        }
        return $lastBalance;
    }

    public function getPendingSold(){
        $sql = "select * from buy_trx where is_sold <> 1  order by id desc";
        $this->db->query($sql);
        $lastBalance = 0;
        $i = 0;
        if($row = $this->db->fetch_assoc()) {
            $arrPendingSold[$i]["signalId"] = $row["signal_id"];
            $arrPendingSold[$i]["buyPrice"] = $row["buy_price"];
            $arrPendingSold[$i]["settledDate"] = $row["settled_date"];
            $arrPendingSold[$i]["userAllocatedBalance"] = $row["user_allocated_balance"];
            $i++;
        }
    }

    public function calculateBuyAmount(){
        $lastBalance = $this->getLastBalance();
        $pendingSold = $this->getPendingSold();
        $allocatedBalance = $lastBalance / (10 - count($pendingSold));
        return $allocatedBalance;
    }

    public function limit_trx($type,$coin, $amount, $price){
        return $this->exchange->create_order($coin, "limit",$type,$amount, $price);
    }


    public function market_buy($coin, $amount){
        return $this->exchange->create_order($coin, "market","buy", $amount);
    }

    public function limit_sell($coin, $amount, $price){
        $acceptedAmount = $amount * 0.98;
        return $this->exchange->create_order($coin, "limit","sell",$acceptedAmount, $price);
    }

    public function market_sell($coin, $amount){
        return $this->exchange->create_order($coin, "market","sell", $amount);
    }

    public function countLimitSell(){
        $limitSellSql = "select count(id) as count_pending from pending_sell_trx where is_pending=1";
        $this->db->query($limitSellSql);
        $count = 0;
        if($row = $this->db->fetch_assoc()){
            $count = $row["count_pending"];
        }
        return $count;
    }

    public function insertBuytoDB($signalId,$buyOrderId, $coin,$userId, $price, $amount, $exchange){
        $insertBuyToDBSql = "insert into buy_trx(signal_id,order_id,coin, user_id, buy_price, user_allocated_balance,settled_date, exchange) values ($signalId,$buyOrderId,'$coin',$userId, $price, $amount, now(),'$exchange')";
        $this->db->query($insertBuyToDBSql);
    }

    public function insertPendingSelltoDB($signalId,$sellOrderId, $buyOrderId, $coin, $userId, $price, $amount,$exchange){
        $insertBuyToDBSql = "insert into pending_sell_trx(signal_id,sell_limit_order_id,buy_market_order_id,coin,user_id, target_price, user_allocated_balance, settled_date, is_pending, exchange) values ($signalId,$sellOrderId, $buyOrderId,'$coin', $userId, $price, $amount, now(),1,'$exchange')";
        $this->db->query($insertBuyToDBSql);
    }

    public function fetch_orders($symbol = null, $since = null, $limit = null){
        return $this->exchange->fetch_open_orders($symbol, $since, $limit);
    }

    public function fetch_ticker($symbol){
        return $this->exchange->fetch_ticker($symbol);
    }

    public function fetch_order_book($symbol){
        return $this->exchange->fetch_order_book($symbol);
    }

    public function fetch_my_trades($symbol){
        return $this->exchange->fetch_my_trades($symbol);
    }

    public function fetch_open_orders($symbol=null){
        return $this->exchange->fetch_open_orders($symbol);
    }

    public function cancel_order($orderId,$coin){
        return $this->exchange->cancel_order($orderId,$coin);
    }

    public function fetch_balance(){
        return $this->exchange->fetch_balance();
    }

    public function fetch_order($id, $symbol){
        return $this->exchange->fetch_order($id,$symbol);
    }

    public function calculate_fee($symbol, $type, $side, $amount, $price){
        return $this->exchange->calculate_fee($symbol, $type, $side, $amount, $price);
    }

    public function binusianBuy($coin, $buyAmount, $buyPrice){
        $marketBuyInfo = $this->market_buy($coin,$buyAmount);
        $orderInfo = $this->fetch_order($marketBuyInfo["id"], $coin);
    }

    public function fetch_markets(){
        return $this->exchange->fetch_markets();
    }

    public function checkMarket($coin, $exchange){
        $exchange = strtolower($exchange);
        $result = "";
        switch($exchange){
            case "binance":
                $result = $this->checkBinanceMarket($coin, $exchange);
                break;
        }
        return $result;
    }

    public function checkBinanceMarket($coin, $exchange){
        $checkSql = "select symbol from markets m inner join exchanges e on m.exchange_id = e.id where m.symbol like '$coin/bnb%'  and e.name like '$exchange'";
        $this->db->query($checkSql);
        if($row = $this->db->fetch_assoc()){
            return $row["symbol"];
        }else{
            $checkSql = "select symbol from markets m inner join exchanges e on m.exchange_id = e.id where m.symbol like '$coin/btc%'  and e.name like '$exchange'";
            $this->db->query($checkSql);
            if($row = $this->db->fetch_assoc()){
                return $row["symbol"];
            }else{
                return null;
            }
        }
    }

    public function getBaseCoinAmountFromUSD($baseCoin = "BTC", $usdAmount){
        $baseCoinTicker = $this->getTicker($baseCoin."/USDT");
        $currentBaseCoinPrice = $baseCoinTicker["ask"];
        echo $currentBaseCoinPrice;exit;
        $coinAmount = round($coinAmount, 5, PHP_ROUND_HALF_DOWN);
        return $coinAmount;

    }
}