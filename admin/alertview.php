<?php
$curr = 'mod';
include '../header.php';
?>
<!-- <a href="dash.php" class="btn btn-dark">Back</a> -->
<?php
    if(isset($_GET['id'])){
        valai::DeleteAlerts($_GET['id']);
        echo 'Alert Dismissed';
    }
?>
<table class="table table-bordered border">
    <tr>
        <th>Sl.No</th>
        <th>Timestamp</th>
        <th>Process Name</th>
        <th>Status</th>
        <th>IP</th>
        <th>Group</th>
        <!-- <th>Actions</th> -->
    </tr>
    <?php
    $ret = khatral::khquerypar('SELECT * FROM alerts');
    $count = 0;
    foreach($ret as $p){
        $count += 1;
        echo '<tr><td>' . $count . '</td><td>' . $p['alert_time'] . '</td><td>' . $p['alert_nm'] . '</td><td>' . $p['alert_mess'] . '</td><td>' . $p['alert_ip'] . '</td><td>' . $p['alert_group'] . '</td></tr>';
    }
    ?>
</table>