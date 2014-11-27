<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	<!--<input type="submit" value="Add Cpu" /> <br/><hr>-->
	<h1>Cpu</h1><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width='100px'>Cpu Label</th>
			<th width='100px'>Invoice No.</th>
			<th width='100px'>Cpu Brand</th>
			<th width='100px'>Cpu Model</th>
			<th width='100px'>Cpu Serial</th>
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	<table border="1" width="750px">
		<?php 
			$cpu = $db->selectQuery("cpu","*", "1");			
			foreach( $cpu AS $c ):
				echo '<tr >';			
				$cpuID = $c['cpu_id'];				
		
				$cpuID = $c['cpu_id'];		
				$where = "assign_cpuid = ".$cpuID;
				$fields = "COUNT(assign_id) as total";								
				$details =	$db->selectSingleQueryArray("assignments", $fields , $where);						
				if($details['total'] > 0)
					echo "<td width='100px'><a href='cpudetails.php?id=".$cpuID."' >".$c['cpu_label']."</a></td>";
				else
					echo "<td width='100px'>".$c['cpu_label']."</td>";
				echo "<td width='100px'>".$c['cpu_invoiceno']."</td>";
				echo "<td width='100px'>".$c['cpu_brand']."</td>";
				echo "<td width='100px'>".$c['cpu_model']."</td>";
				echo "<td width='100px'>".$c['cpu_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>

