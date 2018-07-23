<html>
<head></head>
<body>
    <table>
        <tr>
            <td> BUY signal Id</td>
            <td> BUY Date</td>
            <td> Coin</td>
            <td> BUY Value</td>
        </tr>
<?php
include 'dblib.inc.php';

$db = new db_mySQL;
$db->init();

$listBoughtSignal = "select * from buy_trx order by id desc";
$db->query($listBoughtSignal);
while($row = $db->fetch_assoc()){
    echo '<tr>';
    echo '<td>'.$row["signal_id"].'</td>';
    echo '<td>'.$row["settled_date"].'</td>';
    echo '<td>'.$row["coin"].'</td>';
    echo '<td>'.$row["buy_price"].'</td>';
    echo '</tr>';
}

?>
    <table>

</body>

</html>
