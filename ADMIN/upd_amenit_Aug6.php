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


$season = $conn->prepare("SELECT * FROM hotel_food where hotel_id=? and status = 0");
$season->execute(array($hotel_id));
$row_season = $season->fetch(PDO::FETCH_ASSOC);	
	
$hotel = $conn->prepare("SELECT * FROM hotel_pro where hotel_id=? and status = '0'");
$hotel->execute(array($hotel_id));
$row_hotel = $hotel->fetch(PDO::FETCH_ASSOC);


$upd_hiphen = '0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0';
//$upd_hiphen = '-\\\\-\\\\-\\\\-\\\\-\\\\-\\\\-\\\\-\\\\-';
$upd_flwbed = '';
if (isset($_POST["update_flwbed"]))
{
	for ($s=1;$s<=9;$s++)
	{
		$upd_flwbed.= $_POST['season'.$s.'a']."\\\\";
	}
	$upd_all = rtrim($upd_flwbed,'\\\\');
	
	
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
		$upd_cak.= $_POST['season'.$s.'b']."\\\\";
	}
	$upd_allc = rtrim($upd_cak,'\\\\');
	
	
	$update_cake=$conn->prepare("update hotel_food set cake_rate =? where hotel_id=?");
	$update_cake->execute(array($upd_allc,hotel_id));

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
		$upd_candl.= $_POST['season'.$s.'c']."\\\\";
	}
	$upd_allcn = rtrim($upd_candl,'\\\\');
	
	
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
		$upd_fruit.= $_POST['season'.$s.'d']."\\\\";
	}
	$upd_allf = rtrim($upd_fruit,'\\\\');
	
	
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
		$upd_lunch.= $_POST['season'.$s.'e']."\\\\";
	}
	$upd_alll = rtrim($upd_lunch,'\\\\');
	
	
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
		$upd_dinner.= $_POST['season'.$s.'f']."\\\\";
	}
	$upd_alld = rtrim($upd_dinner,'\\\\');
	
	
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
		$upd_withbed.= $_POST['season'.$s.'f']."\\\\";
	}
	$upd_alld = rtrim($upd_withbed,'\\\\');
	
	
	$update_withbed=$conn->prepare("update hotel_food set child_with_bed =? where hotel_id=?");
	$update_withbed->execute(array($upd_alld,$hotel_id));

	
	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}
	
$upd_hiphen = '0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0';
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
		$upd_withoutbed.= $_POST['season'.$s.'f']."\\\\";
	}
	$upd_alld = rtrim($upd_withoutbed,'\\\\');
	
	
	$update_withbed=$conn->prepare("update hotel_food set child_without_bed =? where hotel_id=?");
	$update_withbed->execute(array($upd_alld,$hotel_id));

	echo "<script>alert('Successully Updated');</script>";
	echo "<script>parent.jQuery.fancybox.close();</script>";
}
	
$upd_hiphen = '0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0\\\\0';
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
						
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel=$seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate <br><small style="font-size: 12px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[0]; ?></label>
					<input type="text" name="season1a" id="edit_season1a" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $flowerbed_dec[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	</label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[1]; ?></label>
					<input type="text" name="season2a" id="edit_season2a" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $flowerbed_dec[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	</label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[2]; ?></label>
					<input type="text" name="season3a" id="edit_season3a" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $flowerbed_dec[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	</label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                      <label id="season4_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[3]; ?></label>
					<input type="text" name="season4a" id="edit_season4a" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $flowerbed_dec[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	</label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[4]; ?></label>
					<input type="text" name="season5a" id="edit_season5a" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $flowerbed_dec[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	</label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[5]; ?></label>
					<input type="text" name="season6a" id="edit_season6a" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $flowerbed_dec[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	 </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[6]; ?></label>
					<input type="text" name="season7a" id="edit_season7a" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $flowerbed_dec[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	</label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[7]; ?></label>
					<input type="text" name="season8a" id="edit_season8a" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $flowerbed_dec[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>	</label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id1" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $flowerbed_dec[8]; ?></label>
					<input type="text" name="season9a" id="edit_season9a" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $flowerbed_dec[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id1" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit1()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id1" style="display:none;" class="btn btn-sm btn-success" name="update_flwbed" value="update_season_val"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
									
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[0]; ?></label>
					<input type="text" name="season1b" id="edit_season1b" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $exp_cake[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group" >
                                     <label id="season2_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[1]; ?></label>
					<input type="text" name="season2b" id="edit_season2b" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $exp_cake[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[2]; ?></label>
					<input type="text" name="season3b" id="edit_season3b" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $exp_cake[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group" >
                                      <label id="season4_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[3]; ?></label>
					<input type="text" name="season4b" id="edit_season4b" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $exp_cake[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[4]; ?></label>
					<input type="text" name="season5b" id="edit_season5b" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $exp_cake[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate<br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[5]; ?></label>
					<input type="text" name="season6b" id="edit_season6b" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $exp_cake[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[6]; ?></label>
					<input type="text" name="season7b" id="edit_season7b" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $exp_cake[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[7]; ?></label>
					<input type="text" name="season8b" id="edit_season8b" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $exp_cake[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id2" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_cake[8]; ?></label>
					<input type="text" name="season9b" id="edit_season9b" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $exp_cake[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id2" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit2()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id2" style="display:none;" class="btn btn-sm btn-success" name="update_cake" value="update_season_val"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[0]; ?></label>
					<input type="text" name="season1c" id="edit_season1c" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $exp_candl[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[1]; ?></label>
					<input type="text" name="season2c" id="edit_season2c" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $exp_candl[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[2]; ?></label>
					<input type="text" name="season3c" id="edit_season3c" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $exp_candl[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                      <label id="season4_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[3]; ?></label>
					<input type="text" name="season4c" id="edit_season4c" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $exp_candl[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[4]; ?></label>
					<input type="text" name="season5c" id="edit_season5c" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $exp_candl[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[5]; ?></label>
					<input type="text" name="season6c" id="edit_season6c" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $exp_candl[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[6]; ?></label>
					<input type="text" name="season7c" id="edit_season7c" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $exp_candl[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[7]; ?></label>
					<input type="text" name="season8c" id="edit_season8c" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $exp_candl[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id3" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_candl[8]; ?></label>
					<input type="text" name="season9c" id="edit_season9c" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $exp_candl[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id3" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit3()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id3" style="display:none;" class="btn btn-sm btn-success" name="update_candl" value="update_season_val1"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[0]; ?></label>
					<input type="text" name="season1d" id="edit_season1d" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $exp_fruit[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[1]; ?></label>
					<input type="text" name="season2d" id="edit_season2d" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $exp_fruit[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[2]; ?></label>
					<input type="text" name="season3d" id="edit_season3d" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $exp_fruit[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group" >
                                      <label id="season4_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[3]; ?></label>
					<input type="text" name="season4d" id="edit_season4d" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $exp_fruit[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[4]; ?></label>
					<input type="text" name="season5d" id="edit_season5d" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $exp_fruit[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[5]; ?></label>
					<input type="text" name="season6d" id="edit_season6d" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $exp_fruit[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[6]; ?></label>
					<input type="text" name="season7d" id="edit_season7d" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $exp_fruit[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[7]; ?></label>
					<input type="text" name="season8d" id="edit_season8d" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $exp_fruit[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id4" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_fruit[8]; ?></label>
					<input type="text" name="season9d" id="edit_season9d" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $exp_fruit[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id4" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit4()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id4" style="display:none;" class="btn btn-sm btn-success" name="update_fruit" value="update_season_val4"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
	
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[0]; ?></label>
					<input type="text" name="season1e" id="edit_season1e" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $exp_lunch[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>  </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[1]; ?></label>
					<input type="text" name="season2e" id="edit_season2e" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $exp_lunch[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small>  </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[2]; ?></label>
					<input type="text" name="season3e" id="edit_season3e" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $exp_lunch[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                      <label id="season4_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[3]; ?></label>
					<input type="text" name="season4e" id="edit_season4e" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $exp_lunch[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[4]; ?></label>
					<input type="text" name="season5e" id="edit_season5e" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $exp_lunch[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[5]; ?></label>
					<input type="text" name="season6e" id="edit_season6e" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $exp_lunch[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[6]; ?></label>
					<input type="text" name="season7e" id="edit_season7e" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $exp_lunch[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[7]; ?></label>
					<input type="text" name="season8e" id="edit_season8e" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $exp_lunch[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id5" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_lunch[8]; ?></label>
					<input type="text" name="season9e" id="edit_season9e" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $exp_lunch[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id5" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit5()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id5" style="display:none;" class="btn btn-sm btn-success" name="update_lunch" value="update_season_val4"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
	
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate 
	<br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[0]; ?></label>
					<input type="text" name="season1f" id="edit_season1f" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $exp_dinner[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[1]; ?></label>
					<input type="text" name="season2f" id="edit_season2f" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $exp_dinner[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group" align="center">
                                    <div class="input-group">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[2]; ?></label>
					<input type="text" name="season3f" id="edit_season3f" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $exp_dinner[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                      <label id="season4_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[3]; ?></label>
					<input type="text" name="season4f" id="edit_season4f" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $exp_dinner[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[4]; ?></label>
					<input type="text" name="season5f" id="edit_season5f" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $exp_dinner[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[5]; ?></label>
					<input type="text" name="season6f" id="edit_season6f" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $exp_dinner[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[6]; ?></label>
					<input type="text" name="season7f" id="edit_season7f" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $exp_dinner[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[7]; ?></label>
					<input type="text" name="season8f" id="edit_season8f" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $exp_dinner[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id6" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_dinner[8]; ?></label>
					<input type="text" name="season9f" id="edit_season9f" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $exp_dinner[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id6" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit6()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id6" style="display:none;" class="btn btn-sm btn-success" name="update_dinner" value="update_season_val6"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
	
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate 
	<br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[0]; ?></label>
					<input type="text" name="season1f" id="edit_season1f" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $exp_withbed[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[1]; ?></label>
					<input type="text" name="season2f" id="edit_season2f" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $exp_withbed[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group" >
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[2]; ?></label>
					<input type="text" name="season3f" id="edit_season3f" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $exp_withbed[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                      <label id="season4_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[3]; ?></label>
					<input type="text" name="season4f" id="edit_season4f" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $exp_withbed[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[4]; ?></label>
					<input type="text" name="season5f" id="edit_season5f" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $exp_withbed[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[5]; ?></label>
					<input type="text" name="season6f" id="edit_season6f" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $exp_withbed[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[6]; ?></label>
					<input type="text" name="season7f" id="edit_season7f" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $exp_withbed[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[7]; ?></label>
					<input type="text" name="season8f" id="edit_season8f" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $exp_withbed[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id7" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withbed[8]; ?></label>
					<input type="text" name="season9f" id="edit_season9f" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $exp_withbed[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id7" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit7()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id7" style="display:none;" class="btn btn-sm btn-success" name="update_withbed" value="update_season_val7"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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
	//$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	$row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC);
	
	
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
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 1 Rate 
	<br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                               <label id="season1_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[0]; ?></label>
					<input type="text" name="season1f" id="edit_season1f" class="form-control"  placeholder="Season 1 Rate" value="<?php echo $exp_withoutbed[0]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 2 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season2_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[1]; ?></label>
					<input type="text" name="season2f" id="edit_season2f" class="form-control"  placeholder="Season 2 Rate" value="<?php echo $exp_withoutbed[1]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group" >
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 3 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small> </label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season3_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[2]; ?></label>
					<input type="text" name="season3f" id="edit_season3f" class="form-control"  placeholder="Season 3 Rate" value="<?php echo $exp_withoutbed[2]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 4 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                      <label id="season4_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[3]; ?></label>
					<input type="text" name="season4f" id="edit_season4f" class="form-control"  placeholder="Season 4 Rate" value="<?php echo $exp_withoutbed[3]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 5 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season5_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[4]; ?></label>
					<input type="text" name="season5f" id="edit_season5f" class="form-control"  placeholder="Season 5 Rate" value="<?php echo $exp_withoutbed[4]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 6 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season6_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[5]; ?></label>
					<input type="text" name="season6f" id="edit_season6f" class="form-control"  placeholder="Season 6 Rate" value="<?php echo $exp_withoutbed[5]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 7 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season7_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[6]; ?></label>
					<input type="text" name="season7f" id="edit_season7f" class="form-control"  placeholder="Season 7 Rate" value="<?php echo $exp_withoutbed[6]; ?>" style="display:none;">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 8 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season8_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[7]; ?></label>
					<input type="text" name="season8f" id="edit_season8f" class="form-control"  placeholder="Season 8 Rate" value="<?php echo $exp_withoutbed[7]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group" align="center">
                                    <?php $row_seashotel = $seashotel->fetch(PDO::FETCH_ASSOC); ?>
										  <label >Season 9 Rate <br><small style="font-size: 11px;color: #F70909;"><?php echo date("d-M-Y",strtotime($row_seashotel['from_date'])).' - '.date("d-M-Y",strtotime($row_seashotel['to_date'])); ?></small></label>
										</div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                    <div class="input-group">
                                     <label id="season9_id8" style="color:#C63">=&nbsp;&nbsp;&#x20b9;&nbsp;<?php echo $exp_withoutbed[8]; ?></label>
					<input type="text" name="season9f" id="edit_season9f" class="form-control"  placeholder="Season 9 Rate" value="<?php echo $exp_withoutbed[8]; ?>" style="display:none">
										</div>
                                        <!--<small class="help-block" id="vnumerr" style=" display:none; color:#E9573F;" ></small>-->
                                        </div>
									</div>
                                    </div>
                                    
                                 <div class="row">
                                 <div class="col-sm-8" >
							<p id="note_id" style="color:#666; word-wrap:break-word; font-size:10px;"> <i style="color:#C63;">Note :</i> If you want to update your detail, please perform action on the above "Edit" button .
                            </p>
                           
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
									<div class="pull-right">
                                    <button  id="cancel_id8" style="display:none;"   class="btn btn-sm btn-default" onClick="cancel_edit8()"><i class="fa fa-times-circle-o"></i> Cancel</button>
                                    
                                    <button type="submit" id="update_id8" style="display:none;" class="btn btn-sm btn-success" name="update_withoutbed" value="update_season_val8"><i class="fa fa-upload"></i> Upload</button>
                                    </div>
								</div>
                                </div>
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