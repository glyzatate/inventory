<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';
if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	
	//print_r($user);
	
	$param = $_GET['itemName'];
	?>
<hr>
<h4>List of <?php echo $param;?></h4>	
	
	<table border="1" >
		<tr align="center">
			<th width='200px'>ITEM NAME</th>
			<th width='200px'>LABEL</th>	
			<th width='200px'>ASSIGN TO DAYSHIFT</th>	
			<th width='200px'>ASSIGN TO NIGHT SHIFT</th>	
		</tr>

		<?php 
			echo $_POST['itemName'];
			$fields = "*";
			$where = "item_name like '%".strtolower($param)."%'  ";
			$itemdetails = $db->selectQuery("physical_inventory",$fields,$where);			
			
			foreach( $itemdetails AS $c ):
				echo '<tr >';				
					echo "<td width='100px'><a href='peritemdetails.php?id=".$c['inventory_number']."' >".$c['item_name']."</td>";									
					echo "<td width='100px'>".$c['item_name']."- ".$c['inventory_number']."</td>";
					$staffAssign = $db->selectSingleQueryArray("assigns Left JOIN staff ON uid  = staff_id", "CONCAT(sFirst,' ', sLast) AS name " , "ps_id=".$c['inventory_number'], $add_sql="");
					echo "<td width='100px'>".$staffAssign['name']."</td>";
					$staffAssign = $db->selectSingleQueryArray("assigns Left JOIN staff ON uid  = staff_idN", "CONCAT(sFirst,' ', sLast) AS nameN " , "ps_id=".$c['inventory_number'], $add_sql="");
					echo "<td width='100px'>".$staffAssign['nameN']."</td>";
					// echo "<td width='100px'>".$c['monitor_serial']."</td>";
				echo '</tr>';		
				
			endforeach; 
		?>				
	</table>
	

	
	
<?php }  require "includes/footer.php"; ?>