<html>
<?php
require_once('../Connections/divdb.php');

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

?>
<head>
	<!--<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
	
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
	
		<!-- MAIN CSS (REQUIRED ALL PAGE)-
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">-->
      
<style>

</style>

</head>



							<div class="panel panel-primary" >
                            
							  <div class="panel-heading" style="height:46px;">
                              <div class="right-content">
                              <table class="">
                              <tr><td style="padding-right:10px" width="201px">
                              <?php 
		$scity1 = $conn->prepare("SELECT * FROM dvi_cities where status='0'");
		$scity1->execute();
		//$row_scity1 = mysql_fetch_assoc($scity1);
		$row_scity1_main=$scity1->fetchAll();
		$tot_sccity1= $scity1->rowCount();
		?>
                              <select id="cyyy1" class="chosen-select" data-placeholder="-    Choose  DVI  Cities   -">
                              <option></option>
                              <?php foreach($row_scity1_main as $row_scity1) {?>
                              <option style="color:#666" value="<?php echo $row_scity1['id'];?>"><?php echo $row_scity1['name'];?></option>
                              <?php }?>
                              </select>
                              </td>
                              <td style="padding-right:10px" width="201px">
                              <?php 
		$scity2 = $conn->prepare("SELECT * FROM dvi_cities where status='0'");
		$scity2->execute();
		//$row_scity2 = mysql_fetch_assoc($scity2);
		$row_scity2_main=$scity2->fetchAll();
		$tot_sccity2= $scity2->rowCount();
		?>
                              <select id="cyyy2" class="chosen-select" data-placeholder="-    Choose DVI Cities   -"  >
                              <option></option>
                              <?php foreach($row_scity2_main as $row_scity2) {?>
                              <option style="color:#666" value="<?php echo $row_scity2['id'];?>"><?php echo $row_scity2['name'];?></option>
                              <?php }?>
                              </select>
                              </td>
                              <td style="padding-right:10px">
                               <a class="btn btn-sm " style="background-color:#40A98F; color:#FFF; font-weight:600" id="search"  onClick="scroll_fun()" ><i class="fa fa-search"></i>&nbsp;search</a>
                               </td>
                               </table>
                              </div>
                             
								<h3 class="panel-title"><i class="fa fa-map-marker"></i> Update - City Distance ( In KMs )</h3>
                              
							  </div>
                              
							  <div class="panel-body"><!--  style="width:1200px; height:450px; overflow:scroll;"-->
								<div class="row">
							<div class="col-sm-12" >
                            <?php
		$city = $conn->prepare("SELECT * FROM dvi_cities where status='0'");
		$city->execute();
		//$row_city = mysql_fetch_assoc($city);
		$row_city_main=$city->fetchAll();
		$tot_ccity= $city->rowCount();
						$city_cnt=0;
						$city_arr=array();	
						if($tot_ccity>0)
						{
							?>
                            <div id="main_div" style="width:auto; height:490px; overflow:scroll" class="scroll-nav-dropdown" >
								 <table class="table table-responsive" >
                                 <thead>
                                 <tr>
                                 <th style=" background-color:#F4EBD8; color:#F30;">Cities</th>
                                 <?php foreach($row_city_main as $row_city) 
								 {?><th style=" background-color:#F4EBD8; color:#F30;">
                              <b class="tooltips" data-original-title="<?php echo "City ID : ".$row_city['id'];?> " data-placement="bottom"> <?php echo $row_city['name'];  ?></b>
                                 </th>
                                 <?php 
								 $city_arr[$city_cnt]=$row_city['name'];
								 $city_cnt++; }?>
                                 </tr>
                                 </thead>
                                 <tbody>
                                  <?php
		
		$city1 = $conn->prepare("SELECT * FROM dvi_cities where status='0'");
		$city1->execute();
		//$row_city1 = mysql_fetch_assoc($city1);
		$row_city1_main=$city1->fetchAll();
							foreach($row_city1_main as $row_city1){
								
		
		$dist = $conn->prepare("SELECT * FROM dvi_citydist where from_cityid=?");
		$dist->execute(array($row_city1['id']));
		//$row_dist = mysql_fetch_assoc($dist);
		$row_dist_main=$dist->fetchAll();
		$tot_dist= $dist->rowCount();
		$hcnt=0;
								?>  <tr id="tr_<?php echo $row_city1['id']; ?>">
                                <td> <a href="javascript:void(0);" class="tooltips" data-original-title="<?php echo "City ID : ".$row_city1['id'];?> " style="text-decoration:none; color:#333;" ><?php echo $row_city1['name'];?></a></td>
                                <?php
								foreach($row_dist_main as $row_dist)
								{
									?><td >
                                <center><label id="lab_<?php echo $row_dist['sno'];?>" class="tooltips" data-original-title="<?php echo "From ".$row_city1['name']." -To ".$city_arr[$hcnt];?> " style="width:100px;" onDblClick="show_dist('<?php echo $row_dist['sno'];?>')"><?php echo $row_dist['dist'];?></label></center>
								<input id="txt_<?php echo $row_dist['sno'];?>" class=" tooltips" data-original-title="<?php echo "From ".$row_city1['name']." -To ".$city_arr[$hcnt];?>" type="text" value="<?php echo $row_dist['dist'];?>" style="width:55px;display:none;">
                                <a id="up_<?php echo $row_dist['sno'];?>" href="javascript:void(0);" onClick="update_dist('<?php echo $row_dist['sno'];?>')" style="display:none;" >&nbsp;<i class="fa fa-check-square" style="font-size: 20px; color:#060"></i></a>
                                <a id="can_<?php echo $row_dist['sno'];?>"  href="javascript:void(0);" onClick="cancel_update('<?php echo $row_dist['sno'];?>')" style="display:none;"><i class="fa fa-times-circle" style="font-size: 20px; color:#C00"></i></a>	

                                </td>
								<?php $hcnt++;} 
								$rem=$city_cnt-$tot_dist;
								/*for($ds=0;$ds<$rem;$ds++)//for start - unwanted td
								{*/
								?>
                                <td colspan="<?php echo $rem; ?>">&nbsp;</td>
                                <?php // }//for end - unwanted td?>
                                </tr>
                                 <?php } ?>
                                 </tbody>
                                 </table>
                                 <input type="hidden" value="1" id="prev_sno">
                                                                  </div>
                                 
                                 <?php }else {?>
                                 <center><strong style="color:#CCC; font-size:24px">No Entry Found</strong></center>
                                 <?php }?>
                                 
                                </div>
							  </div>
							</div><!-- /.panel panel-default -->
						</div>
                       

         
                        
                     <!--  <script src="../core/assets/js/jquery.min.js"></script>-->
                        
                        <!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)--
		
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
		<!-- PLUGINS --
		<script src="../core/assets/plugins/chosen/chosen.jquery.min.js"></script>
	
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
        
		<!-- MAIN APPS JS --
		<script src="../core/assets/js/apps.js"></script>
		<script src="../core/assets/js/demo-panel-1.js"></script>-->
         
<script>

$(document).ready(function(e) {
    $('.scroll-nav-dropdown').niceScroll({
		cursorcolor: "#CCC",
		cursorborder: "3px solid #CCC",
		cursorborderradius: "10px",
		cursorwidth: "2px"
	});
});

$('.tooltips').tooltip({});
$('.chosen-select').chosen({width : '100%'});

function scroll_fun()
{
	var pre=$('#prev_sno').val();
	$('#lab_'+pre).css('background-color','#FFF');
	$('#txt'+pre).css('background-color','#FFF');
	
	$('#main_div').animate({
                        scrollTop: $('#lab_1').offset().top-100
                    }, 10);
		
		$('#main_div').animate({
                        scrollLeft: $('#lab_1').offset().left
                    }, 10);
	
	var rno;
	var sno1=$('#cyyy1 option:selected').val();
	var sno2=$('#cyyy2 option:selected').val();
	var ty=6;
	$.get('ADMIN/ajax_others.php?sno1='+sno1+'&sno2='+sno2+'&type='+ty,function(result)
	{
		//alert(result.trim());
		rno=result.trim();
		
		$('#main_div').animate({
                        scrollTop: $('#lab_'+rno).offset().top-100
                    }, 1000);
		
		$('#main_div').animate({
                        scrollLeft: $('#lab_'+rno).offset().left
                    }, 1000);
		
					
					$('#lab_'+rno).css('background-color','#FCC');
					$('#txt'+rno).css('background-color','#FCC');
					$('#prev_sno').val(rno);
	});
	
	
				
}

function cancel_update(sno)
{
	$('#lab_'+sno).show();
	$('#txt_'+sno).hide();
	$('#up_'+sno).hide();
	$('#can_'+sno).hide();
	$('#lab_'+sno).css('background-color','#FFF');
	$('#txt'+sno).css('background-color','#FFF');
	
}

function update_dist(sno)
{
	var dist=$('#txt_'+sno).val();
	var ty=5;
	$.get('ADMIN/ajax_others.php?sno='+sno+'&dist='+dist+'&type='+ty,function(result)
	{
		//alert(result);
		$('#txt_'+sno).hide();
		$('#up_'+sno).hide();
		$('#can_'+sno).hide();
		$('#lab_'+sno).empty().prepend(dist);
		$('#lab_'+sno).show();
		$('#lab_'+sno).css('background-color','#FFF');
		$('#txt'+sno).css('background-color','#FFF');
	
	});
}

function show_dist(sno)
{
$('#lab_'+sno).hide();
$('#txt_'+sno).show();
$('#up_'+sno).show();
$('#can_'+sno).show();
}

</script>                        

</html>
                        