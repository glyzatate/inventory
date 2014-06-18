<ul class="nav navbar-nav side-nav">
	<li><a href="http://tatepublishing.net/pt"><i class="fa fa-road"></i> PT Page</a></li>
	<?php if( is_login() ){ ?>
	<li <?php if($current_page === "index") echo "class='active'";?>><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
	<li <?php if($current_page === "my-hr-info") echo "class='active'";?>><a href="my-hr-info.php"><i class="fa fa-home"></i> My HR Information</a></li>
	<li <?php if($current_page === "forms") echo "class='active'";?>><a href="forms.php"><i class="fa fa-book"></i> Forms</a></li>
	<li <?php if($current_page === "leaves-application") echo "class='active'";?>><a href="leaves-application.php"><i class="fa fa-calendar"></i> Leaves Application</a></li>
	
	<!--<li <?php //if($current_page === "dashboard") echo "class='active'";?>><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>	-->
	
	<?php if($user->getUserType() < 8 ){ ?>
	<li <?php if($current_page == "managers" || ($current_page == 'pending-leaves' && !isset($_GET['type']) )) echo "class='active'";?>><a href="managers.php"><i class="fa fa-cog"></i> Manager's Panel</a></li><?php } ?>
	
	<?php if($user->isHRAdmin()){ ?>
		<li <?php if($current_page == "hrpanel"  || ($current_page=='pending-leaves' && isset($_GET['type']) && $_GET['type']=='hr')) echo "class='active'";?>><a href="hrpanel.php"><i class="fa fa-icon-certificate"></i> For HR Personnel</a></li>
	<?php } ?>	
	
	<?php if($user->isFinanceAdmin()){ ?>
		<li <?php if($current_page == "finance" || ($current_page=='pending-leaves' && isset($_GET['type']) && $_GET['type']=='finance')) echo "class='active'";?>><a href="finance.php"><i class="fa fa-cog"></i> Finance Panel</a></li>
	<?php } ?>
	
	<?php if($user->isSuperAdmin()){ ?>
	<li <?php if($current_page == "admin" || ($current_page=='pending-leaves' && isset($_GET['type']) && $_GET['type']=='admin' ) ) echo "class='active'";?>><a href="admin.php"><i class="fa fa-cog"></i> Admin Panel</a></li>
	<li <?php if($current_page == "settings") echo "class='active'";?>><a href="settings.php"><i class="fa fa-wrench"></i> Settings</a></li>
	<?php } ?>
	
	<li class="dropdown <?php if( $current_page == 'knowledgebase' || ( $current_page == 'editor' && !isset($_GET['type']) ) ){ echo ' active'; } ?>">
		<a id="sidebar_knowledgebase" class="dropdown-toggle hand" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Knowledge Base <b class="caret"></b>
		<?php if( $user->isSuperAdmin() OR $user->isHRAdmin() ){ ?>
			&nbsp;&nbsp;&nbsp;<span style="font-size:11px; text-decoration:underline;" onClick="window.location.href = 'http://employee.tatepublishing.net/editor.php'">Edit</span>
		<?php } ?>
		</a>
		<ul class="dropdown-menu">
		<?php 
			//0-HR only; 1-all cebu staff; 2-all US staff; 3-all staff
			$condition = '';
			if(!$user->isSuperAdmin() && !$user->isHRAdmin()){
				$condition .= 'AND ( visibleTo = 3';
				if( $user->getLocation()=='US')
					$condition .= ' OR visibleTo = 2';
				if( $user->getLocation()=='PH')
					$condition .= ' OR visibleTo = 1';				
				if( $user->getDeptNum() == 13 )
					$condition .= ' OR visibleTo = 0';
				$condition .= ')';
			}
		
			$manuals = $db->selectQuery('knowledgebase', 'id, title', 'active=1 '.$condition.' ORDER BY level');	
			foreach( $manuals AS $e ):
				$active = ($current_page == "knowledgebase" && $_GET['id'] == $id)?"class='active'":'';				
				echo '<a name="'.$e['id'].'"></a>
					<li '.$active.'>
						<a title="'.$e['title'].'" href="knowledgebase.php?id='.$e['id'].'">'.$e['title'].'</a>
					</li>';
			endforeach;			
		?>
		</ul>
	</li>
	
	<li class="dropdown<?php if( $current_page=='editingManual' || ( $current_page=='editor' && isset($_GET['type']) && $_GET['type']=='editing') ){ echo ' active'; } ?>">
		<a id="sidebar_editing" class="dropdown-toggle hand" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Editing Manual <b class="caret"></b>
		<?php if( $user->isSuperAdmin() OR $user->isEditingAdmin() ){ ?>
		&nbsp;&nbsp;&nbsp;<span style="font-size:11px; text-decoration:underline;" onClick="window.location.href = 'http://employee.tatepublishing.net/editing.php'">Edit</span>
		<?php } ?>
		</a>
		<ul class="dropdown-menu">
		<?php 
			$editing = $db->selectQuery('editingCategory', 'catID, catName', 'parentID=0');	
			foreach( $editing AS $e ):
				$active = ($current_page == "editing" && $_GET['id'] == $id)?"class='active'":'';				
				echo '<a name="'.$e['catID'].'"></a>
					<li '.$active.'>
						<a title="'.$e['catName'].'" href="editingManual.php?id='.$e['catID'].'">'.$e['catName'].'</a>
					</li>';
			endforeach;			
		?>
		</ul>
	</li>
	<?php } ?>
</ul>