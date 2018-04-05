<?php
include 'ccxt.php';
include 'ExchangeService.php';

date_default_timezone_set ('UTC');

$arrSettings = array(
    'exchangeName' => "binance",
    'apiKey' => 'zwhEjpIR3XzbQShM5p9jMNmPUOphCTehHEup1G6DlB9wA8wpdmjc7tTsUiHhCtiF',
    'secret' => 'UGVyb7Txko0t16DbCKjTxi1sI9fM2LK3oRf4WaRCTo6DIJVYSQySV5KOSVmyxzmU'
);


//SIMULATE MARKET BUY
$coin = "BNB/BTC";
$exchange = new ExchangeService($arrSettings);
$BTCAmount = "0.002";
$BNBTicker = $exchange->getCurrentPriceInfo($coin);
echo "<pre>"; print_r($BNBTicker);
$BNBPrice = $BNBTicker["ask"];
$BNBAmount = floor($BTCAmount / $BNBPrice);
$marketBuyInfo = $exchange->market_buy($coin, $BNBAmount);
echo "<pre>"; print_r($marketBuyInfo);
$price = $BNBPrice * 1.03;
$limitSellInfo = $exchange->limit_sell($coin,$marketBuyInfo["amount"], $price);
echo "<pre>";print_r($limitSellInfo);


/*
 * MARKET BUY RESPONSE
 *
 * $marketBuyResponse["info"]["symbol"] = "BNBBTC";
 * $marketBuyResponse["info"]["orderId"] = "36626399";
 * $marketBuyResponse["info"]["clientOrderId"] = "EZF4XZmBIayTpjsOd5HozY";
 * $marketBuyResponse["info"]["transactTime"] = "1522769837375";
 * $marketBuyResponse["info"]["price"] = "0";
 * $marketBuyResponse["info"]["origQty"] = "0.53";
 * $marketBuyResponse["info"]["executedQty"] = "0.53";
 * $marketBuyResponse["info"]["status"] = "FILLED";
 * $marketBuyResponse["info"]["timeInForce"] = "GTC";
 * $marketBuyResponse["info"]["type"] = "MARKET";
 * $marketBuyResponse["info"]["side"] = "BUY";
 * $marketBuyResponse["id"] = 36626399;
 * $marketBuyResponse["timestamp"] = 1522769837375;
 * $marketBuyResponse["datetime"] = 2018-04-03T15:37:17.-705+00:00;
 * $marketBuyResponse["symbol"] = BNB/BTC;
 * $marketBuyResponse["type"] = market;
 * $marketBuyResponse["side"] = buy;
 * * $marketBuyResponse["price"] = 0;
 * $marketBuyResponse["amount"] = 0.53;
 * $marketBuyResponse["cost"] = 0;
 * $marketBuyResponse["filled"] = 0.53;
 * $marketBuyResponse["remaining"] = 0;
 * $marketBuyResponse["status"] = closed;
 * $marketBuyResponse["fee"] = null;
 */


//LIMIT SELL RESPONSE
//$BNBTicker = $exchange->getCurrentPriceInfo($coin);
//$BNBPrice = $BNBTicker["bid"];
//$sellPrice = $BNBPrice * 1.05;
//$balance = $exchange->fetch_open_orders("BNB/BTC");
//$sellPrice = 0.001885;
//$limitSellResponse = $exchange->limit_sell($coin,1, $sellPrice);
//var_dump($limitSellResponse);exit;



/*
 * FETCH ORDER
 *
 * $orderResponse["info"]["symbol"] = "BNBBTC";
 * $orderResponse["info"]["orderId"] = "36644824";
 * $orderResponse["info"]["clientOrderId"] = "8RkR5WUzm76nRmDrzTOKrf";
 * $orderResponse["info"]["transactTime"] = "1522772483181";
 * $orderResponse["info"]["price"] = "0.00280500";
 * $orderResponse["info"]["origQty"] = "0.51000000";
 * $orderResponse["info"]["executedQty"] = "0.000000";
 * $orderResponse["info"]["status"] = "NEW";
 * $orderResponse["info"]["timeInForce"] = "GTC";
 * $orderResponse["info"]["type"] = "LIMIT";
 * $orderResponse["info"]["side"] = "SELL";
 * $orderResponse["id"] = 36644824;
 * $orderResponse["timestamp"] = 1522772483181;
 * $orderResponse["datetime"] = 2018-04-03T15:37:17.-705+00:00;
 * $orderResponse["symbol"] = BNB/BTC;
 * $orderResponse["type"] = limit;
 * $orderResponse["side"] = sell;
 * * $orderResponse["price"] = 0.002805;
 * $orderResponse["amount"] = 0.51;
 * $orderResponse["cost"] = 0;
 * $orderResponse["filled"] = 0.531;
 * $orderResponse["remaining"] = 0;
 * $orderResponse["status"] = open;
 * $orderResponse["fee"] = null;
 */

