<?php
include "ExchangeService.php";
include 'dblib.inc.php';
include 'ccxt.php';

$db = new db_mySQL;
$db->init();
$arrSettings = array(
    'exchangeName' => "binance",
    'apiKey' => 'ZDaaBMAEmN2gDitsDcYESXA99QY9OZCeG2qvpyGyflC0BGb5MnqjqhG4MoPumUlN',
    'secret' => 's30A0gl8wPOer6R5P8bOchU9Aqyt10rY09GMyUjq7SCyIjcUGFawNxt3wWKzdM07'
);
$exchange = new ExchangeService($arrSettings);
$exchangeSignal = "binance";
$usdAmount = 10;

$lastWeekDate = date('Y-m-d',strtotime("-7 days"));
$closeWeekAgoSignalSql = "update signals set is_processed=-1, reason='signal invalid, too long to wait for buy (7days ago)' where received_date >'$lastWeekDate' and is_processed=0";
$db->query($closeWeekAgoSignalSql);

$getPendingSignalSql = "select * from signals where is_processed = 0";
$db->query($getPendingSignalSql);
while($row = $db->fetch_assoc()){
    $id = $row["id"];
    $signalId = $row["signal_id"];
    $buySignal = $row["signal_buy_value"];
    $coin = strtoupper($row["coin"]);
    if(strpos($coin,"/BTC")===false) $coin .= "/BTC";
    $availableCoin = $exchange->checkMarket($coin,$exchangeSignal);
    if($availableCoin){
        $ticker = $exchange->getTicker($coin);
        $buyPrice = $ticker["ask"];
        $coin = $availableCoin;
        $baseCoinAmount = 1;
        if(strpos(strtolower($availableCoin),"/btc")!==false){
            $baseCoinAmount = $exchange->getBaseCoinAmountFromUSD("BTC",$usdAmount);
        }
        if($buyPrice <=($buySignal * 1.02) ) {
            $exchange->updateProcessedSignalStatus($id,1);
            $buyAmount = floor($baseCoinAmount / $buyPrice);
            $marketBuyInfo["id"] = 0;
            $limitSellInfo["id"] = 0;
            //$marketBuyInfo = $exchange->market_buy($coin, number_format($buyAmount, 8));
            $exchange->insertBuytoDB($signalId, $marketBuyInfo["id"],$coin,1,$buyPrice,$baseCoinAmount, "BINANCE");
            $price = $buyPrice * 1.05;
            //$limitSellInfo = $exchange->limit_sell($coin,$marketBuyInfo["amount"], number_format($price, 8));
            $exchange->insertPendingSelltoDB($signalId,$limitSellInfo["id"],$marketBuyInfo["id"],$coin,1,number_format($price, 8),$buyAmount, "BINANCE");
        }
    }
    $sleep = rand(5,15);
    sleep($sleep);
}