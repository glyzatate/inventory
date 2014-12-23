<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
	
	  $( "#dialog" ).dialog({
      autoOpen: false,
	  height:'auto',
	  width:423,
      show: {
       modal: true,
      buttons: {
        "Delete all items": function() {
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener" ).click(function() {			
      $( "#dialog" ).dialog( "open" );
    });
	
	
	
	
	
	$( "#assignStaffId" ).dialog({ autoOpen: false,
	  height:'auto', width:423, show: {
       modal: true,
      buttons: {
        "Delete all items": function() {
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#assignStaffbutton" ).click(function() {
      $( "#assignStaffId" ).dialog( "open" );
    });
	
	$( "#transferId" ).dialog({ autoOpen: false,
		height:'auto', width:423, show: {
		modal: true,
		buttons: {
			"Delete all items": function() {
				$( this ).dialog( "close" );
			},
			Cancel: function() {
			$( this ).dialog( "close" );
			}
		}	
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#transferbutton" ).click(function() {
      $( "#transferId" ).dialog( "open" );
    });
	
	
	$( "#historyId" ).dialog({ autoOpen: false,
	    height:'auto', width:423, show: {
		modal: true,
		buttons: {
			"Delete all items": function() {
				$( this ).dialog( "close" );
			},
			Cancel: function() {
			$( this ).dialog( "close" );
			}
		}	
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#historybutton" ).click(function() {
      $( "#historyId" ).dialog( "open" );
    });
  });
  </script>

 
 <div id="dialog" title="Edit Item Assignment" style="width: 423px; height: 354px;">
  <form action="" name="updateAssign" method="POST" >
		<table border="0" cellpadding="3" cellspacing="3">		
			<tr>
				<td>
					<label>Table #</label>
				</td>
				<td>
					<?php
						$field = "item_name, inventory_number";
						$addON = "JOIN physical_inventory on inventory_number = ps_id ";
						$where = "ws_id =".$_GET['itemName'];
						$tablename = $db->selectQuery("assigns", $field, $where, $addON);
						$result_array = array();	
						$sizeofCurrent = count($tablename);
						$counterofCurrent = 0;
						for($ctr = $size ; $counterofCurrent < $sizeofCurrent; $counterofCurrent++) {
							$result_array[$tablename[$counterofCurrent]['item_name']] = $tablename[$counterofCurrent]['inventory_number'];
						}
						$tableLabel_where	=" workstation_id =".$_GET['itemName'];
						$tableLabel = $db->selectSingleQuery("workstation", "label" , "workstation_id=".$_GET['itemName'], $add_sql="");
					?>
					<input value="<?php echo $tableLabel;?>" class="selectcss" style="width:100px;" readonly />
				</td>
			</tr>		
			<?php $items = $db->selectQuery("physical_inventory","DISTINCT (item_name) as item", "1");		
						$size = count($items);
						$counter = 0;		
						$alltype ="";						
						for($ctr = $size ; $counter < $size; $counter++) {
							$alltype .= $items[$counter]['item']."|";
							echo "<tr>
										<td width=100px;'>
											<label>".$items[$counter]['item']."</label>
										</td>";												
									$test = $db->selectQuery("physical_inventory","*","item_name like '%".$items[$counter]['item']."%' ");									
								echo "<td>";
									echo '<select name="'.$items[$counter]['item'].'" style="width:200px;" class="selectcss">';			
										echo "<option ></option>";						
										foreach( $test AS $c ){									
										if($result_array[$items[$counter]['item']] == $c['inventory_number'] && isset($result_array[$items[$counter]['item']]))
											$selected = "selected";
										else
											$selected ="";
										echo "<option value=".$c['inventory_number']." $selected >".$c['item_name']."- ".$c['inventory_number']."</option>";							
										}
									echo '</select>';		
								echo "</td>";
							echo "</tr>"; 
			
						}	?>		
			
				<input type="hidden" value="<?php echo $alltype;?>" name="alltypevalue">
				<input type="hidden" value="<?php echo $_GET['itemName'];?>" name="workstationId" id="workstationId">
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Update"></td>								
			</tr>	
		</table>	
	</form>
</div>
   
<div id="assignStaffId" title="Assign To Staff" style="width:423px; height:199px;">
  <form action="" name="" method="POST" >
		<table border="0" cellpadding="3" cellspacing="3" align="center">		
			<tr>
				<td>
					<label>Table #</label>
				</td>
				<td>
					<?php
						$tablename = $db->selectSingleQuery("workstation", "label" , "workstation_id=".$_GET['itemName'], $add_sql="");
					?>
					<input value="<?php echo $tablename;?>" class="selectcss" style="width:100px;" readonly />
				</td>
			</tr>		
			<tr>
				<td>
					<label>Shift</label>
				</td>
				<td>
					<select name="shift" id="shift" style="width:200px; height:35px;">
						<option></option>
						<option value="morning">Morning</option>
						<option value="night">Night</option>
					</select>
				</td>
			</tr>		
			<tr>
				<td>
					<label>Staff</label>
				</td>
				<td>					
					<?php 
						$staff = $db->selectQuery("staff","*", "1 ORDER BY sLast");			
						echo '<select name="user_id" style="width:200px; height:35px;">';
						echo "<option ></option>";
						foreach( $staff AS $c ):						
							echo "<option value=".$c['uid'].">".$c['sLast']." ".$c['sFirst']."</option>";													
						endforeach;
						echo '</select>';				
					?>			
				</td>
			</tr>		
			<tr>	
				<td></td>
				<td><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:200px; height:30px;" value="Assign To Staff"></td>		
					
			</tr>	
		</table>	
	</form>
</div>

<div id="transferId" title="Transfer Set" style="width: 423px; height: 354px;">
  <form action="" name="" method="POST" >
		<table border="0" cellpadding="3" cellspacing="3">		
			<tr>
				<td>
					<label>Table #</label>
				</td>
				<td>
					<?php
						$tablename = $db->selectSingleQuery("workstation", "label" , "workstation_id=".$_GET['itemName'], $add_sql="");
					?>
					<input value="<?php echo $tablename;?>" class="selectcss" style="width:100px;" readonly />
				</td>
			</tr>	
			<tr>
				<td>
					<label>List of Workstation</label>
				</td>
				<td>					
					<?php 
						$staff = $db->selectQuery("workstation","*", "1 ORDER BY label asc");			
						echo '<select name="table_id" style="width:200px; height:35px;">';
						echo "<option ></option>";
						foreach( $staff AS $c ):						
							echo "<option value=".$c['workstation_id'].">".$c['label']."</option>";													
						endforeach;
						echo '</select>';				
					?>			
				</td>
			</tr>								
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Transfer"></td>								
			</tr>	
		</table>	
	</form>
</div>

<div id="historyId" title="History" style="width: 423px; height: 354px;">
  <form action="" name="" method="POST" >
		<table border="0" cellpadding="3" cellspacing="3">		
			<tr>
				<td>
					<label>Table #</label>
				</td>
				<td>
					<?php
						$tablename = $db->selectSingleQuery("workstation", "label" , "workstation_id=".$_GET['itemName'], $add_sql="");
					?>
					<input value="<?php echo $tablename;?>" class="selectcss" style="width:100px;" readonly />
				</td>
			</tr>								
		</table>	
	</form>
</div>
