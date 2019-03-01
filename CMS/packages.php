<?php
$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
 $today=date("d_M_Y_H_i_s");
 $his=date("His");
  
  if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
 if(isset($_POST['pack_sett']) && ($_POST['pack_sett']=="pack_sett_val"))
 {
		 $pack_name=$_POST['pack_name'];
		 $pack_locat=$_POST['pack_locat'];
		 $pack_desc=$_POST['pack_desc'];
		 $pack_categ=trim($_POST['pack_categ']);
		 
		 $pack_imgs=$_FILES['pack_img']['name'];
		 if(trim($pack_imgs)!='')
		 {
		 	$FileType = pathinfo($pack_imgs,PATHINFO_EXTENSION);
  			$profile=$his."_".$pack_imgs;
			$target_file='packages/images/'.$profile;

				if(!move_uploaded_file($_FILES["pack_img"]["tmp_name"], $target_file))
				{
					$pack_imgs="default_img.jpg";
				}else{
					$pack_imgs=$profile;	
				}
		 }else{
			 $pack_imgs="default_img.jpg";
		 }

		 $pack_fils=$_FILES['pack_file']['name'];
		 if(trim($pack_fils)!='')
		 {
		 	$FileType = pathinfo($pack_fils,PATHINFO_EXTENSION);
		 	if($FileType=="pdf" or $FileType=="PDF")
		 	{
  			$profile=$his."_".$pack_fils;
			$target_file='packages/'.$profile;

				if(!move_uploaded_file($_FILES["pack_file"]["tmp_name"], $target_file))
				{
					$pack_fils="-";
				}else{
					$pack_fils=$profile;	
				}
			}else{
				 $pack_fils="-";
			}
		 }else{
			 $pack_fils="-";
		 }

	$insert_pack = sprintf("INSERT dvi_packages(pack_name, pack_location, pack_img, pack_pdf, pack_desc, pack_grp)values(%s,%s,%s,%s,%s,%s)",
            GetSQLValueString($pack_name, "text"),
            GetSQLValueString($pack_locat, "text"),
            GetSQLValueString($pack_imgs, "text"),
            GetSQLValueString($pack_fils, "text"),
            GetSQLValueString($pack_desc, "text"),
            GetSQLValueString($pack_categ, "text"));
   			mysql_select_db($database_divdb, $divdb);
	   		mysql_query($insert_pack, $divdb) or die(mysql_error());

	echo "<script>parent.document.location.href='admin_packages.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(7)."';</script>"; 
}
if(isset($_POST['upd_pack_sett']) && ($_POST['upd_pack_sett']=="upd_pack_sett_val"))
 {
		 $pack_name=trim($_POST['updpack_name']);
		 $pack_locat=trim($_POST['updpack_locat']);
		 $pack_desc=trim($_POST['updpack_desc']);
		 $pack_categ=trim($_POST['updpack_categ']);
		 
		 $pack_imgs=$_FILES['updpack_img']['name'];
		 if(trim($pack_imgs)!='')
		 {
		 	$FileType = pathinfo($pack_imgs,PATHINFO_EXTENSION);
  			$profile=$pack_imgs;
			$target_file='packages/images/'.$profile;

				if(!move_uploaded_file($_FILES["updpack_img"]["tmp_name"], $target_file))
				{
					$pack_imgs="default_img.png";
				}else{
					$pack_imgs=$profile;	
				}
		 }else{
			 $pack_imgs=$_POST['my_img'];
		 }

		 $pack_fils=$_FILES['updpack_file']['name'];
		 if(trim($pack_fils)!='')
		 {
		 	$FileType = pathinfo($pack_fils,PATHINFO_EXTENSION);
		 	if($FileType=="pdf" || $FileType=="PDF")
		 	{
  			$profile=$pack_fils;
			$target_file='packages/'.$profile;

				if(!move_uploaded_file($_FILES["updpack_file"]["tmp_name"], $target_file))
				{
					$pack_fils="-";
				}else{
					$pack_fils=$profile;	
				}
			}else{
				 $pack_fils=$_POST['my_pdf'];
			}
		 }else{
			 $pack_fils=$_POST['my_pdf'];
		 }
		 
	     $update_pack = sprintf("UPDATE dvi_packages set pack_name=%s, pack_location=%s, pack_img=%s, pack_pdf=%s, pack_desc=%s, pack_grp=%s  where sno='".trim($_POST['my_sno'])."'",
            GetSQLValueString($pack_name, "text"),
            GetSQLValueString($pack_locat, "text"),
            GetSQLValueString($pack_imgs, "text"),
            GetSQLValueString($pack_fils, "text"),
            GetSQLValueString($pack_desc, "text"),
            GetSQLValueString($pack_categ, "text"));
        mysql_select_db($database_divdb, $divdb);
        mysql_query($update_pack, $divdb) or die(mysql_error());

	echo "<script>parent.document.location.href='admin_packages.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost1=".md5(6)."';</script>"; 
 }
?>

<style>
.datepicker{z-index:1050 !important;}
.flashit{
	-webkit-animation: flash linear 1s infinite;
	animation: flash linear 1s infinite;
	color: #EF0000;
}
@-webkit-keyframes flash {
	0% { opacity: 1; } 
	50% { opacity: .1; } 
	100% { opacity: 1; }
}
@keyframes flash {
	0% { opacity: 1; } 
	50% { opacity: .1; } 
	100% { opacity: 1; }
}
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 0.4em 0.8em 1.4em !important;
    margin: 0 0 0.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
        margin-bottom: 5px!important;
    }
</style>

<?php 
	
?>
	<div class="container-fluid">
				<!-- Begin page heading -->
				<h1 class="page-heading">Packages<small>&nbsp;Frontend Packages</small></h1>
				<div class="modal fade" id="news_settings" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
										  <div class="modal-dialog">
                    <form name="form_distr_sett" id="form_distr_sett" method="post" enctype="multipart/form-data" onsubmit="return checkk1()">
											<div class="modal-content modal-no-shadow modal-no-border">
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-briefcase"></i>&nbsp;Add - Packages </h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
								<div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="pack_name">Pack Name</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="pack_name" id="pack_name" class="form-control" placeholder="Package Title" />

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="pack_locat">Location Name</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="pack_locat" id="pack_locat" class="form-control" placeholder="Place Name" />
                                        </div>
                                    </div>
                                </div>

<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="pack_name">Pack Category</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <select name="pack_categ" id="pack_categ" class="chosen-select">
                        	<option value="DI">Domestic itineraries</option>
                        	<option value="IN">International itineraries</option>
                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="pack_div1">
                                 <fieldset class="scheduler-border">
    							 <legend class="scheduler-border">Package
    								<button type="button" class="btn btn-info btn-sm btn_splus" onclick="add_pack('1')" id="pack_pulse1" style="padding:0px 1px;">
									<i class=" fa fa-plus"></i>			
									</button> 
									<button type="button" class="btn btn-sm btn-warning btn_splus" id="pack_min1" style="padding:0px 1px;">
										<i class="fa fa-minus"></i>
									</button></legend>
									<div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="Day Title">Days</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="day_name1" id="day_name1" class="form-control" placeholder="Days Title" />
                                        </div>
                                    </div>
                                </div>
									<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="pack_desc">Pack - Short Description</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <textarea name="pack_desc1" id="pack_desc1" style="overflow-y:scroll; height:90px; width:405px; resize:none" maxlength="250"></textarea>
                                        </div>
                                    </div>
                                </div>
							<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="pack_img">Location Img</label>
										<br><small style="color : rgb(240, 9, 9);font-size: 11px;
font-weight: 600;">[ Image file only ]</small>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="file" name="pack_img1" id="pack_img1" class="" placeholder="Img" />
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <input type="hidden" value="1" id="pack_inc" name="pack_inc">
                        <div id="add_pack_multi">
                        </div>
                              <!--   <div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="pack_img">Package File</label>
										<br><small style="color : rgb(240, 9, 9);font-size: 11px;
font-weight: 600;">[ 'PDF' file only ]</small>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="file" name="pack_file" id="pack_file" class="" placeholder="Img" />
                                        </div>
                                    </div>
                                </div> -->
                               
							  </div>
											  </div>
											  <div class="modal-footer">
					<strong id="perr" class="flashit pull-left" style="display:none">* Please Enter All Required Fields</strong>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="pack_sett" name="pack_sett" value="pack_sett_val" class="btn btn-info">Submit</button>
											  </div>
											</div>                                </form>
										  </div>
										</div>
                                        
                                        
                                        <!-- update news -->
                  <div class="modal fade" id="news_updates" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
				  </div>
                                        
                                        <!-- ending update news -->
 
                                        
					<div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
           <a id="edit_id" class="btn btn-info " href="admin_add_packages.php"><i class="fa fa-plus"></i>&nbsp; Add News</a>
								</div>
                                <h3 class="panel-title"><i class="fa fa-briefcase"></i>&nbsp;Frontend Package - Settings</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                    <div class="table-responsive" id="default_table">

<div class="panel with-nav-tabs panel-info panel-square panel-no-border">
						  <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#view_all" data-toggle="tab"><i class="fa  fa-road"></i>&nbsp; Domestic Itin. Packages</a></li>
                                <li><a href="#tr_hot" data-toggle="tab"><i class="fa fa-plane"></i>&nbsp; International itin. Packages</a></li>
							</ul>
						  </div>
							<div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="view_all"><?php 
										mysql_select_db($database_divdb, $divdb);
	$query_packages = "SELECT * FROM dvi_packages where pack_grp='DI' ORDER BY sno ASC";
	$packages = mysql_query($query_packages, $divdb) or die(mysql_error());
	//$row_packages = mysql_fetch_assoc($packages);
	$totalRows_packages = mysql_num_rows($packages);
								 if($totalRows_packages>0)  {
								   ?>
						<table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
								<th width="5%"><center> S.No.</center> </th>
                                <th width="20%" colspan="2"><i class="fa fa-cloud-upload "></i>&nbsp; Package Info </th>
								<th width="30%" ><center><i class="fa fa-calendar-o "></i>&nbsp; Package Description</center></th>
                                <th width="15%" ><center><i class="fa fa-calendar "></i>&nbsp; Image</center></th>
                                <th width="15%" ><center><i class="fa fa-calendar "></i>&nbsp; Package File</center></th>
                                <th width="15%" ><center><i class="fa fa-flag "></i>&nbsp; Action</center></th> 
								</tr>
							</thead>
                            <?php 
							$s=1;
							while($row_packages = mysql_fetch_assoc($packages)){ ?>
							<tr id="<?php echo "tr_".$row_packages['sno']; ?>">
                            <td style="text-align:center"><?php echo $s; ?></td>
                            <td><span style="color: rgb(50, 52, 54);font-weight: 600;"><?php echo $row_packages['pack_name']; ?></span><br>
                            	<span><?php echo $row_packages['pack_location'];  ?></span></td>
                            <td>
                                <!-- <span class="badge badge-info icon-count pull-right tooltips" data-toggle='tooltip' data-original-title='Priority'>
                                        <?php echo $row_packages['pack_prior']; ?>
                                </span> -->
                            </td>
                            <td style="text-align:justifydefault_img">
                            	<?php if(strlen($row_packages['pack_desc'])<150){
                            	echo $row_packages['pack_desc'];
                        	 	}else{ ?>
                        	 	<p data-toggle="tooltip" title="<?php echo substr($row_packages['pack_desc'],150,150000) ?>">
                        	 	<?php 
                        	 	echo substr($row_packages['pack_desc'],1,150).".....";
                        	 	?>
                        	 	</p>
                        	 	<?php } ?>
                            	</td>
                            <td style="text-align:center">
                            	<?php if(strpos($row_packages['pack_img'],'~')){ 
                        	$espd=explode('~',$row_packages['pack_img']);
                        	$img_view = $espd[0];
                        	 } else { 
                        	 	$img_view = $row_packages['pack_img'];
                        	 	?>
                        	<?php } ?>
                            <?php 
							 $FileType = pathinfo($img_view ,PATHINFO_EXTENSION);
							if($FileType=='jpg' || $FileType=='png' || $FileType=='jpeg')
							{?>
					<a class="fancybox" href="packages/images/<?php echo $img_view; ?>">
                        <img src="packages/images/<?php echo $img_view; ?>"  style="width:80px ; height:60px;" alt="<?php echo $img_view; ?>"></a>
							<?php }else{ ?>
							 <img src="packages/images/default_img.jpg"  style="width:80px ; height:60px;" alt="No img">
							<?php } ?>
                          </td>

                          <td style="text-align:center">
                           
			<a target="_blank" href="view_package_pdf.php?pack_id=<?php echo $row_packages['sno']; ?>">
            <img src="packages/images/4.jpg" ></a>
							
                          </td>
                            <td style="text-align:center">
                            <a class="btn btn-sm btn-info"  href="admin_update_packages.php?dvisno=<?php echo $row_packages['sno']; ?>"> <i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-danger" onclick="fun_remove_me('<?php echo $row_packages['sno']; ?>')"> <i class="fa fa-trash-o"></i></a>
                            </td>
                            </tr>
                             <?php $s++; }//while end ?>
                                </table>
                                <?php } else{
									?>
                                    <p style="text-align:center; font-size:16px; color:#900; font-weight:600">No Entry Found .. </p>
                                    <?php
									} ?></div>
										<div class="tab-pane fade" id="tr_hot"><?php 
										mysql_select_db($database_divdb, $divdb);
	$query_packages = "SELECT * FROM dvi_packages where pack_grp='IN' ORDER BY sno ASC";
	$packages = mysql_query($query_packages, $divdb) or die(mysql_error());
	//$row_packages = mysql_fetch_assoc($packages);
	$totalRows_packages = mysql_num_rows($packages);
								 if($totalRows_packages>0)  {
								   ?>
						<table class="table table-striped table-hover datatable-example3" >
							<thead class="the-box dark full">
								<tr>
								<th width="5%"><center> S.No.</center> </th>
                                <th width="20%" colspan="2"><i class="fa fa-cloud-upload "></i>&nbsp; Package Info </th>
								<th width="30%" ><center><i class="fa fa-calendar-o "></i>&nbsp; Package Description</center></th>
                                <th width="15%" ><center><i class="fa fa-calendar "></i>&nbsp; Image</center></th>
                                <th width="15%" ><center><i class="fa fa-calendar "></i>&nbsp; Package File</center></th>
                                <th width="15%" ><center><i class="fa fa-flag "></i>&nbsp; Action</center></th> 
								</tr>
							</thead>
                            <?php 
							$s=1;
							while($row_packages = mysql_fetch_assoc($packages)){ ?>
							<tr id="<?php echo "tr_".$row_packages['sno']; ?>">
                            <td style="text-align:center"><?php echo $s; ?></td>
                            <td><span style="color: rgb(50, 52, 54);font-weight: 600;"><?php echo $row_packages['pack_name']; ?></span><br>
                            	<span><?php echo $row_packages['pack_location']; ?></span></td>
                            <td>
                              
                            </td>
                             <td style="text-align:justifydefault_img">
                            	<?php if(strlen($row_packages['pack_desc'])<150){
                            	echo $row_packages['pack_desc'];
                        	 	}else{ ?>
                        	 	<p data-toggle="tooltip" title="<?php echo substr($row_packages['pack_desc'],150,150000) ?>">
                        	 	<?php 
                        	 	echo substr($row_packages['pack_desc'],1,150).".....";
                        	 	?>
                        	 	</p>
                        	 	<?php } ?>
                            	</td>
                            
                        	
                            <td style="text-align:center">
                            		<?php if(strpos($row_packages['pack_img'],'~')){ 
                        	$espd=explode('~',$row_packages['pack_img']);
                        	$img_view1 = $espd[0];
                        	 } else { 
                        	 	$img_view1 = $row_packages['pack_img'];
                        	 	?>
                        	<?php } ?>
                            <?php 
							 $FileType = pathinfo($img_view1,PATHINFO_EXTENSION);
							if($FileType=='jpg' || $FileType=='png' || $FileType=='jpeg')
							{?>
					<a class="fancybox" href="packages/images/<?php echo $img_view1; ?>">
                        <img src="packages/images/<?php echo $img_view1; ?>"  style="width:80px ; height:60px;" alt="<?php echo $img_view1; ?>"></a>
							<?php }else{ ?>
							 <img src="packages/images/default_img.jpg"  style="width:80px ; height:60px;" alt="No img">
							<?php } ?>
                          </td>

                          <td style="text-align:center">
                           	<a target="_blank" href="view_package_pdf.php?pack_id=<?php echo $row_packages['sno']; ?>">
            				<img src="packages/images/4.jpg" ></a>
							
                          </td>
                            <td style="text-align:center">
                            <a class="btn btn-sm btn-info"  href="admin_update_packages.php?dvisno=<?php echo $row_packages['sno']; ?>"> <i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-danger" onclick="fun_remove_me('<?php echo $row_packages['sno']; ?>')"> <i class="fa fa-trash-o"></i></a>
                            </td>
                            </tr>
                             <?php $s++; }//while end ?>
                                </table>
                                <?php } else{
									?>
                                    <p style="text-align:center; font-size:16px; color:#900; font-weight:600">No Entry Found .. </p>
                                    <?php
									} ?></div>
									</div><!-- /.tab-content -->
								</div><!-- /.panel-body -->
							</div><!-- /.collapse in -->
						</div>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div><!-- /.col-sm-8 -->
                    
					</div><!-- /.row -->
				</div>
                <!-- /.container-fluid -->
<script>

$(document).ready(function(e) {
			$('.chosen-select').chosen({width:'100%'});
			$('.datatable-example').dataTable({"bSort": false });
			$('.datatable-example3').dataTable({"bSort": false });
        });

function fun_dates(vall)
{
	$('.datepickerrr').datepicker();
	if(vall=='limit')
	{
	 	$('#dates').fadeIn();	
	}else{
		$('#dates').fadeOut();
	}
}

function fun_updates(vall)
{
	$('.datepickerrr').datepicker();
	if(vall=='limit')
	{
	 	$('#updates').fadeIn();	
	}else{
		$('#updates').fadeOut();
	}
}



function fun_remove_me(sno)
{
	var t=confirm('Conform to remove? Press " OK "');

	if(t==true)
	{
		$('.loader_ax').fadeIn();
		$.get('login_check.php?ty=6&sno='+sno,function(res){
			$('.loader_ax').hide();
			$('#tr_'+sno).hide();
		});
	}
}

function fun_edit_me(sno)
{
	$('.loader_ax').fadeIn();
	$.get('login_check.php?ty=5&sno='+sno,function(res){
			$('.loader_ax').hide();
			$('#news_updates').empty().html(res);
			$('#news_updates').modal('show');
			$('.chosen-select').chosen({width:'100%'});	});	
}

function check_img(name)
{
	$('#upimg_id').css('opacity','0.4');
	$('#rem_upd_img').val(name);
}

function checkk1()
{
	var pack_name=$('#pack_name').val().trim();
	var pack_locat=$('#pack_locat').val().trim();
	var pack_desc=$('#pack_desc').val().trim();
	var pack_img=$('#pack_img').val().trim();
	var pack_file=$('#pack_file').val().trim();

	$('#perr').hide();
	if(pack_name =="")
	{
		$('#perr').empty().prepend("Package name can't be empty .. ").show();
		$('#pack_name').focus();
		return false;
	}else if(pack_locat =="")
	{
		$('#perr').empty().prepend("Package location can't be empty .. ").show();
		$('#pack_locat').focus();
		return false;
	}else if(pack_desc =="")
	{
		$('#perr').empty().prepend("Package description can't be empty .. ").show();
		$('#pack_desc').focus();
		return false;
	}
	else if(pack_file =="")
	{
		$('#perr').empty().prepend("Package file can't be empty .. ").show();
		$('#pack_file').focus();
		return false;
	}else if(pack_file != ""){
		var validExtensions = ['pdf','PDF']; //array of valid extensions
        var fileName = $('#pack_file').val();
        var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
        if ($.inArray(fileNameExt, validExtensions) == -1){
          	$('#perr').empty().prepend("Invalid file type [ PDF - files only accepted on package files ]").show();
			$('#pack_file').focus();
           return false;
        }else if(pack_img!=""){
        	var validExtensions = ['png','jpg','jpeg']; //array of valid extensions
        	var fileName = $('#pack_img').val();
        	var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
        	if ($.inArray(fileNameExt, validExtensions) == -1){
          	$('#perr').empty().prepend("Invalid file type [ image - files only accepted on location image ]").show();
			$('#pack_img').focus();
           	return false;
        	}else{
        		$('#perr').empty().prepend("Please Wait...").show();
        		return true;
        	}
        }else{
        	$('#perr').empty().prepend("Please Wait...").show();
        	return true;
        }
	}
}


function upd_checkk1()
{
	var pack_name=$('#updpack_name').val().trim();
	var pack_locat=$('#updpack_locat').val().trim();
	var pack_desc=$('#updpack_desc').val().trim();
	var pack_img=$('#updpack_img').val().trim();
	var pack_file=$('#updpack_file').val().trim();

	$('#upd_perr').hide();
	if(pack_name =="")
	{
		$('#upd_perr').empty().prepend("Package name can't be empty .. ").show();
		$('#updpack_name').focus();
		return false;
	}else if(pack_locat =="")
	{
		$('#upd_perr').empty().prepend("Package location can't be empty .. ").show();
		$('#updpack_locat').focus();
		return false;
	}else if(pack_desc =="")
	{
		$('#upd_perr').empty().prepend("Package description can't be empty .. ").show();
		$('#updpack_desc').focus();
		return false;
	}
	else if(pack_file != ""){
		var validExtensions = ['pdf','PDF']; //array of valid extensions
        var fileName = $('#updpack_file').val();
        var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
        if ($.inArray(fileNameExt, validExtensions) == -1){
          	$('#upd_perr').empty().prepend("Invalid file type [ PDF - files only accepted on package files ]").show();
			$('#updpack_file').focus();
           return false;
        }else if(pack_img!=""){
        	var validExtensions = ['png','jpg','jpeg']; //array of valid extensions
        	var fileName = $('#updpack_img').val();
        	var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
        	if ($.inArray(fileNameExt, validExtensions) == -1){
          	$('#upd_perr').empty().prepend("Invalid file type [ image - files only accepted on location image ]").show();
			$('#updpack_img').focus();
           	return false;
        	}else{
        		$('#upd_perr').empty().prepend("Please Wait...").show();
        		return true;
        	}
        }else{
        	$('#upd_perr').empty().prepend("Please Wait...").show();
        	return true;
        }
	}
}
//===================12-08-2016 by junior Developer A Ganeshkumar=============
//===============add _pack====================
 function add_pack(val){

	var coval=val;
	var pack_inc=$("#pack_inc").val();
	var type="1";
	var num_pack_inc=Number(pack_inc)+1;	
	var data_string="&type="+type+"&pack_inc="+num_pack_inc;
	// alert(data_string);
	$.ajax({
		type:"GET",
		data:data_string,
		url:"CMS/ajax_pack_page.php",
		beforeSend: function()
		{
			$('.loader_ax').fadeIn();
		},
		success:function(result)
		{
			//alert(result);
			$("#add_pack_multi").show().append(result);
			$("#pack_inc").val(num_pack_inc);
			$('.loader_ax').hide();
			
			var e=1;
			if(e==1)
			{
			$('#pack_pulse1').hide();
			}

			for(e;e<=coval;e++)
			{
			if($('#pack_div'+e).length>0)
			{
			$('#pack_pulse'+e).hide();
			}
		}
		},
		error:function(error,sts,sh)
		{
			alert(error.responseText)
		}
		});	
	
}

//===============add _pack====================
//===============remove_pack====================

function remove_pack(no){
	//$("#exp_de"+val).remove();
		var totc=$('#pack_inc').val().trim();
		var arr=new Array();
		var a=0,a1,tot,chk=0;
		for(var e=1;e<=totc;e++)
		{	
			if($('#pack_div'+e).length>0)
			{			
				arr[a++]=e;
			}
		}
		tot=a;
		a=(Number(a)-1);
		a1=(Number(a)-1);
		//alert(tot+','+a+','+a1);
		if(totc==no){
			$('#pack_pulse'+arr[a1]).show();
			}else{
			$('#pack_pulse'+arr[a]).show();
		}
		if(tot!=1)
		{
		$('#pack_div'+no).remove();
		}
		if($('#pack_inc').val()!=1)
		{
		if(totc==no){
		 $('#pack_inc').val(Number($('#pack_inc').val())-1);
		}
		}
}

//===============remove_pack====================
//===================12-08-2016 by junior Developer A Ganeshkumar=============
</script>