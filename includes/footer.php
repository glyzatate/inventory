    </div><?php //end of page-wrapper ?>
    </div><?php //end of wrapper ?>
    
	<?php
		//this is for additional scripts on the page
		if( isset( $script ) ){
			foreach( $script AS $sc ):
				echo '<script type="text/javascript" src="js/'.$sc.'"></script>';
			endforeach;		
		}	
	?>


  </body>
</html>
