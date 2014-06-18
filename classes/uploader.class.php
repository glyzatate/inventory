<?php
class uploader{
	
	var $num_file;
	var $upload_dir;
	var $add_label;
	var $start_label;
	var $cancel_label;
	var $file_types;
	var $filename;
	var $imgVersion;
	
	function __construct($dir, $add_label = "Add files...", $start_label = "Start upload", $cancel_label = "Cancel Upload"){
		unset($_SESSION['upload']);
		$this->add_label = $add_label;
		$this->start_label = $start_label;
		$this->cancel_label = $cancel_label;
		$this->set_multiple(TRUE);
		$this->num_file = 0;
		$this->set_upload_dir($dir);		
	}

	function set_file_types($file_types){
		$this->file_types = $file_types;
	}
	
	function set_num_file($num){
		$this->num_file = $num;
	}
	
	function set_multiple($multiple){
		$this->multiple = $multiple;
	}
	
	function set_filename($filename){
		$this->newFileName = $filename;
	}
	
	function set_upload_dir($dir){
		$this->upload_dir = $dir;
		$_SESSION['upload']['upload_dir'] = $dir;
	}
		
	function accept_file_types($file_type=''){
		$this->accept_file_types = $file_type;
	}
	
	function max_number_of_files($num_files=NULL){
		$_SESSION['upload']['max_number_of_files'] = $num_files;
	}
	
	function image_versions($w='', $h='', $dir=''){
		$this->image_dir = $dir;
		$this->image_width = $w;
		$this->image_height = $h;
	}
		
	function uploader_html(){
		$url = HTTP_SERVER;
		$file_types = empty($this->file_types)? "" : "accept='{$this->file_types}'";
		$multiple_files = $this->multiple? "multiple" : "";
?>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<!-- 
<link rel="stylesheet" href="css/uploader_css/bootstrap.min.css">
-->
<link rel="stylesheet" href="css/jquery-ui/jquery.fileupload-ui.css">
<link rel="stylesheet" href="css/jquery-ui/upstyle.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="css/jquery-ui/jquery.fileupload-ui-noscript.css"></noscript>
<style>
/* Hide Angular JS elements before initializing */
.ng-cloak {
    display: none;
}
</style>
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="" method="POST" enctype="multipart/form-data" data-ng-app="micro" data-ng-controller="microFileUploadController" data-file-upload="options" data-ng-class="{'fileupload-processing': processing() || loadingFiles}">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value="<?php echo $url.$this->upload_dir;?>"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">		
				<?php //additional values needed ?>
				<input type="hidden" name="upload-dir" value="<?= $this->upload_dir ?>">
				<input type="hidden" name="newFileName" value="<?= $this->newFileName ?>">
				<input type="hidden" name="accept_file_types" value="<?= $this->accept_file_types ?>">
				<input type="hidden" name="image_dir" value="<?= $this->image_dir ?>">
				<input type="hidden" name="image_width" value="<?= $this->image_width ?>">
				<input type="hidden" name="image_height" value="<?= $this->image_height ?>">
				
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button" ng-class="{disabled: disabled}">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span><?php echo $this->add_label; ?></span>
                    <input type="file" name="files[]" <?php echo $multiple_files." ".$file_types;?> ng-disabled="disabled">
                </span>
                <button id="start_upload_btn" type="button" class="btn btn-primary start" data-ng-click="submit()">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span><?php echo $this->start_label; ?></span>
                </button>
                <button id="cancel_upload_btn" type="button" class="btn btn-warning cancel" data-ng-click="cancel()">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span><?php echo $this->cancel_label; ?></span>
                </button>
                <!-- The loading indicator is shown during file processing -->
                <div class="fileupload-loading"></div>
            </div>
            <!-- The global progress information -->
            <div class="col-lg-5 fade" data-ng-class="{in: active()}">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" data-file-upload-progress="progress()"><div class="progress-bar progress-bar-success" data-ng-style="{width: num + '%'}"></div></div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table class="table table-striped files ng-cloak" style="position:relative;">
            <tr data-ng-repeat="file in queue">
                <td data-ng-switch data-on="!!file.url">
                    <div class="preview" data-ng-switch-when="true">
                        <a data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}" data-gallery><img data-ng-src="{{file.url}}" alt="" width="100"></a>
                    </div>
                    <div class="preview" data-ng-switch-default data-file-upload-preview="file"></div>
                </td>				
                <td>
                    <p class="name" data-ng-switch data-on="!!file.url">
                        <span data-ng-switch-when="true" data-ng-switch data-on="!!file.url">
                            <a data-ng-switch-when="true" data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}" data-gallery>{{file.name}}</a>
                            <a data-ng-switch-default data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}">{{file.name}}</a>
                        </span>
                        <span data-ng-switch-default>{{file.name}}</span>
                    </p>
                    <div data-ng-show="file.error"><span class="label label-danger">Error</span> {{file.error}}</div>
                </td>
				<td width="90" class="copy_clip">
					<input type="hidden" value="{{file.url}}"/>
                    <button class="btn btn-success" type="button" onclick="copyUrl('{{file.url}}');">Get link</button>
                </td>
                <td>
                    <p class="size">{{file.size | formatFileSize}}</p>
                    <div class="progress progress-striped active fade" data-ng-class="{pending: 'in'}[file.$state()]" data-file-upload-progress="file.$progress()"><div class="progress-bar progress-bar-success" data-ng-style="{width: num + '%'}"></div></div>
                </td>				
                <td>
                    <button type="button" class="btn btn-primary start" data-ng-click="file.$submit()" data-ng-hide="!file.$submit">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start</span>
                    </button>
                    <button type="button" class="btn btn-warning cancel" data-ng-click="file.$cancel()" data-ng-hide="!file.$cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                    <button data-ng-controller="FileDestroyController" type="button" class="btn btn-danger destroy" data-ng-click="file.$destroy()" data-ng-hide="!file.$destroy">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                </td>
            </tr>
        </table>
        <div id="dev_output"></div>
    </form>
    
 <script>
	$(document).ready(function(){
	
		$("input[type='file']").change(function(){
			<?php if(!empty($this->num_file) && is_numeric($this->num_file)):?>
			if($('.ng-scope').length > <?php echo $this->num_file*4?>){
				alert("Exceed limit!\n\nDelete\/Cancel existing file to give room of the new file.");
				return FALSE;
				throw "stop execution";
			}
			<?php endif;?>
			
			
		});		
	});	

	function copyUrl(url){
		prompt("Copy the link (CTRL+C)", url);
	}
</script>
<?php if(empty($this->start_label)):?>
<script>
	$("#start_upload_btn").hide();
</script>
<?php endif;?>
<?php if(empty($this->cancel_label)):?>
<script>
	$("#cancel_upload_btn").hide();
</script>
<?php endif;?>
<script src="js/uploader_js/angular.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/uploader_js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/uploader_js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/uploader_js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/uploader_js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/uploader_js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/uploader_js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/uploader_js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/uploader_js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/uploader_js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/uploader_js/jquery.fileupload-validate.js"></script>
<!-- The File Upload Angular JS module -->
<script src="js/uploader_js/jquery.fileupload-angular.js"></script>
<!-- The main application script -->
<script src="js/uploader_js/app.js"></script>
<?php 
	}
	
}