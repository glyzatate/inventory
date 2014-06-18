<?php 
require 'includes/header.php';

$info = $db->selectSingleQueryArray('users', 'users.*, deptName, userTypeName', 'userID = "'.$_SESSION['uid'].'"', 'LEFT JOIN departments ON deptID=deptID_fk LEFT JOIN userType ON userType=userType_fk');
?>
	<h1>My HR Information</h1>	
	<table class="table">
		<tr>
			<td>Name</td>
			<td><?php echo $info['firstName'].' '.$info['middleName'].' '.$info['lastName']; ?></td>
		</tr>
		<tr>
			<td>Position Title</td>
			<td><?= $info['title'] ?></td>
		</tr>
		<tr>
			<td>Hire Date</td>
			<td><?= date('F d, Y', strtotime( $info['start_date']))  ?></td>
		</tr>
		<tr>
			<td>Immediate Supervisor</td>
			<td><?php echo $user->getUserNameByID($info['supervisor']); ?></td>
		</tr>
		<tr>
			<td>Compensation Rate</td>
			<td></td>
		</tr>
		<tr>
			<td>Allowances</td>
			<td></td>
		</tr>
		<tr>
			<td>Birthdate</td>
			<td><?php if( $info['birthday']!= '0000-00-00' ){ echo date('F d, Y', strtotime( $info['birthday'])); } ?></td>
		</tr>
		<tr>
			<td>Current Residence Address</td>
			<td><?= $info['address'] ?></td>
		</tr>
		<tr>
			<td>Permanent Residence</td>
			<td><?= $info['perm_address'] ?></td>
		</tr>
		<tr>
			<td>Contact Number</td>
			<td><?= $info['contact'] ?></td>
		</tr>
	</table>
<?php
require 'includes/footer.php';
?>
