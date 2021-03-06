<?php
include 'header.php';
include '../valai.php';
?>
<body class="" style="background-color: #FFFFFF;" onload="hideOther()">
<div class="container-fluid">
    <div class="row" style=" height: 100vh;">
        <div class="col-xl-2 fade-in text-black" style="background-color: #F2F2F2; padding: 0px 0px 0px 0px;">
   <?php
   $curr = 'tickets';
   include 'includenav.php';
   ?> 
</div>

<div class="col-xl-10 fade-in shadow" " id="" style="height: 100vh; padding: 1% 2% 2% 2%; background-color: #fff;">
<?php
if(isset($_POST['submit'])){
    date_default_timezone_set('Asia/Kolkata');
    $date = date('dmYhis', time());
    $date1 = date('d/m/Y h:i:s', time());
    $titl = '';
    if($_POST['titl'] != ''){
        $titl = $_POST['titl'];
    }else{
        $titl = $_POST['ip'];
    }
    khatral::khquery('INSERT INTO ticket VALUES(NULL, :tick_id, :mess, :ip, :group, :wherenm, :unm)', array(
        ':tick_id'=>'valai' . $date,
        ':mess'=>$_POST['des'],
        ':ip'=>$titl,
        ':group'=>$_POST['gro'],
        ':wherenm'=>'admin',
        ':unm'=>$_SESSION['unme']
    ));
    echo 'ticket raised';
}
?>
<!-- <a href="dash.php" class="btn btn-dark">Back</a> -->
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#myModal">
  Create New
</button>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-dark text-white">
        <h4 class="modal-title">Ticket Creation</h4>
        <button type="button" class="close  text-white" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="ticket.php" method="post">
            <div class="form-group">
                <label for="ip">Select IP/Select Other</label>
                <select name="ip" id="ip" class="custom-select" onchange="getSelect()">
                    <?php
                        $ret = khatral::khquery('SELECT * FROM modl WHERE modl_user=:user', array(
                            ':user'=>$_SESSION['unme']
                        ));
                        $me = '';
                        foreach($ret as $p){
                            $me = $p['modl_nm'];
                        }
                        $res = khatral::khquery('SELECT * FROM comp_info WHERE comp_group=:group', array(
                            ':group'=>$me
                        ));
                        foreach($res as $pi){
                            echo '<option>' . $pi['comp_ip'] . '</option>';
                        }
                    ?>
                    <option>Other</option>
                </select>
            </div>
            <div class="form-group" id="otherfl">
                <label for="title">Service Ticket Title</label>
                <input type="text" name="titl" id="titl" class="form-control">
            </div>
            <div class="form-group">
                <label for="message">Service Ticket Description</label>
                <input type="text" name="gro" id="gro" style="display: none;" value="<?php echo $me; ?>">
                <textarea name="des" id="des" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Create and Forward" id="submit" name="submit" class="btn btn-dark">
            </div>
        </form>
      </div>

      <!-- Modal footer -->
      

    </div>
  </div>
</div>
<script>

window.onload = function() {
  document.getElementById('otherfl').style.display = 'none';
};
    function getSelect(){
        var e = document.getElementById("ip");
        var value = e.options[e.selectedIndex].value;
        var text = e.options[e.selectedIndex].text;
        if(text == "Other"){
            // alert('other');
            document.getElementById('otherfl').style.display = 'block';
        }else{
            document.getElementById('otherfl').style.display = 'none';
        }
    }
    
</script>
<table class="table table-bordered" style="margin-top: 2%;">
    <th>Sl.NO</th>
    <th>Ref. No</th>
    <th>IP Address / Title</th>
    <th>Description</th>
    <th>actions</th>
    <?php
        $ret = khatral::khquery('SELECT * FROM ticket WHERE ticket_unm=:unm', array(
            ':unm'=>$_SESSION['unme']
        ));
        $count = 1;
        foreach($ret as $p){
            echo '<tr><td>' . $count . '</td><td>' . $p['ticket_ri_id'] . '</td><td>'. $p['ticket_ip'] . '</td><td>' . $p['ticket_mess'] . '</td><td><a href="viewtick.php?id=' . $p['ticket_ri_id'] . '">View Ticket</a></td></tr>';
            $count += 1;
        }
    ?>
</table>