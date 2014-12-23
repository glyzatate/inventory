<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p id="topmenu">Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>

<style type="text/css">
.tablename {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-webkit-border-top-left-radius:6px;
	-moz-border-radius-topleft:6px;
	border-top-left-radius:6px;
	-webkit-border-top-right-radius:6px;
	-moz-border-radius-topright:6px;
	border-top-right-radius:6px;
	-webkit-border-bottom-right-radius:6px;
	-moz-border-radius-bottomright:6px;
	border-bottom-right-radius:6px;
	-webkit-border-bottom-left-radius:6px;
	-moz-border-radius-bottomleft:6px;
	border-bottom-left-radius:6px;
	text-indent:0;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#777777;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:50px;
	line-height:50px;
	width:60px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #ffffff;
}
.tablename:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.tablename:active {
	position:relative;
	top:1px;
}


#submenu ul {
	display:none;
	 list-style: none;
	 border:0px solid red;
	 position:absolute;		
	
}

#submenu li {
	 border:0px solid red;	
	 width:100px;
	 list-style: none;
	 display: inline-block;
	 
}

#submenu li:hover > ul {
	border:0px solid red;
	display: inline-block;
	position:absolute;  	
    // background-color:#000000;
	margin-left:90px; 
	margin-top:-40px;
	
	 background: #dfdfdf;
  background-image: -webkit-linear-gradient(top, #dfdfdf, #dfdfdf);
  background-image: -moz-linear-gradient(top, #dfdfdf, #dfdfdf);
  background-image: -ms-linear-gradient(top, #dfdfdf, #dfdfdf);
  background-image: -o-linear-gradient(top, #dfdfdf, #dfdfdf);
  background-image: linear-gradient(to bottom, #dfdfdf, #dfdfdf);
  -webkit-border-radius: 3;
  -moz-border-radius: 3;
  border-radius: 3px;
  font-family: Arial;
  color: #777777;
  // font-size: 20px;
  // padding: 6px 12px 6px 12px;
  border: solid #dcdcdc 2px;
  text-decoration: none;
	
}

#submenu li ul li {	
	padding: 5px 0px 5px 5px;
	// border:1px solid red;
	position:relative;	
	width:200px;
	margin-left:-40px;
	display: block;
	text-decoration: none;

}

#submenu li ul li a{		
	text-decoration: none;

}

#submenu li ul li:hover {	
	background: #ededed;
	background-image: -webkit-linear-gradient(top, #ededed, #ededed);
	background-image: -moz-linear-gradient(top, #ededed, #ededed);
	background-image: -ms-linear-gradient(top, #ededed, #ededed);
	background-image: -o-linear-gradient(top, #ededed, #ededed);
	background-image: linear-gradient(to bottom, #ededed, #ededed);
	text-decoration: none;
}



</style>	
<script type="text/javascript">
 //for colorbox
 $(document).ready(function(){
  $("#itroomid").colorbox({iframe:true, width:"40%", height:"55%"});
  //$(".note").colorbox({iframe:true, width:"60%", height:"85%"});
 });
</script>

<ul id="submenu">
	 <li class="active"><a href="#">Home</a></li>
	 <li><a href="#">Products</a>
	  <ul>
	   <li><a href="#">Products Sub Menu 1</a></li>
	   <li><a href="#">Products Sub Menu 2</a></li>
	   <li><a href="#">Products Sub Menu 3</a></li>
	   <li><a href="#">Products Sub Menu 4</a></li>
	  </ul>
	 </li>
	 <li><a href="#">Services</a>
	  <ul>
	   <li><a href="#">Services Sub Menu 1</a></li>
	   <li><a href="#">Services Sub Menu 2</a></li>
	   <li><a href="#">Services Sub Menu 3</a></li>
	   <li><a href="#">Services Sub Menu 4</a></li>
	  </ul>
	 </li>
	 <li><a href="#">About</a></li>
	 <li><a href="#">Contact Us</a></li>
</ul>
 
	<!--<ul id="submenu"> 
	<?php 
		$addON = "";
		$where = "location = 'Admin Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<li  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a>
						  
						</li>';
					$ctr = $ctr + 1;					
				}
				
				$counter = $counter + 2;
			}
		?>							
	</ul> -->
		
 
	<h1></h1><hr>	
	<table border="0" width="750px">
		<tr align="center">
			<td ><a href="#adminroom" >Admin Room</a></td>
			<td ><a href="#callroom" >Call Room</a></td>
			<td ><a href="#itroom" >IT Room</a></td>
			<td ><a href="#productionarea" >Production Area</a></td>
			<td ><a href="#wall" >Wall</a></td>			
		</tr>
	</table>
	
	<div id="adminroom"></div>
	<br/><br/>
	<div>
			<h2>Admin Room</h2>   
	</div>
	<!--<table border="0" >		
		<?php 
		$addON = "";
		$where = "location = 'Admin Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				echo '<tr >';			
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<td  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a></td></a></td>';
					$ctr = $ctr + 1;					
				}
				echo '</tr>';				
				$counter = $counter + 2;
			}
		?>															
	</table>	
	  <ul>
		   <li><a href="endorsementday.php?itemName='.$items[$ctr]['workstation_id'].'">Day Shift</a></li>
		   <li><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'">Night Shift</a></li>
	  </ul>		
	-->
	<ul id="submenu">
	<?php 
		$addON = "";
		$where = "location = 'Admin Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<li  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a>
										
						</li>';
					$ctr = $ctr + 1;					
				}
				
				$counter = $counter + 2;
			}
		?>							
	</ul> 
	
	
	<table><br/>
	 <a href="#topmenu" >Back Top Menu</a>
	<div id="callroom"></div>
	<br/><br/>
	<div>
			<h2>Call Room</h2>
	</div>
	<!--<table border="0" >		
		<?php 
		$addON = "";
		$where = "location = 'Call Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				echo '<tr >';			
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<td  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation'].'" class="classname">'.$items[$ctr]['label'].'</a></td></a></td>';
					$ctr = $ctr + 1;					
				}
				echo '</tr>';				
				$counter = $counter + 2;
			}
		?>															
	</table>
	-->
	<ul id="submenu">
	<?php 
		$addON = "";
		$where = "location = 'Call Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<li  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a>
										
						</li>';
					$ctr = $ctr + 1;					
				}
				
				$counter = $counter + 2;
			}
		?>							
	</ul> 
	
	<br/>
	 <a href="#topmenu" >Back Top Menu</a> <br/>
	 
	<div id="itroom"></div><br/><br/>
	<div id="itroom"> <h2>IT Room</h2> </div>
	<!--<table border="0" >		
		<?php 
		$addON = "";
		$where = "location = 'IT Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				echo '<tr >';			
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<td  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a></td></a></td>';
					$ctr = $ctr + 1;					
				}
				echo '</tr>';				
				$counter = $counter + 2;
			}
		?>															
	</table>-->
	<ul id="submenu">
	<?php 
		$addON = "";
		$where = "location = 'IT Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<li  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a>
									
						</li>';
					$ctr = $ctr + 1;					
				}
				
				$counter = $counter + 2;
			}
		?>							
	</ul> 
	<br/>
	 <a href="#topmenu" >Back Top Menu</a>
	 
	<div  name="productionarea" id="productionarea"></div><br/><br/>
	<div><h2>Production Area</h2></div>
	<!--<table border="0" >		
		<?php 
		$addON = "";
		$where = "location = 'Production Area'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				echo '<tr >';			
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<td  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a></td></a></td>';
					$ctr = $ctr + 1;					
				}
				echo '</tr>';				
				$counter = $counter + 2;
			}
		?>															
	</table>-->
	<ul id="submenu">
	<?php 
		$addON = "";
		$where = "location = 'Production Area'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<li  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a>
										
						</li>';
					$ctr = $ctr + 1;					
				}
				
				$counter = $counter + 2;
			}
		?>							
	</ul> 
	<br/>
	 <a href="#topmenu" >Back Top Menu</a>
	 
	<div id="wall"></div><br/><br/>
	<div>
			<h2>Wall</h2>
	</div>
	<!--<table border="0" >
		<tr >
			<td>
				<table border="0" >
					<tr >
						<td ><a href="perassignment.php" class="tablename">W1</a></td>
						<td ><a href="perassignment.php" class="tablename">W2</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W3</a></td>
						<td ><a href="perassignment.php" class="tablename">W4</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W5</a></td>		
						<td ><a href="perassignment.php" class="tablename">W6</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W7</a></td>
						<td ><a href="perassignment.php" class="tablename">W8</a></td>
					</tr>
					<tr>
						<td ><a href="perassignment.php" class="tablename">W9</a></td>						
						<td ><a href="perassignment.php" class="tablename">W10</a></td>						
					</tr>
				</table>	
			</td>
		</tr>
	<table>-->
	<ul id="submenu">
	<?php 
		$addON = "";
		$where = "location = 'Wall";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<li  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a>
						 				
						</li>';
					$ctr = $ctr + 1;					
				}
				
				$counter = $counter + 2;
			}
		?>							
	</ul> 
	<table><br/>
	 <a href="#topmenu" >Back Top Menu</a>
	<div id="callroom"></div>
	<br/><br/>
	<div>
			<h2>Voice Room</h2>
	</div>
	<!--<table border="0" >		
		<?php 
		$addON = "";
		$where = "location = 'Call Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				echo '<tr >';			
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<td  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation'].'" class="classname">'.$items[$ctr]['label'].'</a></td></a></td>';
					$ctr = $ctr + 1;					
				}
				echo '</tr>';				
				$counter = $counter + 2;
			}
		?>															
	</table>-->
	<ul id="submenu">
	<?php 
		$addON = "";
		$where = "location = 'Voice Room'";
		$fields = "*";
		$items = $db->selectQuery("workstation",$fields, $where,$addON);				
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					if(isset($items[$ctr]['label'])) 
						echo '<li  style="padding:5px"><a href="endorsement.php?itemName='.$items[$ctr]['workstation_id'].'" class="classname">'.$items[$ctr]['label'].'</a>
						 				
						</li>';
					$ctr = $ctr + 1;					
				}
				
				$counter = $counter + 2;
			}
		?>							
	</ul> 
	
	<br/>
	 <a href="#topmenu" >Back Top Menu</a>
	
	
	<div align="center">
		
	
<?php }  require "includes/footer.php"; ?>

