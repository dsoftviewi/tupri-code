<?php
//===================12-08-2016 by junior Developer A Ganeshkumar=============
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
		
		 $pack_categ=trim($_POST['pack_categ']);
		 $pack_inc=$_POST['pack_inc'];	 
		 $pack_d=$_POST['pack_desc'];
		 $image_store='';
		 $day_title='';
		 $pack_desc='';
     $pack_location='';
		 $d=0;
		 for( $j=1;$j<=$pack_inc;$j++)
		{
			if($_POST['day_name'.$j]!='' && $_POST['pack_desc'.$j]!='' && $_FILES['pack_img'.$j]['name']!='' || $_POST['img_hidd'.$j]!='')
			{
			if($day_title=='')
			{
				$day_title=$_POST['day_name'.$j];
			}else{
				$day_title.='~'.$_POST['day_name'.$j];
			}
			if($pack_desc==''){
				$pack_desc=$_POST['pack_desc'.$j];
			}else{
				$pack_desc.='~'.$_POST['pack_desc'.$j];
			}
      if($pack_location==''){
        $pack_location=$_POST['pack_locat'.$j];
      }else{
        $pack_location.='~'.$_POST['pack_locat'.$j];
      }

			$pack_imgs=$_FILES['pack_img'.$j]['name'];
		 if(trim($pack_imgs)!='')
		 {
		 	$FileType = pathinfo($pack_imgs,PATHINFO_EXTENSION);
  			$profile=$his."_".$pack_imgs;
			$target_file='packages/images/'.$profile;

				if(!move_uploaded_file($_FILES["pack_img".$j]["tmp_name"], $target_file))
				{
					$pack_imgs="default_img.jpg";
				}else{
					if($image_store==''){
					  $image_store.=$profile;	
					}else{
					 $image_store.='~'.$profile;
					}
				}
		 }else{
			 if($image_store==''){
					  $image_store.=$_POST['img_hidd'.$j];	
					}else{
					 $image_store.='~'.$_POST['img_hidd'.$j];
					}
		 }
		}
		}
			$image_store = str_replace(' ', '', $image_store);
		 	$insert_pack = sprintf("UPDATE dvi_packages set pack_name=%s, pack_location=%s, pack_img=%s, pack_desc=%s , p_d=%s, day_title=%s, day_locat=%s, pack_grp=%s where sno='".trim($_POST['pack_sno'])."'",
            GetSQLValueString($pack_name, "text"),
            GetSQLValueString($pack_locat, "text"),
            GetSQLValueString($image_store, "text"),
             GetSQLValueString($pack_d, "text"),
            GetSQLValueString($pack_desc, "text"),
            GetSQLValueString($day_title, "text"),
            GetSQLValueString($pack_location, "text"),
            GetSQLValueString($pack_categ, "text"));
        mysql_select_db($database_divdb, $divdb);
        mysql_query($insert_pack, $divdb) or die(mysql_error());

      echo "<script>parent.document.location.href='admin_packages.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost1=".md5(6)."';</script>";
}

?>

<style>
.datepicker{z-index:1050 !important;}
.flashit{
	-webkit-animation: flash linear 1s infinite;
	animation: flash linear 1s infinite;
	color: #EF0000;
	font-size:13px;
	font-weight:none;
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
    margin:  10px!important;
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
	mysql_select_db($database_divdb, $divdb);
	$query_packages = "SELECT * FROM dvi_packages where status=0 and sno='".$_GET['dvisno']."' ";
	$packages = mysql_query($query_packages, $divdb) or die(mysql_error());
	$row_packages = mysql_fetch_assoc($packages);
	$totalRows_packages = mysql_num_rows($packages);
?>
	<div class="container-fluid">
				<!-- Begin page heading -->
				
<div id="panel-collapse-3" class="collapse in">
				<h1 class="page-heading">Packages<small>&nbsp;Frontend Update Packages</small></h1>
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="right-content">
							
							</div>
							<h3 class="panel-title">
								<i class="fa fa-briefcase"></i>
 								Frontend Package - Update Package
							</h3>
						</div>
			<!-- Complex headers with sorting -->
				<div id="tabid" class="panel-body">
                    <form name="form_distr_sett" id="form_distr_sett" method="post" enctype="multipart/form-data" onsubmit="return add_packages()" >											  
                               <div class="row">
								<div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
										<label for="pack_name">Pack Name</label>
										</div><strong id="err_msg_pack_name" style="font-size:13px;color:red;float:right"></strong>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="pack_name" id="pack_name" class="form-control" placeholder="Package Title" value="<?php echo $row_packages['pack_name'];?>"/>
                         <input type="hidden" name="pack_sno" id="pack_sno" class="form-control" placeholder="Package Title" value="<?php echo $row_packages['sno'];?>" />
                                        </div>
                                    </div>
                                </div>
                                  <input type="hidden" id="pack_hid_desc" name="pack_hid_desc" value="<?php echo $row_packages['p_d'];?>" />
                        <input type="hidden" id="pack_hid_day" name="pack_hid_day" value="<?php echo $row_packages['day_title'];?>" />
                        <input type="hidden" id="pack_hid_img" name="pack_hid_img" value="<?php echo $row_packages['pack_img'];?>" />
                         <input type="hidden" id="pack_hid_locat" name="pack_hid_locat" value="<?php echo $row_packages['day_locat'];?>" />
                                <div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left">
										<label for="pack_locat">Location Name</label>
										</div><strong id="err_msg_locat" style="font-size:13px;color:red;float:right"></strong>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="pack_locat" id="pack_locat" class="form-control" placeholder="Place Name" value="<?php echo $row_packages['pack_location'];?>"/>
                                        </div>
                                    </div>
                                </div>

								<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
										<label for="pack_name">Pack Category</label>
										</div><strong id="err_msg_categ" style="font-size:13px;color:red;float:right"></strong>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <select name="pack_categ" id="pack_categ" class="chosen-select" placeholder="Select Category">
                        	<option></option>
                        	<option value="DI" <?php if($row_packages['pack_grp']=="DI"){ ?>selected<?php } ?>>Domestic itineraries</option>
                        	<option value="IN" <?php if($row_packages['pack_grp']=="IN"){ ?>selected<?php } ?>>International itineraries</option>
                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="pack_desc">Pack - Short Description</label>
										</div><strong id="err_msg_desc" style="font-size:13px;color:red;float:right"></strong>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <textarea name="pack_desc" id="pack_desc" style="overflow-y:scroll; height:90px; width:100%; resize:none" maxlength="250"><?php echo $row_packages['pack_desc'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="pack_div1">
                                 <fieldset class="scheduler-border">
    							 <legend class="scheduler-border">Package
    								<button type="button" class="btn btn-info btn-sm btn_splus" onclick="add_pack('1','undefined','undefined','undefined','undefined')" id="pack_pulse1" style="padding:0px 1px;">
									<i class=" fa fa-plus"></i>			
									</button> 
									<button type="button" class="btn btn-sm btn-warning btn_splus" id="pack_min1" style="padding:0px 1px;">
										<i class="fa fa-minus"></i>
									</button></legend>
									<div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
										<label for="Day Title">Days : </label>
										</div><strong id="err_msg_day1" style="font-size:13px;color:red;float:right"></strong>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="day_name1" id="day_name1" class="form-control" placeholder="Days Title" value="<?php if(strpos($row_packages['day_title'],'~')){ $espd=explode('~',$row_packages['day_title']); echo $espd[0]; } else { echo $row_packages['day_title']; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                  <div class="col-sm-12" style="margin-top:5px;">
                                    <div class="row">
                  <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left">
                    <label for="pack_locat">Location Name</label>
                    </div><strong id="err_msg_locat1" style="font-size:13px;color:red;float:right"></strong>
                        </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="text" name="pack_locat1" id="pack_locat1" class="form-control" placeholder="Place Name" value="<?php if(strpos($row_packages['day_locat'],'~')){ $espd=explode('~',$row_packages['day_locat']); echo $espd[0]; } else { echo $row_packages['day_locat']; } ?>" />
                                        </div>
                                    </div>
                                </div>
									<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
										<label for="pack_desc">Day - Short Description</label>
										</div><strong id="err_msg_desc1" style="font-size:13px;color:red;float:right"></strong>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <textarea name="pack_desc1" id="pack_desc1" style="overflow-y:scroll; height:90px; width:100%; resize:none"><?php if(strpos($row_packages['p_d'],'~')){ $espd=explode('~',$row_packages['p_d']); echo $espd[0]; } else { echo $row_packages['p_d']; } ?>
                        </textarea>
                                        </div>
                                    </div>
                                </div>
							<div class="col-sm-12" style="margin-top:5px;">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" style="float:left;">
										<label for="pack_img" >Location Img : </label>
										<br><small style="color : rgb(240, 9, 9);font-size:11px;font-weight: 600;">[ Image file only ]</small>
										</div><strong id="err_msg_img1" style="font-size:13px;color:red;float:right"></strong>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                        <input type="file" name="pack_img1" id="pack_img1" class="" placeholder="Img" style="width:100%" />                     	
                        <input type="hidden" id="img_hidd1" name="img_hidd1" value=" <?php if(strpos($row_packages['pack_img'],'~')){ $espd=explode('~',$row_packages['pack_img']); echo $espd[0]; } else { echo $row_packages['pack_img']; }?>" />
                        <strong id="perr1" class="flashit pull-left" style="display:none;font-sixe:13px;">* Please Enter All Required Fields</strong>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <input type="hidden" value="1" id="pack_inc" name="pack_inc">
                        <div id="add_pack_multi" class="row">
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
					<strong id="perr" class="flashit pull-left" style="display:none">* Please Enter All Required Fields</strong><a href="admin_packages.php">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button></a>
                    <button type="submit" id="pack_sett" name="pack_sett" value="pack_sett_val" class="btn btn-info" >Submit</button>
					  </div>
					 </form>
					</div>                                     
                  <!-- update news -->
                  <div class="modal fade" id="news_updates" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
				  </div>
                                        
                                        <!-- ending update news -->
 
                                        
					<!-- /.row -->
				</div>
			</div>  
		</div>			
                <!-- /.container-fluid -->
                		<!-- /.row -->
			
<script>
$(document).ready(function(e) {
			$('.chosen-select').chosen({width:'100%'});
			$('.datatable-example').dataTable({"bSort": false });
			$('.datatable-example3').dataTable({"bSort": false });
			
        });
var imgstore=$("#pack_hid_desc").val();
var desc=$("#pack_hid_day").val();
var dt=$("#pack_hid_img").val();
var dl=$("#pack_hid_locat").val();

		if(dt.indexOf('~')){
			var eximage=imgstore.split('~');
			var exdesc=desc.split('~');
			var exdt=dt.split('~');
      var exdl=dl.split('~');
			var v=1;
			//$("#day_name1").val(exdt[0]);
			for(var vc=2;vc<=eximage.length;vc++)
			{	
				// alert(eximage[v]+ " / " +exdesc[v]+ " / " +exdt[v]+"   \  "+eximage.length);
				add_pack(v,exdt[v],exdesc[v],eximage[v],exdl[v]);
				
				v++;
			}
		}else{
			
		}
function add_packages()
{	
	var d=0;
	var name=[];
	//========validation==============
	var pack_inc=$("#pack_inc").val();
	for(var j=pack_inc;j>=1;j--)
	{
	for(var i=j;i<=j;i++)
	{	

	if($("#day_name"+i).val()=="" || $("#pack_desc"+i).val()=="" || $("#pack_img"+i).val()=="" && $("#img_hidd"+i).val()=="" || $("#pack_locat"+i).val()=="" )
		{
		name[d]=1;
	}else{
		name[d]=0;
	}
		d++;
	}
}
	var found = $.inArray(1, name) < 0;
	var pack_name=$("#pack_name").val();
	var pack_locat=$("#pack_locat").val();
	var pack_categ=$("#pack_categ").val();

	var pack_d=$("#pack_desc").val();
	var c=1;
	var checkimg=[];
	$("#err_msg_pack_name").empty();
	$("#err_msg_locat").empty();
	$("#err_msg_categ").empty();
	$("#err_msg_desc").empty();
	if(found==false){
	for(var j=pack_inc;j>=1;j--)
	{
	for(var i=j;i<=j;i++)
	{
	
	if($("#pack_img"+i).val()=="" && $("#img_hidd"+i).val()=="")
	{
	$("#err_msg_img"+i).html(" * Select Image");
	$("#pack_img"+i).focus();
	
	}else{
		$("#err_msg_img"+i).empty();
	}
	
  var sertlen=$("#pack_desc"+i).val().length;
  if($("#pack_desc"+i).val()=="")
  {
  $("#err_msg_desc"+i).html(" * Enter Description");
  $("#pack_desc"+i).focus();
  }
  else{
    $("#err_msg_desc"+i).empty();
  }
  if($("#pack_locat"+i).val()==""){
  $("#err_msg_locat"+i).html(" * Enter Location");
  $("#pack_locat"+i).focus();
  }
	else{
    $("#err_msg_locat"+i).empty();
  }
	if($("#day_name"+i).val()=="")
	{
	$("#err_msg_day"+i).html(" * Enter Day Title");
	$("#day_name"+i).focus();
	}else{
		$("#err_msg_day"+i).empty();
	}c++;
	   }
	  }
	  }else if(found==true){
	 
		for(var j=pack_inc;j>=1;j--)
	{
	for(var i=j;i<=j;i++)
	{	
		$("#err_msg_day"+i).empty();
		$("#err_msg_desc"+i).empty();
		$("#err_msg_img"+i).empty();
    $("#err_msg_locat"+i).empty();
		}
   }
	}
  if(pack_d==""){
  $("#err_msg_desc").html(" * Enter Description");
  $("#pack_desc").focus();
  }
	if(pack_categ==""){
	$("#err_msg_categ").html(" * Select Category");
	$("#pack_categ").focus();
	}
	if(pack_locat==""){
	$("#err_msg_locat").html(" * Enter Location");
	$("#pack_locat").focus();
	}
	if(pack_name==""){
	$("#err_msg_pack_name").html(" * Enter Package Name");
	$("#pack_name").focus();
	}
	
	 var r=0;
	for(var j=pack_inc;j>=1;j--)
	{
	for(var i=j;i<=j;i++)
	{	

	if($("#pack_img"+i).val()!="")
	{
	var validExtensions = ['png','jpg','jpeg','JPG','PNG','JPEG']; //array of valid extensions
        	var fileName = $('#pack_img'+i).val();
        	var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
        	
        	if ($.inArray(fileNameExt, validExtensions) == -1){
          	$('#perr'+i).empty().prepend("Invalid file type [ image - files only accepted on location image ]").show();
			$('#pack_img'+i).focus();
           	 checkimg[r]=1;
        	}else{
        		$('#perr'+i).empty().prepend("Accepted").show();
        		 checkimg[r]=0;
        		}
        	}
        	r++;
        }
    }
	var check = $.inArray(1, checkimg) < 0;
	//alert(check);
	if(found!=false && pack_name!='' && pack_locat!="" && pack_categ!="" && check!=false && pack_d!=""){
		//alert("t");
		return true;
	}else{
		//alert();
		return false;
	}
		  //========validation==============
}
//===============add _pack====================
 function add_pack(val,img,title,desc,dl){
	var coval=val;
	var pack_inc=$("#pack_inc").val();
	var type="2";
	var num_pack_inc=Number(pack_inc)+1;
	$("#pack_inc").val(Number(num_pack_inc));	
	var data_string="&type="+type+"&pack_inc="+num_pack_inc+"&img="+img+"&title="+title+"&desc="+desc+"&dl="+dl;
	 //alert(data_string);
	$.ajax({
		type:"GET",
		data:data_string,
		url:"CMS/ajax_pack_page.php",
		beforeSend: function()
		{
			//$('.loader_ax').fadeIn();
		},
		success:function(result)
		{
			//alert(result);
			$("#add_pack_multi").show().append(result);
			$("#pack_inc").val(Number(num_pack_inc));
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