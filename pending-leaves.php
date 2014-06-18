<?php 
//array of additional scripts and css to load on the page
$css = array('colorbox.css');
$script = array('jquery.colorbox-min.js');	
require 'includes/header.php';	



function display_table( $result, $type ){
	global $user;
	
	$th = '';
	if( $type != 'supervisor' ){	
		$th = '<th width="200px">Remarks</th>';		
	}
	$display = '<table class="table table-hover table-condensed">
		<thead>
		<tr>
			<th>Requester</th>			
			<th>Department</th>	
			<th>Supervisor/s</th>	
			<th>Type</th>
			<th>From</th>
			<th>To</th>
			<th># of days</th>	
			'.$th.'			
			<th><br/></th>
			<th><br/></th>
		</tr>
		</thead>';
				
		foreach( $result AS $r ):
			$supervisor = '';
			$res_s = $user->getAllSupervisors( $r['supervisor'], $r['userType_fk'] );
						
			$supervisor = '';
			$sup = $user->getAllSupervisors( $r['supervisor'], $r['userType_fk'] );
			foreach( $sup AS $s ):
				$supervisor .= $s['supName'].'<br/>';			
			endforeach;

			if( $supervisor == '') $supervisor = 'None';
			
			
			
			$display .= '<tr>
				<td>'.$r['firstName'].' '.$r['lastName'].'</td>					
				<td>'.$r['deptName'].'</td>	
				<td>'.$supervisor.'</td>	
				<td>'.$r['typeName'].'</td>
				<td>'.date('F d, Y h:s a', strtotime( $r['leave_start'] ) ).'</td>
				<td>'.date('F d, Y h:s a', strtotime( $r['leave_end'] ) ).'</td>
				<td>'.$r['total_hours'].'</td>';
				
			if( $type != 'supervisor' ){	
				$display .= '<td style="font-size:10px;">'.$r['remarks'].'</td>';
			}
				
			
			$display .= '<td><button type="button" class="btn btn-default btn-xs" onclick="visitFile(\''.$r['leave_id'].'\', \''.$r['username'].'\')">View file</button></td>
				<td><button class="iframe btn btn-default btn-xs" href="/leave-edit.php?leaveId='.$r['leave_id'].'&type='.$type.'" type="button">Edit</button></td>
			</tr>';
		endforeach;
	$display .= '</table>';
	return $display;
}
$add_q = '';
if( $user->isSuperAdmin() && isset($_GET['type']) && $_GET['type']=='admin' ){
	$add_q = '';
}else if( $user->getUserType() < 8 && $user->getUserType() >= 3 ){
	$add_q = " AND deptID_fk ={$user->getDeptNum()} AND userID_fk != {$_SESSION['uid']}";
}else if( $user->getUserType() == 2 ){
	$add_q = " AND userType_fk<=5 AND userType_fk > 2";
}


?>
	<h1>Pending Leave Application APPROVALS</h1>
<?php 
	if( $user->isSuperAdmin() || ( $user->getUserType() < 8 && empty($_GET['type']) ) ){
		if( $user->getUserType() < 8 && $user->getUserType() > 5 )
			$add_q .= ' AND supervisor = '.$user->getUID();
			
		$supervisor = $db->selectQuery("leaves","leave_id, userID_fk, date_requested, leave_start, leave_end, typeName, username, firstName, lastName, middleName, total_hours, remarks, dateApproved, leave_credits, userType_fk, supervisor, deptID_fk, deptName","status=0 {$add_q} ORDER BY date_requested DESC", "LEFT JOIN leaveType ON typeKey=leaveType_fk LEFT JOIN leaveStatus ON leaveStatusID=status LEFT JOIN users ON userID = userID_fk LEFT JOIN departments ON deptID=deptID_fk");
	
	
		if( !empty($_GET['type']) )
			echo '<h3>For Immediate Supervisors</h3>';
			
		if(count($supervisor) == 0 ){
			echo 'No leaves submitted.<br/><br/><br/>'; 
		}else{
			echo '<u>'.count( $supervisor ). ' pending approvals.</u>';
			echo display_table( $supervisor, 'supervisor').'<br/><br/>';	
		} 
	}
	
	if( ( $user->isSuperAdmin() || $user->isHRAdmin() ) && isset($_GET['type']) && ( $_GET['type']=='admin' || $_GET['type']=='hr' ) ){ 		
		$hr = $db->selectQuery("leaves","leave_id, userID_fk, date_requested, leave_start, leave_end, typeName, username, firstName, lastName, middleName, total_hours, remarks, dateApproved, leave_credits, userType_fk, supervisor, deptID_fk, deptName","(status=1 OR status=2) AND ( HR_leave_credits_updated=0 OR HR_payrollhero_updated=0 ) ORDER BY date_requested DESC", "LEFT JOIN leaveType ON typeKey=leaveType_fk LEFT JOIN leaveStatus ON leaveStatusID=status LEFT JOIN users ON userID = userID_fk LEFT JOIN departments ON deptID=deptID_fk");
		
		if( $_GET['type']!='hr' || $user->isSuperAdmin() )
			echo '<h3>For Human Resource Department</h3>';
	
		if( count( $hr ) > 0 ){
			echo '<u>'.count( $hr ). ' pending approvals.</u>';
			echo display_table( $hr, 'hr');	
		}else{ 
			echo 'No pending leaves for HR.'; 
		}
		
		echo '<br/><br/>';
	}
	
	if( ( $user->isSuperAdmin() || $user->isFinanceAdmin() ) && isset($_GET['type']) && ( $_GET['type']=='admin' || $_GET['type']=='finance' ) ){
		$finance = $db->selectQuery("leaves","leave_id, userID_fk, date_requested, leave_start, leave_end, typeName, username, firstName, lastName, middleName, total_hours, remarks, dateApproved, leave_credits, userType_fk, supervisor, deptID_fk, deptName","( status=1 OR status=2 ) AND finance_payroll=0 ORDER BY date_requested DESC", "LEFT JOIN leaveType ON typeKey=leaveType_fk LEFT JOIN leaveStatus ON leaveStatusID=status LEFT JOIN users ON userID = userID_fk LEFT JOIN departments ON deptID=deptID_fk");
		
		if( $_GET['type']!='finance' || $user->isSuperAdmin() )
			echo '<h3>For Finance Department</h3>';

		if( count( $finance ) > 0 ){
			echo '<u>'.count( $finance ). ' pending approvals.</u>';
			echo display_table( $finance, 'finance');	
		}else{ 
			echo 'No pending leaves for Finance.'; 
		}
		echo '<br/><br/>';
	}
?>

<?php
require 'includes/footer.php';
?>

<script type="text/javascript">
	//for colorbox
	$(document).ready(function(){
		$(".iframe").colorbox({iframe:true, width:"60%", height:"80%"});
	});
	
	function visitFile(id, username){
		window.open('/uploads/employees/'+username+'/forms/leave_form-'+id+'.pdf');
	}
	
</script>