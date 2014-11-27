<style type="text/css">
.classname {
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
	height:64px;
	line-height:64px;
	width:90px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #ffffff;
}
.classname:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.classname:active {
	position:relative;
	top:1px;
}</style>

<ul class="nav navbar-nav side-nav">
<li>
<div style="padding:10px">


<table cellspacing="100" border="0">
	<tr >
		<td  style="padding:5px"><a href="index.php" class="classname"><img src="img/home.png" style="width:50px; height:50px;" /></a></td>
		<td  style="padding:5px"><a href="addinventory2.php" class="classname"><img src="img/settings.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr >
		<td  style="padding:5px"><a href="endorse.php" class="classname"><img src="img/seatplan.png" style="width:50px; height:50px;" /></a></td>
		<td  style="padding:5px"><a href="keyboard.php" class="classname"><img src="img/plus.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr >
		<td  style="padding:5px"><a href="mouse.php" class="classname"><img src="img/mouse.png" style="width:50px; height:50px;" /></a></td>
		<td  style="padding:5px"><a href="keyboard.php" class="classname"><img src="img/keyboard.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<?php 
			$items = $db->selectQuery("physical_inventory","DISTINCT (item_name) as item", "1");			
			$size = count($items);
			$counter = 0;						
			while($counter < $size ) {
				echo '<tr >';			
				$ctr = $counter ;
				$two = $counter + 2;
				while($ctr < $two) {
					echo '<td  style="padding:5px"><a href="detailspage.php?itemName='.$items[$ctr]['item'].'" class="classname">'.$items[$ctr]['item'].'</a></td></a></td>';
					$ctr = $ctr + 1;
				}
				echo '</tr>';				
				$counter = $counter + 2;
			}
		?>				
		
</table>


<!--
<table cellspacing="100" border="0">
	<tr >
		<td  style="padding:5px"><a href="index.php" class="classname"><img src="img/home.png" style="width:50px; height:50px;" /></a></td>
		<td  style="padding:5px"><a href="#" class="classname"><img src="img/settings.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr>
		<td style="padding:5px"><a href="addinventory.php" class="classname"><img src="img/compset.png" style="width:50px; height:50px;" /></a></td></a></td>
		<td style="padding:5px"><a href="perassignment.php" class="classname"><img title="Add per Table" src="img/plus.png" style="width:50px; height:50px;" /></a></td></a></td>		
	</tr>
	<tr>		
		<td style="padding:5px"><a href="assignment2.php" class="classname"><img src="img/history.png" style="width:50px; height:50px;" /></a></td></a></td>		
		<td style="padding:5px"><a href="listofemployee.php" class="classname"><img src="img/staff.png" style="width:50px; height:50px;" /></a></td></a></td>		
	</tr>
	<tr>	
		<td style="padding:5px"><a href="#" class="classname"><img title="Add by Invoice" src="img/laptop.png" style="width:50px; height:50px;" /></a></td></a></td>		
		<td style="padding:5px"><a href="#" class="classname"><img src="img/mac.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr >
		<td  style="padding:5px"><a href="mouse.php" class="classname"><img src="img/mouse.png" style="width:50px; height:50px;" /></a></td>
		<td  style="padding:5px"><a href="keyboard.php" class="classname"><img src="img/keyboard.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr>
		<td style="padding:5px"><a href="monitor.php" class="classname"><img src="img/monitor.png" style="width:50px; height:50px;" /></a></td></a></td>
		<td style="padding:5px"><a href="cpu.php" class="classname"><img src="img/cpu.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr>
		<td style="padding:5px"><a href="headset.php" class="classname"><img src="img/headset.png" style="width:50px; height:50px;" /></a></td></a></td>
		<td style="padding:5px"><a href="hardphone.php" class="classname"><img src="img/hardphone.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	
	<tr>
		<td style="padding:5px"><a href="tablet.php" class="classname"><img src="img/tablet.png" style="width:50px; height:50px;" /></a></td></a></td>
		<td style="padding:5px"><a href="avr.php" class="classname"><img src="img/avr.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr>
		<td style="padding:5px"><a href="ups.php" class="classname"><img src="img/ups.png" style="width:50px; height:50px;" /></a></td></a></td>
		<td style="padding:5px"><a href="printer.php" class="classname"><img src="img/printer.png" style="width:50px; height:50px;" /></a></td></a></td>
	</tr>
	<tr>		
		<td style="padding:5px"><a href="assignment.php" class="classname"><img src="img/seatplan.png" style="width:50px; height:50px;" /></a></td></a></td>		
		<td style="padding:5px"><a href="listofemployee.php" class="classname"><img src="img/staff.png" style="width:50px; height:50px;" /></a></td></a></td>		
	</tr>
</table>

-->
</div>
</li>
</ul>

	