<?php
require_once('../Connections/divdb.php');
session_start();
?>

<?php
if(isset($_GET['type']) && $_GET['type']==1)
{ $state_id=$_GET['sid'];
									$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where region=?");
									$hotelcity->execute(array($state_id));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main=$hotelcity->fetchAll();
									//print_r($row_hotelstate_main);
									?>
									<span class="input-group-addon tooltips" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose City" name="hotel_city" id='hotel_city' class="form-control chosen-select " tabindex="2">									<option></option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) {?>
										<option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>
                                        <?php } ?>
									</select>
<?php }
?>


<?php
if(isset($_GET['type']) && $_GET['type']==2)
{ $state_id=$_GET['sid'];
									$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where region=?");
									$hotelcity->execute(array($state_id));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main=$hotelcity->fetchAll();
									?>
                                   
										 <select data-placeholder="Choose a city" name="hotel_city" id="hotel_city" class="form-control chosen-select " tabindex="2" onchange="show_priority(this.value)">									<option></option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) { ?>
										<option value="<?php echo $row_hotelcity['id']; ?>"><?php echo $row_hotelcity['name']; ?></option>
                                        <?php } ?>
									</select>
<?php }
?>

<?php
if(isset($_GET['type']) && $_GET['type']==3)
{ 
$hotel_id=$_GET['hid'];
	/*$SQLupd="UPDATE hotel_pro set status='1' where hotel_id='$hotel_id'";
	mysql_select_db($database_divdb, $divdb);
	$Resultupd = mysql_query($SQLupd, $divdb) or die(mysql_error());
	
	$SQLupdseas="UPDATE hotel_season set status='1' where hotel_id='$hotel_id'";
	mysql_select_db($database_divdb, $divdb);
	$ResultSQLupdseas = mysql_query($SQLupdseas, $divdb) or die(mysql_error());*/
	
	$SQLDEl1=$conn->prepare("DELETE FROM hotel_pro WHERE hotel_id=?");
	$SQLDEl1->execute(array($hotel_id));
	
	$SQLDEl2=$conn->prepare("DELETE FROM hotel_season WHERE hotel_id=?");
	$SQLDEl2->execute(array($hotel_id));
	
	$SQLDEl3=$conn->prepare("DELETE FROM hotel_food WHERE hotel_id=?");
	$SQLDEl3->execute(array($hotel_id));
	
	echo "<script>parent.document.location.href='../admin_manahotel.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."';</script>"; 
}
?>

<?php
if(isset($_GET['type']) && $_GET['type']==4)
{
	
	 $season_sno=$_GET['sno'];
$season_name=$_GET['sname'];
$season_fdate=$_GET['fdate'];
$season_tdate=$_GET['tdate'];

	echo $updateSS=$conn->prepare("UPDATE setting_season set season_name=?, from_date=?, to_date=? where sno=?");
	$updateSS->execute(array($season_name,$season_fdate,$season_tdate,$season_sno));

}?>


<?php
if(isset($_GET['type']) && $_GET['type']==5)
{
	$sno=$_GET['sno'];
	$SQLupdseas=$conn->prepare("UPDATE hotel_season set status='1' where sno=?");
	$SQLupdseas->execute(array($sno));
	
    
}?>

<?php
if(isset($_GET['type']) && $_GET['type']==6)
{
	$sno=$_GET['sno'];
	echo $updseas=$conn->prepare("UPDATE setting_season set season_name='',from_date='0000-00-00', to_date='0000-00-00' where sno=?");
	$updseas->execute(array($sno));
    
}?>
<?php
if(isset($_GET['type']) && $_GET['type']==7)
{
	$sno=$_GET['sno'];
	$updseas=$conn->prepare("UPDATE setting_season set lock_sts='0' where sno=?");
	$updseas->execute(array($sno));
	echo "suc";
    
}?>

<?php
if(isset($_GET['type']) && $_GET['type']==8)
{
	$htl = $conn->prepare("SELECT * FROM hotel_pro where  status = '0' ORDER BY sno ASC");
	$htl->execute();
	//$row_htl = mysql_fetch_assoc($htl);
	$row_ht1_main =$ht1->fetchAll();
	$totalRows_htl = $ht1->rowCount();
	
								   
								 if($totalRows_htl>0)  {
								   ?>
                                    <input type="hidden" id="tot" value="<?php echo $totalRows_htl;?>" />
						<table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
									<th width="5%"># </th>
                                    <th width="25%"><i class="fa fa-building  "></i>&nbsp; Hotel Information</th>
									<th width="70%" ><center><i class="fa fa-cloud-upload "></i>&nbsp; Season Details</center></th>
								</tr>
							</thead>
							<tbody>
                            
                            <?php
							$i=1;
						$cv=0;
				foreach($row_ht1_main as $row_htl)
				{
							?>
                           
								<tr class="even gradeA">
									<td ><br /><br /><br /><?php echo $i;?></td>
                                    <td  style="word-wrap:break-word;" ><br /><br /><br /><label id="sn<?php echo $row_htl['hotel_id']; ?>"><?php
									echo $row_htl['hotel_name']."<br>";
									 $addr= str_replace('\\',',',$row_htl['location']);
									 echo $addr."<br>";
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_ht1['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelcity['name']."<br>";
									  
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_ht1['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);			 
									  echo $row_hotelstate['name'];
									  
									 ?>
                                    
                                    </label>
                                     <input type="hidden" id="htl<?php echo $i;?>" value="<?php echo $row_htl['hotel_id']; ?>" />
                                    </td>
                                    <td>
                                    <?php
	$season = $conn->prepare("SELECT * FROM setting_season where hotel_id=? and status = '0' ORDER BY sno ASC");
	$season->execute(array($row_ht1[hotel_id]));
	//$row_season = mysql_fetch_assoc($season);
	$row_season_main=$season->fetchAll();
	$totalRows_season = $season->rowCount();
									?>
<table  width="100%"  class="table table-th-block table-striped" >

<thead align="center" >

<th width="30%" style="color:#416D9C;" ><i class="fa fa-cloud "></i>&nbsp; Season Name</th>
<th  width="33%" style="color:#416D9C;"><i class="fa fa-calendar-o "></i>&nbsp; Starting Date</th>
<th width="33%" style="color:#416D9C;"><i class="fa fa-calendar "></i>&nbsp; Ending Date
<a onclick="cancel_edit('<?php echo $row_htl['hotel_id'];?>')" id="cancel1_<?php echo $row_htl['hotel_id']; ?>" class="btn btn-xs btn-danger pull-right" href="javascript:void(0);" style="text-decoration:none; display:none;"><i class="fa fa-times "></i>Cancel</a>
</th>
<th width="4%">
<a onclick="make_editable('<?php echo $row_htl['hotel_id'];?>','<?php echo $i;?>')" id="edit1_<?php echo $row_htl['hotel_id']; ?>" class="btn btn-xs btn-info" href="javascript:void(0);" style="text-decoration:none;"><i class="fa  fa-edit "></i> Edit</a>

<a onclick="update_edit('<?php echo $row_htl['hotel_id'];?>')" id="update1_<?php echo $row_htl['hotel_id']; ?>" class="btn btn-xs btn-info" href="javascript:void(0);" style="text-decoration:none; display:none;"><i class="fa  fa-edit "></i> Update</a>
</th>
<tbody>
<?php
$r=0;
 foreach($row_season_main as $row_season){
	?>
    
<tr id="trrow_<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" 
<?php if($row_season['to_date']=='0000-00-00' && $row_season['from_date']=='0000-00-00') {?> style="display:none;"<?php }?>
>
<input type="hidden" value="<?php echo $row_season['sno']; ?>" id="sea_sno<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" />
<td>
<label id="sn<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>"><?php echo $row_season['season_name']; ?></label>
<input type="text"  class="form-control" id="editsn<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" value="<?php echo $row_season['season_name']; ?>" style="display:none;">
</td>

<td>
<label id="fd<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>"><?php echo $row_season['from_date']; ?></label>
<input type="text" data-date-format="yyyy-mm-dd"  class="form-control datepick" id="editfd<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" value="<?php if($row_season['from_date']!='0000-00-00') { echo $row_season['from_date']; }?>" style="display:none;">
</td>

<td>
<label id="td<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>"><?php echo $row_season['to_date']; ?></label>
<input type="text" data-date-format="yyyy-mm-dd"  class="form-control datepick" id="edittd<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" value="<?php if($row_season['to_date']!='0000-00-00') {echo $row_season['to_date'];}?>" style="display:none;">
</td>
<td>

<center>
<a title="Remove this season" href="javascript:void(0);" id="remove1_<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];; ?>" onclick="remove_season_fun('<?php echo $row_season['sno']; ?>','<?php echo $r; ?>','<?php echo $row_htl['hotel_id'];?>')" style="text-decoration:none; color:#666">
<i class="fa fa-trash-o"></i>
</a>
</center>

</td>
</tr>

<?php
	$r++;// }//if end
  } ?>
  <tr id="trrow_def_<?php echo $row_htl['hotel_id']; ?>">
  </tr>
  <tr>
  <td colspan="4" >
  <center>

  <a class="btn btn-default btn-rounded-lg" title="Add more season" href="javascript:void(0);" id="more_id1_<?php echo $row_htl['hotel_id']; ?>" onclick="add_more_season('<?php echo $row_htl['hotel_id'] ?>')" style="text-decoration:none; display:none; color:#666">
Add more season for this hotel &nbsp; <i class="fa fa-plus"></i>
</a>

  </center>
  </td>
  </tr>
  <input type="hidden" id="rcout_<?php echo $row_htl['hotel_id'] ?>" value="<?php echo $r;?>" />
<tbody>
</table>
                                    </td>
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                <?php } else{?>
                                <h4 style="color:#900; font-weight:600;" align="center" > No Entry Found...</h4>
                                <?php } 
                               
}?>

<?php
if(isset($_GET['type']) && $_GET['type']==9)
{
	$hotel_id=$_GET['hid'];
	
	if($hotel_id != 'all')
	{
	$htl = $conn->prepare("SELECT * FROM hotel_pro where  status = '0' and hotel_id=? ORDER BY sno ASC");
	}else
	{
		$htl = $conn->prepare("SELECT * FROM hotel_pro where  status = '0'  ORDER BY sno ASC");
	}
	
	$htl->execute(array($hotel_id));
	$row_ht1_main=$ht1->fetchAll();
	$totalRows_htl = $ht1->rowCount();
	
								   
								 if($totalRows_htl>0)  {
								   ?>
                                   <input type="hidden" id="tot" value="<?php echo $totalRows_htl;?>" />
						<table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
									<th width="5%"># </th>
                                    <th width="25%"><i class="fa fa-building  "></i>&nbsp; Hotel Information</th>
									<th width="70%" ><center><i class="fa fa-cloud-upload "></i>&nbsp; Season Details</center></th>
								</tr>
							</thead>
							<tbody>
                             
                            <?php
							$i=1;
						$cv=0;
				foreach($row_ht1_main as $row_htl)
				{
							?>
                           
								<tr class="even gradeA">
									<td ><br /><br /><br /><?php echo $i;?></td>
                                    <td  style="word-wrap:break-word;" ><br /><br /><br /><label id="sn<?php echo $row_htl['hotel_id']; ?>"><?php
									echo $row_htl['hotel_name']."<br>";
									 $addr= str_replace('\\',',',$row_htl['location']);
									 echo $addr."<br>";
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_ht1['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelcity['name']."<br>";
									  
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_ht1['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelstate['name'];
									  
									 ?>
                                    
                                    </label>
                                     <input type="hidden" id="htl<?php echo $i;?>" value="<?php echo $row_htl['hotel_id']; ?>" />
                                    </td>
                                    <td>
                                    <?php
	$season = $conn->prepare("SELECT * FROM setting_season where hotel_id=? and status = '0' ORDER BY sno ASC");
	$season->execute(array($row_ht1['hotel_id']));
	//$row_season = mysql_fetch_assoc($season);
	$row_season_main=$season->fetchAll();
	$totalRows_season = $season->rowCount();
									?>
<table  width="100%"  class="table table-th-block table-striped" >

<thead align="center" >

<th width="30%" style="color:#416D9C;" ><i class="fa fa-cloud "></i>&nbsp; Season Name</th>
<th  width="33%" style="color:#416D9C;"><i class="fa fa-calendar-o "></i>&nbsp; Starting Date</th>
<th width="33%" style="color:#416D9C;"><i class="fa fa-calendar "></i>&nbsp; Ending Date
<a onclick="cancel_edit('<?php echo $row_htl['hotel_id'];?>')" id="cancel1_<?php echo $row_htl['hotel_id']; ?>" class="btn btn-xs btn-danger pull-right" href="javascript:void(0);" style="text-decoration:none; display:none;"><i class="fa fa-times "></i>Cancel</a>
</th>
<th width="4%">
<a onclick="make_editable('<?php echo $row_htl['hotel_id'];?>','<?php echo $i;?>')" id="edit1_<?php echo $row_htl['hotel_id']; ?>" class="btn btn-xs btn-info" href="javascript:void(0);" style="text-decoration:none;"><i class="fa  fa-edit "></i> Edit</a>

<a onclick="update_edit('<?php echo $row_htl['hotel_id'];?>')" id="update1_<?php echo $row_htl['hotel_id']; ?>" class="btn btn-xs btn-info" href="javascript:void(0);" style="text-decoration:none; display:none;"><i class="fa  fa-edit "></i> Update</a>
</th>
<tbody>
<?php
$r=0;
 foreach($row_season_main as $row_season){
	?>
    
<tr id="trrow_<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" 
<?php if($row_season['to_date']=='0000-00-00' && $row_season['from_date']=='0000-00-00') {?> style="display:none;"<?php }?>
>
<input type="hidden" value="<?php echo $row_season['sno']; ?>" id="sea_sno<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" />
<td>
<label id="sn<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>"><?php echo $row_season['season_name']; ?></label>
<input type="text"  class="form-control" id="editsn<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" value="<?php echo $row_season['season_name']; ?>" style="display:none;">
</td>

<td>
<label id="fd<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>"><?php echo $row_season['from_date']; ?></label>
<input type="text" data-date-format="yyyy-mm-dd"  class="form-control datepick" id="editfd<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" value="<?php if($row_season['from_date']!='0000-00-00') { echo $row_season['from_date']; }?>" style="display:none;">
</td>

<td>
<label id="td<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>"><?php echo $row_season['to_date']; ?></label>
<input type="text" data-date-format="yyyy-mm-dd"  class="form-control datepick" id="edittd<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];?>" value="<?php if($row_season['to_date']!='0000-00-00') {echo $row_season['to_date'];}?>" style="display:none;">
</td>
<td>

<center>
<a title="Remove this season" href="javascript:void(0);" id="remove1_<?php echo $r; ?>_<?php echo $row_htl['hotel_id'];; ?>" onclick="remove_season_fun('<?php echo $row_season['sno']; ?>','<?php echo $r; ?>','<?php echo $row_htl['hotel_id'];?>')" style="text-decoration:none;  color:#666">
<i class="fa fa-trash-o"></i>
</a>
</center>

</td>
</tr>

<?php
	$r++;// }//if end
  } ?>
  <tr id="trrow_def_<?php echo $row_htl['hotel_id']; ?>">
  </tr>
  <tr>
  <td colspan="4" >
  <center>

  <a class="btn btn-default btn-rounded-lg" title="Add more season" href="javascript:void(0);" id="more_id1_<?php echo $row_htl['hotel_id']; ?>" onclick="add_more_season('<?php echo $row_htl['hotel_id'] ?>')" style="text-decoration:none; display:none; color:#666">
Add more season for this hotel &nbsp; <i class="fa fa-plus"></i>
</a>

  </center>
  </td>
  </tr>
  <input type="hidden" id="rcout_<?php echo $row_htl['hotel_id'] ?>" value="<?php echo $r;?>" />
<tbody>
</table>
                                    </td>
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                <?php } else{?>
                                <h4 style="color:#900; font-weight:600;" align="center" > No Entry Found...</h4>
                                <?php }
                                
}?>




<?php
if(isset($_GET['type']) && $_GET['type']==10)
{
	$hotel_id=$_GET['hid'];
	
	if($hotel_id != 'all')
	{
	$hotelpro = $conn->prepare("SELECT * FROM hotel_pro where status = '0' and hotel_id=? ORDER BY sno ASC");
	}else
	{
	$hotelpro = $conn->prepare("SELECT * FROM hotel_pro where status = '0' ORDER BY sno ASC");
	}

	
	$hotelpro->execute(array($hotel_id));
	$row_hotelpro_main=$hotelpro->fetchAll();
	$totalRows_hotelpro = $hotelpro->rowCount();
								   
								 if($totalRows_hotelpro>0)  {
								   ?>
						<table class="table table-striped table-hover datatable-example">
							<thead class="the-box dark full">
								<tr>
									<th># </th>
									<th><i class="fa fa-building "></i> Hotel Name</th>
                                    <th><i class="fa fa-star-half-o"></i> Hotel Type</th>
                                    <th><i class="fa  fa-tablet "></i> Room Type</th>
									<th><i class="fa fa-university"></i> Residential Address</th>
									<th><i class="fa fa-exclamation-triangle"></i> Process</th>
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
									<td width="25%" ><?php echo $row_hotelpro['hotel_name'];?></td>
									<td  width="15%"><?php echo $row_hotelpro['category'];?></td>
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
                                    
                                    <td  width="25%" style="word-wrap:break-word">
                                     <?php
									  //$row_hotelpro['location']."<br>";
									 $addr= str_replace('\\',',',$row_hotelpro['location']);
									 echo $addr."<br>";
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hotelpro['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelcity['name']."<br>";
									  
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hotelpro['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									  echo $row_hotelstate['name'];
									  
									 ?></td>
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
                                <?php } 
                                
                                }?>
								
<?php
if(isset($_GET['type']) && $_GET['type']==11)
{

	$spot_id=$_GET['sid'];
	$searchString = $spot_id;
$files = glob('../img_upload/uploads/files/*');
//echo $files;
$filesFound = array();

$fullname='';
foreach($files as $file) {
    $name = pathinfo($file, PATHINFO_FILENAME);
	//echo "find =".strpos(strtolower($name), strtolower($searchString));
    if(strpos(strtolower($name), strtolower($searchString))!== false) {
		$extension = end(explode('.', $file));
         $filesFound[] = $file;
		$fullname=$fullname.','.$name.'.'.$extension;
    }
}
$fullstring=substr($fullname,1);
//echo "FF".$fullstring;
if(trim($fullstring) != '')
{
$SQLupd=$conn->prepare("UPDATE hotspots_pro SET `spot_images`=? WHERE hotspot_id =?");
$SQLupd->execute(array($fullstring,$spot_id));
}
//print_r($filesFound);
}?>
<?php
if(isset($_GET['type']) && $_GET['type']==12)
{
	//remove from admin
	/*$SQL="DELETE From agent_pro  WHERE sno ='".$_GET['sno']."'";
	mysql_select_db($database_divdb, $divdb);
	$Delete = mysql_query($SQL, $divdb) or die(mysql_error());*/
	$SQL=$conn->prepare("UPDATE agent_pro set status='2' WHERE agent_id =?");
	$SQL->execute(array($_GET['sno']));
	
	$SQL1=$conn->prepare("DELETE From login_secure WHERE uid =?");
	$SQL1->execute(array($_GET['sno']));
	
	if(trim($_GET['pic'])!='default.jpg')
	{
		unlink('../img_upload/agent_img/'.$_GET['pic']);
	}
}
	?>
	
    <?php
if(isset($_GET['type']) && $_GET['type']==13)
{	//remove from admin
	
	/*$SQL="DELETE From distributor_pro  WHERE sno ='".$_GET['sno']."'";
	mysql_select_db($database_divdb, $divdb);
	$Delete = mysql_query($SQL, $divdb) or die(mysql_error());*/
	echo $SQL=$conn->prepare("UPDATE distributor_pro set status='2' WHERE distr_id =?");
	$SQL->execute(array($_GET['sno']));
	
	$SQL1=$conn->prepare("DELETE From login_secure WHERE uid =?");
	$SQL1->execute(array($_GET['sno']));
	
	if(trim($_GET['pic'])!='default.jpg')
	{
	unlink('../img_upload/distributor_img/'.$_GET['pic']);
	}
}
	?>
	<?php 
	if(isset($_GET['type']) && $_GET['type']==14)
	{
$hspotpro = $conn->prepare("SELECT * FROM hotspots_pro where spot_city=? and status = '0' ORDER BY sno");
$hspotpro->execute(array($_GET['cid']));
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
								  <ul class="dropdown-menu margin-list-rounded info with-triangle" role="menu" style="width:12%">
									<li class="divider" style="margin-top:-2%; border:2px solid #434A54"></li>
                                    <li>
                                    <a class="update_hot" title="Update - <?php echo $row_hspotpro['spot_name'];?>" href="<?php echo $_SESSION['grp'];?>/update_hotspot.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo $row_hspotpro['hotspot_id'];?>"><i class="fa fa-wrench"></i>&nbsp; Update Details</a></li>
                                    <li><a class="add_hots3" href="<?php echo $_SESSION['grp'];?>/spot_img_upload.php?mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>&hid=<?php echo  $row_hspotpro['hotspot_id'];?>" onclick="get_sid('<?php echo  $row_hspotpro['hotspot_id'];?>')" ><i class="fa fa-upload"></i>&nbsp; Upload Images</a></li>
                                  <li><a href="javascript:void(0);" onclick="removes('<?php  echo $row_hspotpro['hotspot_id'];?>','<?php echo $row_hspotpro['spot_name'];?>')" ><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
                                  
									<li class="divider" style="margin-bottom:-2%; border:2px solid #434A54"></li>
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
if(isset($_GET['type']) && $_GET['type']==15)
{ $state_id=$_GET['sid'];
									$hotelcity = $conn->prepare("SELECT * FROM reg_cities where region='$state_id'");
									$hotelcity->execute(array($state_id));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main=$hotelcity->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose a city" name="hotel_city" id="hotel_city" class="form-control chosen-select " tabindex="2">									<option value="">Choose City</option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) {?>
										<option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>
                                        <?php } ?>
									</select>
			
<?php }
?>
<?php
if(isset($_GET['type']) && $_GET['type']==16)
{ $state_id=$_GET['sid'];
									$hotelcity = $conn->prepare("SELECT * FROM reg_cities where region=?");
									$hotelcity->execute(array($state_id));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main=$hotelcity->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose City" name="hotel_city" id='hotel_city' class="form-control chosen-select " tabindex="2">									<option></option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) {?>
										<option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>
                                        <?php } ?>
									</select>
			
<?php }


if(isset($_GET['type']) && $_GET['type']==17)
{
	$cid=$_GET['cid'];
									$hotprior = $conn->prepare("SELECT * FROM  hotspots_pro where spot_city=?");
									$hotprior->execute(array($cid));
									//$row_hotprior= mysql_fetch_assoc($hotprior);
									$row_hotprior=$hotprior->fetch(PDO::FETCH_ASSOC);
									$tot_hotprior=$hotprior->rowCount();
										 ?>
                                    <span class="input-group-addon tooltips" data-original-title="Hotspot Priority"><i class="fa  fa-signal fa-fw"></i></span><?php if($tot_hotprior>0){ ?>
                                 <select name="prior" id="prior" data-placeholder="Choose Priority" class="form-control chosen-select " >
                                 <?php for($pr=1;$pr<= $tot_hotprior;$pr++){
								 ?>
                                 <option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
                                 <?php 
								 }//for loop end?>
                                 </select>   
                                    <?php }else{?>
										 <input class="form-control" name="prior" id="prior" type="text" value="1" placeholder="Priority" ><?php }?>
										
<?php }
?>

<?php
if(isset($_GET['type']) && $_GET['type']==18)
{ $state_id=$_GET['sid'];
									$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where region=?");
									$hotelcity->execute(array($state_id));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main=$hotelcity->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose City" name="hotel_city" id='hotel_city' class="form-control chosen-select " tabindex="2" onchange="change_priotity(this.value)">									<option></option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) {?>
										<option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>
                                        <?php } ?>
									</select>
			
<?php }
?><?php
if(isset($_GET['type']) && $_GET['type']==19)
{
	$cid=$_GET['cid'];
									$hotprior = $conn->prepare("SELECT * FROM  hotspots_pro where spot_city=?");
									$hotprior->execute(array($cid));
									//$row_hotprior= mysql_fetch_assoc($hotprior);
									$row_hotprior=$hotprior->fetch(PDO::FETCH_ASSOC);
									$tot_hotprior=$hotprior->rowCount();
										 ?>
                                    <span class="input-group-addon tooltips" data-original-title="Hotspot Priority"><i class="fa  fa-signal fa-fw"></i></span>
                                 <select name="prior" id="prior" data-placeholder="Choose Priority" class="form-control chosen-select " >
                                 <?php for($pr=1;$pr<= $tot_hotprior+1;$pr++){
								 ?>
                                 <option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
                                 <?php 
								 }//for loop end?>
                                 </select>   
<?php }

if(isset($_GET['type']) && $_GET['type']==20)
{
	$cid=$_GET['cid'];
									$hotlprior = $conn->prepare("SELECT * FROM  hotel_pro where city=?");
									$hotlprior->execute(array($cid));
									//$row_hotlprior= mysql_fetch_assoc($hotlprior);
									$row_hotlprior=$hotlprior->fetch(PDO::FETCH_ASSOC);
									$tot_hotlprior=$hotlprior->rowCount();
										 ?>
                                    <?php if($tot_hotlprior>0){ ?>
                                 <select name="prior" id="prior" data-placeholder="Choose Priority" class="form-control chosen-select " >
                                 <?php for($pr=1;$pr<= $tot_hotlprior;$pr++){
								 ?>
                                 <option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
                                 <?php 
								 }//for loop end?>
                                 </select>   
                                    <?php }else{?>
								<input class="form-control" name="prior" id="prior" type="text" value="1" placeholder="Priority" ><?php }?>
										
<?php }
//update priority to hotspots from itin_pro.php
if(isset($_GET['type']) && $_GET['type']==21)
{
	$sno=$_GET['sno'];
	$cid=$_GET['cid'];
	
	$updattt=$conn->prepare("update hotspots_pro set spot_prior=? where sno=? and spot_city=?");
	$updattt->execute(array($_GET['prior'],$sno,$cid));
}

//update priority to hotel from hotel_pro.php
if(isset($_GET['type']) && $_GET['type']==22)
{
	$sno=$_GET['sno'];
	$cid=$_GET['cid'];
	
	$upd=$conn->prepare("update hotel_pro set hotel_prior=? where sno=? and city=?");
	$upd->execute(array($_GET['prior'],$sno,$cid));
}


//select cagetory and city wise select= hotel_pro.php
if(isset($_GET['type']) && $_GET['type']==23)
{
	$scat=trim($_POST['scat']);
	$scity=trim($_POST['scity']);
	
	$hotelpro = $conn->prepare("SELECT * FROM hotel_pro where city=? and  category =? and status = '0' ORDER BY sno ASC");
	$hotelpro->execute(array($scity,$scat));
	//$row_hotelpro = mysql_fetch_assoc($hotelpro);
	$row_hotelpro_main=$hotelpro->fetchAll();
	$totalRows_hotelpro = $hotelpro->rowCount();
								   
$_GET['mm']="76a732673da97ccc606eb6482d25f298";
$_GET['sm']="28b5856335dedd80e0dd2bf5915448e0";								   
					
					 if($totalRows_hotelpro>0)  {
	$hprior = $conn->prepare("SELECT * FROM hotel_pro where city=? and  category =? and status = '0' ORDER BY sno ASC");
	$hprior->execute(array($scity,$scat));
	//$row_hprior = mysql_fetch_assoc($hprior);
	$row_hprior_main=$hprior->fetchAll();
	$totalRows_hprior = $hprior->rowCount();

	$hpci = $conn->prepare("SELECT * FROM dvi_cities where id=?");
	$hpci->execute(array($scity));
	$row_hpci = $hpci->rowCount();	
								   ?>
<!-- priority modal display start-->
<form name="prior_forms" id="prior_forms" method="POST">
 <div class="modal fade" id="priority_mod" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
										  <div class="modal-dialog" >
											<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"><i class="fa fa-university"></i>&nbsp; <?php echo $row_hpci['name']." - ".$scat; ?> Hotel - Priorities</h5>
											  </div>
											  <div class="modal-body">
                                               <div class="row">
              <div class="col-sm-12" align="center">
              	<?php 
              		for($v=1;$v<=$totalRows_hprior;$v++)
              		{?>
    <label class="ddd" style="border:1px solid #CCC; padding:5px" id="hplab_<?php echo $v; ?>"><?php echo $v; ?></label>
              		<?php }
              	?>
            <input type="hidden" value="<?php echo $totalRows_hprior; ?>" name="tot_prior" id="tot_prior">
            <input type="hidden" value="" name="picked_prior" id="picked_prior">
              </div>                                 	
                <div class="col-sm-12" style="background-color:antiquewhite;padding: 6px;color: #995802;font-weight: 600;">
					<div class="col-sm-1">Sno</div>
					<div class="col-sm-7">Hotel Name</div>
					<div class="col-sm-2">Priority</div>
					<div class="col-sm-2">Current</div>
				</div>
<?php 
$h=1;
foreach($row_hprior_main as $row_hprior)
{?>
	<div class="col-sm-12" style="border: 1px solid rgb(204, 204, 204);padding: 2px;">
		<div class="col-sm-1"><?php echo $h; ?></div>
		<div class="col-sm-7"><?php echo $row_hprior['hotel_name']; ?></div>
		<div class="col-sm-2">
<input class="form-control" type="number" min="1" max="<?php echo $totalRows_hprior; ?>"
name="hprior_<?php echo $h; ?>" id="hprior_<?php echo $h; ?>"onchange="fun_prior_chck('<?php echo $h; ?>')" />
<input type="hidden" name="hp_id_<?php echo $h; ?>" id="hp_id_<?php echo $h; ?>" value="<?php echo $row_hprior['hotel_id']; ?>"/>
		</div>
		<div class="col-sm-1">
<label><?php echo $row_hprior['hotel_prior']; ?></lable> 
		</div>
	</div>
<?php $h++; } ?>
                                               </div>
											  </div>
											  <div class="modal-footer">
			<strong class="flashit pull-left" id="warn" style="display:none;">This priority already assigned to another hotel.</strong>
			 <button type="submit" class="btn btn-info" name="prior_forms_sub" value="prior_forms_sub_val">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											  </div><!-- /.modal-footer -->
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->										  </div><!-- /.modal-dialog -->
										</div>
									</form>
<!-- modal priority end -->

					<p align="center" style="background-color: #E6EDF3; padding: 6px;">
	<a class="btn btn-info" href="#priority_mod" name="prio_btn" id="prio_btn" data-toggle="modal" >Set Hotel Priority</a>
					</p>			   
						<table class="table table-striped table-hover datatable-example" width="100%">
							<thead class="the-box dark full">
								<tr>
									<th width="5%"># </th>
									<th width="20%">Hotel Name</th>
                                    <th width="20%"> Address</th>
                                 <!--<th width="12%"><i class="fa fa-star-half-o"></i> Hotel Type</th>-->
                                    <th width="15%"> Room Type</th>
                                    <th width="10%"> Meal</th>
                                    <th width="18%">Special Amenities</th>
									<th width="12%"> Process</th>
								</tr>
							</thead>
							<tbody>
                            <?php
							$i=1;
				foreach($row_hotelpro_main as $row_hotelpro)
				{
	$hotelcity = $conn->prepare("SELECT * FROM dvi_cities where status = '0' and id=?");
	$hotelcity->execute(array($row_hotelpro['city']));
	$row_hotelcity = $hotelcity->fetch(PDO::FETCH_ASSOC);	
							?>
								<tr class="even gradeA">
									<td width="5%" ><?php echo $i;?></td>
									<td width="20%">
                                    <font class="tooltips" data-toggle='tooltip' data-original-title='<?php echo 'Hotel Priority -'.$row_hotelpro['hotel_prior'].' ( '.$row_hotelcity['name'].' )'; ?>'><?php echo $row_hotelpro['hotel_name'];?></font>
                          
                          <a id="btn_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" class="badge badge-info icon-count pull-right tooltips" data-toggle='tooltip' data-original-title='Priority -<?php echo $row_hotelpro['hotel_prior'].' ( '.$row_hotelpro['hotel_name'].' )'; ?>' style="background-color:#2893BD; color:#FDFEFF;" ondblclick="show_prior_tab_escap('<?php echo $row_hotelpro['sno']; ?>','<?php echo $row_hotelpro['city']; ?>')"><strong style="font-size:14px;"><?php echo $row_hotelpro['hotel_prior']; ?></strong></a>
                          
                         <br /> <label style="color:#B07A7A;">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-star-half-full (alias)"></i> <?php echo "&nbsp;".$row_hotelpro['category'];?></label>&nbsp;&nbsp;
                       
                         <a class="btn" id="lck_btn_<?php echo $row_hotelpro['hotel_id']; ?>" style="color:#666" ondblclick="show_lock_hotel('<?php echo $row_hotelpro['hotel_id']; ?>')">
                           <?php if(trim($row_hotelpro['hotel_slock'])=='0000-00-00' && trim($row_hotelpro['hotel_elock'])=='0000-00-00'){?>
                         <i class="fa fa-unlock-alt tooltips" data-original-title='Double Click To Lock' ></i>
                         <?php }
						 else{ 
						 $llock="From ".date('d-M-Y',strtotime($row_hotelpro['hotel_slock']))." To ".date('d-M-Y',strtotime($row_hotelpro['hotel_elock']));
						 ?>
                          <i class="fa fa-lock tooltips" data-original-title='<?php echo $llock; ?>'></i>
                         <?php }
						 ?>
 						</a>                         
                          <!-- For Priority adding hiddden table - to update -->
                         <table id="tab_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" style="display:none;"><tr>
                         <td><?php
									$hotprior = $conn->prepare("SELECT * FROM  hotel_pro where city=?");
									$hotprior->execute(array($row_hotelpro['city']));
									//$row_hotprior= mysql_fetch_assoc($hotprior);
									$row_hotprior=$hotprior->fetch(PDO::FETCH_ASSOC);
									$tot_hotprior= $hotprior->rowCount();
										 ?>
                                    <?php if($tot_hotprior>0){ ?>
                                 <select name="prior_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" id="prior_<?php echo $row_hotelpro['sno'].'_'.$row_hotelpro['city']; ?>" data-placeholder="Choose Priority" class="form-control city_cls<?php echo $row_hotelpro['city']; ?>">
                                 <?php for($pr=1;$pr<= $tot_hotprior;$pr++)
								 {
									 if($pr==$row_hotelpro['hotel_prior'])
									 {?>
								<option selected value="<?php echo $pr; ?>"><?php echo $pr; ?></option>		<?php }else{ ?>
					 			<option value="<?php echo $pr; ?>"><?php echo $pr; ?></option>
									<?php 			
									  } 
								 }//for loop end?>
                                 </select> <?php } ?> </td>
                                 <td><a class="btn  btn-default" onclick="update_prior('<?php echo $row_hotelpro['sno']; ?>','<?php echo $row_hotelpro['city']; ?>','<?php echo $row_hotelpro['hotel_name']; ?>')"><i class="  fa fa-check-square" style="color:#23691E"></i></a></td><td><a class="btn  btn-default" onclick="hide_prior_tab('<?php echo $row_hotelpro['sno']; ?>','<?php echo $row_hotelpro['city']; ?>')"><i class="  fa fa-times-circle" style="color:#900"></i></a></td></tr></table>
                          </td>
                                    <td style="word-wrap:break-word" width="20%">
                                     <?php
									 $addr= str_replace('\\',',',$row_hotelpro['location']);
									 echo $addr."<br>";
	$hotelstate = $conn->prepare("SELECT * FROM dvi_states where status = '0' and code=?");
	$hotelstate->execute(array($row_hotelpro['state']));
	$row_hotelstate = $hotelstate->fetch(PDO::FETCH_ASSOC);								 
									 ?>
                                     </td>
                                    <td  width="15%" style="word-wrap:break-word">
									<?php
	$hotelroom = $conn->prepare("SELECT * FROM hotel_season where status = '0' and hotel_id=? group by room_type");
	$hotelroom->execute(array($row_hotelpro['hotel_id']));
	$tot_room=$hotelroom->rowCount();
	$row_hotelroom_main=$hotelroom->fetchAll();
	if($tot_room>0){
	foreach($row_hotelroom_main as $row_hotelroom)
	{	?>	
    
    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/view_season.php?sno=<?php echo $row_hotelroom['sno'];?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=76a732673da97ccc606eb6482d25f298&sm=28b5856335dedd80e0dd2bf5915448e0&room_type=<?php echo $row_hotelroom['room_type']; ?>"><i class="fa fa-tags"></i>&nbsp;<?php
	if(strlen($row_hotelroom['room_type'])<24)
	{
		echo $row_hotelroom['room_type']; 
	}else{
		echo substr($row_hotelroom['room_type'],0,24)."..."; 
	}
	 ?></a>
    <br />	
<?php    }
	}else{ //if end
	echo "No Room types";
	}?>
                                    </td>
                                    <td  width="10%" ><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '5';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Lunch </a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '6';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-fire"></i>&nbsp;Dinner</a>
                                     <hr style="margin:0px" />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '7';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-puzzle-piece"></i>&nbsp;WithBed</a>
                                    <br />
                                     <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '8';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-puzzle-piece"></i>&nbsp;WithOutBed</a>
                                    </td>
                                   
                                    <td  width="18%" ><a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '1';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Flower bed decoration</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '2';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Cake</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '3';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Candle light dinner</a>
                                    <br />
                                    <a class="view_season btn default" style="color:#656D78;"  href="<?php echo $_SESSION['grp'];?>/upd_amenit.php?typ=<?php echo '4';?>&hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-cubes"></i>&nbsp;Fruit basket</a>
                                    </td>
                                     <td  width="12%">
                                     <div class="btn-group">
								  <button class="dropdown-toggle btn btn-sm btn-info" data-toggle="dropdown">
									<i class="fa fa-cogs"></i> Actions <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu margin-list-rounded info with-triangle pull-right" role="menu" style="width:12%">
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/hotel_update.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-wrench"></i>&nbsp; Update</a></li>
                                    
                                    <li>
                                    <a class="update_hotel" title="Update - <?php echo $row_hotelpro['hotel_name']; ?>"   href="<?php echo $_SESSION['grp'];?>/ajax_hotel.php?hid=<?php echo $row_hotelpro['hotel_id'];?>&type=<?php echo "3";?>&mm=<?php echo $_GET['mm'];?>&sm=<?php echo $_GET['sm'];?>"><i class="fa fa-trash-o"></i>&nbsp; Remove</a></li>
								  </ul>
                                    </div>
                                    
                                    <br />
                                    <strong class="tooltips" data-toggle='tooltip' data-placement='left' data-original-title='This Hotel ID' style="color:#933; font-weight:600; font-size:14px">[ <?php echo $row_hotelpro['hotel_id'];?> ]</strong>
                                     </td>
                                     
								</tr>
                               <?php $i++;}?>
                                </tbody>
                                </table>
                                <?php } else{?>
                                <h4 style="color:#900; font-weight:600;" align="center" > No Entry Found...</h4>
                                <?php } 
}//select catge isset if end

?>
