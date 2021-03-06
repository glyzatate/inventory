<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Drawing Tests</title>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/style.css" />
        <link rel="stylesheet" type="text/css" href="stylesheets/jquery-ui.css" />
        
        <script src="scripts/jquery-1.10.2.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script src="../fieldChooser.js"></script>
        
        <script>
            $(document).ready(function () {
                var $sourceFields = $("#sourceFields");
                var $destinationFields = $("#destinationFields");
                var $chooser = $("#fieldChooser").fieldChooser(sourceFields, destinationFields);
            });
        </script>
    </head>
    <body>
        <div id="fieldChooser" tabIndex="1">
            <div id="sourceFields">
                <div>First name</div>
                <div>Last name</div>
                <div>Home</div>
                <div>Work</div>
                <div>Direct</div>
                <div>Cell</div>
                <div>Fax</div>
                <div>Work email</div>
                <div>Personal email</div>
                <div>Website</div>
				<div><button>test</button></div>
            </div>
			
			<form name="formName" action="" method="post">
				<div id="destinationFields"></div>
			</form>
        </div>
    </body>
</html>