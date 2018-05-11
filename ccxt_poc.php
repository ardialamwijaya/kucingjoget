<?php
include 'ccxt.php';
include 'ExchangeService.php';
include "myBinance.php";
include "dblib.inc.php";


$arrSettings = array(
    'exchangeName' => 'binance',
    'apiKey' => 'ZDaaBMAEmN2gDitsDcYESXA99QY9OZCeG2qvpyGyflC0BGb5MnqjqhG4MoPumUlN',
    'secret' => 's30A0gl8wPOer6R5P8bOchU9Aqyt10rY09GMyUjq7SCyIjcUGFawNxt3wWKzdM07'
);

$exchange = new ExchangeService($arrSettings);
$exchange->verbose = true;
$balance = $exchange->fetch_balance();
$exchange->limit_trx("buy","ENG/BTC",5, 0.0002);
var_dump ($balance);


?>