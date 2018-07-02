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

$getPendingSignalSql = "select * from signals where is_processed = 0";
$db->query($getPendingSignalSql);
while($row = $db->fetch_assoc()){
    $id = $row["id"];
    $signalId = $row["signal_id"];
    $buySignal = $row["signal_buy_value"];
    $coin = $row["coin"];
    $availableCoin = $exchange->checkMarket($coin,$exchangeSignal);
    $ticker = $exchange->getTicker($coin);
    $buyPrice = $ticker["ask"];
    if($availableCoin){
        $coin = $availableCoin;
        $baseCoinAmount = 1;
        if(strpos(strtolower($availableCoin),"/btc")!==false){
            $baseCoinAmount = $exchange->getBaseCoinAmountFromUSD("BTC",$this->usdAmount);
        }elseif(strpos(strtolower($availableCoin),"/bnb")!==false){
            //$baseCoinAmount = $exchange->getBaseCoinAmountFromUSD("BNB",$this->usdAmount);
            $baseCoinAmount = 1;
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