<?php 
if(!isset($_GET['id'])){
	header("Location: all-employees.php");
	exit();
}
require 'config.php';

if( isset($_POST['submit']) ){
	$_POST['is_admin'] = '0';
	$_POST['is_HR'] = '0';
	$_POST['is_editing'] = '0';
	$_POST['is_finance'] = '0';
	
	if(isset($_POST['admin']) && $_POST['admin'] == 'on' )
		$_POST['is_admin'] = '1';
	if(isset($_POST['HR']) && $_POST['HR'] == 'on' )
		$_POST['is_HR'] = '1';
	if(isset($_POST['editing']) && $_POST['editing'] == 'on' )
		$_POST['is_editing'] = '1';
	if(isset($_POST['finance']) && $_POST['finance'] == 'on' )
		$_POST['is_finance'] = '1';
	if(isset($_POST['leave_credits']) ){
		$_POST['leave_credits_old'] = $_POST['leave_credits'];
		$ptDb->updateQuery('eData', array('leaveC'=> $_POST['leave_credits']), "u='{$_POST['username']}'");
	}
	unset($_POST['submit']);
	unset($_POST['admin']);
	unset($_POST['HR']);
	unset($_POST['editing']);
	unset($_POST['finance']);
	
	$db->updateQuery('users', $_POST, "userID={$_GET['id']}");
	header("Location: employee.php?id=".$_GET['id']);
	exit;
}

$emp = $db->selectSingleQueryArray('users', 'users.*, deptName, userTypeName', 'userID = "'.$_GET['id'].'"', 'LEFT JOIN departments ON deptID=deptID_fk LEFT JOIN userType ON userType=userType_fk');
$dept = $db->selectQuery('departments', '*');
$uType = $db->selectQuery('userType', '*');
$supervisors = $db->selectQuery('users', 'userID, firstName, lastName, deptName', 'userType_fk < 8 ORDER BY deptID_fk, firstName', 'LEFT JOIN departments ON deptID=deptID_fk');

$editable = 0;
if(isset($_GET['edit']))
	$editable = 1;	
	



require 'includes/header.php';

if( $editable )
	echo '<form method="POST" action="">';
?>
	<a href="all-employees.php"><button class="btn btn-default" type="button"><< Back to all employees</button></a>
	<h1>Employee Details</h1>
	<table class="table">
		<tr>
			<td>Username</td>
			<td>
				<?= $emp['username']; ?>
				<input type="hidden" name="username" value="<?= $emp['username'] ?>"/>
			</td>
		</tr>
		<tr>
			<td>First Name</td>
			<td><?
				if($editable)
					echo '<input type="text" name="firstName" value="'.$emp['firstName'].'" class="form-control"/>';
				else
					echo $emp['firstName'];			
			?></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td><?
				if($editable)
					echo '<input type="text" name="lastName" value="'.$emp['lastName'].'" class="form-control" />';
				else
					echo $emp['lastName'];			
			?></td>
		</tr>
		<tr>
			<td>Middle Name</td>
			<td><?
				if($editable)
					echo '<input type="text" name="middleName" value="'.$emp['middleName'].'" class="form-control" />';
				else
					echo $emp['middleName'];			
			?></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?
				if($editable)
					echo '<input type="text" name="email" value="'.$emp['email'].'" class="form-control" />';
				else
					echo $emp['email'];			
			?></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td><?
				if($editable){
					echo '<select name="gender" class="form-control" >';
					if( $emp['gender']=='M' )
						echo '<option value="M" selected="selected">Male</option>
							<option value="F">Female</option>';
					else
						echo '<option value="M">Male</option>
							<option value="F" selected="selected">Female</option>';
					echo '</select>';
				}else{
					if( $emp['gender']=='M')
						echo 'Male';
					else
						echo 'Female';
				}
			?></td>
		</tr>
		<tr>
			<td>Start Date</td>
			<td><?
				if($editable)
					echo '<input type="text" name="start_date" value="'.$emp['start_date'].'" class="form-control" />';
				else
					echo date( 'F d, Y', strtotime( $emp['start_date'] ) );			
			?></td>
		</tr>
		<tr>
			<td>Available Leave Credits</td>
			<td><?
				if($editable)
					echo '<input type="text" name="leave_credits" value="'.$emp['leave_credits'].'" class="form-control" />';
				else
					echo $emp['leave_credits'];			
			?></td>
		</tr>		
		<tr>
			<td>Title</td>
			<td><?
				if($editable)
					echo '<input type="text" name="title" value="'.$emp['title'].'" class="form-control" />';
				else
					echo $emp['title'];			
			?></td>
		</tr>	
		<tr>
			<td>Department</td>
			<td><?php
				if($editable){
					echo '<select name="deptID_fk" class="form-control">';
						foreach( $dept AS $d):
							echo '<option value="'.$d['deptID'].'"';
							if($d['deptID'] == $emp['deptID_fk'])
								echo ' selected="selected"';
							echo '>'.$d['deptName'].'</option>';
						endforeach;
					echo '</select>
					';
				}else{
					echo $emp['deptName'];
				}
			?></td>
		</tr>
		<tr>
			<td>Supervisor</td>
			<td><?php
				if($editable){
					echo '<select name="supervisor" class="form-control">';
						foreach( $supervisors AS $s):
							echo '<option value="'.$s['userID'].'"';
							if($s['userID'] == $emp['supervisor'])
								echo ' selected="selected"';
							echo '>'.$s['firstName'].' '.$s['lastName'].' - '.$s['deptName'].'</option>';
						endforeach;
					echo '</select>
					';
				}else{
					echo '<a href="employee.php?id='.$emp['supervisor'].'">'.$user->getUserNameByID( $emp['supervisor'] ).'</a>';
				}
			?></td>
		</tr>
		<tr>
			<td>User Type</td>
			<td><?php
				if($editable){
					echo '<select name="userType_fk" class="form-control">';
						foreach( $uType AS $u):
							echo '<option value="'.$u['userType'].'"';
							if($u['userType'] == $emp['userType_fk'])
								echo ' selected="selected"';
							echo '>'.$u['userTypeName'].'</option>';
						endforeach;
					echo '</select>
					';
				}else{
					echo $emp['userTypeName'];
				}
			?></td>
		</tr>
		<tr>
			<td>Access</td>
			<td><?php
				if($editable){ ?>
					<input type="checkbox" name="admin" <?php if($emp['is_admin']){ echo 'checked'; } ?>> Admin <br/>
					<input type="checkbox" name="HR" <?php if($emp['is_HR']){ echo 'checked'; } ?>> HR <br/>
					<input type="checkbox" name="editing" <?php if($emp['is_editing']){ echo 'checked'; } ?>> Editing <br/>
					<input type="checkbox" name="finance" <?php if($emp['is_finance']){ echo 'checked'; } ?>> Finance
				<?php }else{			
					$access = '';
					if( $emp['is_admin'] ) $access .= 'Admin, ';
					if( $emp['is_HR'] ) $access .= 'HR, ';
					if( $emp['is_editing'] ) $access .= 'Editing, ';
					if( $emp['is_finance'] ) $access .= 'Finance';
					if(empty($access)) 
						echo 'None'; 
					else 
						echo rtrim($access, ", ");
				}
			?></td>
		</tr>	
		<tr>
			<td colspan=2>
				<?php if($editable){ ?>
					<button class="btn btn-primary" name="submit" type="submit">Submit</button>
					<a href="employee.php?id=<?= $emp['userID'] ?>"><button class="btn btn-default" type="button">Cancel</button></a>
				<?php }else{ ?>
					<a href="employee.php?id=<?= $emp['userID'] ?>&edit=Y"><button class="btn btn-default" type="button">Edit</button></a>
				<?php } ?>
			</td>
		</tr>
	</table>
	
			
<?php
if( $editable )
	echo '</form>';
	
require 'includes/footer.php';
?>