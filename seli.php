<html>
<head></head>
<body>
    <table>
        <tr>
            <td> SELL Id</td>
            <td> SELL Date</td>
            <td> Coin</td>
            <td> SELL Value</td>
        </tr>
<?php
include 'dblib.inc.php';

$db = new db_mySQL;
$db->init();

$listSellSignalSql = "select * from sell_trx order by id desc";
$db->query($listSellSignalSql);
while($row = $db->fetch_assoc()){
    echo '<tr>';
    echo '<td>'.$row["signal_id"].'</td>';
    echo '<td>'.$row["settled_date"].'</td>';
    echo '<td>'.$row["coin"].'</td>';
    echo '<td>'.$row["sold_price"].'</td>';
    echo '</tr>';
}

?>
    <table>

</body>

</html>
