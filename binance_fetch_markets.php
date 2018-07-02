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
$truncateMarketsSql = "truncate markets";
$db->query($truncateMarketsSql);
$exchange = new ExchangeService($arrSettings);
$binanceMarkets = $exchange->fetch_markets();
foreach($binanceMarkets as $binanceMarket){
    $insertMarketSql = "insert into markets (symbol, exchange_id) values ('".$binanceMarket["symbol"]."',1)";
    $db->query($insertMarketSql);
}