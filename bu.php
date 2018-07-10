<html>
<head></head>
<body>
<form method="post">
    <table>
        <tr>
            <td>receh:</td><td><input type="text" name="receh" id="receh" required> </td>
        </tr>
        <tr>
            <td>nilai:</td><td><input type="text" name="nilai" id="nilai" required> </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Submit"></td>
        </tr>
    </table>

</form>

</body>
</html>

<?php
if(isset($_POST["receh"]) && isset($_POST["nilai"])){
    $receh = $_POST["receh"];
    $nilai = $_POST["nilai"];

    include 'dblib.inc.php';

    $db = new db_mySQL;
    $db->init();

    $yesterdayDate = date('Y-m-d',strtotime("-1 days"));
    $checkIsDuplicateProcessedSignal = "select signal_id from signals where channel_id=1268010485 and received_date >='$yesterdayDate' and receh like '%$receh%' order by signal_id desc limit 0,1";
    $db->query($checkIsDuplicateProcessedSignal);
    $duplicatedId = "";
    if($row = $db->fetch_assoc()){
        $duplicatedId = $row["signal_id"];
    }

    if(!$duplicatedId){
        $getLastSignalIdSQL = "select signal_id from signals where channel_id=1268010485 order by signal_id desc limit 0,1";
        $db->query($getLastSignalIdSQL);
        $lastSignalId = 1;
        if($row = $db->fetch_assoc()){
            $lastSignalId = $row["signal_id"];
        }
        $buyPendingSignalSql = "insert into signals(signal_id, channel_id, exchange, coin, received_date, signal_buy_value, signal_sell_value, is_processed, is_rejected ) values 
('".($lastSignalId+1)."', '1268010485', 'BINANCE', '".strtoupper($receh)."', NOW(), '".$nilai."', '".($nilai*1.1)."', 0, 0  )";
        $db->query($buyPendingSignalSql);

        echo $receh." processed";
    }


}