<?php 	
require 'includes/header.php';	

if(isset($_GET['delete'])){
	$db->updateQuery('leaves', array( 'status' => 4), 'leave_id = '.$_GET['delete']);
}

$username = $_SESSION['u'];
$uid = $_SESSION['uid'];

$addquery = '';

$result = $db->selectQuery("leaves","leave_id, date_requested, leave_start, leave_end, total_hours, status, typeName, leaveStatusName,firstName, lastName, middleName","status!=4 ORDER BY date_requested DESC", "LEFT JOIN leaveType ON typeKey=leaveType_fk LEFT JOIN leaveStatus ON leaveStatusID=status LEFT JOIN users ON userID = userID_fk");
?>
	<h1>Leave Requests</h1>	
	<?php if(count($result) == 0 ){ echo 'No leaves yet.<br/><br/>'; }else{	?>
	<table class="table table-hover table-condensed">
		<thead>
		<tr>
			<th>Name</th>
			<th>Date Filed</th>
			<th>Leave Type</th>
			<th>Leave Start</th>
			<th>Leave End</th>
			<th>Total Number of Hours/days</th>
			<th>Status</th>
			<th><br/></th>
		</tr>
		</thead>
		<?php foreach( $result as $r ): 
			$class = '';
			if( $r['status'] == 1 ) $class = ' class="success"';
			else if( $r['status'] == 2 ) $class = ' class="danger"';
			
		?>
		<tr <?= $class ?> id="tr_<?= $r['leave_id'] ?>">
			<td><?= $r['firstName'].' '.$r['middleName'].' '.$r['lastName'] ?></td>
			<td><?= date('F d, Y', strtotime( $r['date_requested'] ) ) ?></td>
			<td><?= $r['typeName'] ?></td>
			<td><?= date('F d, Y h:s a', strtotime( $r['leave_start'] ) ) ?></td>
			<td><?= date('F d, Y h:s a', strtotime( $r['leave_end'] ) ) ?></td>
			<td><?= $r['total_hours'] ?></td>
			<td><?= $r['leaveStatusName'] ?></td>
			<td><a target="_blank" href="<?= '/uploads/employees/'.$username.'/forms/leave_form-'.$r['leave_id'] ?>.pdf">View</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php } ?>

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