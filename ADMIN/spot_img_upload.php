<?php
require_once('../Connections/divdb.php');
if(isset($_POST['img_sub']) && $_POST['img_sub']== 'img_sub_val')
{
	$simg=$conn->prepare("select * from hotspots_pro where hotspot_id=?");
	$simg->execute(array($_GET['hid']));
	$row_simg =$simg->fetch(PDO::FETCH_ASSOC);
	
	
	$str='';
	$cnt=0;
	for($vv=1;$vv<=$_POST['cun'];$vv++)
	{
		$file=$_FILES["img_up".$vv]["name"];
		if(isset($file) && $file!='')
		{
			$cnt=1;
	 $FileType = pathinfo($file,PATHINFO_EXTENSION);
  $profile=$_GET['hid'].'-'.$file;
$target_file='../img_upload/hot_spots/'.$profile;
move_uploaded_file($_FILES["img_up".$vv]["tmp_name"], $target_file);

			if($str=='')
			{
				$str=$profile;
			}else{
				$str=$str.','.$profile;
			}
		}
		
	}
	
	if($cnt==1)
	{
	if(trim($row_simg['spot_images'])!='')
	{
		$newfil=$row_simg['spot_images'].','.$str;
	}else{
		$newfil=$str;
	}
	
	$upd=$conn->prepare("update hotspots_pro set spot_images=? where hotspot_id=?");
	$upd->execute(array($newfil,$_GET['hid']));
		}
	echo "<script>parent.location.reload();jQuery.fancybox.close();</script>";
	
}

?>



<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" >
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>


	
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />




<!-- BEGIN GLOBAL MANDATORY STYLES -->
	
<link href="../img_upload/global1/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="../img_upload/global1/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="../img_upload/global1/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="../img_upload/global1/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="../img_upload/global1/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="../img_upload/global1/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet"/>
<link href="../img_upload/global1/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
<link href="../img_upload/global1/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="../img_upload/global1/css/components.css" rel="stylesheet" type="text/css"/>
<link href="../img_upload/global1/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="../img_upload/admin1/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<!--<link id="style_color" href="../../assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>-->
<link href="../img_upload/admin1/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<!--<link rel="shortcut icon" href="file:///C|/wamp/www/Helpdesk/Client/System/favicon.ico"/>-->
</head>

<body >
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-file-excel-o"></i> Upload file</h3>
							  </div>
							  <div class="panel-body">
								<div class="row"> 
				<div class="col-md-12" >
                <div align="left">
                 <h4 align="center"><strong>Instructions!</strong></h4>
                                 <p class="text-muted text-justify" align="left" style="color:#434A54; ">
                                <i class="fa fa-star"></i> Please Note that the allowed Image file format for upload is  <strong class="text-danger">*.jpg (Joint Photographic Experts Group) and *.png (Portable Network Graphics) only.</strong>
                                 </p>
                                 </div>
                                 <form method="post" name="img_up_form" enctype="multipart/form-data">
                                 <div class="col-sm-12" id="parent_img1" style="margin-top:20px;">
                                 <div class="col-sm-2">Add Image 1</div>
                                 <div class="col-sm-6">
                                 <input class="btn btn-default" type="file" name="img_up1" id="img_up1">
                                 </div>
                                 <div class="col-sm-2"><a id="par_plus" class="btn btn-default" onClick="load_images(1)"><i class="fa fa-plus"></i></a></div> <div class="col-sm-2"></div>
                                 </div>
                                 <input type="hidden" name="cun" id="cun" value="1">
                                 <div class="col-sm-12" align="center" style="margin-top:20px;"><button class="btn btn-success" type="submit" name="img_sub" value="img_sub_val">Submit</button></div>
                                 </form>
                                 <?php /*?><div align="center">
                                 <hr>
					
					<form id="fileupload" action="../img_upload/uploads/" method="POST" enctype="multipart/form-data">
						
						<div class="row fileupload-buttonbar">
							<div class="col-lg-7">
								<!-- The fileinput-button span is used to style the file input field as button -->
								<span class="btn green fileinput-button">
								<i class="fa fa-plus"></i>
								<span>
								Add files... </span>
								<input type="file" name="files[]" multiple>
								</span>
								<button type="submit" class="btn blue start">
								<i class="fa fa-upload"></i>
								<span>
								Start upload </span>
								</button>
								<button type="reset" class="btn warning cancel">
								<i class="fa fa-ban-circle"></i>
								<span>
								Cancel upload </span>
								</button>
								<button type="button" class="btn red delete">
								<i class="fa fa-trash"></i>
								<span>
								Delete </span>
								</button>
                                <input type="hidden" name="hid" id="hid" value="<?php echo $_GET['hid']; ?>">
								<input type="checkbox" class="toggle">
								<!-- The global file processing state -->
								<span class="fileupload-process">
								</span>
							</div>
							<!-- The global progress information -->
							<div class="col-lg-5 fileupload-progress fade">
								<!-- The global progress bar -->
								<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
									<div class="progress-bar progress-bar-success" style="width:0%;">
									</div>
								</div>
								<!-- The extended global progress information -->
								<div class="progress-extended">
									 &nbsp;
								</div>
							</div>
						</div>
						<!-- The table listing the files available for upload/download -->
						<table role="presentation" class="table table-striped clearfix">
						<tbody class="files">
						</tbody>
						</table>
					</form>
                    
					  
				</div><?php */?>
			</div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>

<script>
var no1;
function load_images(no)
{
	no1=parseInt(no)+1;
	$('#cun').val(parseInt($('#cun').val())+1);
	
  var new_img="<div class='col-sm-12' id='parent_img"+no1+"' style='margin-top:20px;'><div class='col-sm-2'>Add Image "+no1+"</div><div class='col-sm-6'><input type='file'  class='btn btn-default' name='img_up"+no1+"' id='img_up"+no1+"'></div><div class='col-sm-2'><a class='btn btn-default' onClick='rem_load_images("+no1+")' style='display:none;'><i class='fa fa-minus'></i></a></div><div class='col-sm-2'></div></div>";	
  
  $('#par_plus').removeAttr('onclick').attr('onclick','load_images('+no1+')');
  $(new_img).insertAfter('#parent_img'+no);
}

function rem_load_images(no)
{
	$('#parent_img'+no).remove();
}
</script>


<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger label label-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn blue start" disabled>
                    <i class="fa fa-upload"></i>
                    <span >Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn red cancel">
                    <i class="fa fa-ban"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
                <td>
                    <span class="preview">
                        {% if (file.thumbnailUrl) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                        {% } %}
                    </span>
                </td>
                <td>
                    <p class="name">
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                        {% } else { %}
                            <span>{%=file.name%}</span>
                        {% } %}
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </td>
                <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                </td>
                <td>
                    {% if (file.deleteUrl) { %}
                        <button class="btn red delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="fa fa-trash-o"></i>
                            <span>Delete</span>
                        </button>
                        <input type="checkbox" name="delete" value="1" class="toggle">
                    {% } else { %}
                        <button class="btn yellow cancel btn-sm">
                            <i class="fa fa-ban"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
    </script>


<script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->

<script src="../img_upload/global1/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="../img_upload/global1/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../img_upload/global1/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../img_upload/global1/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="../img_upload/global1/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="../img_upload/global1/plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
<script src="../img_upload/global1/plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
<script src="../img_upload/global1/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="../img_upload/global1/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>

<script src="../img_upload/global1/scripts/metronic.js" type="text/javascript"></script>
<script src="../img_upload/admin1/layout/scripts/layout.js" type="text/javascript"></script>
<script src="../img_upload/admin1/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script>
        jQuery(document).ready(function() {
        // initiate layout and plugins
        Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init() // init quick sidebar
       
	   
	   var fileName = "";

// On file add assigning the name of that file to the variable to pass to the web service
$('#fileupload').bind('fileuploadadd', function (e, data) {
  $.each(data.files, function (index, file) {
    fileName = file.name;
	//alert(fileName);
	
  });
});

/*$('#fileupload').bind('fileuploadsubmit', function (e, data) {
  data.formData = {"file" : fileName};
  alert(fileName)
});
*/
  
             // Initialize the jQuery File Upload widget:
            $('#fileupload').fileupload({
				//url: '../../assets/global/plugins/jquery-file-upload/',
                disableImageResize: false,
                autoUpload: false,
                disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
                maxFileSize: 500000000,
                acceptFileTypes: /(\.|\/)(jpg|jpe?g|png)$/i,	  
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},                
            });

            // Load & display existing files:
            $('#fileupload').addClass('fileupload-processing');
            $.ajax({
				
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                dataType: 'json',
                context: $('#fileupload')[0]
            }).always(function () {
				 
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
            });
   
   
     });



/*function start_upload()
{
alert('ddd'+$('#hid').val());
var spot=$('#hid').val();	
$.get("ADMIN/ajax_hotel?type=11&sid="+spot, function (result){
				$('#default_table').empty().html(result);
							 $('.datepick').datepicker();
        });
}*/
    </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>