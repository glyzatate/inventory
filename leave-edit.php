<?php
	require 'config.php'; 
	
	if( $_GET['leaveId'] ){
		$result = $db->selectSingleQueryArray("leaves", "leave_id, userID_fk, status, date_requested, leave_start, leave_end, reason, typeName, username, firstName, lastName, middleName, email, total_hours, remarks, leave_credits, leave_credits_old, approverUserID_fk, HR_leave_credits_updated, HR_payrollhero_updated, finance_payroll", 
		"leave_id = {$_GET['leaveId']}", 
		"LEFT JOIN leaveType ON typeKey=leaveType_fk LEFT JOIN leaveStatus ON leaveStatusID=status LEFT JOIN users ON userID = userID_fk");		
	}else{
		exit;
	}
	
	$dir = "uploads/employees/".$_SESSION['u']."/";	
	$img_signature = '';
	$write_pdf = false;
	
	
	if( is_dir( $dir.'signature/' ) ){
		$dh  = opendir($dir.'signature/');
		while (false !== ($filename = readdir($dh))) {
			if( $filename != '..' && $filename != '.' )
				$img_signature = $dir.'signature/'.$filename;
		}
	}

	
	if( !empty($_POST) ){
		$update_q = array();
		$from = 'helpdesk@tatepublishing.com';
		$fromName = 'Self Service Auto Email';
		//if edited by supervisor
		if( $_GET['type'] == 'supervisor'){		
			$update_q['status'] = $_POST['approval'];	
			$update_q['approverUserID_fk'] = $_POST['approverID'];
			$update_q['dateApproved'] = date('Y-m-d');	
			$update_q['remarks'] = '';
				
			if( $update_q['status'] == 1 )
				$rStat = 'approved WITH pay';				
			else if( $update_q['status'] == 2 )
				$rStat = 'approved WITHOUT pay';				
			else
				$rStat = 'disapproved';
			
			
			$stat = 'Your leave request for '.date('F d, Y', strtotime($result['leave_start'])).' has been '.$rStat.' by '.$user->getFullName().' on '.date('F d, Y');
			
			if( $update_q['status'] != 3 )
				$stat .= ' but still pending for HR and Finance Departments approvals.';
			else
				$stat .= ' for the reason: '.$_POST['remarks'].'. Click <a href=http://employee.tatepublishing.net/leaves-application.php>here</a> to view details of leave application.';
			
			
			$update_q['remarks'] = '<b>'.$user->getFirstName().'</b> ['.date('F d, Y h:s').']: '.$rStat.'<br/>'.$_POST['remarks'].'<br/>';			
			$db->updateQuery('leaves', $update_q, "leave_id={$_GET['leaveId']}"); //update leaves table
			
			//send email and add notification to requester
			$subject = 'Leave Application Status';
			$body = '<p>Hi,</p><p>'.$stat.'</p><p>&nbsp;</p><p>Thanks!</p>';			
			sendEmail($from, $result['email'], $subject, $body, $fromName);
			add_notification($_POST['user_id'],$stat);
			
			if( $update_q['status'] != 3 ){
				$hrstat = 'The leave requested by '.$result['firstName'].' '.$result['lastName'].' has been approved by '.$user->getFullName().' on '.date('F d, Y').'.  Please take action on this leave application request. Click <a href=http://employee.tatepublishing.net/>here</a>.';
				$bodyHRD = '<p>Hi,</p><p>'.$hrstat.'</p><p>&nbsp;</p><p>Thanks!</p>';
				//send email to hrd and accounting
				sendEmail($from, 'hrd@tatepublishing.com', 'Leave Application Status of '.$result['firstName'].' '.$result['lastName'], $bodyHRD, $fromName);
				sendEmail($from, 'cebu-accounting@tatepublishing.com', 'Leave Application Status of '.$result['firstName'].' '.$result['lastName'], $bodyHRD, $fromName);
				//add notifications to HR admins
				$adminHR = $db->selectQuery("users","userID","active=1 AND is_HR=1");
				foreach($adminHR AS $hr):
					add_notification($hr['userID'],$hrstat.'.');
				endforeach;
				
				//add notifications to Finance admins
				$adminFinance = $db->selectQuery("users","userID","active=1 AND is_finance=1");
				foreach($adminFinance AS $f):
					add_notification($f['userID'],$hrstat.'.');
				endforeach;
			}		
			
			$write_pdf = true;		
		}else if( $_GET['type'] == 'hr' ){	//if edited by HR	
			$mstat = '';
			if( $_POST['approval'] != $result['status'] ){
				$update_q['status'] = $_POST['approval'];
				
				if( $update_q['status'] == 1 )
					$mstat = ' edited to approved WITH pay';
				else if( $update_q['status'] == 2 )
					$mstat = ' edited to approved WITHOUT pay';
				else
					$mstat = ' edited to disapproved';
					
				$message = ' leave request for '.date('F d, Y', strtotime($result['leave_start'])).' has been '.$mstat.' by HR '.$user->getFullName().' on '.date('F d, Y').'.';
					
				//send email and add notification to requester
				$subject = 'Leave Application Status';
				$body = '<p>Hi,</p><p>Your '.$message.'</p><p>&nbsp;</p><p>Thanks!</p>';				
				sendEmail($from, $result['email'], $subject, $body, $fromName);
				add_notification($_POST['user_id'],'Your '.$message);

				//send email and notification to approver
				$apEmail = $user->getUserField( $result['approverUserID_fk'], 'email');
				$subject2 = $subject.' of '.$result['firstName'].' '.$result['lastName'];
				$body2 = '<p>Hi,</p><p>The '.$message.'</p><p>&nbsp;</p><p>Thanks!</p>';
				sendEmail($from, $apEmail, $subject2, $body2, $fromName);
				add_notification($result['approverUserID_fk'],'The '.$message);
			}
			
			
			if( isset($_POST['cebu_leave']) && $_POST['cebu_leave'] == 'on' ){
				$update_q['HR_leave_credits_updated'] = 1;
				$mstat .= ' leave credits updated<br/>';
			}
						
			if( isset($_POST['payrollhero']) && $_POST['payrollhero'] == 'on' ){
				$update_q['HR_payrollhero_updated'] = 1;
				$mstat .= ' payrollhero updated<br/>';
			}
			
			if( isset($_POST['cebu_leave']) || isset($_POST['payrollhero']) || !empty($_POST['remarks']) ){		
				$update_q['remarks'] = $result['remarks'].'<b>'.$user->getFirstName().'</b> ['.date('F d, Y h:s').']: '.$mstat.$_POST['remarks'].'<br/>';
				$db->updateQuery('leaves', $update_q, "leave_id={$_GET['leaveId']}"); //update leaves table
				
				if( $_POST['approval'] == $result['status'] ){
					$subject = 'Leave Application Status';
					$body = '<p>Hi,</p><p>Your leave application for '.date('F d, Y', strtotime($result['leave_start'])).' has been updated by HR '.$user->getFullName().'. Click <a href=http://employee.tatepublishing.net/leaves-application.php>here</a> to view leave application details of leave application.</p><p>&nbsp;</p><p>Thanks!</p>';			
					sendEmail($from, $result['email'], $subject, $body, $fromName);
					add_notification($_POST['user_id'],'Your leave application for '.date('F d, Y', strtotime($result['leave_start'])).' has been updated by HR '.$user->getFullName().'.');
				}
				
				if( isset($_POST['cebu_leave']) && $_POST['cebu_leave'] == 'on' ){
					$db->updateQuery('users', array('leave_credits'=> $_POST['leave_num'], 'leave_credits_old'=> $_POST['leave_num']), "userId={$_POST['user_id']}");
					$ptDb->updateQuery('eData', array('leaveC'=> $_POST['leave_num']), "u='{$result['username']}'");
				}
				$write_pdf = true;	
			}			
		}else if( $_GET['type'] == 'finance' ){ //if edited by finance
			if( isset($_POST['payroll']) && $_POST['payroll'] == 'on')
				$update_q['finance_payroll'] = 1;
			
			if( isset($_POST['payroll']) || !empty( $_POST['remarks'] ) ){
				$update_q['remarks'] = $result['remarks'].'<b>'.$user->getFirstName().'</b> ['.date('F d, Y h:s').']: payroll updated<br/>'.$_POST['remarks'].'<br/>';
				$db->updateQuery('leaves', $update_q, "leave_id={$_GET['leaveId']}"); 
				
				$subject = 'Leave Application Status';
				$body = '<p>Hi,</p><p>Your leave application for '.date('F d, Y', strtotime($result['leave_start'])).' has been updated by Finance Department - '.$user->getFullName().'. Click <a href=http://employee.tatepublishing.net/leaves-application.php>here</a> to view details of leave application.</p><p>&nbsp;</p><p>Thanks!</p>';			
				sendEmail($from, $result['email'], $subject, $body, $fromName);
				add_notification($_POST['user_id'],'Your leave application for '.date('F d, Y', strtotime($result['leave_start'])).' has been updated by Finance Department - '.$user->getFullName().'.');
				
				$write_pdf = true;				
			}
		}
		
		
		//if approved all
		if( $_GET['leaveId'] ){
			$check = $db->selectSingleQueryArray("leaves", "status, leave_start, firstName, lastName, email, approverUserID_fk, HR_leave_credits_updated, HR_payrollhero_updated, finance_payroll", 
			"leave_id = {$_GET['leaveId']}", 
			"LEFT JOIN leaveType ON typeKey=leaveType_fk LEFT JOIN leaveStatus ON leaveStatusID=status LEFT JOIN users ON userID = userID_fk");		
		}else{
			exit;
		}
		if( $check['status']==1 && $check['HR_leave_credits_updated']==1 && $check['HR_payrollhero_updated']==1 && $check['finance_payroll']==1){
			//send email and add notification to requester if approved by all
			$subject = 'Leave Application Status';
			$msg = 'leave application for '.date('F d, Y', strtotime($check['leave_start'])).' has been APPROVED by your supervisor, HR and Finance. ';
			$body = '<p>Hi,</p><p>Your '.$msg.' Click <a href=http://employee.tatepublishing.net/leaves-application.php>here</a> to view details of leave application.</p><p>&nbsp;</p><p>Thanks!</p>';			
			sendEmail($from, $check['email'], $subject, $body, $fromName);
			add_notification($_POST['user_id'],'Your '.$msg);
			
			
			//send email and notification to approver/supervisor
			$apEmail = $user->getUserField( $check['approverUserID_fk'], 'email');
			$subject2 = $subject.' of '.$check['firstName'].' '.$check['lastName'];
			$body2 = '<p>Hi,</p><p>'.$check['firstName'].' '.$check['lastName'].'\'s '.$msg.'</p><p>&nbsp;</p><p>Thanks!</p>';
			sendEmail($from, $apEmail, $subject2, $body2, $fromName);
			add_notification($check['approverUserID_fk'],$check['firstName'].' '.$check['lastName'].' '.$msg);
		}
	}
	
	if( $write_pdf ){
		$form_dir = 'uploads/employees/'.$result['username'].'/forms/leave_form-'.$_GET['leaveId'].'.pdf';
		
		ob_end_clean();
		require_once('includes/fpdf/fpdf.php');
		require_once('includes/fpdf/fpdi.php');

		$pdf = new FPDI();
		$pdf->AddPage();
		$pdf->setSourceFile($form_dir);
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx);
		
		if( $_GET['type'] == 'supervisor' ){
			$pdf->SetFontSize(10);
			if($_POST['approval']==1)
				$pdf->setXY(23.5, 141);					
			else if($_POST['approval']==2)
				$pdf->setXY(23.5, 147);
			else
				$pdf->setXY(23.5, 153);
			$pdf->Write(0, 'X' );
						
			$pdf->setXY(140, 170);
			$pdf->Write(0, date('F d, Y'));
			
			$pdf->setXY(23.5, 170);
			$pdf->SetFontSize(8);
			$pdf->Write(0, $_POST['remarks'] );

			$pdf->Image($img_signature, 130, 155, 0);
		}else if( $_GET['type'] == 'hr' ){
			$pdf->SetFontSize(10);
			if( $_POST['approval'] != $result['status'] ){
				if($result['status']==1)
					$pdf->setXY(23.5, 141);					
				else if($result['status']==2)
					$pdf->setXY(23.5, 147);
				else
					$pdf->setXY(23.5, 153);
				$pdf->Write(0, '================== Edited by '.$user->getFirstName().' '.date('F d, Y H:i'));
				
				if($_POST['approval']==1)
					$pdf->setXY(23.5, 141);					
				else if($_POST['approval']==2)
					$pdf->setXY(23.5, 147);
				else
					$pdf->setXY(23.5, 153);
				$pdf->Write(0, 'X' );				
			}	
		
		
			if( isset($_POST['cebu_leave']) && $_POST['cebu_leave'] == 'on' ){
				$pdf->SetFontSize(10);		
				$pdf->setXY(23.5, 190.5);
				$pdf->Write(0, 'X'); //leave
			}
			
			if( isset($_POST['payrollhero']) && $_POST['payrollhero'] == 'on' ){
				$pdf->SetFontSize(10);		
				$pdf->setXY(23.5, 199);
				$pdf->Write(0, 'X'); //payrollhero
			}
							
			$pdf->Image($img_signature, 130, 202, 0); //HR signature
			$pdf->setXY(140, 216);
			$pdf->Write(0, date('F d, Y'));
			
			$pdf->SetFontSize(8);		
			$pdf->setXY(23.5, 213);
			$pdf->Write(0, $_POST['remarks']);
		}else if( $_GET['type'] == 'finance' ){
			if( isset($_POST['payroll']) && $_POST['payroll'] == 'on'){
				$pdf->SetFontSize(10);		
				$pdf->setXY(23.5, 234.5);
				$pdf->Write(0, 'X'); //payroll
			}
			$pdf->Image($img_signature, 130, 239, 0); //Finance signature
			$pdf->setXY(140, 253);
			$pdf->Write(0, date('F d, Y'));
			
			$pdf->SetFontSize(8);		
			$pdf->setXY(23.5, 245);
			$pdf->Write(0, $_POST['remarks']); 
		}
		
		
		$pdf->Output($form_dir, 'F');
		
				
		//echo "<script> parent.$.fn.colorbox.close(); window.location = '{$_SERVER['HTTP_REFERER']}';  </script>";
		echo "<script> parent.$.fn.colorbox.close(); parent.window.location.reload();  </script>";
	}
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Leave application approval</title>   
	<link href="css/bootstrap.css" rel="stylesheet">
	
	<script src="js/jquery-1.10.2.js"></script>	
    <script src="js/bootstrap.js"></script>
	<script src="js/jquery.colorbox-min.js"></script>		
</head>
<body>
<div>
	<h3>Approval</h3>
	<?php
		if( $img_signature == '' ){
			echo 'No signature on file.  Please upload signature before approving any leave requests. <a class="ajax" href="/upload_signature.php">Click here</a> to upload.';
		}else{
			if( $_GET['type'] == 'hr' ){			
			$form->formStart('', 'POST', 'onSubmit="return validate_hr();"');			
			$form->setEditable(TRUE);
		?>
			<div class="form-group">
            	<label class="col-lg-2 control-label" for="radio">Approved by the Manager:</label>
                <div class="col-lg-10">					
					<div class="approv"><input type="radio" value="1" name="approval" <?php if( $result['status']==1 ){ echo 'checked'; } ?>> approved WITH pay</div>
					<div class="approv"><input type="radio" value="2" name="approval" <?php if( $result['status']==2 ){ echo 'checked'; } ?>> approved WITHOUT pay</div>
					<div class="approv"><input type="radio" value="3" name="approval" <?php if( $result['status']==3 ){ echo 'checked'; } ?>> disapproved</div>
				</div>
			</div>
			
			<div class="form-group" style="padding-left:15px;">	
				<?php
					$remaining = $result['leave_credits_old'];
					if( $result['status'] == 1 )
						$remaining = $result['leave_credits_old'] - $result['total_hours'];						
				?>
				<span style="font-size:13px;">
					<b>Leave credits computation:</b><br/>
					Available Leave Credits &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;<?= $result['leave_credits_old']; ?> <br/>
					Total days requested &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;<?= $result['total_hours']; ?><br/>
					Remaining leave credits	&nbsp;- &nbsp;&nbsp;<input type="text" name="leave_num" id="leave_num" value="<?= $remaining; ?>" size="2"> 			
				</span><br/>
				<input type="hidden" id="leave_num_minus" value="<?= $result['leave_credits_old'] - $result['total_hours']; ?>"/>
				<input type="hidden" id="leave_num_old" value="<?= $result['leave_credits_old']; ?>"/>
				<input type="checkbox" name="cebu_leave" id="cebu_leave"/> Remaing leave credits is correct<br/>
				<br/><br/>
				<input type="checkbox" name="payrollhero" id="payrollhero"/> PayrollHero schedule updated<br/><br/>
			
			</div>
		<?php				
			}else if( $_GET['type'] == 'finance' ){
				$form->formStart('', 'POST', '');
				$form->setEditable(TRUE);
		?>			
			<div><input type="checkbox" name="payroll"/> Payroll entries updated<br/><br/>
		<?php			
			}else{
				$form->formStart('', 'POST', 'onSubmit="return validate_form();"');			
				$form->setEditable(TRUE);
		?>
				<div class="form-group">
            	<label class="col-lg-2 control-label" for="radio">Please choose one: <span style="font-size:12px; color:#a1a1a1;">Note: Available leave credit is <?= $result['leave_credits'] ?>.</span></label><br/>
				
                <div class="col-lg-10">					
					<div class="approv"><input type="radio" value="1" name="approval" <?php if( $result['status']==1 ){ echo 'checked'; } ?>> approved WITH pay</div>
					<div class="approv"><input type="radio" value="2" name="approval" <?php if( $result['status']==2 ){ echo 'checked'; } ?>> approved WITHOUT pay</div>
					<div class="approv"><input type="radio" value="3" name="approval" <?php if( $result['status']==3 ){ echo 'checked'; } ?>> disapproved</div>
				</div>
			</div>					
	<?php					
			}
			$form->hidden("user_id",$result['userID_fk']);
			$form->hidden("approverID",$_SESSION['uid']);
			$form->textarea("remarks",$_POST['remarks'],'id="remarks" class="form-control" rows="3"',"Remarks:"," ");	
			$form->button("submit","Submit","class='btn btn-primary'");
			$form->formEnd();
		}
	?>
</div>	
<div style="float:left;">	
	<h3>Details</h3>
	<table class="table table-striped table-bordered">
		<tr>
			<td>Employee Name</td>
			<td><?= $result['firstName'].' '.$result['middleName'].' '.$result['lastName'] ?></td>
		</tr>
		<tr>
			<td>Type of Leave Request</td>
			<td><?= $result['typeName'] ?></td>
		</tr>
		<tr>
			<td>Reason</td>
			<td><?= stripslashes( $result['reason'] ) ?></td>
		</tr>
		<tr>
			<td>Start of Leave</td>
			<td><?= date('F d, Y h:s a', strtotime( $result['leave_start'] ) ) ?></td>
		</tr>
		<tr>
			<td>End of Leave</td>
			<td><?= date('F d, Y h:s a', strtotime( $result['leave_end'] ) ) ?></td>
		</tr>
		<tr>
			<td>Total number of hours/days</td>
			<td><?= $result['total_hours'] ?></td>
		</tr>
		<tr>
			<td>Available leave credits</td>
			<td><?= $result['leave_credits'] ?></td>
		</tr>
	</table>	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[name=approval]').click(function(){ 		
			value = $(this).val();			
			if( value == 1 ){
				$('#leave_num').val($('#leave_num_minus').val());						
			}else{
				$('#leave_num').val($('#leave_num_old').val());			
			}
		});
		
		$('.form-control').click(function(){ 
			$(this).css('color','#000');
			$(this).removeClass('error');
		});
	});
	
	function validate_form(){
		valid = true;
		v = $('input[name=approval]:checked').val();
		
		if( !v ){
			valid = false;
		}else if( v==3 && $('#remarks').val() == '' ){
			$('#remarks').addClass('error');		
			valid = false;
		}	
		
		if( !valid )
			alert("Please fill up the form correctly.");
		return valid;
	}
	
	function validate_hr(){
		valid = true;
		if( !$('#cebu_leave').is(":checked") ){
			valid = false;
		}
		if( !$('#payrollhero').is(":checked") ){
			valid = false;
		}
		
		if(!valid)
			alert('Please tick all the checkboxes.');
		
		return valid;
	}
</script>

</body>
</html>