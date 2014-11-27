<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
	
	  $( "#dialog" ).dialog({
      autoOpen: false,
	  height:390,
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
	  height:390, width:423, show: {
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
		height:390, width:423, show: {
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
		height:390, width:423, show: {
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
										echo "<option value=".$c['inventory_number']." >".$c['label']."</option>";							
										}
									echo '</select>';		
								echo "</td>";
							echo "</tr>"; 
			
					}
			
			?>
				<input type="hidden" value="<?php echo $alltype;?>" name="alltypevalue">
				<input type="hidden" value="<?php echo $_GET['itemName'];?>" name="itemName" id="itemName">
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Update"></td>								
			</tr>	
		</table>	
	</form>
</div>
   
<div id="assignStaffId" title="Assign To Staff" style="width: 423px; height: 354px;">
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
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Update"></td>								
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
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Update"></td>								
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
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Update"></td>								
			</tr>	
		</table>	
	</form>
</div>
