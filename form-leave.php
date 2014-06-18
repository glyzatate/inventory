<?php
//array of additional scripts and css to load on the page
$css = array('jquery.datetimepicker.css', 'colorbox.css');
$script = array('jquery.datetimepicker.js', 'jquery.colorbox-min.js');
require 'config.php';

$username = $_SESSION['u'];
$error = false;
$success = false;
$link = '';
$dir = "uploads/employees/".$username."/";
$typeDB = $db->selectQuery("leaveType","typeName"); 
$type = array('');
foreach($typeDB AS $t=>$val):
	$type[] = $val['typeName'];
endforeach;

$hour = array();
	for( $i=0; $i<24; $i++){
		if( $i<10 )
			$hour[$i] = '0'.$i;
		else
			$hour[$i] = $i;				
	}
	

$img_signature = '';

if( is_dir( $dir.'signature/' ) ){
	$dh  = opendir($dir.'signature/');
	while (false !== ($filename = readdir($dh))) {
		if( $filename != '..' && $filename != '.' )
			$img_signature = $dir.'signature/'.$filename;
	}
}

	
if( !empty( $username ) && !empty( $_POST['staff_id'] ) && !empty( $_POST['date_of_request'] ) && $_POST['leave_type'] != 0 && !empty( $_POST['leave_start'] ) && !empty( $_POST['leave_end'] ) && !empty( $_POST['total_hours'] ) 
){
	$insertArray = array(
		"userID_fk" => $_SESSION['uid'],
		"date_requested" => date('Y-m-d'),
		"leaveType_fk" => $_POST['leave_type'],
		"reason" => addslashes( $_POST['reason'] ),
		"leave_start" => date('Y-m-d h:s', strtotime( $_POST['leave_start'] ) ),
		"leave_end" => date('Y-m-d H:s', strtotime( $_POST['leave_end'] ) ),
		"total_hours" => $_POST['total_hours']
	);
	$id = $db->insertQuery('leaves', $insertArray);
	if( $id ){		
		//create pdf file	
		if (!is_dir($dir.'forms/')){
			mkdir($dir.'forms/');         
		}
	
		ob_end_clean();
		require_once('includes/fpdf/fpdf.php');
		require_once('includes/fpdf/fpdi.php');

		$pdf = new FPDI();
		$pdf->AddPage();
		$pdf->setSourceFile('includes/forms/leave_form.pdf');
		$tplIdx = $pdf->importPage(1);
		$pdf->useTemplate($tplIdx, null, null, 0, 0, true);

		$pdf->SetFont('Arial');
		$pdf->SetFontSize(8);
		$pdf->setTextColor(0, 0, 0);

		$pdf->setXY(108, 65);
		$pdf->Write(0, date('F d, Y') );

		$pdf->setXY(108, 70);
		$pdf->Write(0, $_POST['employee_name'] );

		$pdf->setXY(108, 75);		
		$pdf->Write(0, $type[$_POST['leave_type']] );

		$pdf->setXY(107, 78);
		if( strlen( $_POST['reason'] ) < 250 )
			$pdf->SetFontSize(8);
		else
			$pdf->SetFontSize(5);
		$pdf->MultiCell(80,3,$_POST['reason']);
		
		$pdf->setXY(93, 93);
		$pdf->SetFontSize(8);
		$pdf->Write(0, date('F d, Y', strtotime( $_POST['leave_start'] ) ) );

		$pdf->setXY(165, 93);
		$pdf->Write(0, date('h:s a', strtotime( $_POST['leave_start'] ) ) );

		$pdf->setXY(93, 98);
		$pdf->Write(0, date('F d, Y', strtotime( $_POST['leave_end'] ) ) );

		$pdf->setXY(165, 98);
		$pdf->Write(0, date('h:s a', strtotime( $_POST['leave_end'] ) ) );

		if( $_POST['total_hours'] == '0.5' || $_POST['total_hours'] == '.5')
			$tDays = '4 hours';
		else if( $_POST['total_hours'] == '1' )
			$tDays = $_POST['total_hours'].' day';
		else			
			$tDays = $_POST['total_hours'].' days';
		

		$pdf->setXY(110, 102.5);
		$pdf->Write(0, $tDays);

		$pdf->Image($img_signature, 80, 102, 0);

		$pdf->Output($dir."forms/leave_form-".$id.".pdf", "F");
		$success = true;
		$link = $dir."forms/leave_form-".$id.".pdf";
		foreach($_POST as $p){ 
			unset($_POST);
		}	

		//send email and add notification		
		$subject = 'Leave Application of '.$user->getFullName();
		$body = '<p>Hi,</p>
				<p>Your approval is requested for <u>leave application</u> of '.$user->getFullName().'. Click <a href=http://employee.tatepublishing.net/>here</a> to take action on this leave application request.</a></p>
				<p>&nbsp;</p>
				<p>Thanks!</p>
				';
				
		$sup = $user->getAllSupervisors( $user->getSupervisorID(), $user->getUserType() );
		if( count( $sup ) > 0 ){
			foreach( $sup AS $s ):
				sendEmail('helpdesk@tatepublishing.com', $user->getUserField($s['userID'], 'email'), $subject, $body, 'Self Service Auto Email');
				add_notification($s['userID'], 'Your approval is requested for <u>leave application</u> of '.$user->getFullName().'.');		
			endforeach;
		}		
	}else{
		$error = true;
	}
	
}else if( !empty( $_POST ) ){
	$error = true;
} 
	
require 'includes/header.php';

if (isset($_GET['delete_signature'])) {
	unlink($img_signature);
}

  
?>
<style type="text/css">
	form .error{ border:1px solid red !important; }
</style>
        <h1>PAID TIME OFF(PTO) / LEAVE REQUEST FORM</h1>	
		<p>The Paid Time Off (PTO) / Leave Request Form is used by full-time reqular staff in accordance with company policy.  All time off requests require the approval of your immediate supervisor.  Vacation Leaves must be filed two weeks in advance and *Sick Leaves must be filed within 24 hours from returning to work.  For detailed information regarding the administration of paid time off, refer to the Code of Conduct and/or the Employee Handbook.</p>
		<?php if( $error ){ ?><p class="bg-danger">We encountered an error when processing your request.  Please try again.  Thanks.</p><?php } ?>
		<?php if( $success && !empty( $link ) ){ ?><p class="bg-success">Leave submitted succesfully.  <a href="<?= $link ?>" target="_blank">Click here</a> to view the file.</p><?php } ?>		
		<?php if( empty( $img_signature ) ) { ?>
			<p class="bg-danger">No signature on file.  You cannot submit a leave without your signature.  Please <a class="iframe" href="/upload_signature.php">click here</a> to upload.</p>
		<?php } ?>
	</div>
		<?php			
		$form->formStart('', 'POST', 'onSubmit="return validate_form(\''.$img_signature.'\');"');
		$form->setEditable(FALSE);
		$form->text("employee_name",$user->getFullName(),'class="form-control"',"Employee Name:");
		$form->hidden("staff_id",$user->getUID());
		$form->text("date_of_request",date('F d, Y'),'class="form-control"',"");
		$form->setEditable(TRUE);		
		$form->select("leave_type",$_POST['leave_type'],$type,'id="leave_type" class="form-control"',"Type of Leave Requested:","");
		$form->textarea("reason",$_POST['reason'],'id="reason" class="editable form-control" rows="6"',"Please specify reason:<br/><span style='color:#a1a1a1; font-size: 12px;'><i>Note that the approval of this leave request may depend on the reason provided:</i></span>"," ");
		$form->date_picker("leave_start",$_POST['leave_start'],'id="leave_start" class="form-control" readonly="readonly"',"Start of Leave:","Month day, year hour:min");
		$form->date_picker("leave_end",$_POST['leave_end'],'id="leave_end" class="form-control" readonly="readonly"',"End of Leave:","Month day, year hour:min");
		$form->text("total_hours",$_POST['total_hours'],'id="total_hours" class="form-control"',"Total Number of Days:","0.5 for half day or 4 hours, 1 for 1 day");
 		
		if( !empty( $img_signature ) ) { ?>
		<div class="form-group">
			<label class="col-lg-2 control-label" for="signature">Signature</label>
			<div id="img-div" class="col-lg-10">
				<img src="<?php echo $img_signature; ?>" />
			</div>
		<?php
		}
		
		$form->button("submit","Submit","class='btn btn-primary'");
		$form->formEnd();
		
		
require 'includes/footer.php';
?>

<script type="text/javascript">
	//for colorbox
	$(document).ready(function(){
		$(".iframe").colorbox({iframe:true, width:"60%", height:"80%", onClosed:function(){  $('#img-div').css('display','none'); location.reload(); }});
	});

	$('#leave_start').datetimepicker({ format:'F d, Y H:00' });
	$('#leave_end').datetimepicker({ format:'F d, Y H:00' });
	$('.form-control').click(function(){ 
		$(this).css('color','#000');
		$(this).removeClass('error');
	});
	
	function validate_form(signature)
	{
		check = true;
		$('#leave_type').removeClass('error');
		$('#reason').removeClass('error');
		$('#leave_start').removeClass('error');
		$('#leave_end').removeClass('error');
		$('#total_hours').removeClass('error');
		
		if( $('#leave_type').val() == '0' ){
			check = false;
			$('#leave_type').addClass('error');
		}		
		if( $('#reason').val() == '' && $('#type_of_leave').val() != 1 ){
			check = false;
			$('#reason').addClass('error');
		}
		if( $('#leave_start').val() == '' ){
			check = false;
			$('#leave_start').addClass('error');
		}
		if( $('#leave_end').val() == '' ){
			check = false;
			$('#leave_end').addClass('error');
		} 
		if( $('#total_hours').val() == '' ){
			check = false;
			$('#total_hours').addClass('error');
		}else if( $('#total_hours').val()%0.5 != 0 ){
			check = false;
			alert('Total number of days is invalid. Please write total number of days. Ex. "0.5" for half day or 4 hours, "1" for 1 day');	
			$('#total_hours').addClass('error');			
		}
		if( signature == '' ){
			check = false;
			alert('Please upload signature.');
		}
		
		
						
		return check;
	}
	
	
</script>