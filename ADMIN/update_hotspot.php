<html>
<?php
require_once('../Connections/divdb.php');
$spot_id=$_GET['hid'];

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


    	$spot = $conn->prepare("SELECT * FROM hotspots_pro  where hotspot_id =?");
		$spot->execute(array($spot_id));
		$row_spot = $spot->fetch(PDO::FETCH_ASSOC);



	if ((isset($_POST["MM_insertform"])) && ($_POST["MM_insertform"] == "form_upload_hotspot")) {
		
	//mysql_select_db($database_divdb, $divdb);

//$timing=$_POST['stime'].' - '.$_POST['etime'];
$timing=$_POST['timing'];


$hdesc=str_replace("'",">>>",$_POST['hdesc']);

if(isset($_POST['def_img']) && (trim($_POST['def_img']) != ''))
{
$def_img=explode(',',$_POST['def_img']);
$up_img='';
			if(isset($_POST['rem_img']) && $_POST['rem_img'] != '')
			{
			$rem_img=explode(',',$_POST['rem_img']);
			
			//$rem_img=trim($rem_img[0]);
			
			$def_len=count($def_img);
			$rem_len=count($rem_img);
			
			//print_r($_POST['rem_img']);
			
			$up_img1=array_diff($def_img, $rem_img);
			$up_img=implode(',',$up_img1);
			
			$up_img=substr($up_img,0);
			
						for($r=0;$r<$rem_len;$r++)
						{
   						unlink("../img_upload/uploads/files/".$rem_img[$r]);	
   						unlink("../img_upload/uploads/files/thumbnail/".$rem_img[$r]);	
						}
			}else
			{
				$up_img=$row_spot['spot_images'];
			}
			$UPD=$conn->prepare("UPDATE hotspots_pro set spot_name=?,spot_state=?, spot_city=?, spot_timings=?, video_link=?, spot_images=?, spot_desc=?, spot_prior=?,status='0' where hotspot_id=?"); 
			$UPD->execute(array($_POST['hname'],$_POST['hstate'],$_POST['hotel_city'],$timing,$_POST['hvideo'],$up_img,$hdesc,$_POST['prior'],$spot_id));
		
		//echo $rem_len;				

}else
{
	
		$UPD=$conn->prepare("UPDATE hotspots_pro set spot_name=?, spot_state=?, spot_city=?, spot_timings=?, video_link=?, spot_desc=?, spot_prior=?, status='0' where hotspot_id=?"); 
	/*	echo $UPD="UPDATE hotspots_pro set spot_name='".mysql_real_escape_string($_POST['hname'])."',spot_state='".mysql_real_escape_string($_POST['hstate'])."', spot_city='".mysql_real_escape_string($_POST['hotel_city'])."', spot_timings='".mysql_real_escape_string($timing)."', video_link='".mysql_real_escape_string($_POST['hvideo'])."', spot_desc='".mysql_real_escape_string($hdesc)."', status='0' where hotspot_id='$spot_id' ";*/
		$UPD->execute(array($_POST['hname'],$_POST['hstate'],$_POST['hotel_city'],$timing,$_POST['hvideo'],$hdesc,$_POST['prior'],$spot_id));
	
}
	
		$cn1=$_POST['hname'];
			
				
		/*echo "<script>parent.document.location.href='../admin_manaitin.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(4)."&rec1=".$cn1."';</script>"; */
  echo "<script>parent.document.location.reload();parent.jQuery.fancybox.close();</script>";
		
}


		

?>
<head>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">

		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/summernote/summernote.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/markdown/bootstrap-markdown.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
<!--		<link href="../core/assets/plugins/morris-chart/morris.min.css" rel="stylesheet">
	<link href="../core/assets/plugins/c3-chart/c3.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		<link href="../core/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="../core/assets/plugins/fullcalendar/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">-->
			
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
      
<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

</head>
<body>

<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-map-marker"></i> Update - <?php echo $row_spot['spot_name'];?></h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
								 <form   method="post" name="form_upload_hotspot"  id="form_upload_hotspot" onSubmit="return validate_me()" >
                                 <input type="hidden" id="mm" value="<?php echo $_GET['mm'];?>">
                                   <input type="hidden" id="sm" value="<?php echo $_GET['sm'];?>">
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Hotspot name" ><i class="fa fa fa-map-marker fa-fw"  ></i></span>
										  <input type="text" name="hname" id="hname"  class="form-control" placeholder="Hotspot name" value="<?php echo $row_spot['spot_name'];?>">
										</div>
									<!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->                                        </div>
                                    
                                        </div>
                                        
                                        <div class="col-sm-6">
                                         <div class="form-group">
                                    <div class="input-group">
                                    <span class="input-group-addon tooltips" data-original-title="Hotspot Timing" ><i class="fa fa fa-clock-o fa-fw"  ></i></span>
                                    <input type="text" name="timing"  id="timing" class="form-control" placeholder="Opening and closing time" value="<?php echo $row_spot['spot_timings'];?>">
                                    </div>
                                    </div>
                                        </div>
                                        
                                        <!--<div class="col-sm-6">
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                   
                                        <div class="input-group input-append bootstrap-timepicker">
                                        <?php //$tt=explode('-',$row_spot['spot_timings'])?>
												<input type="text" readonly name="stime" id="stm" class="form-control timepicker" value="<?php //echo $tt[0];?>">
												<span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
											</div>
                                        <small class="help-block" id="stmerr">Opening time.</small>
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                   
                                        <div class="input-group input-append bootstrap-timepicker">
												<input type="text" readonly name="etime" id="cltms" class="form-control timepicker" value="<?php //echo $tt[1];?>">
												<span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
											</div>
                                        <small class="help-block" id="cltmerr">Closing time.</small>
                                        </div>
                                        </div>
									</div>-->
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
									$hotelstate = $conn->prepare("SELECT * FROM dvi_states");
									$hotelstate->execute();
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelstate_main=$hotelstate->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Hotspot State"><i class="fa fa-globe fa-fw"></i></span>
										 <select data-placeholder="Choose a State" id="hstate" name="hstate" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_city(this.value);change_prio_def();" >									
                                         <option ></option>	
										 <?php foreach($row_hotelstate_main as $row_hotelstate) {
											 if($row_hotelstate['code']==$row_spot['spot_state'])
											 {
											 ?>
                                        <option selected value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option> 
                                         <?php }else {?>
										<option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option><?php }?>
                                        <?php } ?>
									</select>
										</div>
                                       <!-- <small class="help-block" id="perklerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group" id="default_city_id">
										  <?php 
									$hotelcity = $conn->prepare("SELECT * FROM  dvi_cities where region=?");
									$hotelcity->execute(array($row_spot['spot_state']));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main = $hotelcity->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="Hotspot City"><i class="fa fa-globe fa-fw"></i></span>
										 <select data-placeholder="Choose a City" id="hotel_city" name="hotel_city" class="form-control chosen-select " tabindex="2" onChange="change_priotity(this.value)">									
                                         <option value="Empty">&nbsp;</option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) {
											 if($row_spot['spot_city']==$row_hotelcity['id'])
											 {
											 ?>
                                  <option selected value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>           
                                             <?php }else{?>
										<option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>
                                        <?php 
											 }
											 } ?>
									</select>
										</div>
                                        <!--<div class="input-group" id="active_city_id"></div>-->
                                        </div>
                                        </div>
                                         <!-- /.col-sm-6 -->
                                </div>
                                <div class="row">
                                <div class="col-sm-6">
                                <div class="form-group">
										 <div class="input-group">
                                         
										<span class="input-group-addon tooltips" data-original-title="Video link"><i class="fa fa-video-camera fa-fw"></i></span>
										  <input type="text" class="form-control" id="vide" name="hvideo" placeholder="Video link" value="<?php echo $row_spot['video_link']; ?>">
										</div>
                                        <small class="help-block" id="seaterr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group" id="hotprior_div">
                                      <?php
									$hotprior = $conn->prepare("SELECT * FROM  hotspots_pro where spot_city=?");
									$hotprior->execute(array($row_spot['spot_city']));
									//$row_hotprior= mysql_fetch_assoc($hotprior);
									$row_hotprior=$hotprior->fetch(PDO::FETCH_ASSOC);
									$tot_hotprior=$hotprior->rowCount();
										 ?>
                                    <span class="input-group-addon tooltips" data-original-title="Hotspot Priority"><i class="fa  fa-signal fa-fw"></i></span><?php if($tot_hotprior>0){ ?>
                                 <select name="prior" id="prior" data-placeholder="Choose Priority" class="form-control chosen-select " >
                                 <?php for($pr=1;$pr<= $tot_hotprior;$pr++){
									 if($pr==$row_spot['spot_prior'])
									 {?>
								  <option selected value="<?php echo $pr; ?>"><?php echo $pr; ?></option>		 
									<?php }else{
									 ?>
                                 <option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
                                 <?php }
								 }//for loop end?>
                                 </select>   
                                    <?php }else{?>
										 <input class="form-control" name="prior" id="prior" type="text" value="1" placeholder="Priority" ><?php }?>
										</div>
                                        <!--<div class="input-group" id="active_city_id"></div>-->
                                        </div>
                                        </div>
                                
                                
                                </div>
                                
                                <div class="row">
                                <div class="col-sm-12">
                                <div class="the-box">
						<h4 class="small-title" align="center" style="color:#999;">Description About - <?php echo $row_spot['spot_name']; ?></h4>
						
							<textarea name="hdesc" class="summernote-sm" placeholder="History"><?php
							$hdesc=str_replace(">>>","'",$row_spot['spot_desc']);
							 echo $hdesc; ?>
                             </textarea>
					
					</div><!-- /.the-box -->
                    </div>
                    </div>

                                
                                
                                 <?php $immages= explode(',',$row_spot['spot_images']) ;
								 //print_r($immages);
								// echo count($immages);
								 if(trim($immages[0]) != '')
								 {
								 ?>
                                 
<hr>
<div class="row"  style=" background-color:#F5F6F9;">
                                <div class="col-sm-12">
                                <div class="form-group">
                                <br>
                                <center><strong style="color:#CCC; font-size:16px">Uploaded Images for this hotspot</strong><a id="checkall" class="btn btn-default btn-sm pull-right" onClick="check_all()"><i class="fa fa-check-square-o"></i>&nbsp; Check All</a></center><br>
                               <?php 
							   $img_cnt=0;
							   foreach($immages as $imm ) {?>
										 <div class="col-sm-2" id="div<?php echo $img_cnt; ?>" style="padding-bottom:20px" >
                                         <input type="checkbox" id="check<?php echo $img_cnt; ?>" data-bv-choice="true" data-bv-choice-min="2" data-bv-choice-max="4" style="margin-left:2px; position:absolute; z-index: 1000 " onClick="check_me('<?php echo $img_cnt; ?>','<?php echo $imm; ?>')" >
                                      
                                        <img id="img<?php echo $img_cnt; ?>" src="../img_upload/hot_spots/<?php echo $imm; ?>"  width="74%" height="10%"  alt="<?php echo $imm; ?>"  >
                                        </div>
                                        <?php $img_cnt++; }?>
                                       
                                        </div>
                                        <input type="hidden" id="tot_cont" value="<?php echo $img_cnt;?>">
                                        <input type="hidden" name="def_img" value="<?php echo $row_spot['spot_images'];?>" id="image_name">
                                          <input type="hidden" value="" name="removed_img" id="image_new">
                                           <input type="hidden" value="" id="div_new">
                                            <input type="hidden" value="" id="rem_img" name="rem_img">
                                </div>
                                 <br>
                                <center>  <a id="remove" class="btn btn-default btn-sm" onClick="remove_me()"><i class="fa fa-trash-o"></i>&nbsp; Remove</a>
                            <a id="remove" class="btn btn-default btn-sm" onClick="cancel_me()"><i class="fa fa-reply-all"></i>&nbsp; Undo</a></center>
                            <br>
                                </div>
                               
                                <?php }else { ?>
                              <center><strong style="color:#CCC; font-size:14px">No Images Uploaded..</strong></center>
                           <?php  }?>
                          
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group pull-right">
                                    <button type="submit"  name="form_entry_hotspot" value="form_entry_hotspot_val" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Submit</button>
                                    <button type="button" class="btn btn-sm btn-danger" onClick="parent.jQuery.fancybox.close();"><i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                        </div>
                                </div>
                                 <input type="hidden" class="form-control" name="MM_insertform" value="form_upload_hotspot">
                                <input type="hidden" id="cnt2"><input type="hidden" id="cnt3"><input type="hidden" id="cnt4"><input type="hidden" id="cnt5"><input type="hidden" id="cnt6"><input type="hidden" id="cnt7">
											
                                 </form>
                                 
                                </div>
							  </div>
							</div><!-- /.panel panel-default -->
						</div>
                        </div>
                        </div>

                        </body>
                        
                        <script src="../core/assets/js/jquery.min.js"></script>
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
        
        
		<!-- PLUGINS -->
        <script type="text/javascript" src="../core/assets/plugins/Tags/jquery.tagsinput.js"></script>
		<script src="../core/assets/plugins/skycons/skycons.js"></script>
		<script src="../core/assets/plugins/prettify/prettify.js"></script>
		<script src="../core/assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../core/assets/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
		<!--<script src="../core/assets/plugins/icheck/icheck.min.js"></script>-->
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
	<!--	<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>-->
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
	<!--	<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>-->
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
        
                 
<script>




function check_all()
{
	var len=$('#tot_cont').val();
	var nct='';
	for(var ty=0; ty<len; ty++)
	{
		$('#img'+ty).css({"opacity": "0.5"});
		$('#check'+ty).prop('checked',true);
		
		if(nct == '' )
		{
			nct='0';
		}else
		{
			nct=nct+','+ty;
		}
	}
	$('#image_new').val($('#image_name').val());
	$('#div_new').val(nct);
}

function check_me(no,name)
{
	if($('#check'+no).is(':checked'))
	{
		//alert('checked');
		$('#img'+no).css({"opacity": "0.5"});
		$('#check'+no).prop('checked',true);
			var newchecked=$('#image_new').val();
			if(newchecked != '')
			{
			newchecked =newchecked+','+name;
			}else
			{
				newchecked =name;
			}
		$('#image_new').val(newchecked);
		//alert(newchecked);
		var newdiv=$('#div_new').val();
		//alert('div'+newdiv);
			if(newdiv != '')
			{
				newdiv=newdiv+','+no;
				//alert('not emp'+newdiv);
			}else
			{
				newdiv=no;
				//alert('nn'+newdiv);
			}
			$('#div_new').val(newdiv);
	}else
	{
		$('#img'+no).css({"opacity": "1.0"});
		$('#check'+no).prop('checked',false);
		var remchecked1=$('#image_name').val();
		var remchecked2=$('#image_new').val();
		
		var arr1,arr2;
		arr1=remchecked1.split(',');
		arr2=remchecked2.split(',');
		
		var new_str='';
		for(var i=0; i<arr2.length; i++)
		{
			if(arr2[i]!=name)
			{
				if(new_str.trim() !='')
				{
					new_str=new_str+','+arr2[i];
				}else{
					new_str=arr2[i];
				}
			}
		}
		
		$('#image_new').val(new_str);
		
		arr3=$('#div_new').val().split(',');
	
		var rem_divv='';
		for(var ii=0; ii<arr3.length; ii++)
		{
			if(arr3[ii] != no)
			{
				if(rem_divv.trim() !='')
				{
					rem_divv=rem_divv+','+arr3[ii];
				}else{
					rem_divv=arr3[ii];
				}
			}
		}
		$('#div_new').val(rem_divv);
		//alert(rem_divv);
		
	}
}

function remove_me()
{
	//alert('rem');
	var nam=$('#div_new').val();
	var nam1=nam.split(',');
	for(var z=0;z<nam1.length;z++)
	{
		$('#div'+nam1[z]).hide();
	}
	
	//alert($('#image_new').val());
	$('#rem_img').val($('#image_new').val());
}

function cancel_me()
{
	var nam=$('#div_new').val();
	var nam1=nam.split(',');
	for(var z=0;z<nam1.length;z++)
	{
		$('#div'+nam1[z]).show();
	}
	$('#rem_img').val('');
}

$('.tooltips').tooltip({});
$('.chosen-select').chosen({width : '100%'});

function find_city(state_id)
{
		var type=18;
	$.get("ajax_hotel.php?sid="+state_id+"&type="+type,function(result)
	{
		//alert(result);
		$('#default_city_id').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
	
}

function change_prio_def()
{
	$('#hotprior_div').empty().html("<span class='input-group-addon tooltips' data-original-title='Hotspot Priority'><i class='fa  fa-signal fa-fw'></i></span><input type='text' name='prior' id='prior' value='1' class='form-control'/>");
}

function change_priotity(cid)
{
	var type=17;
	$.get("ajax_hotel.php?cid="+cid+"&type="+type,function(result)
	{
		$('#hotprior_div').empty().html(result);
							$('.chosen-select').chosen({'width':'100%'});
							$('.tooltips').tooltip({});
		
	});
	
}

function validate_me()
{
	var numbers =  /^\d+$/; 
	if($('#hname').val().trim()=='')
	{
		alert("Please Enter Hotspot Name");	
		$('#hname').focus();
		return false;
	}else if($('#hname').val().trim().length<4)
	{
		alert("Hotspot Name should be minimum 4 charactors");
		$('#hname').focus();
		return false;	
	}else if($('#timing').val().trim() =='')
	{
		alert('Please Enter Hotspot Visiting-Time');
		$('#timing').focus();
		return false;
	}else if($('#hstate').val() == '')
	{
		alert('Please Choose Hotspot Located State');
		$('#hstate').focus();
		return false;		
	}else if($('#hotel_city').val() == '')
	{
		alert('Please Choose Hotspot Located City');
		$('#hotel_city').focus();
		return false;		
	}else if($('#prior').val() == '')
	{
		alert('Please Choose Hotspot Priority');
		$('#prior').focus();
		return false;		
	}else if(!numbers.test($('#prior').val()))
	{
		alert('Please Enter Priority In Integer');
		$('#prior').focus();
		return false;		
	}else {
		return true;	
	}
	
}


</script>                        

</html>
                        