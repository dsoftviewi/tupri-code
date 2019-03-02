<html>
<?php
require_once('../Connections/divdb.php');

$vehidinf = $conn->prepare("SELECT * FROM vehicle_pro  where vehi_id =?");
$vehidinf->execute(array($_GET['vid']));
$row_vehidinf = $vehidinf->fetch(PDO::FETCH_ASSOC);

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
	
//For update the vehicle form
if((isset($_POST["MM_insertupd"])) && ($_POST["MM_insertupd"] == "updatefrm")) 
{
		
				//This is for vehi table
				$vehitime = $conn->prepare("SELECT datetime FROM vehicle_pro where vehi_id=?");
				$vehitime->execute(array($_POST['vid']));
				$row_vehitime = $vehitime->fetch(PDO::FETCH_ASSOC);
	
			  $insertSQLupd=$conn->prepare('update vehicle_pro set datetime=?, vehicle_type=?,vehicle_seat=? where vehi_id=?');
			  $insertSQLupd->execute(array($row_vehitime['datetime'],$_POST['vehiname'],$_POST['occu'],$_POST['vid']));				
				
		
				$trans='';
				$to='';
				$prch='';
				$prmkl='';
				$snn='';
				$mnsn='';
				
				//This is for vehi table 2
				for($i=1;$i<=$_POST['updcnt'];$i++)
				{
					
					if(isset($_POST['transfer'.$i]) && $_POST['transfer'.$i]!='')
					{
						$trans=$_POST['transfer'.$i];
					}
					else
					{
						$trans=0;
					}
					if(isset($_POST['perday'.$i]) && $_POST['perday'.$i]!='')
					{
						$to=$_POST['perday'.$i];
					}
					else
					{
						$to=0;
					}
					
					if(isset($_POST['perkilo'.$i]) && $_POST['perkilo'.$i]!='')
					{
						$prch=$_POST['perkilo'.$i];
					}
					else
					{
						$prch=0;
					}
					
					if(isset($_POST['permxkl'.$i]) && $_POST['permxkl'.$i]!='')
					{
						$prmkl=$_POST['permxkl'.$i];
					}
					else
					{
						$prmkl=0;
					}
					
					
					if(isset($_POST['city'.$i]) && $_POST['city'.$i]!='')
					{
						
						if(isset($_POST['sno'.$i]) && $_POST['sno'.$i]!='')
						{
						
						$snn.=$_POST['sno'.$i].',';
						
				$insertSQLupd123=$conn->prepare('update vehicle_rent set city=?, rent_transfer=?,rent_day=?,charge_perkm =?, maxkm_perday=? where sno=? and vehicle_id =?');
				$insertSQLupd123->execute(array($_POST['city'.$i],$trans,$to,$prch,$prmkl,$_POST['sno'.$i],$_POST['vid']));
						}
						else
						{
							
							//this is for table 2
					
					 $insert_distrb = $conn->prepare("INSERT INTO  vehicle_rent (vehicle_id,city,rent_transfer,rent_day,charge_perkm,maxkm_perday) VALUES (?,?,?,?,?,?)");
					 $insert_distrb->execute(array($_POST['vid'],$_POST['city'.$i],$trans,$to,$prch,$prmkl));
					
						$vehdesno = $conn->prepare("SELECT sno FROM vehicle_rent where vehicle_id=? ORDER BY sno DESC limit 1");
						$vehdesno->execute(array($_POST['vid']));
						$row_vehdesno = $vehdesno->fetch(PDO::FETCH_ASSOC);
					
					$mnsn.=$row_vehdesno['sno'].',';
						}
						
				
				
					}
				}
	
	//This is for remove duplicate entry
	$scd='';
	$sds='';
	$sds2='';
	$scd=explode(',',substr($snn.$mnsn,0,-1));
		
	$vehitime = $conn->prepare("SELECT sno FROM vehicle_rent where vehicle_id=?");
	$vehitime->execute(array($_POST['vid']));
	$row_vehitime_main = $vehitime->fetchAll();
	
	foreach($row_vehitime_main as $row_vehitime){
		
		$sds.=$row_vehitime['sno'].',';
		
	};
		
	$sds2=explode(',',substr($sds,0,-1));
	$dd=array_diff($sds2,$scd);
	
	 foreach($dd as $d)
	 {
		
		$vdel = $conn->prepare("DELETE from  vehicle_rent where sno=?");
		$vdel->execute(array($d));
	 }
	
	$cn1=$_POST['vehiname'].' record was successfully Updated..!';
	$cl='info';
	
	
	echo "<script>parent.document.location.href='../admin_manavehile.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."&rec=".$cn1."&clr=".$cl."';</script>"; 
  	echo "<script>parent.jQuery.fancybox.close();</script>";
}



?>
<head>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- PLUGINS CSS -->
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
		
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../core/assets/plugins/Tags/jquery.tagsinput.css" />
        
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
								<h3 class="panel-title"><i class="fa fa-taxi"></i> Update vehicle</h3>
							  </div>
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12"> <!--onSubmit="return exmapleval();" -->
								 <form method="post" name="exmaplevals"  >
                                 <input type="hidden" id="mm" value="<?php echo $_GET['mm'];?>">
                                   <input type="hidden" id="sm" value="<?php echo $_GET['sm'];?>">
                                                <div class="row">
									<div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Vehicle name" ><i class="fa fa-taxi fa-fw"  ></i></span>
										  <input type="text" autocomplete="off" name="vehiname" id="vnum" value="<?php echo $row_vehidinf['vehicle_type'];?>" class="form-control"  placeholder="Vehicle name">
										</div>
                                        <small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
                                    
                                        </div>
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Vehicle capacity"><i class="fa fa-taxi fa-fw" ></i></span>
										  <input type="text" autocomplete="off" value="<?php echo $row_vehidinf['vehicle_seat'];?>" class="form-control" id="seat" name="occu" placeholder="Occupancy">
										</div>
                                        <small class="help-block" id="seaterr" style=" display:none; color:#E9573F;" ></small>
                                        </div>
									</div>
                                    </div>
                                    <?php
                                    
		$updcity = $conn->prepare("SELECT * FROM vehicle_rent where vehicle_id=? ORDER BY sno ASC");
		$updcity->execute(array($_GET['vid']));
		$row_updcity_main = $updcity->fetchAll();
		$tot= $updcity->rowCount();
		?>
        <input type="hidden" id="cnupd" value="<?php echo $tot?>" name="updcnt"/>
		<?php $iv=1;		
		  foreach($row_updcity_main as $row_updcity){				
									?>
                                    <div class="row" id="upderow<?php echo $iv;?>" >
                                    <div class="col-sm-6">
                                    <div class="col-sm-6">
                                    <div class="form-group" >
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Choose a city"><i class="fa fa-map-marker fa-fw"></i></span>
                                        <select class="form-control chosen-select" name="city<?php echo $iv;?>" id="citys" data-placeholder="Choose a city" >
                                          <?php 
										 
		$cits1 = $conn->prepare("SELECT * FROM dvi_cities ORDER BY name ASC");
		$cits1->execute();
		$row_cits1_main = $cits1->fetchAll();
		foreach($row_cits1_main as $row_cits1){
?>
                                          <option value="<?php echo $row_cits1['id'];?>" <?php if($row_updcity['city']==$row_cits1['id']){ ?> selected <?php }?>><?php echo $row_cits1['name'];?></option>
                                          <?php } ?>
                                          </select>
										  
										</div>
                                        <small class="help-block" id="cityserr" style="color:#E9573F;" ></small>
                                        </div>
                                        </div>
																			   										
                                        <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Per day rental"><i class="fa fa-inr fa-fw"></i></span>
										  <input type="text" autocomplete="off" class="form-control" id="totamt" name="perday<?php echo $iv;?>" value="<?php echo $row_updcity['rent_day'];?>" placeholder="Per day rental">
										</div>
                                        <small class="help-block" id="totamterr" style="color:#E9573F;" ></small>
                                        </div>
                                        </div>
                                    
                                        
                                         
										 <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Per day Transfer"><i class="fa fa-inr fa-fw"></i></span>
										  <input type="text" autocomplete="off" class="form-control" id="totamt" name="transfer<?php echo $iv;?>" value="<?php echo $row_updcity['rent_transfer'];?>" placeholder="Per day transfer">
										</div>
                                        <small class="help-block" id="totamterr" style="color:#E9573F;" ></small>
                                        </div>
                                        </div>
								</div>
									<div class="col-sm-5">
                                    <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Per kilomater rental"><i class="fa fa-inr fa-fw"></i></span>
										  <input type="text" autocomplete="off" class="form-control" value="<?php echo $row_updcity['charge_perkm'];?>" id="perkilo" name="perkilo<?php echo $iv;?>" placeholder="Per kilomater rental">
										</div>
                                        <small class="help-block" id="perklerr" style="color:#E9573F;" ></small>
                                        </div>
                                        </div>
                                        <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Maximum kilometer per day"><i class="fa fa-tachometer fa-fw"></i></span>
										  <input type="text" autocomplete="off" class="form-control" value="<?php echo $row_updcity['maxkm_perday'];?>" id="permxkl" name="permxkl<?php echo $iv;?>" placeholder="Maximum kilometer per day">
										</div>
                                        <small class="help-block" id="permxklerr" style="color:#E9573F;" ></small>
                                        </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="form-group">
                                        <?php if($iv==1){?>
										<a href="javascript:void(0)" id="addrowupd" class="input-group-addon tooltips" data-original-title="Add One"><i class="fa fa-plus fa-fw"></i></a>
                                        <?php }else{?>
                                        <a href="javascript:void(0)" onClick="remrow('<?php echo $iv;?>')" class="input-group-addon tooltips" data-original-title="Remove this."><i class="fa fa-minus fa-fw"></i></a>
                                        <?php }?>
                                        </div>
                                        </div>
                                        </div>
									</div>
                                     <input type="hidden" class="form-control" name="sno<?php echo $iv;?>" value="<?php echo $row_updcity['sno'];?>">
                                    <?php $iv++;}?>
                                
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                    <div class="form-group pull-right">
                                    <button type="submit"  name="add" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Submit</button>
                                    <button type="button" class="btn btn-sm btn-danger" onClick="parent.jQuery.fancybox.close();"><i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                        </div>
                                </div>
                                 <input type="hidden" class="form-control" name="MM_insertupd" value="updatefrm">
                                 <input type="hidden" class="form-control" name="vid" value="<?php echo $_GET['vid'];?>">
                                 <input type="hidden" class="form-control" id="svid" value="<?php echo $row_vehidinf['datetime'];?>">
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
		<script src="../core/assets/plugins/icheck/icheck.min.js"></script>
		<script src="../core/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="../core/assets/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="../core/assets/plugins/mask/jquery.mask.min.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="../core/assets/plugins/summernote/summernote.min.js"></script>
		<script src="../core/assets/plugins/markdown/markdown.js"></script>
		<script src="../core/assets/plugins/markdown/to-markdown.js"></script>
		<script src="../core/assets/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="../core/assets/plugins/slider/bootstrap-slider.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>
         <script src="../core/assets/plugins/jQuery1/form-validator/jquery.form-validator.js"></script>
</html> 
<script>
$('.tooltips').tooltip({});

//validation for vehicle update form
function exmapleval()
{
	if($('#vnum').val()=='')
	{
		$('#vnum').css('border','1px solid #E8573F');
 		$('#vnumerr').html("This field is required.").slideDown('slow');
		$('#cnt1').val(0);
	}
	else
	{
		//For perkilo meter
		$('#vnum').css('border','1px solid #8CC152');
		$('#vnumerr').empty().slideUp('slow');
		$('#cnt1').val(1);
		
	}
	
	//For name
	if($('#citys').val()=='')
	{
 		$('#cityserr').html("This field is required.").slideDown('slow');
		$('#cnt2').val(0);
	}
	else
	{
		//For name
		$('#cityserr').empty().slideUp('slow');
		$('#cnt2').val(1);
		
	}
	
	//For perkilo meter
	if($('#perkilo').val()=='')
	{
		$('#perkilo').css('border','1px solid #E8573F');
 		$('#perklerr').html("This field is required.").slideDown('slow');
		$('#cnt3').val(0);
	}
	else if($.isNumeric($('#perkilo').val())==false)
	{
		$('#perkilo').css('border','1px solid #E8573F');
		$('#perklerr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt3').val(0);
	}
	else
	{
		//For perkilo meter
		$('#perkilo').css('border','1px solid #8CC152');
		$('#perklerr').empty().slideUp('slow');
		$('#cnt3').val(1);
		
	}
	
	//For total amount
	if($('#totamt').val()=='')
	{
		$('#totamt').css('border','1px solid #E8573F');
 		$('#totamterr').html("This field is required.").slideDown('slow');
		$('#cnt4').val(0);
	}
	else if($.isNumeric($('#totamt').val())==false)
	{
		$('#totamt').css('border','1px solid #E8573F');
		$('#totamterr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt4').val(0);
	}
	else
	{
		//For perkilo meter
		$('#totamt').css('border','1px solid #8CC152');
		$('#totamterr').empty().slideUp('slow');
		$('#cnt4').val(1);
	}
	
	//For seats
	if($('#seat').val()=='')
	{
		$('#seat').css('border','1px solid #E8573F');
 		$('#seaterr').html("This field is required.").slideDown('slow');
		$('#cnt5').val(0);
	}
	else
	{
		//For perkilo meter
		$('#seat').css('border','1px solid #8CC152');
		$('#seaterr').empty().slideUp('slow');
		$('#cnt5').val(1);
		
	}
	
	//For extra charge
	if($('#permxkl').val()=='')
	{
		$('#permxkl').css('border','1px solid #E8573F');
 		$('#permxklerr').html("This field is required.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else if($.isNumeric($('#permxkl').val())==false)
	{
		$('#permxkl').css('border','1px solid #E8573F');
		$('#permxklerr').html("This is not number input give correct input format.").slideDown('slow');
		$('#cnt6').val(0);
	}
	else
	{
		//For perkilo meter
		$('#permxkl').css('border','1px solid #8CC152');
		$('#permxklerr').empty().slideUp('slow');
		$('#cnt6').val(1);
	}
	
	
	var totval;
	totval=	parseInt($('#cnt2').val())+parseInt($('#cnt3').val())+parseInt($('#cnt4').val())+parseInt($('#cnt5').val())+parseInt($('#cnt6').val())+parseInt($('#cnt1').val());

	if(totval==6)
	{
		 return true;
	}
	else
	{
		return false;
	}

}

//This is for remove row for entry form
function rediv(ss)
{ 
	var rm;
	rm=parseInt($('#cnupd').val());
	rm--;
	//$('#cnupd').val(rm);
	$('#upderow'+ss).remove();
}

//this is for remove row for update form
function remrow(ss)
{ 
	var rm;
	rm=parseInt($('#cnupd').val());
	rm--;
	//$('#cnupd').val(rm);
	$('#upderow'+ss).remove();
}

//this is for add row in update form
$('#addrowupd').click(function(e) {
    
	var type,cnt;
	type=4;
	cnt=parseInt($('#cnupd').val());
	cnt++;
		
	$.ajax({
	type : 'GET',
	url:"load_page.php",
	data: 'type='+type+'&cnt='+cnt,
	success: function(da)
	{
		$(da).insertAfter('#upderow1');
	
		$('.chosen-select').chosen({'width':'100%'});
		$('#cnupd').val(cnt);
		$('.tooltips').tooltip();
	}
		});
	
});
</script>                       