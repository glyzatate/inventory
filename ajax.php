<?php
require 'config.php';

if(isset($_POST['action']) && $_POST['action']==='knowledgebase_sort'){
	$sort_array = explode(",", $_POST['sort_array']);
	if( $_POST['type']=='editing' ){
		$tbl = 'editingManual';
		$id = 'em_id';
	}else{
		$tbl = 'knowledgebase';
		$id = 'id';
	}
	if(is_array($sort_array)){
		foreach($sort_array AS $k=>$v){
			$db->updateQuery($tbl, array("level"=>$k+1), $id."=".$v);
		}
		echo "SAVED";
	}
	else{
		echo "Sort Array Error.";
	}
}

if(isset($_POST['action']) && $_POST['action']==='manual_delete'){
	if(!empty($_POST['kb_id'])){
		if( $_POST['type'] == 'knowledgebase' )
			$db->deleteQuery("knowledgebase","id=".$_POST['kb_id']);
		else
			$db->deleteQuery("editingManual","em_id=".$_POST['kb_id']);
		echo "Post Deleted Successfully";
	}
	else{
		echo "No ID selected.";
	}
}
?>