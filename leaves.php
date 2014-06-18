<?php 	
require 'includes/header.php';	

if(isset($_GET['delete'])){
	$db->updateQuery('leaves', array( 'status' => 4), 'leave_id = '.$_GET['delete']);
}

$username = $_SESSION['u'];
$uid = $_SESSION['uid'];
$result = $db->selectQuery("leaves","leave_id, date_requested, status, typeName, leaveStatusName","userID_fk = $uid AND status!=4 ORDER BY date_requested DESC", "LEFT JOIN leaveType ON typeKey=leaveType_fk LEFT JOIN leaveStatus ON leaveStatusID=status");
?>
	<h1>Your Leaves Status</h1>	
	<?php if(count($result) == 0 ){ echo 'No leaves yet.<br/><br/>'; }else{	?>
	<table class="table table-hover table-condensed">
		<thead>
		<tr>
			<th>Date Filed</th>
			<th>Leave Type</th>
			<th>Status</th>
			<th><br/></th>
			<th><br/></th>
		</tr>
		</thead>
		<?php foreach( $result as $r ): 
			$class = '';
			if( $r['status'] == 1 ) $class = ' class="success"';
			else if( $r['status'] == 2 ) $class = ' class="danger"';
			
		?>
		<tr <?= $class ?> id="tr_<?= $r['leave_id'] ?>">
			<td><?= date('F d, Y', strtotime( $r['date_requested'] ) ) ?></td>
			<td><?= $r['typeName'] ?></td>
			<td><?= $r['leaveStatusName'] ?></td>
			<td><a target="_blank" href="<?= '/uploads/employees/'.$username.'/forms/leave_form-'.$r['leave_id'] ?>.pdf">View</a></td>
			<td>
				<?php if( $r['status'] != 0 ){ echo '<br/>'; }else{ ?>
				<button class="btn btn-xs btn-danger" type="button" onclick="hide_tr('<?= $r['leave_id'] ?>');">Cancel</button>
				<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php } ?>
	<button type="button" class="btn btn-primary" onclick="location.href='/leaveform.php'">File a Leave</button>
<?php
require 'includes/footer.php';
?>

<script type="text/javascript">
	function hide_tr( id ){
		var conf = confirm('Are you sure you want to cancel this leave request?');
		if( conf ){
			$('#tr_'+id).hide();
			location.href="leaves.php?delete="+id;
		}
	}
</script>