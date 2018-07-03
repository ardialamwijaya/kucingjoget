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


$getPendingSignalSql = "select pst.*,bt.buy_price from pending_sell_trx pst inner join buy_trx bt on pst.signal_id=bt.signal_id where pst.is_pending = 1";
$db->query($getPendingSignalSql);
while($row = $db->fetch_assoc()){
    $buyPrice = $row["buy_price"];
    $coin = $row["coin"];
    $ticker = $exchange->getTicker($coin);
    $currentPrice = $ticker["ask"];
    if($currentPrice >=($buyPrice * 1.03) ) {
        $closePendingSellTrxSql = "update pending_sell_trx set is_pending = 0, target_price = $buyPrice";
    }
    $sleep = rand(5,15);
    sleep($sleep);
}