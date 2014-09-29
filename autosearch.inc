<?php
require_once("classes/staff.inc");
$staffProjectMap = array_change_key_case($staffProjectMap, CASE_LOWER);

if (isset($_POST['submit']) && $_POST['submit'] == "Search") {
  $_POST['formStaff'] = trim($_POST['formStaff']);
  $staff = new Staff();
  $staff->getStaffMember("username = '".$_POST['formStaff']."'", $dbObj);
  $dept = $staff->getAllDepts();
  $deptWhere = " (";
  foreach($dept as $loopKey => $loopValue) {
  	if (array_key_exists($loopKey, $staffProjectMap)) {
  		if($deptWhere != " (") $deptWhere .= " or ";
  		$deptWhere .= $staffProjectMap[$loopKey] ." = ". $loopValue ." ";
  	}
  }
  $deptWhere .= ")";
  if ($deptWhere == " ()") $deptWhere = " 0";
  $result = $dbObj->selectQuery("SELECT projectKey as tableKey, title, concat(first, ' ', last) as author, email, projectType, if (pTypeShowLabel = 'Y', CONCAT(' (',pTypeName,')'), '') as pTypeName, pTypeCompany, pipeName FROM projects inner join pTypeLabels on pTypeKey = projectType inner join pipeStatus on pipeline = pipeKey where". $deptWhere ." ORDER BY last, first, title");
?>

<table border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td align=center class=white><a href="<?= $_SERVER['PHP_SELF'] ?>" class="white">new search</a></td>
    <td align=center class=white>&nbsp;|&nbsp;</td>
    <td align=center class=white><a href="javascript:history.back()" class="white">modify search</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>


<table width=95% border=1 cellspacing=0 cellpadding=4 bordercolor="#000000">
  <tr bgcolor="#ffffff">
    <th>- Author -</th>
    <th>Title</th>
    <th>Pipeline</th>
    <th>E-mail</th>
	</tr>
<?php
    for ($i = 0; $i < $dbObj->getNumberOfRows($result); $i++) {
        $info = $dbObj->selectNextRowAsAssoc($result);

        if ($info['title'] == "") {
            $info['title'] = "none";
        }

       if ($info['pTypeCompany'] == 'tol') {
            $details = "detailsaud.php?key={$info['tableKey']}";
        } else if ($info['pTypeCompany'] == 'tmg') {
            $details = "detailsmusic.php?key={$info['tableKey']}";
        } else {
            $details = "details.php?key={$info['tableKey']}";
        }
?>    
  <tr bgcolor="#ffffff">
    <td><?= $info['author'] ?></td>
		<td><a href=<?=$details?>><?= $info['title'] ?></a></td>
		
        <?php
            print "<td>{$info['pipeName']}</td>";

?>
    <td><a href="mailto:<?= $info['email'] ?>"><?= $info['email'] ?></a></td>
  </tr>

<?php
	
    }
    
    if ($dbObj->getNumberOfRows($result) == 0) {
?>
  <tr bgcolor="#ffffff">
    <td colspan=5 align=center>Your search did not match any projects.</td>
  </tr>
<?php
    
    }

    print "</table><p>\n\n";
    exit();

}
?>

<table width=50% border=0 cellpadding=0 cellspacing=0>
  <tr>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" onSubmit="return checkThisForm();">
    <td width=45% valign=top><table width=100% border=1 cellspacing=0 cellpadding=4 bordercolor="#000000">
      <tr bgcolor=#fffffff">
        <td><table width=100% border=0 cellspacing=5 cellpadding=0>
      <tr>
            <td align=right valign=center><b>Staff Member</b></td>
            <td valign=center>
            	<select name="formStaff">
            		<option value="all">Select Name</option>
            		<?php
            			$staffQuery = $dbObj->selectQuery("select username, concat(sFirst, ' ', sLast) as name from staff where (editorNum > 0 or copyEditorNum > 0 or designerNum > 0 or typesetNum > 0 or artistNum > 0 or producerNum > 0 or musicNum > 0 or videoNum > 0 or musicVideoNum > 0 or websiteNum > 0 or myspaceNum > 0 or facebookNum > 0 or ppcEditorNum > 0 or ppcDesignNum > 0 or caseboundNum > 0 or journalNum > 0 or coloringNum > 0 or 3dNum > 0 or tshirtsNum > 0 or photoNum > 0 or radioNum > 0 or magazineMangNum > 0 or magazineDesgNum > 0 or ebookNum > 0) order by sFirst");
            			while($info = $dbObj->selectNextRowAsAssoc($staffQuery)) {
            				print "<option value='".$info['username']."'>".$info['name']."</option>";
            			}
            		?>
            	</select>
            </td>
          </tr>
		    </table></td>
      </tr>
    </table><p align=right><input type="reset" value="Reset">&nbsp;<input type="submit" name="submit" value="Search"></td>
    </form>
  </tr>
</table><p>

<script>
	function checkThisForm() {
		if(document.getElementsByName("formStaff")[0].value == "all") return false;
		else return true;
	}
</script>
