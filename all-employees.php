<?php 
$css = array('DT_bootstrap.css');	
$script = array('jquery.dataTables.js', 'DT_bootstrap.js');	
require 'includes/header.php';

$query = $db->selectQuery('users', 'userID, username, firstName, lastName, middleName, email, gender, supervisor, title, start_date, leave_credits, deptName, userTypeName', 'active=1 ', 'LEFT JOIN departments ON deptID=deptID_fk LEFT JOIN userType ON userType=userType_fk');

?>
	<h1>All Employees</h1>
	<table id="employeestbl" class="table table-striped table-hover table-condensed table-bordered" style="font-size:12px">
		<thead>
			<tr class="header">
				<th>Username</td>
				<th>Name</td>
				<th>Email</td>								
				<th>Supervisor</td>
				<th>Department</td>
				<th>Title</td>
				<th>Type</td>						
				<th>Start Date</td>
				<th>Leave Credits</td>
				<th><br/></td>
			</tr>
		</thead>	
		<?php		
			foreach( $query AS $q ):
			echo '<tr>
				<td>'.$q['username'].'</td>
				<td>'.$q['lastName'].', '.$q['firstName'].' '.$q['middleName'].'</td>
				<td>'.$q['email'].'</td>				
				<td>'.$user->getUserNameByID( $q['supervisor'] ).'</td>
				<td>'.$q['deptName'].'</td>
				<td>'.$q['title'].'</td>
				<td>'.$q['userTypeName'].'</td>
				<td>'.$q['start_date'].'</td>
				<td>'.$q['leave_credits'].'</td>
				<td><a href="employee.php?id='.$q['userID'].'"><button type="button" class="btn btn-default btn-xs">View</button></a></td>
			</tr>';
		endforeach;
		?>
	</table>
			
<?php
require 'includes/footer.php';
?>

<script type="text/javascript">	
	$(document).ready(function() {
		// Setup - add a text input to each footer cell
		$('#employeestbl tfoot th').each( function () {
			var title = $('#employeestbl thead th').eq( $(this).index() ).text();
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		} );
	 
		// DataTable
		var table = $('#employeestbl').DataTable();
		 
		// Apply the filter
		$("#employeestbl tfoot input").on( 'keyup change', function () {
			table
				.column( $(this).parent().index()+':visible' )
				.search( this.value )
				.draw();
		} );
	} );
</script>