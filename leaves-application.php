<?php
require 'includes/header.php';	

if(isset($_GET['delete'])){
	$db->updateQuery('leaves', array( 'status' => 4), 'leave_id = '.$_GET['delete']);
}

$username = $_SESSION['u'];
$uid = $_SESSION['uid'];
$approved = $db->selectQuery("leaves","leave_id, date_requested, leave_start, leave_end, status, total_hours, remarks, CONCAT(firstName,' ',lastName) AS approvedBy","userID_fk = $uid AND ( status=1 OR status=2 ) AND HR_leave_credits_updated=1 AND HR_payrollhero_updated=1 AND finance_payroll=1 ORDER BY date_requested DESC", "LEFT JOIN users ON userID=approverUserID_fk");

$pending = $db->selectQuery("leaves","leave_id, date_requested, leave_start, leave_end, status, total_hours, remarks, HR_leave_credits_updated, HR_payrollhero_updated, finance_payroll","userID_fk = $uid AND status<3 AND ( HR_leave_credits_updated=0 OR HR_payrollhero_updated=0 OR finance_payroll=0 ) ORDER BY date_requested DESC");

$disapproved = $db->selectQuery("leaves","leave_id, date_requested, leave_start, leave_end, status, total_hours, remarks, CONCAT(firstName,' ',lastName) AS approvedBy","userID_fk = $uid AND status = 3 ORDER BY date_requested DESC", "LEFT JOIN users ON userID=approverUserID_fk");


$allSup = '';
$sup = $user->getAllSupervisors( $user->getSupervisorID(), $user->getUserType() );
foreach( $sup AS $s ):
	$allSup .= $s['supName'].'<br/>';			
endforeach;

if( $allSup == '') $allSup = 'None';

?>
	<h1>Leaves Application</h1>	
	<div>Your Available Leave Credits: <?= $user->getLeaveCreditsOld(); ?></div>
	
	<div><a href="#">Read our leaves policy here.</a></div>
	<button type="button" class="btn btn-primary" onclick="location.href='/form-leave.php'">Apply for Leave</button>
	<br/><br/>
	
	<?php if( count( $pending ) > 0 ){ ?>	
	<table class="table table-bordered table-hover">
		<thead>
			<tr><th colspan=7>Pending Leave Application</th></tr>		
			<tr>
				<th>From</th>
				<th>To</th>
				<th># of days</th>
				<th>Supervisor/s</th>				
				<th>Status</th>
				<th width="200px">Remarks</th>
				<th><br/></th>
			</tr>
		</thead>
			<?php foreach( $pending AS $p ){ ?>
			<tr <?= $class ?> id="tr_<?= $p['leave_id'] ?>">
				<td><?= date('F d, Y h:s a', strtotime( $p['leave_start'] ) ) ?></td>
				<td><?= date('F d, Y h:s a', strtotime( $p['leave_end'] ) ) ?></td>
				<td><?= $p['total_hours'] ?></td>
				<td><?= $allSup ?></td>				
				<td><?php
					if( $p['status'] == 0 )
						echo 'For supervisors approval';
					else{
						if( $p['HR_leave_credits_updated']==0 || $p['HR_payrollhero_updated']==0 )
							echo 'For HR review<br/>';
						if( $p['finance_payroll']==0 )
							echo 'For Finance review';
					}
				?></td>
				<td style="font-size:10px;"><?= $p['remarks'] ?></td>				
				<td>
					<button type="button" class="btn btn-default btn-xs" onclick="visitFile('<?= $p['leave_id'] ?>', '<?= $username ?>')">View file</button>
					<button type="button" class="btn btn-default btn-xs" onclick="hide_tr('<?= $p['leave_id'] ?>')">Cancel</button>
				</td>
			</tr>
			<?php } ?>
	</table>
	<?php } ?>
	
	
	<?php if( count( $approved ) > 0 ){ ?>	
	<table class="table table-bordered table-hover">
		<thead>
			<tr><th colspan=7>Approved leaves</th></tr>
		
			<tr>
				<th>Approved by</th>
				<th>From</th>
				<th>To</th>
				<th>Paid?</th>
				<th>Leave Credits Used</th>
				<th width="200px">Remarks</th>
				<th><br/></th>
			</tr>
		</thead>
			<?php foreach( $approved AS $a ){ ?>
			<tr>
				<td><?= $a['approvedBy'] ?></td>
				<td><?= date('F d, Y h:s a', strtotime( $a['leave_start'] ) ) ?></td>
				<td><?= date('F d, Y h:s a', strtotime( $a['leave_end'] ) ) ?></td>
				<td><?= ( $a['status']==1 ) ? 'Yes' : 'No' ?></td>
				<td><?= $a['total_hours'] ?></td>
				<td style="font-size:10px;"><?= $a['remarks'] ?></td>
				<td><button type="button" class="btn btn-default btn-xs" onclick="visitFile('<?= $a['leave_id'] ?>', '<?= $username ?>')">View file</button></td>
			</tr>
			<?php } ?>
	</table>
	<?php } ?>
	
	
	
	<?php if( count( $disapproved ) > 0 ){ ?>	
	<table class="table table-bordered table-hover">
		<thead>
			<tr><th colspan=5>Disapproved Leave Application</th></tr>		
			<tr>
				<th>Disapproved by</th>
				<th>From</th>
				<th>To</th>
				<th width="200px">Remarks</th>
				<th><br/></th>
			</tr>
		</thead>
			<?php foreach( $disapproved AS $d ){ ?>
			<tr>
				<td><?= $d['approvedBy'] ?></td>
				<td><?= date('F d, Y h:s a', strtotime( $d['leave_start'] ) ) ?></td>
				<td><?= date('F d, Y h:s a', strtotime( $d['leave_end'] ) ) ?></td>
				<td style="font-size:10px;"><?= stripslashes( $d['remarks'] ) ?></td>
				<td>
					<button type="button" class="btn btn-default btn-xs" onclick="visitFile('<?= $d['leave_id'] ?>', '<?= $username ?>')">View file</button>					
				</td>
			</tr>
			<?php } ?>
	</table>
	<?php } ?>

<?php
require 'includes/footer.php';
?>

<script type="text/javascript">
	function visitFile(id, username){
		window.open('/uploads/employees/'+username+'/forms/leave_form-'+id+'.pdf');
	}
	
	function hide_tr( id ){
		var conf = confirm('Are you sure you want to cancel this leave request?');
		if( conf ){
			$('#tr_'+id).hide();
			location.href="leaves-application.php?delete="+id;
		}
	}
</script>