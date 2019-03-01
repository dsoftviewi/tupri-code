<?php
require_once('../Connections/divdb.php');
session_start();

if($_POST['type']=="VIEW_FULL_DET") {
$id=$_POST['id'];
?>

<div class="col-sm-12" id="ac_div<?php echo $id;?>" style="margin-top:20px;">
<div class="col-sm-2 reduce_padd" > 
<?php 
$city= $conn->prepare("SELECT * FROM dvi_cities where status = '0' ORDER BY name ASC");
$city->execute();
//$row_city = mysql_fetch_assoc($city);
$row_city_main=$city->fetchAll();
$totalRows_city = $city->rowCount();
?>
<select class="chosen-select" name="ac_sel<?php echo $id;?>" id="ac_sel<?php echo $id;?>" onchange="place_det(this.value,'<?php echo $id;?>')">
<?php foreach($row_city_main as $row_city)
{ ?>
<option value="<?php echo $row_city['id']; ?>"> <?php echo $row_city['name']; ?> </option>
<?php } ?>
</select>
</div>
<div class="col-sm-2 reduce_padd" id="place_view<?php echo $id;?>" > 
<select class="chosen-select" hidden>                                     	
</select>
</div>
<div class="col-sm-2 reduce_padd">
<input type="text" class="form-control" name="ac_name<?php echo $id;?>" id="ac_name<?php echo $id;?>" >
</div>
<div class="col-sm-2 reduce_padd" style="width: 133px">
<input type="text" class="form-control datepicker_ac datepicker" name="ac_fdate<?php echo $id;?>" id="ac_fdate<?php echo $id;?>" data-date-format='yyyy-mm-dd' readonly="readonly" >
</div>
<div class="col-sm-2 reduce_padd" style="width: 133px">
<input type="text" class="form-control datepicker_ac datepicker" name="ac_tdate<?php echo $id;?>" id="ac_tdate<?php echo $id;?>" data-date-format='yyyy-mm-dd' readonly="readonly">
</div>
<div class="col-sm-1 reduce_padd"  > 
<input type="text" class="form-control" name="ac_amount<?php echo $id;?>" id="ac_amount<?php echo $id;?>" onkeypress="decemal_or_number('1')" >
</div>
<div class="col-sm-1 reduce_padd" >
<div class="col-sm-6"><a class="btn btn-sm btn-danger" name="ac_sub_btn<?php echo $id;?>" id="ac_sub_btn<?php echo $id;?>" onClick="sub_addi_fun('<?php echo $id;?>')"><i class="fa fa-minus"></i></a></div>
<div class="col-sm-6">
<a class="btn btn-sm btn-info" name="ac_add_btn<?php echo $id;?>" id="ac_add_btn<?php echo $id;?>" onClick="addi_add_fun()"><i class="fa fa-plus"></i></a> 									</div>					
</div>
</div>
<?php	
}

if($_POST['type']=="VIEW_PLACE") {
$id=$_POST['id'];
$val=$_POST['val'];

$hspotpro1 = $conn->prepare("SELECT * FROM hotspots_pro where status = '0' and spot_city=? ORDER BY spot_prior ASC ");
$hspotpro1->execute(array($id));
$row_hspotpro1_main = $hspotpro1->fetchAll();
$totalRows_hspotpro1 = $hspotpro1->rowCount();
?>
<select class="chosen-select" name="place<?php echo $val;?>" id="place<?php echo $val;?>">
<?php foreach($row_hspotpro1_main as $row_hspotpro1)
{ ?>
<option value="<?php echo $row_hspotpro1['hotspot_id']; ?>"> <?php echo $row_hspotpro1['spot_name']; ?> </option>
<?php } ?>
</select>
<?php
}
if($_POST['type']=="VIEW_PLACE_UP") {
$id=$_POST['id'];

$hspotpro1 = $conn->prepare("SELECT * FROM hotspots_pro where status = '0' and spot_city=? ORDER BY spot_prior ASC ");
$hspotpro1->execute(array($id));
$row_hspotpro1_main = $hspotpro1->fetchAll();
$totalRows_hspotpro1 = $hspotpro1->rowCount();
?>
<select class="chosen-select" name="ac_pla_upd" id="ac_pla_upd">
<?php foreach($row_hspotpro1_main as $row_hspotpro1)
{ ?>
<option value="<?php echo $row_hspotpro1['hotspot_id']; ?>"> <?php echo $row_hspotpro1['spot_name']; ?> </option>
<?php } ?>
</select>
<?php
}
if(isset($_POST['type']) && $_POST['type']=="PAGINATION_ITN")
{
$hspotpro1 = $conn->prepare("SELECT * FROM hotspots_pro where status = '0'  ORDER BY sno DESC ");
$hspotpro1->execute();
$row_hspotpro1 = $hspotpro1->fetch(PDO::FETCH_ASSOC);
$totalRows_hspotpro1 = $hspotpro1->rowCount();
	
if($totalRows_hspotpro1>0){
	?>
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
									<li><a class="add_hots1" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_POST['mm'];?>&sm=<?php echo $_POST['sm'];?>&type=<?php echo md5(1);?>"><i class="fa fa-credit-card"></i>&nbsp;Form Entry</a></li>
									<li><a class="add_hots2 " title="Upload file" href="<?php echo $_SESSION['grp'];?>/add_hotspots.php?mm=<?php echo $_POST['mm'];?>&sm=<?php echo $_POST['sm'];?>&type=<?php echo md5(2);?>"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;File Upload</a></li>
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
								  </ul>
								</div>
                                &nbsp;&nbsp;
                                    &nbsp;&nbsp;
                                    <input type="hidden" id="lcn" value="1" />
                                    <div class="btn-group">
								  <a class="btn btn-danger btn-sm dropdown-toggle" id="sptxt" data-toggle="dropdown">
									<i class="fa fa-filter"></i> All records (<?php echo $totalRows_hspotpro1;?>) <span class="caret"></span>
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
											
													  foreach($row_hot_main as $row_hot)
													  {
									   
	$hot1 = $conn->prepare("SELECT * FROM hotspots_pro where datetime=?");
	$hot1->execute(array($row_hot['datetime']));
	$row_hot1 = $hot1->fetch(PDO::FETCH_ASSOC);
 $totalRows_hot1 = $hot1->rowCount();
	
	
	$sda=str_replace('-','_',$row_hot['datetime']);
								    $dsd=str_replace(' ','_',$sda);
									 $fns=str_replace(':','_',$dsd).'.csv';
									   ?>
                                    <li class="col-sm-10 " >
                                    <a id="<?php echo 'h'.$ds;?>" style="margin-left:-3%;color:#656D8D;" onclick="lodloc('<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.')';?>','<?php echo $totalRows_hspotpro1;?>','<?php echo $row_hot['datetime'];?>')"  data-toggle="tooltip" data-original-title="Click to view all records" href="javascript:void(0);"><i class="fa fa-calendar fa-fw"></i> <?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).'<br>'.' ('.$totalRows_hot1.')';?></a>
                                    </li>
                                    <li class="col-sm-2 " id="<?php echo 'h'.$ds.$ds;?>" ><a class="ss pull-right"   href="javascript:void(0);" style="" onclick="rem('<?php echo $row_hot['datetime'];?>','<?php echo $row_hot['datetime'].' '.date('a',strtotime($row_hot['datetime'])).' ('.$totalRows_hot1.' records )';?>','<?php echo $fns;?>');"><i class="fa fa-trash-o " style="color:#D5472B" data-toggle="tooltip" data-original-title="Remove all records"></i></a></li>
                                     
									<?php $ds++;  $sda='';
													 $dsd='';
													 $fns='';}
													 ?>
													
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

<div class="row">
<?php  


  $client_detailsp = $conn->prepare("SELECT * FROM  hotspots_pro where status='0'  order by sno DESC");
  $client_detailsp->execute();
  $row_client_detailsp = $client_detailsp->fetch(PDO::FETCH_ASSOC);
  $totalRows_client_detailsp =$client_detailsp->rowCount();
?>
<?php if($totalRows_client_detailsp >100){
  
   $img_count = $totalRows_client_detailsp ;
$per_page = 100;
$max_pages = ceil($img_count / $per_page);
$output='';
$href="pagi('"; 
  $pages  = ceil($img_count / $per_page);?>

<div align="right" style="padding-right:35px">
<ul class="pagination" >
<?php


 if($pages>1) {
      if(isset($_POST["page"])=="") {
        $_POST["page"]=1;
      }


      if($_POST["page"] == 1) {?>
                  <li class="disabled"><a style="cursor:pointer;cursor:hand" onclick="javascript:void();">&laquo;</a></li>
                  <li class="disabled"><a style="cursor:pointer;cursor:hand" onclick="javascript:void();">&lsaquo;</a></li>
                                  <?php } else { ?>
                                   <li><a style="cursor:pointer;cursor:hand" onclick="<?php echo $href;?>1')">&laquo;</a></li>
                  <li><a style="cursor:pointer;cursor:hand" onclick="<?php echo $href.($_POST["page"]-1);?>">&lsaquo;</a></li>
                                  <?php


                                   }

if(($_POST["page"]-3)>0) {
        if($_POST["page"] == 1) { ?>
                  <li class="active"><a style="cursor:pointer;cursor:hand" onclick="javascript:void();">1</a></li>
                  <?php } else { ?>
 <li><a style="cursor:pointer;cursor:hand" onclick="<?php echo $href;?>1')">1</a></li>
                   <?php } } if(($_POST["page"]-3)>1) {?>
                   <li><a style="cursor:pointer;cursor:hand" onclick="javascript:void();">...</a></li>
                  <?php }
                  for($i=($_POST["page"]-2); $i<=($_POST["page"]+2); $i++)  {
        if($i<1) continue;
        if($i>$pages) break;
        if($_POST["page"] == $i) {?>
                  <li class="active"><a style="cursor:pointer;cursor:hand" onclick="javascript:void();"><?php echo $i;?></a></li>
                  <?php }else { ?>
<li><a style="cursor:pointer;cursor:hand" onclick="<?php echo $href;?><?php echo $i;?>')"><?php echo $i;?></a></li>
                   <?php } }
if(($pages-($_POST["page"]+2))>1) { ?>
<li><a style="cursor:pointer;cursor:hand" onclick="javascript:void();">...</a></li>
<?php }

if(($pages-($_POST["page"]+2))>0) {
        if($_POST["page"] == $pages) {?>
<li class="active"><a style="cursor:pointer;cursor:hand" onclick="javascript:void();"><?php echo $pages;?></a></li>
        <?php }else { ?>

<li><a style="cursor:pointer;cursor:hand" onclick="<?php echo $href;?><?php echo $pages;?>')"><?php echo $pages;?></a></li>
        <?php } } 
if($_POST["page"] < $pages) {?> 

<li><a style="cursor:pointer;cursor:hand" onclick="<?php echo $href;?><?php echo ($_POST["page"]+1);?>')">&rsaquo;</a></li>
<li><a style="cursor:pointer;cursor:hand" onclick="<?php echo $href;?><?php echo ($pages);?>')">&raquo;</a></li>
                  <?php } else {?>
                  <li class="disabled"><a style="cursor:pointer;cursor:hand" onclick="javascript:void();">&rsaquo;</a></li>
                  <li class="disabled"><a style="cursor:pointer;cursor:hand" onclick="javascript:void();">&raquo;</a></li>
                  <?php } ?>
                  

                                   <?php

  if($_POST['page']==1) {
$pcnt=$_POST['page']-1;
$strt=$_POST['page'];
$end=100;
}
else {
$pcnt=($_POST['page']-1)*100;
$strt=(($_POST['page']-1)*100)+1;
  if($pages!=$_POST['page']) {
$end=$_POST['page']*100;
  } else {
$end1=$totalRows_client_detailsp-(($_POST['page']-1)*100);
$end=$end1+(($_POST['page']-1)*100);
  } }
                                    } ?>
                </ul></div>
                                <?php } ?>


<div  class="pull-left" style="color:#2C3E50; float:right; font-size:18px; padding-left:40px"><strong>Total number of Itineraries <?php echo $totalRows_client_detailsp ;?></strong></div>
<div  class="pull-right">
<strong style="color:#262213; font-size:13px;">
<?php if($totalRows_client_detailsp > 100) { ?><strong style="color:#2C3E50; float:right; font-size:18px; padding-right:35px">Showing <?php echo $strt;?> to <?php echo $end;?> of <?php echo $totalRows_client_detailsp ;?> Itineraries</strong><?php } ?>
</div><br><br></div>
                                    <div class="table-responsive" id="tabonly">
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th colspan="2"><i class="fa fa fa-map-marker"></i> Hotspot Name</th>
									<th><i class="fa fa-clock-o"></i> Timing </th>
									<th><i  class="fa fa-globe"></i> City </th>
									<th ><center><i class="fa fa-film"></i> Spot View </center></th>
                                    <th><i class="fa fa-exclamation-triangle"></i> Process </th>
								</tr>
							</thead>
							<tbody>
                            <?php

$hspotpro = $conn->prepare("SELECT * FROM hotspots_pro where status = '0' ORDER BY sno DESC LIMIT ".$pcnt.",100 ");
$hspotpro->execute();
$row_hspotpro_main = $hspotpro->fetchAll();
$totalRows_hspotpro = $hspotpro->rowCount();

                            $i=1;
							$es='';
							$es1='';
							foreach($row_hspotpro_main as $row_hspotpro){
								
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hspotpro['spot_city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);	
							?>
								<tr class="even gradeA">
									<td width="5%"><?php echo $i;?></td>
									<td width="25%" ><?php echo $row_hspotpro['spot_name'];?></td>
                                    <td width='12%'>
                                    	<a id="btn_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" class="badge badge-info icon-count" data-toggle='tooltip' data-original-title='Priority -<?php echo $row_hspotpro['spot_prior'].' ( '.$row_hotelcity['name'].' )'; ?>' style="background-color:#2893BD; color:#FDFEFF;" ondblclick="show_prior_tab('<?php echo $row_hspotpro['sno']; ?>','<?php echo $row_hspotpro['spot_city']; ?>')"><strong style="font-size:14px;"><?php echo $row_hspotpro['spot_prior']; ?></strong></a>
                                        
                                        <table id="tab_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" style="display:none;"><tr><td> 			<?php
									$hotprior = $conn->prepare("SELECT * FROM  hotspots_pro where spot_city=?");
									$hotprior->execute(array($row_hspotpro['spot_city']));
									//$row_hotprior= mysql_fetch_assoc($hotprior);
									$row_hotprior=$hotprior->fetch(PDO::FETCH_ASSOC);
									$tot_hotprior=$hotprior->rowCount();
										 ?>
                                    <?php if($tot_hotprior>0){ ?>
                                 <select name="prior_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" id="prior_<?php echo $row_hspotpro['sno'].'_'.$row_hspotpro['spot_city']; ?>" data-placeholder="Choose Priority" class="form-control city_cls<?php echo $row_hspotpro['spot_city']; ?>">
                                 <?php for($pr=1;$pr<= $tot_hotprior;$pr++)
								 {
									 if($pr==$row_hspotpro['spot_prior'])
									 {?>
								  <option selected value="<?php echo $pr; ?>"><?php echo $pr; ?></option>		 
									<?php }else{
									?>
													<option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
									<?php 			
									  }
								 }//for loop end?>
                                 </select> <?php }?>  </td><td><a class="btn  btn-default" onclick="update_prior('<?php echo $row_hspotpro['sno']; ?>','<?php echo $row_hspotpro['spot_city']; ?>','<?php echo $row_hotelcity['name']; ?>')"><i class="  fa fa-check-square" style="color:#23691E"></i></a></td><td><a class="btn  btn-default" onclick="hide_prior_tab('<?php echo $row_hspotpro['sno']; ?>','<?php echo $row_hspotpro['spot_city']; ?>')"><i class="  fa fa-times-circle" style="color:#900"></i></a></td></tr></table>
                                    </td>
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
									  echo $row_hotelcity['name']."<br>";
									  
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hspotpro['spot_state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									  echo "".$row_hotelstate['name']."";
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
                                    <a class="update_hot" title="Update - <?php echo $row_hspotpro['spot_name'];?>" href="<?php echo $_SESSION['grp'];?>/update_hotspot.php?mm=<?php echo $_POST['mm'];?>&sm=<?php echo $_POST['sm'];?>&hid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update Details</a></li>
                                    <li><a class="add_hots3" href="<?php echo $_SESSION['grp'];?>/spot_img_upload.php?mm=<?php echo $_POST['mm'];?>&sm=<?php echo $_POST['sm'];?>&hid=<?php echo  $row_hspotpro['hotspot_id'];?>" onclick="get_sid('<?php echo  $row_hspotpro['hotspot_id'];?>')" ><i class="fa fa-upload"></i>&nbsp; Upload Images</a></li>
                                  <li><a href="javascript:void(0);" onclick='removes("<?php  echo $row_hspotpro['hotspot_id'];?>","<?php echo $_POST['page'];?>")' ><i class="fa fa-trash-o"></i>&nbsp; Remove</a>
                                  <input type="hidden" value="<?php echo $row_hspotpro['spot_name']; ?>" id="txt_<?php echo $row_hspotpro['hotspot_id']; ?>"  /></li>
								  </ul>
                                    </div>
                                    </td>
								</tr>
                               <?php $i++;}?>
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
                                    <?php }?>

	<?php
	}
?>