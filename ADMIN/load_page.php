<?php
session_start();
require_once('../Connections/divdb.php');

//This is for load remove and load hole records
if(isset($_GET['type']) && $_GET['type']==1)
{
$vehipro = $conn->prepare("SELECT * FROM vehicle_pro  ORDER BY vehicle_type ASC");
$vehipro->execute();
$row_vehipro_main = $vehipro->fetchAll();
$totalRows_vehipro = $vehipro->rowCount();

$vehifilt1 = $conn->prepare("SELECT distinct(datetime) FROM vehicle_pro ORDER BY datetime ASC");
$vehifilt1->execute();
$row_vehifilt1_main = $vehifilt1->fetchAll();
$totalRows_vehifilt1 = $vehifilt1->rowCount();


?>
                                <?php if($totalRows_vehipro>0){?>
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable" >
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                  
                                    <div align="right">
                                    <span ><strong> Add vehicle </strong></span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu" style="text-align:left">
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_vehiform " href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_vehi " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                &nbsp;&nbsp;
                                    &nbsp;&nbsp;
                                     <input type="hidden" id="lcn1" value="1" />
                                    <div class="btn-group">
								  <a class="btn btn-danger btn-sm dropdown-toggle" id="sptxt1" data-toggle="dropdown">
									<i class="fa fa-filter"></i> All records (<?php echo $totalRows_vehipro;?>) <span class="caret"></span>
								  </a>
                                  
                                  <ul class="dropdown-menu  " role="menu" style="text-align:left; margin-left:-55%; width:250px; " >
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li>
											<div class="nav-dropdown-heading" style="text-align:center">
											<strong>Uploaded Date's</strong>
											</div><!-- /.nav-dropdown-heading -->
											<div class="nav-dropdown-contents  scroll-nav-dropdowns" style=" min-height:150px; max-height:240px;">
												<ul >
													 <?php 
													 $sda='';
													 $dsd='';
													 $fns=''; 
													 foreach($row_vehifilt1_main as $row_vehifilt1){
									   
	$vehifilt12 = $conn->prepare("SELECT * FROM vehicle_pro where datetime=?");
	$vehifilt12->execute(array($row_vehifilt1['datetime']));
	$row_vehifilt12 = $vehifilt12->fetch(PDO::FETCH_ASSOC);
	$totalRows_vehifilt12 = $vehifilt12->rowCount();
	
	$sda=str_replace('-','_',$row_vehifilt1['datetime']);
								    $dsd=str_replace(' ','_',$sda);
									$fns=str_replace(':','_',$dsd).'.csv';
									   ?>
                                    <li class="col-sm-10 "  >
                                    <a style="margin-left:-3%;color:#656D8D;" onclick="lodrec1('<?php echo $row_vehifilt1['datetime'].' '.date('a',strtotime($row_vehifilt1['datetime'])).' ('.$totalRows_vehifilt12.')';?>','<?php echo $totalRows_vehipro;?>','<?php echo $row_vehifilt1['datetime'];?>')"  href="javascript:void(0);"  data-toggle="tooltip" data-original-title="Click to view all records"><i class="fa fa-calendar fa-fw"></i> <?php echo $row_vehifilt1['datetime'].' '.date('a',strtotime($row_vehifilt1['datetime'])).'<br>'.' ('.$totalRows_vehifilt12.')';?></a>
                                    </li>
                                    <li class="col-sm-2 " ><a class="ss pull-right" href="javascript:void(0);"  onclick="rem('<?php echo $row_vehifilt1['datetime'];?>','<?php echo $row_vehifilt1['datetime'].' '.date('a',strtotime($row_vehifilt1['datetime'])).' ('.$totalRows_vehifilt12.' records )';?>','<?php echo $fns;?>');"><i class="fa fa-trash-o " data-toggle="tooltip" data-original-title="Remove all records" style="color:#D5472B"></i></a></li>
									<?php }?>
													
												</ul>
											</div><!-- /.nav-dropdown-content scroll-nav-dropdown -->
											<div style="text-align:center" id="btdiv1">
                                            </div>
										</li>
                                        <li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                  
                                  
								</div>
                                </div>
                                    </div>
                                    <div class="table-responsive" id="tbonly1" >
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th><i class="fa fa-taxi"></i> Vehicle</th>
									<th><i class="fa fa-child"></i> Occupancy (seats)</th>
                                    <th><i class="fa fa-language"></i> Cities</th>
                                    <th><i  class="fa fa-inr"></i> Rental chart</th>
                                    <th><i class="fa fa-exclamation-triangle"></i> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
							$es='';
							$es1='';
							$city='';
							$perkl='';
							$rents='';
							$maxkl='';
							
							$ecity='';
							$eperkl='';
							$erents='';
							$emaxkl='';
							
							foreach($row_vehipro_main as $row_vehipro){
								
		$vehitab2 = $conn->prepare("SELECT * FROM vehicle_rent where vehicle_id=?");
		$vehitab2->execute(array($row_vehipro['vehi_id']));
		$row_vehitab2_main =$vehitab2->fetchAll();
		$totalRows_vehitab2 = $vehitab2->rowCount();
		foreach($row_vehitab2_main as $row_vehitab2)
		{
			
		$city.=$row_vehitab2['city'].',';
		
		$perkl.=$row_vehitab2['charge_perkm'].',';
		
		$rents.=$row_vehitab2['rent_day'].',';
		
		$maxkl.=$row_vehitab2['maxkm_perday'].',';
		
		}
		
		$ecity=explode(',',substr($city,0,-1));
		
		$eperkl=explode(',',substr($perkl,0,-1));
		
		$erents=explode(',',substr($rents,0,-1));
		
		$emaxkl=explode(',',substr($maxkl,0,-1));
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td ><?php echo $row_vehipro['vehicle_type'];?></td>
									<td style="text-align:center" width="18%"><?php echo $row_vehipro['vehicle_seat'];?></td>
									<td style="text-align:center" width="12%" >
                                    <div class="btn-group">
								  <a  class="dropdown-toggle btn btn-xs btn-default"  data-toggle="dropdown" ><i class="fa fa-map-marker"></i> 
									<strong><?php if(count($ecity)>=2){ echo count($ecity).' Cities';}else{ echo count($ecity).' City'; }?></strong> <span class="caret"></span>
								  </a><!--div-nicescroller-->
								  <ul class="dropdown-menu div-nicescroller info with-triangle " role="menu" style=" height:150px; text-align:left;" >
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <?php $ij=1; foreach($ecity as $ecty){
										
		$cname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cname->execute(array($ecty));
		$row_cname = $cname->fetch(PDO::FETCH_ASSOC);
		
		?>
                                    <li><a href="javascript:void(0);" <?php if(strlen($row_cname['name'])>15){?> data-toggle="tooltip" data-original-title="<?php echo $row_cname['name']; ?>" <?php }?>><?php echo $ij.'.'.$row_cname['name'];?></a></li>
                                    <?php $ij++;}?>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                    </td>
                                    <td style="text-align:center">
                                    <div class="btn-group">
								  <a  class="dropdown-toggle btn btn-xs btn-default"  data-toggle="dropdown" >
									<strong><i class="fa  fa-bar-chart-o"></i> Click</strong> <span class="caret"></span>
								  </a>
                                  <ul class="dropdown-menu margin-list-rounded div-nicescroller info with-triangle " role="menu" style=" text-align:left; height:150px;" >
								 <table class="table table-striped table-hover " style="width:350px; overflow-y:scroll;">
                                 <thead class="the-box dark full"><th>City</th><th>Per day</th><th>Per km</th><th>Max km</th></thead>
                                 <tbody>
                                  <?php $ijw=1; $ik=0; foreach($ecity as $ecty){
										
		$cname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cname->execute(array($ecty));
		$row_cname = $cname->fetch(PDO::FETCH_ASSOC);
		
		?>
        <tr class="even gradeA"><td><?php if(strlen($row_cname['name'])>14){?><span data-toggle="tooltip" data-original-title="<?php echo $row_cname['name'];?>"><?php echo substr($row_cname['name'],0,10).'&hellip;';?></span><?php }else { echo $row_cname['name']; }?></td><td ><i class="fa fa-inr"></i> <?php echo $erents[$ik];?></td><td><i class="fa fa-inr"></i> <?php echo $eperkl[$ik];?></td><td><?php echo $emaxkl[$ik].' km';?></td></tr>
        <?php $ijw++; $ik++;}?></tbody>
                                 </table>
                                 </ul>
                                    </div>
                                    </td>
									
                                    <td class="center">
                                    <div class="btn-group">
								  <button  class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown" >
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded with-triangle" role="menu" style="width:12%">
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li><a class="add_vehiform " title="Update - <?php echo $row_vehipro['vehicle_type'];?>" href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(3);?>&vid=<?php echo $row_vehipro['vehi_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a></li>
                                  <li><a href="javascript:void(0);"                                 
                                   onclick="removes('<?php echo $row_vehipro['vehi_id'];?>','<?php echo $row_vehipro['vehicle_type'];?>')"><i class="fa fa-trash-o"></i> Remove</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;
							   $city='';
							$perkl='';
							$rents='';
							$maxkl='';}?>
                                </tbody>
                                </table>
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                    <span class="text-muted">Vehicle's are not yet setting. Click to setup </span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu">
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_vehiform " href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_vehi " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                    </div>
<script>
function lal(dd)
{
	alert(dd);
}
</script>                                    
                                    <?php } }
									
//This is for update current record
if(isset($_GET['type']) && $_GET['type']==2)
{ 

	$esx1=explode(',',$_POST['city']);
	$esx=implode($esx1,',');
	$sx=implode($esx1,"\\\\");
	$sxs='';
	$sxs=$sx;
	
			 	$insertSQLupd=$conn->prepare('update vehicle_pro set vehicle_type=?,vehicle_seat=?,vehicle_rental=?,vehicle_km_price=?,vehicle_no=?,vehicle_extra_charg=?,vehicle_cities=? where vehi_id=?');
			  	$insertSQLupd->execute(array($_POST['vno'],$_POST['occu'],$_POST['perdy'],$_POST['perkl'],$_POST['vname'],$_POST['exch'],$sxs,$_POST['vid']));


 }

//This is for load current date records

if(isset($_GET['type']) && $_GET['type']==3)
{ 

$vehipro = $conn->prepare("SELECT * FROM vehicle_pro  where status='0' and datetime=? ORDER BY vehicle_type ASC");
$vehipro->execute(array($_GET['dads']));
$row_vehipro_main  = $vehipro->fetchAll();
$totalRows_vehipro = $vehipro->rowCount();



?>
<input id="gdtime" type="hidden" value="<?php echo $_GET['dads'];?>" />
<?php if($totalRows_vehipro>0){?>
<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th><i class="fa fa-taxi"></i> Vehicle</th>
									<th><i class="fa fa-child"></i> Occupancy (seats)</th>
                                    <th><i class="fa fa-language"></i> Cities</th>
                                    <th><i  class="fa fa-inr"></i> Rental chart</th>
                                    <th><i class="fa fa-exclamation-triangle"></i> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
							$es='';
							$es1='';
								
							$city='';
							$perkl='';
							$rents='';
							$maxkl='';
							
							$ecity='';
							$eperkl='';
							$erents='';
							$emaxkl='';
							
							foreach($row_vehipro_main as $row_vehipro){
								
		$vehitab2 = $conn->prepare("SELECT * FROM vehicle_rent where vehicle_id=?");
		$vehitab2->execute(array($row_vehipro['vehi_id']));
		$row_vehitab2_main = $vehitab2->fetchAll();
		$totalRows_vehitab2 = $vehitab2->rowCount();
		
		foreach($row_vehitab2_main as $row_vehitab2)
		{
			
		$city.=$row_vehitab2['city'].',';
		
		$perkl.=$row_vehitab2['charge_perkm'].',';
		
		$rents.=$row_vehitab2['rent_day'].',';
		
		$maxkl.=$row_vehitab2['maxkm_perday'].',';
		
		}
		
		$ecity=explode(',',substr($city,0,-1));
		
		$eperkl=explode(',',substr($perkl,0,-1));
		
		$erents=explode(',',substr($rents,0,-1));
		
		$emaxkl=explode(',',substr($maxkl,0,-1));
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td ><?php echo $row_vehipro['vehicle_type'];?></td>
									<td style="text-align:center" width="18%"><?php echo $row_vehipro['vehicle_seat'];?></td>
									<td style="text-align:center" width="12%" >
                                    <div class="btn-group">
								  <a  class="dropdown-toggle btn btn-xs btn-default"  data-toggle="dropdown" ><i class="fa fa-map-marker"></i> 
									<strong><?php if(count($ecity)>=2){ echo count($ecity).' Cities';}else{ echo count($ecity).' City'; }?></strong> <span class="caret"></span>
								  </a><!--div-nicescroller-->
								  <ul class="dropdown-menu div-nicescroller info with-triangle " role="menu" style=" text-align:left;  height:150px;" >
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <?php $ij=1; foreach($ecity as $ecty){
										
		$cname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cname->execute(array($ecty));
		$row_cname = $cname->fetch(PDO::FETCH_ASSOC);
		
		?>
                                    <li><a href="javascript:void(0);" <?php if(strlen($row_cname['name'])>15){?> data-toggle="tooltip" data-original-title="<?php echo $row_cname['name']; ?>" <?php }?>><?php echo $ij.'.'.$row_cname['name'];?></a></li>
                                    <?php $ij++;}?>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                    </td>
                                    <td style="text-align:center">
                                    <div class="btn-group">
								  <a  class="dropdown-toggle btn btn-xs btn-default"  data-toggle="dropdown" >
									<strong><i class="fa  fa-bar-chart-o"></i> Click</strong> <span class="caret"></span>
								  </a>
                                  <ul class="dropdown-menu margin-list-rounded div-nicescroller info with-triangle " role="menu" style="  height:150px; text-align:left;" >
								 <table class="table table-striped table-hover " style="width:350px; overflow-y:scroll;">
                                 <thead class="the-box dark full"><th>City</th><th>Per day</th><th>Per km</th><th>Max km</th></thead>
                                 <tbody>
                                  <?php $ijw=1; $ik=0; foreach($ecity as $ecty){
										
		$cname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
		$cname->execute(array($ecty));
		$row_cname = $cname->fetch(PDO::FETCH_ASSOC);
		
		?>
        <tr class="even gradeA"><td><?php if(strlen($row_cname['name'])>14){?><span data-toggle="tooltip" data-original-title="<?php echo $row_cname['name'];?>"><?php echo substr($row_cname['name'],0,10).'&hellip;';?></span><?php }else { echo $row_cname['name']; }?></td><td ><i class="fa fa-inr"></i> <?php echo $erents[$ik];?></td><td><i class="fa fa-inr"></i> <?php echo $eperkl[$ik];?></td><td><?php echo $emaxkl[$ik].' km';?></td></tr>
        <?php $ijw++; $ik++;}?></tbody>
                                 </table>
                                 </ul>
                                    </div>
                                    </td>
									
                                    <td class="center">
                                    <div class="btn-group">
								  <button  class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown" >
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li>
                                    <!--add_vehiformupdate--><a class="add_vehiform " title="Update - <?php echo $row_vehipro['vehicle_type'];?>" href="<?php echo $_SESSION['grp'];?>/add_vehicle.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(3);?>&vid=<?php echo $row_vehipro['vehi_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a>
                                    </li>
                                  <li><a href="javascript:void(0);" onclick="removes1('<?php echo $row_vehipro['vehi_id'];?>','<?php echo $totalRows_vehipro;?>','<?php echo $row_vehipro['vehicle_type'];?>')" ><i class="fa fa-trash-o"></i> Remove</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;
							    $city='';
							$perkl='';
							$rents='';
							$maxkl='';}?>
                                </tbody>
                                </table>
<?php }else{?>                                
<center><strong style="color:#D8482C">All records are removed from this date - ' <?php echo substr($_GET['dads'],0,-3).' '.date('a',strtotime($_GET['dads']));?> '.</strong><strong> Redirect to main page in <span id="ses" style="font-size:20px; color:#D8482C">5</span> seconds..</strong></center>
<script>
$(document).ready(function(e) {
   
   var i,myVar,type,mm,sm;
   mm='<?php echo $_GET['mm'];?>';
   sm='<?php echo $_GET['sm'];?>';
   type=1;
   myVar=setInterval(function()
   {
	   i=$('#ses').text();
	   $('#ses').text(parseInt(i)-1);
	},1000);
	
	setTimeout(function()
	{
	clearInterval(myVar);
	
		$.ajax({
		type:'GET',
		url:"<?php echo $_SESSION['grp'];?>/load_page.php?type="+type,
		cache:false,
		data:'mm='+mm+'&sm='+sm,
		success: function(sd)
		{
			 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Main page was successfully Redirected..!');
		
			$('#tabid').empty().html(sd);
			 $('.datatable-example').dataTable();
		 $('.tagname').tagsInput({width:'auto'});
			
		}
			
		});
	 	
	},5000);
   
});

</script>
<?php }
}


//This is for Update vehicle pro
if(isset($_GET['type']) && $_GET['type']==4)
{

?>

<div class="row" id="upderow<?php echo $_GET['cnt'];?>" >
                                    <div class="col-sm-6">
                                    <div class="col-sm-6">
                                    <div class="form-group" >
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Choose a city"><i class="fa fa-map-marker fa-fw"></i></span>
                                        <select class="form-control chosen-select" name="city<?php echo $_GET['cnt'];?>" data-placeholder="Choose a city" >
                                          <option></option>
                                         <?php 
										 
		$cits = $conn->prepare("SELECT id,name FROM dvi_cities where type = 'AD' and status=0 ORDER BY name ASC");
		$cits->execute();
		$row_cits_main  = $cits->fetchAll();
		foreach($row_cits_main as $row_cits){
?>
                                          <option value="<?php echo $row_cits['id'];?>"><?php echo $row_cits['name'];?></option>
                                          <?php }?>
                                          </select>
										  
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Per day rental"><i class="fa fa-inr fa-fw"></i></span>
										  <input type="text" class="form-control"   name="perday<?php echo $_GET['cnt'];?>" placeholder="Per day rental">
										</div>
                                        </div>
                                        </div>
                                    
                                        </div>
                                         <div class="col-sm-6">
								
                                    <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Per kilometer rental"><i class="fa fa-inr fa-fw"></i></span>
										  <input type="text" class="form-control" name="perkilo<?php echo $_GET['cnt'];?>" placeholder="Per kilomater rental">
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-5">
                                    <div class="form-group">
                                    <div class="input-group">
										<span class="input-group-addon tooltips" data-original-title="Maximum kilometer per day"><i class="fa fa-tachometer fa-fw"></i></span>
										  <input type="text" class="form-control" name="permxkl<?php echo $_GET['cnt'];?>" placeholder="Maximum kilometer per day">
										</div>
                                        </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="form-group">
										<a class="input-group-addon tooltips" onclick="rediv('<?php echo $_GET['cnt'];?>');" data-original-title="Remove this"><i class="fa fa-minus "></i></a>
                                        </div>
                                        </div>
                                        </div>
									</div><!-- /.col-sm-6 -->
                                </div>

<?php }
//End?>

<?php
if(isset($_GET['type']) && $_GET['type']==5)
{ 

$hotelpro = $conn->prepare("SELECT * FROM hotel_pro where datetime=? and status='0' ORDER BY sno ASC");
$hotelpro->execute(array($_GET['dads']));
$row_hotelpro_main = $hotelpro->fetchAll();
$totalRows_hotelpro = $hotelpro->rowCount();?>
<input id="gdtime" type="hidden" value="<?php echo $_GET['dads'];?>" />
<?php if($totalRows_hotelpro>0){?>
<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th width="5%"># </th>
									<th width="20%"><i class="fa fa-building "></i> Hotel Name</th>
                                    <th width="25%"><i class="fa fa-university"></i> Residential Address</th>
                                  <!--  <th width="12%"><i class="fa fa-star-half-o"></i> Hotel Type</th>-->
                                    <th width="15%"><i class="fa  fa-tablet "></i> Room Type</th>
                                    <th width="15%"><i class="fa  fa-spoon "></i> Meal</th>
                                    <th width="15%"><i class="fa  fa-th"></i> Special Amenities</th>
									<th width="25%"><i class="fa fa-exclamation-triangle"></i> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
				foreach($row_hotelpro_main as $row_hotelpro)
				{
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td width="20%" ><?php echo $row_hotelpro['hotel_name'];?><br />
                          <label style="color:#B07A7A;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star-half-full (alias)"></i> <?php echo "&nbsp;".$row_hotelpro['category'];?></label></td>
                                    <td  width="25%" style="word-wrap:break-word">
                                     <?php
									  //$row_hotelpro['location']."<br>";
									 $addr= str_replace('\\',',',$row_hotelpro['location']);
									 echo $addr."<br>";
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hotelpro['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									//  echo $row_hotelcity['name']."<br>";
									  
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hotelpro['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									  //echo $row_hotelstate['name'];
									  
									 ?></td>
									<!--<td  width="12%"><?php// echo $row_hotelpro['category'];?></td>-->
                                    <td   width="15%" >
									<?php
	$hotelroom = $conn->prepare("SELECT * FROM hotel_season where status = '0' and hotel_id=?");
	$hotelroom->execute(array($row_hotelpro['hotel_id']));
	$tot_room=$hotelroom->rowCount();
	$row_hotelroom_main=$hotelroom->fetchAll();
	if($tot_room>0){
	foreach($row_hotelroom_main as $row_hotelroom)
	{	?>	
    
    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/view_season.php?sno=<?php echo $row_hotelroom['sno'];?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&room_type=<?php echo $row_hotelroom['room_type']; ?>"><i class="fa fa-tags"></i>&nbsp;<?php echo $row_hotelroom['room_type']; ?></a>
    <br />	
<?php    }
	}else{ //if end
	echo "No Room types";
	}?>
                                    </td>
                                    <td  width="15%"><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '5';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Lunch </a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '6';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Dinner</a>
                                    </td>
                                    <td  width="15%"><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '1';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Flower bed decoration</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '2';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Cake</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '3';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Candle light dinner</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '4';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Fruit basket</a>
                                    </td>
                                     <td width="25%">
                                     <div class="btn-group">
								  <button class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/hotel_update.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a></li>
                                    
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/ajax_hotel.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&type=<?php echo "3";?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
                                    
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                     </td>
                                     
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
<?php }else{?>                                
<center><strong style="color:#D8482C">All records are removed from this date - ' <?php echo substr($_GET['dads'],0,-3).' '.date('a',strtotime($_GET['dads']));?> '.</strong><strong> Redirect to main page in <span id="ses" style="font-size:20px; color:#D8482C">5</span> seconds..</strong></center>
<script>
$(document).ready(function(e) {
   
   var i,myVar,type,mm,sm;
   mm='<?php echo $_GET['mm'];?>';
   sm='<?php echo $_GET['sm'];?>';
   type=1;
   myVar=setInterval(function()
   {
	   i=$('#ses').text();
	   $('#ses').text(parseInt(i)-1);
	},1000);
	
	setTimeout(function()
	{
	clearInterval(myVar);
	
		$.ajax({
		type:'GET',
		url:"<?php echo $_SESSION['grp'];?>/load_page.php?type="+type,
		cache:false,
		data:'mm='+mm+'&sm='+sm,
		success: function(sd)
		{
			 toastr.options={   
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
           "hideMethod": "fadeOut"
          			}
      	toastr.info('Main page was successfully Redirected..!');
		
			$('#tabid').empty().html(sd);
			 $('.datatable-example').dataTable();
		 $('.tagname').tagsInput({width:'auto'});
			
		}
			
		});
	 	
	},5000);
   
});

</script>
<?php }
}?>

<?php 
//This is for load remove and load hole records
if(isset($_GET['type']) && $_GET['type']==6)
{

$htpro = $conn->prepare("SELECT * FROM hotel_pro where  status='0'  ORDER BY sno ASC");
$htpro->execute();
$row_htpro =$htpro->fetch(PDO::FETCH_ASSOC);
$totalRows_htpro =$htpro->rowCount();


$hot = $conn->prepare("SELECT distinct(datetime) FROM hotel_pro where status='0' ORDER BY datetime ASC");
$hot->execute();
$row_hot_main  = $hot->fetchAll();
$totalRows_row_hot = $hot->rowCount(); 

if($totalRows_htpro>0){?>
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable" >
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                  
                                    <div align="right">
                                    <span id="vs1"><strong> Add Hotel </strong></span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu" style="text-align:left">
                                  
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li>
                                    <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor212"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a>
                                    <!--<a class="add_hotelform " href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a>--></li>
									<li>
                                     <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor2"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a>
                                    <!--<a class="add_vehi " title="Upload file" href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a>--></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                &nbsp;&nbsp;
                                    &nbsp;&nbsp;
                                    <input type="hidden" id="lcn" value="1" />
                                    <div class="btn-group">
								  <a class="btn btn-danger btn-sm dropdown-toggle" id="sptxt" data-toggle="dropdown">
									<i class="fa fa-filter"></i> All records (<?php echo $totalRows_htpro;?>) <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu  " role="menu" style="text-align:left; margin-left:-55%; width:250px; " >
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>													
                                    <li>
											<div class="nav-dropdown-heading" style="text-align:center">
											<strong>Uploaded Date's</strong>
											</div><!-- /.nav-dropdown-heading -->
											<div class="nav-dropdown-contents  scroll-nav-dropdowns" style=" min-height:150px; max-height:240px;">
												<ul >
                                                
													 <?php
													 $ds=1; 
													 $sda='';
													 $dsd='';
													 $fns='';
													  foreach($row_hot_main as $row_hot){
									   
	$hot1 = $conn->prepare("SELECT * FROM hotel_pro where datetime=?");
	$hot1->execute(array($row_hot['datetime']));
	$row_hot1 = $hot1->fetch(PDO::FETCH_ASSOC);
	$totalRows_hot1 = $hot1->rowCount();
	
	
	$sda=str_replace('-','_',$row_hot['datetime']);
								    $dsd=str_replace(' ','_',$sda);
									 $fns=str_replace(':','_',$dsd).'.csv';
									   ?>
                                    <li class="col-sm-10 " >
                                    <a id="<?php echo 'h'.$ds;?>" style="margin-left:-3%;color:#656D8D;" onclick="lodrec('<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.')';?>',<?php echo $totalRows_htpro;?>,'<?php echo $row_hot['datetime'];?>')"  data-toggle="tooltip" data-original-title="Click to view all records" href="javascript:void(0);"><i class="fa fa-calendar fa-fw"></i> <?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).'<br>'.' ('.$totalRows_hot1.')';?></a>
                                    </li>
                                    <li class="col-sm-2 " id="<?php echo 'h'.$ds.$ds;?>" ><a class="ss  pull-right"   href="javascript:void(0);" style="" onclick="rem('<?php echo $row_hot['datetime'];?>','<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.' records )';?>','<?php echo $fns;?>');"><i class="fa fa-trash-o " style="color:#D5472B" data-toggle="tooltip" data-original-title="Remove all records"></i></a></li>
                                     
									<?php $ds++;  $sda='';
													 $dsd='';
													 $fns='';}?>
													
												</ul>
											</div><!-- /.nav-dropdown-content scroll-nav-dropdown -->
											<div style="text-align:center" id="btdiv">
                                            
                                            </div>
										</li>
                                        <li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                </div>
                                    </div>
                                    <div class="table-responsive" id="default_table1">
                                   <?php 
	$hotelpro = $conn->prepare("SELECT * FROM hotel_pro where status = '0' ORDER BY sno ASC");
	$hotelpro->execute();
	//$row_hotelpro = mysql_fetch_assoc($hotelpro);
	$row_hotelpro_main=$hotelpro->fetchAll();
	$totalRows_hotelpro = $hotelpro->rowCount();
								   
								 if($totalRows_hotelpro>0)  {
								   ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th width="5%"># </th>
									<th width="20%"><i class="fa fa-building "></i> Hotel Name</th>
                                    <th width="25%"><i class="fa fa-university"></i> Residential Address</th>
                                 <!--   <th width="12%"><i class="fa fa-star-half-o"></i> Hotel Type</th>-->
                                    <th width="15%"><i class="fa  fa-tablet "></i> Room Type</th>
                                    <th width="15%"><i class="fa  fa-spoon "></i> Meal</th>
                                    <th width="15%"><i class="fa  fa-th"></i> Special Amenities</th>
									<th width="25%"><i class="fa fa-exclamation-triangle"></i> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
				foreach($row_hotelpro_main as $row_hotelpro)
				{
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td width="20%" ><?php echo $row_hotelpro['hotel_name'];?><br />
                          <label style="color:#B07A7A;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star-half-full (alias)"></i> <?php echo "&nbsp;".$row_hotelpro['category'];?></label></td>
                                    <td  width="25%" style="word-wrap:break-word">
                                     <?php
									  //$row_hotelpro['location']."<br>";
									 $addr= str_replace('\\',',',$row_hotelpro['location']);
									 echo $addr."<br>";
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hotelpro['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									 // echo $row_hotelcity['name']."<br>";
									  
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hotelpro['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									 // echo $row_hotelstate['name'];
									  

									 ?></td>
									<!--<td  width="12%"><?php// echo $row_hotelpro['category'];?></td>-->
                                    <td   width="15%" >
									<?php
	$hotelroom = $conn->prepare("SELECT * FROM hotel_season where status = '0' and hotel_id=?");
	$hotelroom->execute(array($row_hotelpro['hotel_id']));
	$tot_room=$hotelroom->rowCount();
	$row_hotelroom_main=$hotelroom->fetchAll();
	if($tot_room>0){
	foreach($row_hotelroom_main as $row_hotelroom)
	{	?>	
    
    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/view_season.php?sno=<?php echo $row_hotelroom['sno'];?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&room_type=<?php echo $row_hotelroom['room_type']; ?>"><i class="fa fa-tags"></i>&nbsp;<?php echo $row_hotelroom['room_type']; ?></a>
    <br />	
<?php    }
	}else{ //if end
	echo "No Room types";
	}?>
                                    </td>
                                    <td  width="15%"><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '5';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Lunch </a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '6';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Dinner</a>
                                    </td>
                                    <td  width="15%"><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '1';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Flower bed decoration</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '2';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Cake</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '3';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Candle light dinner</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '4';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Fruit basket</a>
                                    </td>
                                     <td width="25%">
                                     <div class="btn-group">
								  <button class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/hotel_update.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a></li>
                                    

                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/ajax_hotel.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&type=<?php echo "3";?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
                                    
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                     </td>
                                     
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                <?php } else{?>
                                <h4 style="color:#900; font-weight:600;" align="center" > No Entry Found...</h4>
                                <?php } ?>
                                </div>
                                <div class="" id="tabon2">
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                    <span class="text-muted">Hotels not yet added. Click to add entries </span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu" >
                                  
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li>
                                    <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor212"><i class="fa fa-credit-card"></i>&nbsp;Form Entry1</a>
                                    <!--<a class="add_hotelform " href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a>--></li>
									<li>
                                     <a href="javascript:void(0)" data-toggle="modal" onclick="model_div_hide()" data-target="#InfoModalColor2"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload1</a>
                                    <!--<a class="add_vehi " title="Upload file" href="<?php// echo $_SESSION['grp'];?>/add_hotel.php?mm=<?php// echo $_GET['mm'];?>&sm=<?php// echo $_GET['sm'];?>&type=<?php// echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a>--></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                    </div>
                                    <?php }
									  }
?>
<?php 
//This is for load remove and load hole records
if(isset($_GET['type']) && $_GET['type']==7)
{
$hspotpro = $conn->prepare("SELECT * FROM hotspots_pro where  status='0' and datetime=? ORDER BY sno DESC");
$hspotpro->execute(array($_GET['dads']));
$row_hspotpro_main = $hspotpro->fetchAll();
$totalRows_hspotpro = $hspotpro->rowCount();
 ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th><i class="fa fa fa-map-marker"></i> Hotspot Name</th>
									<th><i class="fa fa-clock-o"></i> Timing </th>
									<th><i  class="fa fa-globe"></i> City </th>
									<th ><center><i class="fa fa-film"></i> Spot View </center></th>
                                    <th><i class="fa fa-exclamation-triangle"></i> Process </th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
							$es='';
							$es1='';
							foreach($row_hspotpro_main as $row_hspotpro){
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td width="25%" ><font data-toggle='tooltip' data-original-title='<?php echo $row_hspotpro['spot_prior'].' - Priority  in '.$row_hotelcity['name']; ?>'><?php echo $row_hspotpro['spot_name'];?></font></td>
									<td width="18%"><?php 
									$match[1]='';
									$text =$row_hspotpro['spot_timings'];
								 $strpos=strpos($text,'(');
								$endpos=strpos($text,')');
								if($strpos != 0)
								{
									$txt= $row_hspotpro['spot_timings'];
									echo substr($row_hspotpro['spot_timings'],0,$strpos)."<br>";
									echo $stext=substr($txt,$strpos);
								}else
								{
									echo $row_hspotpro['spot_timings'];
								}
								?></td>
									<td  width="15%" > <?php
									
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hspotpro['spot_city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									 // echo $row_hotelcity['name']."<br>";
									  
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hspotpro['spot_state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									 // echo "".$row_hotelstate['name']."";
									?></td>
                                    
									<td align="center" width="18%" >
                                    <div class="btn-group" align="center">
<?php if( $row_hspotpro['spot_images'] != '') 
{?>
<a class="add_hots4 btn  btn-default"  title="Images of - <?php echo $row_hspotpro['spot_name'];?>" href="ADMIN/hotspot_images.php?sid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-picture-o" style="color:#3576AC"></i></a>
<?php }else{ ?>
<a class=" btn  btn-default"  title="Images of - <?php echo $row_hspotpro['spot_name'];?>" style="color:#CCC;" ><i class="fa fa-picture-o" ></i></a>
<?php }
if($row_hspotpro['video_link'] != '')
{
?>
                                    <a class="viewspot1 btn  btn-default"  title="Video of - <?php echo $row_hspotpro['spot_name'];?>" href="<?php echo $row_hspotpro['video_link'];?>"><i class="fa fa-video-camera" style="color:#3576AC"></i></a>
	<?php }else{?>
    								<a class=" btn  btn-default"  title="Video of - <?php echo $row_hspotpro['spot_name'];?>" style="color:#CCC;" ><i class="fa fa-video-camera" ></i></a>
    <?php }?>								
                                    
										</div>
                                   <input type="hidden" id='img<?php echo $row_hspotpro['hotspot_id']; ?>' value='<?php echo $row_hspotpro['spot_images']; ?>'  />
                                    </td>
                                    <td class="center" width="14%">
                                    <div class="btn-group">
								  <button  class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown" >
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle pull-right" role="menu" style="width:12%">
                                    <li>
                                    <a class="update_hot" title="Update - <?php //echo $row_vehipro['vehicle_type'];?>" href="<?php echo $_SESSION['grp'];?>/update_hotspot.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update Details</a></li>
                                    <li><a class="add_hots3" href="<?php echo $_SESSION['grp'];?>/spot_img_upload.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo  $row_hspotpro['hotspot_id'];?>" onclick="get_sid('<?php echo  $row_hspotpro['hotspot_id'];?>')" ><i class="fa fa-upload"></i>&nbsp; Upload Images</a></li>
                                  <li><a href="javascript:void(0);" onclick="removes('<?php  echo $row_hspotpro['hotspot_id'];?>')" ><i class="fa fa-trash-o"></i>&nbsp; Remove</a> <input type="hidden" value="<?php echo $row_hspotpro['spot_name']; ?>" id="txt_<?php echo $row_hspotpro['hotspot_id']; ?>"  /></li>
                                  
									  </ul>
                                  
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                            <?php
	
}
?>
<?php
if(isset($_GET['type']) && $_GET['type']==8)
{
$hspotpro = $conn->prepare("SELECT * FROM hotspots_pro where status = '0' ORDER BY sno DESC");
$hspotpro->execute();
$row_hspotpro=$hspotpro->fetch(PDO::FETCH_ASSOC);
$totalRows_hspotpro = $hspotpro->rowCount();

$hot = $conn->prepare("SELECT distinct(datetime) FROM hotspots_pro ORDER BY datetime ASC");
$hot->execute();
$row_hot_main = $hot->fetchAll();
$totalRows_row_hot = $hot->rowCount(); 

 if($totalRows_hspotpro>0){?>
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable" >
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                  
                                    <div align="right">
                                    <span id="vs1"><strong> Add Hotspots </strong></span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu" style="text-align:left">
                                  
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_hots1" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_hots2 " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                &nbsp;&nbsp;
                                    &nbsp;&nbsp;
                                    <input type="hidden" id="lcn" value="1" />
                                    <div class="btn-group">
								  <a class="btn btn-danger btn-sm dropdown-toggle" id="sptxt" data-toggle="dropdown">
									<i class="fa fa-filter"></i> All records (<?php echo $totalRows_hspotpro;?>) <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu  " role="menu" style="text-align:left; margin-left:-55%; width:250px; " >
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>													
                                    <li>
											<div class="nav-dropdown-heading" style="text-align:center">
											<strong>Uploaded Date's</strong>
											</div><!-- /.nav-dropdown-heading -->
											<div class="nav-dropdown-contents  scroll-nav-dropdowns" style=" min-height:150px; max-height:240px;">
												<ul >
                                                
													 <?php
													 $ds=1; 
													 $sda='';
													 $dsd='';
													 $fns='';
													  foreach($row_hot_main as $row_hot){
									   
	$hot1 = $conn->prepare("SELECT * FROM hotspots_pro where datetime=?");
	$hot1->execute(array($row_hot['datetime']));
	$row_hot1 = $hot1->fetch(PDO::FETCH_ASSOC);
	$totalRows_hot1 = $hot1->rowCount();
	
	
	$sda=str_replace('-','_',$row_hot['datetime']);
								    $dsd=str_replace(' ','_',$sda);
									 $fns=str_replace(':','_',$dsd).'.csv';
									   ?>
                                    <li class="col-sm-10 " >
                                    <a id="<?php echo 'h'.$ds;?>" style="margin-left:-3%;color:#656D8D;" onclick="lodloc('<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.')';?>','<?php echo $totalRows_hspotpro;?>','<?php echo $row_hot['datetime'];?>')"  data-toggle="tooltip" data-original-title="Click to view all records" href="javascript:void(0);"><i class="fa fa-calendar fa-fw"></i> <?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).'<br>'.' ('.$totalRows_hot1.')';?></a>
                                    </li>
                                    <li class="col-sm-2 " id="<?php echo 'h'.$ds.$ds;?>" ><a class="ss pull-right"   href="javascript:void(0);" style="" onclick="rem('<?php echo $row_hot['datetime'];?>','<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.' records )';?>','<?php echo $fns;?>');"><i class="fa fa-trash-o " style="color:#D5472B" data-toggle="tooltip" data-original-title="Remove all records"></i></a></li>
                                     
									<?php $ds++;  $sda='';
													 $dsd='';
													 $fns='';}?>
													
												</ul>
											</div><!-- /.nav-dropdown-content scroll-nav-dropdown -->
											<div style="text-align:center" id="btdiv">
                                            
                                            </div>
										</li>
                                        <li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                </div>
                                    </div>
                                    <div class="table-responsive" id="tabonly">

 <?php

 ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th><i class="fa fa fa-map-marker"></i> Hotspot Name</th>
									<th><i class="fa fa-clock-o"></i> Timing </th>
									<th><i  class="fa fa-globe"></i> City </th>
									<th ><center><i class="fa fa-film"></i> Spot View </center></th>
                                    <th><i class="fa fa-exclamation-triangle"></i> Process </th>
								</tr>
							</thead>
							<tbody>
                            <?php
                            $i=1;
							$es='';
							$es1='';
							do{
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td width="25%" ><?php echo $row_hspotpro['spot_name'];?></td>
									<td width="18%"><?php 
									$match[1]='';
									$text =$row_hspotpro['spot_timings'];
								 $strpos=strpos($text,'(');
								$endpos=strpos($text,')');
								if($strpos != 0)
								{
									$txt= $row_hspotpro['spot_timings'];
									echo substr($row_hspotpro['spot_timings'],0,$strpos)."<br>";
									echo $stext=substr($txt,$strpos);
								}else
								{
									echo $row_hspotpro['spot_timings'];
								}
								?></td>
									<td  width="15%" > <?php
									
									mysql_select_db($database_divdb, $divdb);
	$query_city = "SELECT * FROM dvi_cities where status = '0' and id='$row_hspotpro[spot_city]'";
	$hotelcity = mysql_query($query_city, $divdb) or die(mysql_error());
	$row_hotelcity = mysql_fetch_assoc($hotelcity);								 
									//  echo $row_hotelcity['name']."<br>";
									  
	mysql_select_db($database_divdb, $divdb);
	$query_state = "SELECT * FROM dvi_states where status = '0' and code='$row_hspotpro[spot_state]'";
	$hotelstate= mysql_query($query_state, $divdb) or die(mysql_error());
	$row_hotelstate = mysql_fetch_assoc($hotelstate);								 
									 // echo "".$row_hotelstate['name']."";
									?></td>
                                    
									<td align="center" width="18%" >
                                    <div class="btn-group" align="center">
<?php if( $row_hspotpro['spot_images'] != '') 
{?>
<a class="add_hots4 btn  btn-default"  title="Images of - <?php echo $row_hspotpro['spot_name'];?>" href="ADMIN/hotspot_images.php?sid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-picture-o" style="color:#3576AC"></i></a>
<?php }else{ ?>
<a class=" btn  btn-default"  title="Images of - <?php echo $row_hspotpro['spot_name'];?>" style="color:#CCC;" ><i class="fa fa-picture-o" ></i></a>
<?php }
if($row_hspotpro['video_link'] != '')
{
?>
                                    <a class="viewspot1 btn  btn-default"  title="Video of - <?php echo $row_hspotpro['spot_name'];?>" href="<?php echo $row_hspotpro['video_link'];?>"><i class="fa fa-video-camera" style="color:#3576AC"></i></a>
	<?php }else{?>
    								<a class=" btn  btn-default"  title="Video of - <?php echo $row_hspotpro['spot_name'];?>" style="color:#CCC;" ><i class="fa fa-video-camera" ></i></a>
    <?php }?>								
                                    
										</div>
                                   <input type="hidden" id='img<?php echo $row_hspotpro['hotspot_id']; ?>' value='<?php echo $row_hspotpro['spot_images']; ?>'  />
                                    </td>
                                    <td class="center" width="14%">
                                    <div class="btn-group">
								  <button  class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown" >
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle pull-right" role="menu" style="width:12%">
								
                                    <li>
                                    <a class="update_hot" title="Update - <?php //echo $row_vehipro['vehicle_type'];?>" href="<?php echo $_SESSION['grp'];?>/update_hotspot.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update Details</a></li>
                                    <li><a class="add_hots3" href="<?php echo $_SESSION['grp'];?>/spot_img_upload.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo  $row_hspotpro['hotspot_id'];?>" onclick="get_sid('<?php echo  $row_hspotpro['hotspot_id'];?>')" ><i class="fa fa-upload"></i>&nbsp; Upload Images</a></li>
                                  <li><a href="javascript:void(0);" onclick="removes('<?php  echo $row_hspotpro['hotspot_id'];?>')" ><i class="fa fa-trash-o"></i>&nbsp; Remove</a> <input type="hidden" value="<?php echo $row_hspotpro['spot_name']; ?>" id="txt_<?php echo $row_hspotpro['hotspot_id']; ?>"  /></li>
                                  
								
								  </ul>
                                  
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;}while($row_hspotpro = mysql_fetch_assoc($hspotpro));?>
                                </tbody>
                                </table>
                                </div>
                                <div class="" id="tabon2">
                                </div>
                                  <?php }else{?>  
                                    <div class="alert alert-danger alert-bold-border fade in alert-dismissable">
                                    <p><strong>Welcome! <?php echo $_SESSION['name'];?></strong></p>
                                    <span class="text-muted">Vehicle's are not yet setting. Click to setup </span>
                                    &nbsp;&nbsp;
                                    <div class="btn-group">
								  <a class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-random"></i> Via <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu">
                                  <li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
									<li><a class="add_hots1" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_hots2 " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                    </div>
                                    <?php }
	
}
?>


<?php
if(isset($_GET['type']) && $_GET['type']==9)
{ 

mysql_select_db($database_divdb, $divdb);
$query_hotelpro = "SELECT * FROM hotel_pro where status='0' ORDER BY sno ASC";
$hotelpro = mysql_query($query_hotelpro, $divdb) or die(mysql_error());
$row_hotelpro = mysql_fetch_assoc($hotelpro);
$totalRows_hotelpro = mysql_num_rows($hotelpro);?>
<?php if($totalRows_hotelpro>0){?>
<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th width="5%"># </th>
									<th width="20%"><i class="fa fa-building "></i> Hotel Name</th>
                                    <th width="25%"><i class="fa fa-university"></i> Residential Address</th>
                                   <!-- <th width="12%"><i class="fa fa-star-half-o"></i> Hotel Type</th>-->
                                    <th width="15%"><i class="fa  fa-tablet "></i> Room Type</th>
                                    <th width="15%"><i class="fa  fa-spoon "></i> Meal</th>
                                    <th width="15%"><i class="fa  fa-th"></i> Special Amenities</th>
									<th width="25%"><i class="fa fa-exclamation-triangle"></i> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
				while($row_hotelpro = mysql_fetch_assoc($hotelpro))
				{
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td width="20%" ><?php echo $row_hotelpro['hotel_name'];?><br />
                          <label style="color:#B07A7A;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star-half-full (alias)"></i> <?php echo "&nbsp;".$row_hotelpro['category'];?></label></td>
                                    <td  width="25%" style="word-wrap:break-word">
                                     <?php
									  //$row_hotelpro['location']."<br>";
									 $addr= str_replace('\\',',',$row_hotelpro['location']);
									 echo $addr."<br>";
	mysql_select_db($database_divdb, $divdb);
	$query_city = "SELECT * FROM dvi_cities where status = '0' and id='$row_hotelpro[city]'";
	$hotelcity = mysql_query($query_city, $divdb) or die(mysql_error());
	$row_hotelcity = mysql_fetch_assoc($hotelcity);								 
									//  echo $row_hotelcity['name']."<br>";
									  
	mysql_select_db($database_divdb, $divdb);
	$query_state = "SELECT * FROM dvi_states where status = '0' and code='$row_hotelpro[state]'";
	$hotelstate= mysql_query($query_state, $divdb) or die(mysql_error());
	$row_hotelstate = mysql_fetch_assoc($hotelstate);								 
									 // echo $row_hotelstate['name'];
									  
									 ?></td>
									<!--<td  width="12%"><?php// echo $row_hotelpro['category'];?></td>-->
                                    <td   width="15%" >
									<?php
	mysql_select_db($database_divdb, $divdb);
	$query_room = "SELECT * FROM hotel_season where status = '0' and hotel_id='$row_hotelpro[hotel_id]'";
	$hotelroom = mysql_query($query_room, $divdb) or die(mysql_error());
	$tot_room=mysql_num_rows($hotelroom);
	if($tot_room>0){
	while($row_hotelroom = mysql_fetch_assoc($hotelroom))
	{	?>	
    
    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/view_season.php?sno=<?php echo $row_hotelroom['sno'];?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&room_type=<?php echo $row_hotelroom['room_type']; ?>"><i class="fa fa-tags"></i>&nbsp;<?php echo $row_hotelroom['room_type']; ?></a>
    <br />	
<?php    }
	}else{ //if end
	echo "No Room types";
	}?>
                                    </td>
                                    <td  width="15%"><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '5';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Lunch </a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '6';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Dinner</a>
                                    </td>
                                    <td  width="15%"><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '1';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Flower bed decoration</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '2';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Cake</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '3';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Candle light dinner</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '4';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Fruit basket</a>
                                    </td>
                                     <td width="25%">
                                     <div class="btn-group">
								  <button class="dropdown-toggle btn btn-xs btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/hotel_update.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a></li>
                                    
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/ajax_hotel.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&type=<?php echo "3";?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
                                    
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
                                    </div>
                                     </td>
                                     
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
<?php }else{ 
?>
<center><lable> No Entry Available</lable></center>
<?php 
}
}?>