<?php

	if( isset($_GET['sEcho']) ) {

	$aColumns = array( 'username', 'active', 'password', 'sFirst', 'sLast', 'email'  );
	
	$sIndexColumn = "username";
	
	$sTable = "users";
	
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
			intval( $_GET['iDisplayLength'] );
	}
	
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%". $_GET['sSearch'] ."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".$_GET['sSearch_'.$i]."%' ";
		}
	}
	require 'includes/header.php';

	//$db = new DatabaseConnection();
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
	//$rResult = selectQuery( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$rResult = $db->selectQuery( $sQuery );


	$sQuery = "
		SELECT FOUND_ROWS()
	";
	//$rResultFilterTotal = selectQuery( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
//	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$rResultFilterTotal = $db->selectQuery( $sQuery );
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = $db->selectQuery( $sQuery );
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
				$row[] = $aRow[ $aColumns[$i] ];
			
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
exit();
}

?>


<html>
<head>
<title>Staff Search</title>
<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="style/DT_bootstrap.css">
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/jquery.dataTables.js"></script>
<script src="js/DT_bootstrap.js"></script>
</head>
<body>
<div class="container" style="margin-top: 10px">
	<table class="table-striped table table-bordered" id="example">
		<thead>
			<tr>
				<th>Username</th>
				<th>Active</th>
				<th>Password</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>	
			<tr>
				<td>Usernamei1</td>
				<th>Active</th>
				<td>Password</td>
				<td>Frist Name</td>
				<td>Last Name</td>
				<th>Email</th>
			</tr>
			<tr>
				<td>Username2</td>
				<th>Active</th>
				<td>Password</td>
				<td>Frist Name</td>
				<td>Last Name</td>
				<th>Email</th>
			</tr>
			<tr>
				<td>Username3</td>
				<th>Active</th>
				<td>Password</td>
				<td>Frist Name</td>
				<td>Last Name</td>
				<th>Email</th>
			</tr>
		</tbody>

	</table>
</div>
<script>

$(function() {
         $('#example').dataTable( {
                 "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                 "sPaginationType": "bootstrap",
                 "oLanguage": {
                         "sLengthMenu": "_MENU_ records per page"
                 },
		  "bProcessing": true,
	          "bServerSide": true,
	          "sAjaxSource": "<?php echo pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME); ?>"
         } );
 } );
</script>
</body>
</html>
