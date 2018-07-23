<html>
<head></head>
<body>
    <table>
        <tr>
            <td> Signal Id</td>
            <td> Received Date</td>
            <td> Coin</td>
            <td> Buy Value</td>
        </tr>
<?php
include 'dblib.inc.php';

$db = new db_mySQL;
$db->init();

$lastWeekDate = date('Y-m-d',strtotime("-7 days"));

$listOpenSignalSql = "select * from signals where is_processed=0 order by signal_id desc";
$db->query($listOpenSignalSql);
while($row = $db->fetch_assoc()){
    echo '<tr>';
    echo '<td>'.$row["signal_id"].'</td>';
    echo '<td>'.$row["received_date"].'</td>';
    echo '<td>'.$row["coin"].'</td>';
    echo '<td>'.$row["signal_buy_value"].'</td>';
    echo '</tr>';
}

?>
    <table>

</body>

</html>
