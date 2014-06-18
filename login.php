<?php 
if($_GET['logout'] == "1"){
	session_start();
	session_destroy();
	unset($_SESSION);
	header("Location: login.php");
	exit();
}

require 'config.php'; 

if(isset($_SESSION['uid'])){
	header("Location: index.php");
	exit();
}

if(isset($_POST['submit'])){	
	$result = $db->selectSingleQueryArray("users", array("userID", "username","password","firstName","lastName"), "username='{$_POST['username']}' AND password='{$_POST['password']}' AND active = 1");
	
	if(is_array($result) && sizeof($result) != 0){
		$_SESSION['uid'] = $result['userID'];
		$_SESSION['u'] = $result['username'];
		header("Location: index.php");
		exit();
	}
	else{
		$result_pt = $ptDb->selectSingleQueryArray("staff", array("uid", "username","password","sFirst","sLast","sMaidenLast","email","dt","sD","title","epos_id", "leaveC", "sup"), "username='{$_POST['username']}' AND password='{$_POST['password']}' AND active = 'Y'", "LEFT JOIN eData ON u=username");
		
		if(is_array($result_pt) && sizeof($result_pt) != 0){
		
			$leave_c = '0.00';	
			if(!empty($result_pt['leaveC'])){
				$leave_c = $result_pt['leaveC'];
			}else if(strtotime($result_pt['sD']) < strtotime('now -90 days')){
				$leave_c = '10.00';
			}
			
			$insertUser = array(
				'username' => $result_pt['username'],
				'password' => $result_pt['password'],
				'firstName' => $result_pt['sFirst'],
				'lastName' => $result_pt['sLast'],
				'middleName' => $result_pt['sMaidenLast'],
				'email' => $result_pt['email'],
				'start_date' => $result_pt['sD'],
				'deptID_fk' => $result_pt['dt'],
				'title' => $result_pt['title'],
				'userType_fk' => $result_pt['epos_id'],
				'supervisor' => $result_pt['sup'],
				'leave_credits' => $leave_c,
				'leave_credits_old' => $leave_c
			);
			
			$_SESSION['uid'] = $db->insertQuery('users', $insertUser);	
			$_SESSION['u'] = $result_pt['username'];
			
			header("Location: index.php");
			exit();
		}else{
			$error['username'] = "Username or Password is invalid.";
			$error['password'] = "Please try again.";
		}		
	}
}
require 'includes/header.php';
echo get_error();
$form->formStart("","POST",'style="width: 300px;"');
$form->text("username","",'class="form-control"',"","PT Username");
$form->password("password","",'class="form-control"',"","Password");
$form->button("submit","Login","class='btn btn-primary'","class='col-lg-10 col-lg-offset-2'");
$form->formEnd();
require 'includes/footer.php';
?>