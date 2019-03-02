<style>
body {
    background-position: 50% 50%;
    margin:0px;
    padding:0px !important;
}
</style>

<html>
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
        <script src="../core/assets/js/jquery.min.js"></script>
</head>        
      <body>

<?php 
require_once('../Connections/divdb.php');
$typ=$_GET['typ'];
$hotel_id=$_GET['hid'];


$season = $conn->prepare("SELECT * FROM hotel_food where hotel_id=? and status = '0'");
$season->execute(array($hotel_id));
print ($hotel_id);
$row_season = $season->fetch(PDO::FETCH_ASSOC);	
$tot_season	= $season->rowCount();

$hotel = $conn->prepare("SELECT * FROM hotel_pro where hotel_id=? and status = '0'");
$hotel->execute(array($hotel_id));
$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);


$upd_hiphen = '0\\0\\0\\0\\0\\0\\0\\0\\0';
//$upd_hiphen = '-\\-\\-\\-\\-\\-\\-\\-\\-';
$upd_flwbed = '';
if (isset($_POST["update_flwbed"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_flwbed.= $_POST['season'.$s.'a']."\\";
	}
	$upd_all = rtrim($upd_flwbed,'\\');
	
	
	$update_flowbed=$conn->prepare("update hotel_food set flower_bed =? where hotel_id=?");
	$update_flowbed->execute(array($upd_all,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
	

}
	
if (isset($_POST["remove_flwbed"])) 
{
	
	
	$rem_flowbed=$conn->prepare("update hotel_food set flower_bed =? where hotel_id=?");
	$rem_flowbed->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>";*/ 
	/*echo "<script>parent.jQuery.fancybox.close();</script>";*/
	echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

$upd_cak = '';
if (isset($_POST["update_cake"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_cak.= $_POST['season'.$s.'b']."\\";
	}
	$upd_allc = rtrim($upd_cak,'\\');
	
	
	$update_cake=$conn->prepare("update hotel_food set cake_rate =? where hotel_id=?");
	$update_cake->execute(array($upd_allc,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";

}
	
if (isset($_POST["remove_cake"])) 
{
	
	$rem_cak=$conn->prepare("update hotel_food set cake_rate =? where hotel_id=?");
	$rem_cak->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>"; */
	/*echo "<script>parent.jQuery.fancybox.close();</script>";*/
	echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

$upd_candl = '';
if (isset($_POST["update_candl"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_candl.= $_POST['season'.$s.'c']."\\";
	}
	$upd_allcn = rtrim($upd_candl,'\\');
	
	
	$update_candl=$conn->prepare("update hotel_food set candle_light =? where hotel_id=?");
	$update_candl->execute(array($upd_allcn,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";

}
	
if (isset($_POST["remove_candl"])) 
{
	
	$rem_candl=$conn->prepare("update hotel_food set candle_light =? where hotel_id=?");
	$rem_candl->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>"; */
	/*echo "<script>parent.jQuery.fancybox.close();</script>";*/
	echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

$upd_fruit = '';
if (isset($_POST["update_fruit"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_fruit.= $_POST['season'.$s.'d']."\\";
	}
	$upd_allf = rtrim($upd_fruit,'\\');
	
	
	$update_fruit=$conn->prepare("update hotel_food set fruit_basket =? where hotel_id=?");
	$update_fruit->execute(array($upd_allf,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}
	
if (isset($_POST["remove_fruit"])) 
{
	
	$rem_fruit=$conn->prepare("update hotel_food set fruit_basket =? where hotel_id=?");
	$rem_fruit->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>"; */
	/*echo "<script>parent.jQuery.fancybox.close();</script>";*/
	echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

$upd_lunch = '';
if (isset($_POST["update_lunch"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_lunch.= $_POST['season'.$s.'e']."\\";
	}
	$upd_alll = rtrim($upd_lunch,'\\');
	
	
	$update_lunch=$conn->prepare("update hotel_food set lunch_rate =? where hotel_id=?");
	$update_lunch->execute(array($upd_alll,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}
	
if (isset($_POST["remove_lunch"])) 
{
	
	$rem_lunch=$conn->prepare("update hotel_food set lunch_rate =? where hotel_id=?");
	$rem_lunch->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>"; */
	/*echo "<script>parent.jQuery.fancybox.close();</script>";*/
		echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

$upd_dinner = '';
if (isset($_POST["update_dinner"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_dinner.= $_POST['season'.$s.'f']."\\";
	}
	$upd_alld = rtrim($upd_dinner,'\\');
	
	
	$update_dinner=$conn->prepare("update hotel_food set dinner_rate =? where hotel_id=?");
	$update_dinner->execute(array($upd_alld,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}
	
if (isset($_POST["remove_dinner"])) 
{
	
	$rem_dinner=$conn->prepare("update hotel_food set dinner_rate =? where hotel_id=?");
	$rem_dinner->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>"; */
	/*echo "<script>parent.jQuery.fancybox.close();</script>";*/
		echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

$upd_withbed = '';
if (isset($_POST["update_withbed"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_withbed.= $_POST['season'.$s.'f']."\\";
	}
	$upd_alld = rtrim($upd_withbed,'\\');
	
	
	$update_withbed=$conn->prepare("update hotel_food set child_with_bed =? where hotel_id=?");
	$update_withbed->execute(array($upd_alld,$hotel_id));

	
	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}
	
$upd_hiphen = '0\\0\\0\\0\\0\\0\\0\\0\\0';
if (isset($_POST["remove_withbed"])) 
{
	
	$rem_withbed=$conn->prepare("update hotel_food set child_with_bed =? where hotel_id=?");
	$rem_withbed->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>"; */
	echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
	
}

$upd_withoutbed = '';
if (isset($_POST["update_withoutbed"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_withoutbed.= $_POST['season'.$s.'f']."\\";
	}
	$upd_alld = rtrim($upd_withoutbed,'\\');
	
	
	$update_withbed=$conn->prepare("update hotel_food set child_without_bed =? where hotel_id=?");
	$update_withbed->execute(array($upd_alld,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}
	
$upd_hiphen = '0\\0\\0\\0\\0\\0\\0\\0\\0';
if (isset($_POST["remove_withoutbed"])) 
{
	
	$rem_withoutbed=$conn->prepare("update hotel_food set child_without_bed =? where hotel_id=?");
	$rem_withoutbed->execute(array($upd_hiphen,$hotel_id));

	/*echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(1)."';</script>";*/ 
	/*echo "<script>parent.jQuery.fancybox.close();</script>";*/
		echo "<script>alert('Successully Emptied');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}

if ($typ == '1')
{	
	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();					
?>
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - FLOWER BED DECORATION"; 
									
									$flowerbed_dec = explode('\\',$row_season['flower_bed']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id1" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun1()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_form1" method="post">
                                         <button id="remove_id1"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_flwbed" value="remove_room_val" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								
								</h3>
							  </div> 
                           <form name="update_form1" role="form" method="post">   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							
							<?php
							foreach($row_seashotel_main as $row_seashotel)
	{	
	$sno = $row_seashotel['sno'];
	if($tot_season){
$flower_bed_str = $row_season['flower_bed'];
$flower_bed_arr=@unserialize(base64_decode($flower_bed_str));
if(!is_array($flower_bed_arr)){
	$flower_bed_arr[0]=600;
	}
	$flower_bed_arr_keys = array_keys($flower_bed_arr);
	
	}
if(in_array($sno,$flower_bed_arr_keys)){
	

	?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    
									
										  <label >Season 1 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                      
                                    
                                    
                                   
                                    
                                 <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flower_bed_arr[$sno]; ?></label>
					<input type="text" name="season1a" id="edit_season1a" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $flower_bed_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php
}
elseif($typ == '2')
{
	
	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	
			$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();

		//print_r($row_seashotel_main);			
	
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - CAKE"; 
									
									$exp_cake = explode('\\',$row_season['cake_rate']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id2" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun2()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_cake" method="post">
                                         <button id="remove_id2"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_cake" value="remove_room_val" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								
								</h3>
							  </div> 
                           <form name="update_cake" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							<?php
							foreach($row_seashotel_main as $row_seashotel)
	{	
	$sno = $row_seashotel['sno'];
	if($tot_season){
$cake_rate_str = $row_season['cake_rate'];
$cake_rate_arr=@unserialize(base64_decode($cake_rate_str));
if(!is_array($cake_rate_arr)){
	$cake_rate_arr[0]=600;
	}
	$cake_rate_arr_keys = array_keys($cake_rate_arr);
	
	}
if(in_array($sno,$cake_rate_arr_keys)){
	

	?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php  ?>
										  <label >Season 1 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
										<div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $cake_rate_arr[$sno]; ?></label>
					<input type="text" name="season1a" id="edit_season1a" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $cake_rate_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php
}
elseif($typ == '3')
{
	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();
//print_r($row_season);	
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - CANDLE LIGHT"; 
									
									$exp_candl = explode('\\',$row_season['candle_light']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id3" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun3()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_candl" method="post">
                                         <button id="remove_id3"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_candl" value="remove_room_val3" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								
								</h3>
							  </div> 
                           <form name="update_candl" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							
							<?php
							foreach($row_seashotel_main as $row_seashotel)
	{	
	$sno = $row_seashotel['sno'];
	if($tot_season){
$candle_light_str = $row_season['candle_light'];
$candle_light_arr=@unserialize(base64_decode($candle_light_str));
if(!is_array($candle_light_arr)){
	$candle_light_arr[0]=600;
	}
	$candle_light_arr_keys = array_keys($candle_light_arr);
	
	}
if(in_array($sno,$candle_light_arr_keys)){
	

	?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    
										  <label >Season 1 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                 <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $candle_light_arr[$sno]; ?></label>
					<input type="text" name="season1a" id="edit_season1a" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $candle_light_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php
}
elseif($typ == '4')
{
	
	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();
	
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - FRUIT BASKET"; 
									
									$exp_fruit = explode('\\',$row_season['fruit_basket']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id4" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun4()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_fruit" method="post">
                                         <button id="remove_id4"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_fruit" value="remove_room_val4" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								
								</h3>
							  </div> 
                           <form name="update_fruit" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
                                   
<?php
							foreach($row_seashotel_main as $row_seashotel)
	{	
	$sno = $row_seashotel['sno'];
	if($tot_season){
$fruit_basket_str = $row_season['fruit_basket'];
$fruit_basket_arr=@unserialize(base64_decode($fruit_basket_str));
if(!is_array($fruit_basket_arr)){
	$fruit_basket_arr[0]=600;
	}
	$fruit_basket_arr_keys = array_keys($fruit_basket_arr);
	
	}
if(in_array($sno,$fruit_basket_arr_keys)){
	

	?>
								   <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                   
										  <label >Season 1 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                       
                                 <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $fruit_basket_arr[$sno]; ?></label>
					<input type="text" name="season1a" id="edit_season1a" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $fruit_basket_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php
}
elseif($typ == '5')
{
	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - LUNCH"; 
									
									$exp_lunch = explode('\\',$row_season['lunch_rate']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id5" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun5()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_lunch" method="post">
                                         <button id="remove_id5"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_lunch" value="remove_room_val5" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								</h3>
							  </div> 

                           <form name="update_lunch" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							
							<?php $i=0;
							foreach($row_seashotel_main as $row_seashotel)
	{	
	
	$sno = $row_seashotel['sno'];
	if($tot_season){
$lunch_rate_str = $row_season['lunch_rate'];
$lunch_rate_arr=@unserialize(base64_decode($lunch_rate_str));
if(!is_array($lunch_rate_arr)){
	$lunch_rate_arr[0]=600;
	}
	$lunch_rate_arr_keys = array_keys($lunch_rate_arr);
	
	}
if(in_array($sno,$lunch_rate_arr_keys)){
	$i++;
//print $row_seashotel['from_date'];
//print strtotime($row_seashotel['from_date']);
//print date("d-M-Y",strtotime($row_seashotel['from_date']));
	?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    
										  <label >Season <?php echo $i;?> Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                 <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season<?php echo $i;?>_id<?php echo $i;?>" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $lunch_rate_arr[$sno]; ?></label>
					<input type="text" name="season<?php echo $i;?>a" id="edit_season<?php echo $i;?>a" class="form-control"  placeholder="Season <?php echo $i;?> Rate" value="<?php echo $lunch_rate_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php
}
elseif($typ == '6')
{	

	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - DINNER"; 
									
									$exp_dinner = explode('\\',$row_season['dinner_rate']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id6" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun6()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_dinner" method="post">
                                         <button id="remove_id6"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_dinner" value="remove_room_val6" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								</h3>
							  </div> 

                           <form name="update_lunch" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							
							<?php
							foreach($row_seashotel_main as $row_seashotel)
	{	
	$sno = $row_seashotel['sno'];
	if($tot_season){
$dinner_rate_str = $row_season['dinner_rate'];
$dinner_rate_arr=@unserialize(base64_decode($dinner_rate_str));
if(!is_array($dinner_rate_arr)){
	$dinner_rate_arr[0]=600;
	}
	$dinner_rate_arr_keys = array_keys($dinner_rate_arr);
	
	}
if(in_array($sno,$dinner_rate_arr_keys)){
	

	?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                   
										  <label >Season 1 Rate 
	<br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                 <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $dinner_rate_arr[$sno]; ?></label>
					<input type="text" name="season1a" id="edit_season1a" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $dinner_rate_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php

}elseif($typ == '7')
{	

	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - WithBedRate"; 
									
									$exp_withbed = explode('\\',$row_season['child_with_bed']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id7" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun7()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_dinner" method="post">
                                         <button id="remove_id7"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_withbed" value="remove_room_val7" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								</h3>
							  </div> 

                           <form name="update_withbed" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							
							<?php
							foreach($row_seashotel_main as $row_seashotel)
	{	
	$sno = $row_seashotel['sno'];
	if($tot_season){
$child_with_bed_str = $row_season['child_with_bed'];
$child_with_bed_arr=@unserialize(base64_decode($child_with_bed_str));
if(!is_array($child_with_bed_arr)){
	$child_with_bed_arr[0]=600;
	}
	$child_with_bed_arr_keys = array_keys($child_with_bed_arr);
	
	}
if(in_array($sno,$child_with_bed_arr_keys)){
	

	?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    
										  <label >Season 1 Rate 
	<br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                 <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $child_with_bed_arr[$sno]; ?></label>
					<input type="text" name="season1a" id="edit_season1a" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $child_with_bed_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php

}elseif($typ == '8')
{	

	$seashotel = $conn->prepare("SELECT * FROM setting_season");
	$seashotel->execute();
	//$row_seashotel = mysql_fetch_assoc($seashotel);
	$row_seashotel_main=$seashotel->fetchAll();
$totalRows_distr  = $seashotel->rowCount();
?>
<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-primary">
							 <div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $row_hotel['hotel_name']." - ChildWithOutBed Rate"; 
									
									$exp_withoutbed = explode('\\',$row_season['child_without_bed']);
									
									?>&nbsp; rates 
									<span class="right-content">
									<button id="edit_id8" class="btn btn-primary  btn-rounded-lg dropdown-toggle" onClick="edit_fun8()" data-toggle="dropdown">
										<i class="fa fa-cog"></i>&nbsp;Edit
										</button>
                                        <form name="remove_withoutbed" method="post">
                                         <button id="remove_id8"  type="submit" style="display:none;"  class="btn btn-primary  btn-rounded-lg dropdown-toggle"  name="remove_withoutbed" value="remove_room_val8" >
										<i class="fa fa-trash-o"></i>&nbsp;Remove
										</button>
                                        	</form>								
                                        </span>
								</h3>
							  </div> 

                           <form name="update_withoutbed" role="form"  method="post" >   
							  <div class="panel-body">
								<div class="row">
							<div class="col-sm-12">
							
							<?php
							$i=0;
							foreach($row_seashotel_main as $row_seashotel)
	{	
	$i++;
	$sno = $row_seashotel['sno'];
	if($tot_season){
$child_without_bed_str = $row_season['child_without_bed'];
$child_without_bed_arr=@unserialize(base64_decode($child_without_bed_str));
if(!is_array($child_without_bed_arr)){
	$child_without_bed_arr[0]=600;
	}
	$child_without_bed_arr_keys = array_keys($child_without_bed_arr);
	
	}
if(in_array($sno,$child_without_bed_arr_keys)){
	

	?>
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    
										  <label >Season <?php echo $i;?> Rate 
	<br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                 <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season<?php echo $i;?>_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $child_without_bed_arr[$sno]; ?></label>
					<input type="text" name="season<?php echo $i;?>a" id="edit_season<?php echo $i;?>a" class="form-control"  placeholder="Season <?php echo $i;?> Rate" value="<?php echo $child_without_bed_arr[$sno]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                       </div> 
	<?php }

} ?>
                                
                                </div>
                                </div>
							  </div><!-- /.panel-body -->
							  <!--<div class="panel-footer">Panel footer</div>-->
							</div><!-- /.panel panel-default -->
                            </form>
						</div>
                        </div>
                        </div>
<?php

}
?>
 </body>    
 </html>    
 
 <script>
 function edit_fun1()
 {
	$('#season1_id1').hide(1000);
	$('#edit_season1a').show(1000);
	
	$('#season2_id1').hide(1000);
	$('#edit_season2a').show(1000);
	
	$('#season3_id1').hide(1000);
	$('#edit_season3a').show(1000);
	
	$('#season4_id1').hide(1000);
	$('#edit_season4a').show(1000);
	
	$('#season5_id1').hide(1000);
	$('#edit_season5a').show(1000);
	
	$('#season6_id1').hide(1000);
	$('#edit_season6a').show(1000);
	
	$('#season7_id1').hide(1000);
	$('#edit_season7a').show(1000);
	
	$('#season8_id1').hide(1000);
	$('#edit_season8a').show(1000);
	
	$('#season9_id1').hide(1000);
	$('#edit_season9a').show(1000);
	
	$('#remove_id11').show(1000);
	$('#update_id1').show(1000);
	$('#cancel_id1').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id1').hide(1000);
 }
 
 
 function cancel_edit1()
 {
	$('#edit_season1a').hide(1000);
	$('#season1_id1').show(1000);
	
	$('#edit_season2a').hide(1000);
	$('#season2_id1').show(1000);
	
	$('#edit_season3a').hide(1000);
	$('#season3_id1').show(1000);
	
	$('#edit_season4a').hide(1000);
	$('#season4_id1').show(1000);
	
	$('#edit_season5a').hide(1000);
	$('#season5_id1').show(1000);
	
	$('#edit_season6a').hide(1000);
	$('#season6_id1').show(1000);
	
	$('#edit_season7a').hide(1000);
	$('#season7_id1').show(1000);
	
	$('#edit_season8a').hide(1000);
	$('#season8_id1').show(1000);
	
	$('#edit_season9a').hide(1000);
	$('#season9_id1').show(1000);
	
	$('#remove_id1').hide(1000);
	$('#update_id1').hide(1000);
	$('#cancel_id1').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id1').show(1000);
	 
 }
 </script>
 
 <script>
 function edit_fun2()
 {
	$('#season1_id2').hide(1000);
	$('#edit_season1b').show(1000);
	
	$('#season2_id2').hide(1000);
	$('#edit_season2b').show(1000);
	
	$('#season3_id2').hide(1000);
	$('#edit_season3b').show(1000);
	
	$('#season4_id2').hide(1000);
	$('#edit_season4b').show(1000);
	
	$('#season5_id2').hide(1000);
	$('#edit_season5b').show(1000);
	
	$('#season6_id2').hide(1000);
	$('#edit_season6b').show(1000);
	
	$('#season7_id2').hide(1000);
	$('#edit_season7b').show(1000);
	
	$('#season8_id2').hide(1000);
	$('#edit_season8b').show(1000);
	
	$('#season9_id2').hide(1000);
	$('#edit_season9b').show(1000);
	
	$('#remove_id2').show(1000);
	$('#update_id2').show(1000);
	$('#cancel_id2').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id2').hide(1000);
 }
 
 
 function cancel_edit2()
 {
	$('#edit_season1b').hide(1000);
	$('#season1_id2').show(1000);
	
	$('#edit_season2b').hide(1000);
	$('#season2_id2').show(1000);
	
	$('#edit_season3b').hide(1000);
	$('#season3_id2').show(1000);
	
	$('#edit_season4b').hide(1000);
	$('#season4_id2').show(1000);
	
	$('#edit_season5b').hide(1000);
	$('#season5_id2').show(1000);
	
	$('#edit_season6b').hide(1000);
	$('#season6_id2').show(1000);
	
	$('#edit_season7b').hide(1000);
	$('#season7_id2').show(1000);
	
	$('#edit_season8b').hide(1000);
	$('#season8_id2').show(1000);
	
	$('#edit_season9b').hide(1000);
	$('#season9_id2').show(1000);
	
	$('#remove_id2').hide(1000);
	$('#update_id2').hide(1000);
	$('#cancel_id2').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id2').show(1000);
	 
 }
 </script>
 
 <script>
 function edit_fun3()
 {
	$('#season1_id3').hide(1000);
	$('#edit_season1c').show(1000);
	
	$('#season2_id3').hide(1000);
	$('#edit_season2c').show(1000);
	
	$('#season3_id3').hide(1000);
	$('#edit_season3c').show(1000);
	
	$('#season4_id3').hide(1000);
	$('#edit_season4c').show(1000);
	
	$('#season5_id3').hide(1000);
	$('#edit_season5c').show(1000);
	
	$('#season6_id3').hide(1000);
	$('#edit_season6c').show(1000);
	
	$('#season7_id3').hide(1000);
	$('#edit_season7c').show(1000);
	
	$('#season8_id3').hide(1000);
	$('#edit_season8c').show(1000);
	
	$('#season9_id3').hide(1000);
	$('#edit_season9c').show(1000);
	
	$('#remove_id3').show(1000);
	$('#update_id3').show(1000);
	$('#cancel_id3').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id3').hide(1000);
 }
 
 
 function cancel_edit3()
 {
	$('#edit_season1c').hide(1000);
	$('#season1_id3').show(1000);
	
	$('#edit_season2c').hide(1000);
	$('#season2_id3').show(1000);
	
	$('#edit_season3c').hide(1000);
	$('#season3_id3').show(1000);
	
	$('#edit_season4c').hide(1000);
	$('#season4_id3').show(1000);
	
	$('#edit_season5c').hide(1000);
	$('#season5_id3').show(1000);
	
	$('#edit_season6c').hide(1000);
	$('#season6_id3').show(1000);
	
	$('#edit_season7c').hide(1000);
	$('#season7_id3').show(1000);
	
	$('#edit_season8c').hide(1000);
	$('#season8_id3').show(1000);
	
	$('#edit_season9c').hide(1000);
	$('#season9_id3').show(1000);
	
	$('#remove_id3').hide(1000);
	$('#update_id3').hide(1000);
	$('#cancel_id3').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id3').show(1000);
	 
 }
 </script>
 
 <script>
 function edit_fun4()
 {
	$('#season1_id4').hide(1000);
	$('#edit_season1d').show(1000);
	
	$('#season2_id4').hide(1000);
	$('#edit_season2d').show(1000);
	
	$('#season3_id4').hide(1000);
	$('#edit_season3d').show(1000);
	
	$('#season4_id4').hide(1000);
	$('#edit_season4d').show(1000);
	
	$('#season5_id4').hide(1000);
	$('#edit_season5d').show(1000);
	
	$('#season6_id4').hide(1000);
	$('#edit_season6d').show(1000);
	
	$('#season7_id4').hide(1000);
	$('#edit_season7d').show(1000);
	
	$('#season8_id4').hide(1000);
	$('#edit_season8d').show(1000);
	
	$('#season9_id4').hide(1000);
	$('#edit_season9d').show(1000);
	
	$('#remove_id4').show(1000);
	$('#update_id4').show(1000);
	$('#cancel_id4').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id4').hide(1000);
 }
 
 
 function cancel_edit4()
 {
	$('#edit_season1d').hide(1000);
	$('#season1_id4').show(1000);
	
	$('#edit_season2d').hide(1000);
	$('#season2_id4').show(1000);
	
	$('#edit_season3d').hide(1000);
	$('#season3_id4').show(1000);
	
	$('#edit_season4d').hide(1000);
	$('#season4_id4').show(1000);
	
	$('#edit_season5d').hide(1000);
	$('#season5_id4').show(1000);
	
	$('#edit_season6d').hide(1000);
	$('#season6_id4').show(1000);
	
	$('#edit_season7d').hide(1000);
	$('#season7_id4').show(1000);
	
	$('#edit_season8d').hide(1000);
	$('#season8_id4').show(1000);
	
	$('#edit_season9d').hide(1000);
	$('#season9_id4').show(1000);
	
	$('#remove_id4').hide(1000);
	$('#update_id4').hide(1000);
	$('#cancel_id4').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id4').show(1000);
	 
 }
 </script>
 
 <script>
 function edit_fun5()
 {
	$('#season1_id5').hide(1000);
	$('#edit_season1e').show(1000);
	
	$('#season2_id5').hide(1000);
	$('#edit_season2e').show(1000);
	
	$('#season3_id5').hide(1000);
	$('#edit_season3e').show(1000);
	
	$('#season4_id5').hide(1000);
	$('#edit_season4e').show(1000);
	
	$('#season5_id5').hide(1000);
	$('#edit_season5e').show(1000);
	
	$('#season6_id5').hide(1000);
	$('#edit_season6e').show(1000);
	
	$('#season7_id5').hide(1000);
	$('#edit_season7e').show(1000);
	
	$('#season8_id5').hide(1000);
	$('#edit_season8e').show(1000);
	
	$('#season9_id5').hide(1000);
	$('#edit_season9e').show(1000);
	
	$('#remove_id5').show(1000);
	$('#update_id5').show(1000);
	$('#cancel_id5').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id5').hide(1000);
 }
 
 
 function cancel_edit5()
 {
	$('#edit_season1e').hide(1000);
	$('#season1_id5').show(1000);
	
	$('#edit_season2e').hide(1000);
	$('#season2_id5').show(1000);
	
	$('#edit_season3e').hide(1000);
	$('#season3_id5').show(1000);
	
	$('#edit_season4e').hide(1000);
	$('#season4_id5').show(1000);
	
	$('#edit_season5e').hide(1000);
	$('#season5_id5').show(1000);
	
	$('#edit_season6e').hide(1000);
	$('#season6_id6').show(1000);
	
	$('#edit_season7e').hide(1000);
	$('#season7_id5').show(1000);
	
	$('#edit_season8e').hide(1000);
	$('#season8_id5').show(1000);
	
	$('#edit_season9e').hide(1000);
	$('#season9_id5').show(1000);
	
	$('#remove_id5').hide(1000);
	$('#update_id5').hide(1000);
	$('#cancel_id5').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id5').show(1000);
	 
 }
 </script>
 
 <script>
 function edit_fun6()
 {
	$('#season1_id6').hide(1000);
	$('#edit_season1f').show(1000);
	
	$('#season2_id6').hide(1000);
	$('#edit_season2f').show(1000);
	
	$('#season3_id6').hide(1000);
	$('#edit_season3f').show(1000);
	
	$('#season4_id6').hide(1000);
	$('#edit_season4f').show(1000);
	
	$('#season5_id6').hide(1000);
	$('#edit_season5f').show(1000);
	
	$('#season6_id6').hide(1000);
	$('#edit_season6f').show(1000);
	
	$('#season7_id6').hide(1000);
	$('#edit_season7f').show(1000);
	
	$('#season8_id6').hide(1000);
	$('#edit_season8f').show(1000);
	
	$('#season9_id6').hide(1000);
	$('#edit_season9f').show(1000);
	
	$('#remove_id6').show(1000);
	$('#update_id6').show(1000);
	$('#cancel_id6').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id6').hide(1000);
 }
 
 
 function cancel_edit6()
 {
	$('#edit_season1f').hide(1000);
	$('#season1_id6').show(1000);
	
	$('#edit_season2f').hide(1000);
	$('#season2_id6').show(1000);
	
	$('#edit_season3f').hide(1000);
	$('#season3_id6').show(1000);
	
	$('#edit_season4f').hide(1000);
	$('#season4_id6').show(1000);
	
	$('#edit_season5f').hide(1000);
	$('#season5_id6').show(1000);
	
	$('#edit_season6f').hide(1000);
	$('#season6_id6').show(1000);
	
	$('#edit_season7f').hide(1000);
	$('#season7_id6').show(1000);
	
	$('#edit_season8f').hide(1000);
	$('#season8_id6').show(1000);
	
	$('#edit_season9f').hide(1000);
	$('#season9_id6').show(1000);
	
	$('#remove_id6').hide(1000);
	$('#update_id6').hide(1000);
	$('#cancel_id6').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id6').show(1000);
	 
 }
 </script>
 
 <script>
 function edit_fun7()
 {
	$('#season1_id7').hide(1000);
	$('#edit_season1f').show(1000);
	
	$('#season2_id7').hide(1000);
	$('#edit_season2f').show(1000);
	
	$('#season3_id7').hide(1000);
	$('#edit_season3f').show(1000);
	
	$('#season4_id7').hide(1000);
	$('#edit_season4f').show(1000);
	
	$('#season5_id7').hide(1000);
	$('#edit_season5f').show(1000);
	
	$('#season6_id7').hide(1000);
	$('#edit_season6f').show(1000);
	
	$('#season7_id7').hide(1000);
	$('#edit_season7f').show(1000);
	
	$('#season8_id7').hide(1000);
	$('#edit_season8f').show(1000);
	
	$('#season9_id7').hide(1000);
	$('#edit_season9f').show(1000);
	
	$('#remove_id7').show(1000);
	$('#update_id7').show(1000);
	$('#cancel_id7').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id7').hide(1000);
 }
 
 
 function cancel_edit7()
 {
	$('#edit_season1f').hide(1000);
	$('#season1_id7').show(1000);
	
	$('#edit_season2f').hide(1000);
	$('#season2_id7').show(1000);
	
	$('#edit_season3f').hide(1000);
	$('#season3_id7').show(1000);
	
	$('#edit_season4f').hide(1000);
	$('#season4_id7').show(1000);
	
	$('#edit_season5f').hide(1000);
	$('#season5_id7').show(1000);
	
	$('#edit_season6f').hide(1000);
	$('#season6_id7').show(1000);
	
	$('#edit_season7f').hide(1000);
	$('#season7_id7').show(1000);
	
	$('#edit_season8f').hide(1000);
	$('#season8_id7').show(1000);
	
	$('#edit_season9f').hide(1000);
	$('#season9_id7').show(1000);
	
	$('#remove_id7').hide(1000);
	$('#update_id7').hide(1000);
	$('#cancel_id7').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id7').show(1000);
	 
 }
 </script>
 
 <script>
 function edit_fun8()
 {
	$('#season1_id8').hide(1000);
	$('#edit_season1f').show(1000);
	
	$('#season2_id8').hide(1000);
	$('#edit_season2f').show(1000);
	
	$('#season3_id8').hide(1000);
	$('#edit_season3f').show(1000);
	
	$('#season4_id8').hide(1000);
	$('#edit_season4f').show(1000);
	
	$('#season5_id8').hide(1000);
	$('#edit_season5f').show(1000);
	
	$('#season6_id8').hide(1000);
	$('#edit_season6f').show(1000);
	
	$('#season7_id8').hide(1000);
	$('#edit_season7f').show(1000);
	
	$('#season8_id8').hide(1000);
	$('#edit_season8f').show(1000);
	
	$('#season9_id8').hide(1000);
	$('#edit_season9f').show(1000);
	
	$('#remove_id8').show(1000);
	$('#update_id8').show(1000);
	$('#cancel_id8').show(1000);
	$('#note_id').hide(1000);
	$('#edit_id8').hide(1000);
 }
 
 
 function cancel_edit8()
 {
	$('#edit_season1f').hide(1000);
	$('#season1_id8').show(1000);
	
	$('#edit_season2f').hide(1000);
	$('#season2_id8').show(1000);
	
	$('#edit_season3f').hide(1000);
	$('#season3_id8').show(1000);
	
	$('#edit_season4f').hide(1000);
	$('#season4_id8').show(1000);
	
	$('#edit_season5f').hide(1000);
	$('#season5_id8').show(1000);
	
	$('#edit_season6f').hide(1000);
	$('#season6_id8').show(1000);
	
	$('#edit_season7f').hide(1000);
	$('#season7_id8').show(1000);
	
	$('#edit_season8f').hide(1000);
	$('#season8_id8').show(1000);
	
	$('#edit_season9f').hide(1000);
	$('#season9_id8').show(1000);
	
	$('#remove_id8').hide(1000);
	$('#update_id8').hide(1000);
	$('#cancel_id8').hide(1000);
	$('#note_id').show(1000);
	$('#edit_id8').show(1000);
	 
 }
 </script>
                               
                        
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