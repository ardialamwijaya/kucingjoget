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
$closeWeekAgoSignalSql = "update signals set is_processed=0 where channel_id=1268010485 and received_date >'$lastWeekDate' and is_processed=0";
$db->query($closeWeekAgoSignalSql);

$listOpenSignalSql = "select * from signals where channel_id=1268010485 and received_date >'$lastWeekDate' and is_processed=0 order by signal_id desc";
$db->query($listOpenSignalSql);
while($row = $db->fetch_assoc()){
    echo '<tr>';
    echo '<td>'.$row["signal_id"].'</td>';
    echo '<td>'.$row["received_date"].'</td>';
    echo '<td>'.$row["coin"].'</td>';
    echo '<td>'.$row["signal_buy_value"].'</td>';
    echo '</tr>';

    $duplicatedId = $row["signal_id"];
}

?>
    <table>

</body>

</html>
