<?php
require_once('../Connections/divdb.php');
session_start();

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("Y-m-d");
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==1)
{ 
$fr=$_GET['fr'];
$city_id=$_GET['cid'];
$no=$_GET['no'];
$cates=$_GET['cates'];
$tdate=date("Y-m-d",strtotime($_GET['tdate']));

$sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date)");
$sdate->execute();
$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
$hotel=$conn->prepare("select * from hotel_pro where city=? and category=? and status='0' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
$hotel->execute(array($city_id,$cates));
//$row_hotel=mysql_fetch_assoc($hotel);
$row_hotel_main=$hotel->fetchAll();
$tot_hotel=$hotel->rowCount();
								if($tot_hotel>0)
								{?>
									<select  class="form-control chosen" id="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" name="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" onChange="find_hotel_rooms('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>')"  data-placeholder="Choose">
                                    <option ></option>
                                    <?php foreach($row_hotel_main as $row_hotel){
										?>
                                    <option value="<?php echo $row_hotel['hotel_id']; ?>"><?php echo $row_hotel['hotel_name']; ?></option>
                                    <?php 
									} ?>
                                    </select>
								<?php }else{
							//for finding hotel other than given hotel-catagory in paricular city..
                                $hotel1=$conn->prepare("select * from hotel_pro where city=? and status='0' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
								$hotel1->execute(array($city_id));
								//$row_hotel1=mysql_fetch_assoc($hotel1);
								$row_hotel1_main=$hotel1->fetchAll();
								$tot_hotel1=$hotel1->rowCount();
								if($tot_hotel1>0)
								{?>
                                
                                <select  class="form-control chosen" id="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" name="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" onChange="find_hotel_rooms('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>')" data-placeholder="Choose">
                                    <option></option>
                                    <?php foreach($row_hotel1_main as $row_hotel1){
										?>
                                    <option value="<?php echo $row_hotel1['hotel_id']; ?>"><?php echo $row_hotel1['hotel_name']; ?></option>
                                    <?php } ?>
                                    </select>
                                     
                                <?php
                                }else{ ?>
                                <input type="text" class="form-control" value="Hotel - Unavailable" disabled="disabled"/>
                                <?php	}
								}
								
								}//season setting if end
								else
								{?>
								 <input type="text" class="form-control" value="Hotel - Unavailable" disabled="disabled"/>	
								<?php }

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==2)
{
		$fr=$_GET['fr'];
	 	$hotel_id=$_GET['hid'];
		$no=$_GET['no'];
		$tdate=date("Y-m-d",strtotime($_GET['tdate']));
		$rooms=$_GET['rooms'];
		$hcheck='';
								$check=$conn->prepare("select * from hotel_pro where hotel_id=? and status='0'");
								$check->execute(array($hotel_id));
								$row_check=$check->fetch(PDO::FETCH_ASSOC);
								$catagory=trim(strtoupper($row_check['category']));
								if(strpos($catagory,"HOUSE") !== false)
								{
									$hcheck="HOUSEBOAT";
								}
			if($hcheck!="HOUSEBOAT") //without houseboating hotels
	{
 								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date) ");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
									 $ses_id=$row_sdate['sno'];
								}

								$room=$conn->prepare("select * from hotel_season where hotel_id=? and status='0' and season_sno = ?  ORDER by season_rate ASC");
								$room->execute(array($hotel_id,$ses_id));
								//$row_room=mysql_fetch_assoc($room);
								$row_room_main=$room->fetchAll();
								$tot_room=$room->rowCount();
								if($tot_room>0)
								{?>
									<table width="100%" >
									<?php for($room_no=1;$room_no<=$rooms;$room_no++)
									{?>
                                <tr><td style="padding:9px;" width="40%">Room <?php echo $room_no;?></td><td style="padding:9px;" width="60%">
									<select class="form-control chosen" id="<?php echo $fr; ?>_hot_rm_id<?php echo $no."_".$room_no; ?>" name="<?php echo $fr; ?>_hot_rm_id<?php echo $no."_".$room_no; ?>" onchange="find_room_rent('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>','<?php echo $room_no; ?>')"  data-placeholder="Choose Room" > <!-- onChange="find_room_adult(this.value,'<?php// echo $no; ?>')" -->
                                    <option ></option>
                                    <?php foreach($row_room_main as $row_room){?>
                                    <option value="<?php echo $row_room['sno']; ?>"><?php echo $row_room['room_type']; ?></option>
                                    <?php } ?>
                                    </select>
                               <input type="hidden" id="<?php echo $fr; ?>_hot_rm_rent<?php echo $no."_".$room_no; ?>" name="<?php echo $fr; ?>_hot_rm_rent<?php echo $no."_".$room_no; ?>"  />
                                    </td></tr>
                                    <?php 
									$room=$conn->prepare("select * from hotel_season where hotel_id=? and status='0' and season_sno = ?  ORDER by season_rate ASC");
									$room->execute(array($hotel_id,$ses_id));
									
									} ?>
                                    </table>
								<?php
								//finding hotel address for particular hotel_id
								$hotel_add=$conn->prepare("select * from hotel_pro where hotel_id=?  and status='0'");
								$hotel_add->execute(array($hotel_id));
								$row_hotel_add=$hotel_add->fetch(PDO::FETCH_ASSOC);
								$tot_hotel_add=$hotel_add->rowCount();
								?>
                                <input type="hidden" value="<?php echo $row_hotel_add['category']."&nbsp;Hotel<br>"; ?>" id="<?php echo $fr; ?>_hot_addrs<?php echo $no;
								 ?>"  />
                                <?php
								
								 }else{
								?>
                                
                                <input  type="text" class="form-control" value="Rooms - Unavailable" disabled="disabled"/>
                                <?php	
								}
	}elseif($hcheck=="HOUSEBOAT")
	{ //this is for houseboating hotels
	
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date) ");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
									 $ses_id=$row_sdate['sno'];
								}

								$room=$conn->prepare("select * from hotel_season where hotel_id=? and status='0' and season_sno = ?  ORDER by season_rate ASC");
								$room->execute(array($hotel_id,$ses_id));
								//$row_room=mysql_fetch_assoc($room);
								$row_room_main=$room->fetchAll();
								$tot_room=$room->rowCount();
								if($tot_room>0)
								{
									$room_no=0;
									?>
									<table width="100%" id="<?php echo $fr; ?>_tr_hb_<?php echo $no; ?>" >
                                    <tr >
                                    <td style="padding:9px; text-align:center" width="100%" colspan="3">Special Rooms</td>
                                    </tr>
                                	<tr id="<?php echo $fr; ?>_tr_hb_<?php echo $no; ?>_<?php echo $room_no; ?>">
                                    <td style="padding:9px;" width="5%"><?php echo "1) ";?></td><td style="padding:9px;" width="50%">
									<select class="form-control chosen" id="<?php echo $fr; ?>_hot_hb_rm_id<?php echo $no."_".$room_no; ?>" name="<?php echo $fr; ?>_hot_hb_rm_id<?php echo $no."_".$room_no; ?>" onchange="find_hb_room_rent('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>','<?php echo $room_no; ?>')"  data-placeholder="Choose Room" > 
                                    <option ></option>
                                    <?php foreach($row_room_main as $row_room){?>
                                    <option value="<?php echo $row_room['sno']; ?>"><?php echo $row_room['room_type']; ?></option>
                                    <?php } ?>
                                    </select>
                       <input type="hidden" id="<?php echo $fr; ?>_hot_hb_rm_rent<?php echo $no."_".$room_no; ?>" name="<?php echo $fr; ?>_hot_hb_rm_rent<?php echo $no."_".$room_no; ?>"  />
                                    </td>
                                    
                                    <td style="padding:9px;" width="15%">
                                    <a class="btn btn-sm btn-info" id="<?php echo $fr; ?>_btn_hb_<?php echo $no; ?>" onclick="fun_hb_add('<?php echo $fr; ?>','<?php echo trim($hotel_id); ?>','<?php echo $no; ?>','0')"> <i class="fa fa-plus"></i></a>
                                    </td>
                                    </tr>
                                    <?php 
									$room=$conn->prepare("select * from hotel_season where hotel_id=? and status='0' and season_sno = ?  ORDER by season_rate ASC");
									$room->execute(array($hotel_id,$ses_id));
									 ?>
                                    </table>
                                    <input type="hidden" name="<?php echo $fr; ?>_tr_cnt_<?php echo $no; ?>" id="<?php echo $fr; ?>_tr_cnt_<?php echo $no; ?>" value="0" />
								<?php
								//finding hotel address for particular hotel_id
								$hotel_add=$conn->prepare("select * from hotel_pro where hotel_id=?  and status='0'");
								$hotel_add->execute(array($hotel_id));
								$row_hotel_add=$hotel_add->fetch(PDO::FETCH_ASSOC);
								$tot_hotel_add=$hotel_add->rowCount();
								?>
                                <input type="hidden" value="<?php echo $row_hotel_add['category']."&nbsp;Hotel<br>"; ?>" id="<?php echo $fr; ?>_hot_addrs<?php echo $no; ?>"  />
                                <?php
								 }else{
								?>
                                <input  type="text" class="form-control" value="Rooms - Unavailable" disabled="disabled"/>
                                <?php	
								}
	}
}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==3)
{ $sno=$_GET['sno'];
$no=$_GET['no'];

								$adult=$conn->prepare("select * from hotel_season where sno=?");
								$adult->execute(array($sno));
								$row_adult=$adult->fetch(PDO::FETCH_ASSOC);
								$tot_adult=$adult->rowCount();
								$row_adult['no_of_adults'];
								if($tot_adult>0)
								{?>
									<select class="form-control chosen" data-placeholder="No." >
                                    <option ></option>
                                    <?php for($z=1;$z<=$row_adult['no_of_adults'];$z++){?>
                                    <option value="<?php echo $z; ?>"><?php echo $z; ?></option>
                                    <?php } ?>
                                    </select>
								<?php }else{
								?>
                                <input type="text" class="form-control" value="No" disabled="disabled"/>
                                <?php	
								}

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==4)
{ $sno=$_GET['sno'];
$no=$_GET['no'];

								$child=$conn->prepare("select * from hotel_season where sno=?");
								$child->execute(array($sno));
								$row_child=$child->fetch(PDO::FETCH_ASSOC);
								$tot_child=$child->rowCount();
								if($tot_child>0)
								{?>
									<select class="form-control chosen" data-placeholder="No." >
                                   <!-- <option style="color:#999">No.</option>-->
                                   <option></option>
                                    <?php for($z1=1;$z1<=$row_child['no_of_child'];$z1++){?>
                                    <option value="<?php echo $z1; ?>"><?php echo $z1; ?></option>
                                    <?php } ?>
                                    </select>
								<?php }else{
								?>
                                <input type="text" class="form-control" value="No" disabled="disabled"/>
                                <?php	
								}

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==5)
{ $city_id=$_GET['cid'];
$pno=$_GET['pno'];
$cno=$_GET['cno'];
$tdate=$_GET['tdate'];

$city_id=trim($city_id);
 $sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date) ");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{

 $hotel=$conn->prepare("select * from hotel_pro where city=? and category=? and status='0' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ");
								$hotel->execute(array($city_id,$cates));
								//$row_hotel=mysql_fetch_assoc($hotel);
								$row_hotel_main=$hotel->fetchAll();
								$tot_hotel=$hotel->rowCount();
								if($tot_hotel>0)
								{?>
					<select  class="form-control chosen" id="sel<?php echo $pno."_".$cno; ?>" name="hotel_sel_id<?php echo $pno."_".$cno; ?>" onChange="find_hotel_rooms1(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')" data-placeholder="Choose Hotel">
                                    <option></option>
                                   
                                    <?php foreach($row_hotel_main as $row_hotel){
										?>
                                    <option value="<?php echo $row_hotel['hotel_id']; ?>"><?php echo $row_hotel['hotel_name']."&nbsp;-&nbsp;".$row_hotel['category']; ?></option>
                                    <?php
									 } ?>
                                    </select>
                                    
								<?php }else{
							//for finding hotel other than given hotel-catagory in paricular city..
                                $hotel1=$conn->prepare("select * from hotel_pro where city=? and status='0' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock)");
								$hotel1->execute(array($city_id));
								//$row_hotel1=mysql_fetch_assoc($hotel1);
								$row_hotel1_main=$hotel1->fetchAll();
								$tot_hotel1=$hotel1->rowCount();
								if($tot_hotel1>0)
								{?>
                                
                                <select  class="form-control chosen"id="sel<?php echo $pno."_".$cno; ?>" name="hotel_sel_id<?php echo $pno."_".$cno; ?>"  onChange="find_hotel_rooms1(this.value,'<?php echo $no; ?>')" data-placeholder="Choose Hotel">
                                    <option ></option>
                                   
                                    <?php foreach($row_hotel1_main as $row_hotel1){
										?>
                                    <option value="<?php echo $row_hotel1['hotel_id']; ?>"><?php echo $row_hotel1['hotel_name']; ?></option>
                                    <?php
									} ?>
                                    </select>
                                <?php
                                }else{ ?>
                                <input type="text" class="form-control" value="Hotel - Unavailable" disabled="disabled"/>
                                <?php	}
								}

								}//season setting if end
								else
								{
								?>
                                <input type="text" class="form-control" value="Hotel - Unavailable" disabled="disabled"/>
                                <?php		
								}
}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==6)
{ $hotel_id=$_GET['hid'];
$pno=$_GET['pno'];
$cno=$_GET['cno'];


								$room=$conn->prepare("select * from hotel_season where hotel_id=? and status='0'");
								$room->execute(array($hotel_id));
								//$row_room=mysql_fetch_assoc($room);
								$row_room_main=$room->fetchAll();
								$tot_room=$room->rowCount();
								if($tot_room>0)
								{?>
									<select class="form-control chosen" id="hot_rm_id<?php echo $pno."_".$cno; ?>"  name="hot_rm_id<?php echo $pno."_".$cno; ?>" onchange="find_room_rent1(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')" data-placeholder="Choose" ><!-- onChange="find_ffroom_adult1(this.value,'<?php// echo $pno; ?>','<?php// echo $cno; ?>')"-->
                                    <option ></option>
                                   
                                    <?php foreach($row_room_main as $row_room){?>
                                    <option value="<?php echo $row_room['sno']; ?>"><?php echo $row_room['room_type']; ?></option>
                                    <?php } ?>
                                    </select>
                                     <input type="hidden" id="hot_rm_rent<?php echo $pno."_".$cno; ?>" name="hot_rm_rent<?php echo $pno."_".$cno; ?>"  />
								<?php }else{
								?>
                                <input type="text" class="form-control" value="Rooms - Unavailable" disabled="disabled"/>
                                <?php	
								}

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==7)
{ $sno=$_GET['sno'];
$pno=$_GET['pno'];
$cno=$_GET['cno'];

								$adult=$conn->prepare("select * from hotel_season where sno=?");
								$adult->execute(array($sno));
								$row_adult=$adult->fetch(PDO::FETCH_ASSOC);
								$tot_adult=$adult->rowCount();
								$row_adult['no_of_adults'];
								if($tot_adult>0)
								{?>
									<select class="form-control chosen" data-placeholder="No.">
                                    <option ></option>
                                    <?php for($z=1;$z<=$row_adult['no_of_adults'];$z++){?>
                                    <option value="<?php echo $z; ?>"><?php echo $z; ?></option>
                                    <?php } ?>
                                    </select>
								<?php }else{
								?>
                                <input type="text" class="form-control" value="No" disabled="disabled"/>
                                <?php	
								}

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==8)
{ $sno=$_GET['sno'];
$pno=$_GET['pno'];
$cno=$_GET['cno'];

								$child=$conn->prepare("select * from hotel_season where sno=?");
								$child->execute(array($sno));
								$row_child=$child->fetch(PDO::FETCH_ASSOC);
								$tot_child=$child->rowCount();
								if($tot_child>0)
								{?>
									<select class="form-control chosen" data-placeholder="No." >
                                    <option ></option>
                                   
                                    <?php for($z1=1;$z1<=$row_child['no_of_child'];$z1++){?>
                                    <option value="<?php echo $z1; ?>"><?php echo $z1; ?></option>
                                    <?php } ?>
                                    </select>
								<?php }else{
								?>
                                <input type="text" class="form-control" value="No" disabled="disabled"/>
                                <?php	
								}
}
?>
<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==9)
{ $cityname=$_GET['cname'];
$cityexp=explode(',',$cityname);
$cityname_len=count($cityexp);
//$no=$_GET['no'];
$joy=0;
foreach($cityexp as $cn)
{
	 $cn1=strtolower($cn);
								$city=$conn->prepare("SELECT *  FROM `dvi_cities` WHERE lower(name) LIKE ");
								$city->execute(array($cn1));
								$row_city=$city->fetch(PDO::FETCH_ASSOC);
								$tot_city=$city->rowCount();
								if($tot_city==1)
								{
									if($joy == 0)
									{
										$joy=$row_city['id'];
									}else
									{
										$joy=$joy.','.$row_city['id'];
									}
								}else{
									
								if($joy == 0)
									{
										$joy="0";
									}else
									{
										$joy=$joy.',0';
									}
								}
}
	echo $joy;

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==10)
{ 
	$fr=$_GET['fr'];
	$value=$_GET['val'];
	
	if(isset($_GET['date']) && trim($_GET['date']) != '')
	{
		$tdate=date("Y-m-d",strtotime($_GET['date']));
	}

		 $sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date) ");
		 //print "SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date) ";
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
									$ses_id=$row_sdate['sno'];
								$srate=$conn->prepare("SELECT * FROM hotel_season WHERE sno =?");
								$srate->execute(array($value));
								$row_srate=$srate->fetch(PDO::FETCH_ASSOC);
								//print $ses_id;
								echo $row_srate['season_rate'];
									
								}else
								{
									echo '00';
								}
}
?>
<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==11)
{ 
	$fr=$_GET['fr'];
	$no=$_GET['no'];
	$hotel_id=$_GET['hot_id'];
	$tdate=date("Y-m-d",strtotime($_GET['date']));
	
	if(isset($_GET['date']) && trim($_GET['date']) != '')
	{
		$tdate=date("Y-m-d",strtotime($_GET['date']));
	}
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE '$tdate' BETWEEN from_date AND to_date");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
									$ses_id=$row_sdate['sno'];
								$ss=$ses_id+1;
								
								$sbed=$conn->prepare("SELECT * FROM hotel_food WHERE hotel_id =?");
								$sbed->execute(array($hotel_id));
								$row_sbed=$sbed->fetch(PDO::FETCH_ASSOC);
								
								$total_sbed=$sbed->rowCount();
								if($total_sbed){
									$cbed_with_rate1_arr=decode_unserialize($row_sbed['child_with_bed']);
										if(isset($cbed_with_rate1_arr[$ss-1]))
									$cbed_with_rate1=$cbed_with_rate1_arr[$ss-1];
									else
									$cbed_with_rate1=$cbed_with_rate1_arr[0];
									
									$cbed_without_rate_arr=decode_unserialize($row_sbed['child_without_bed']);
										if(isset($cbed_without_rate_arr[$ss-1]))
									$cbed_without_rate=$cbed_without_rate_arr[$ss-1];
									else
									$cbed_without_rate=$cbed_without_rate_arr[0];
								?>
                                <input type='hidden' id='<?php echo $fr; ?>_withbed_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_withbed_rate<?php echo $no; ?>' value='<?php echo $cbed_with_rate1;?>' /><input type='hidden' id='<?php echo $fr; ?>_withoutbed_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_withoutbed_rate<?php echo $no; ?>' value='<?php echo $cbed_without_rate;?>' />
                                <?php
								}else{?>
                                  <input type='hidden' id='<?php echo $fr; ?>_withbed_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_withbed_rate<?php echo $no; ?>' value='0' /><input type='hidden' id='<?php echo $fr; ?>_withoutbed_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_withoutbed_rate<?php echo $no; ?>' value='0' />
                                <?php
								}	
								}
								
								
}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==12)
{ 
	$fr=$_GET['fr'];
	$value=$_GET['val'];
	//echo $_GET['hot_id'];
	$hotel_id=explode(',',$_GET['hot_id']);
	
	if(isset($_GET['date']) && trim($_GET['date']) != '')
	{
		$tdate=date("Y-m-d",strtotime($_GET['date']));
	}
$rates_hotel='';
for($rt=0; $rt<count($hotel_id);$rt++)
{
	$strinp='';
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE '$tdate' BETWEEN from_date AND to_date");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
									$ses_id=$row_sdate['sno'];
								}else
								{
									$ses_id='season1_rate';
								}
								$ss=$ses_id+1;
								
								$food=$conn->prepare("SELECT * FROM hotel_food WHERE hotel_id =?");
								$food->execute(array($hotel_id[$rt]));
								$row_food=$food->fetch(PDO::FETCH_ASSOC);
								if($value == 'lunch_rate')
								{
									$lunchrate_arr=decode_unserialize($row_food['lunch_rate']);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									if($rates_hotel=='')
									{
										$rates_hotel=$lunch_rate;
									}else
									{
										$rates_hotel=$rates_hotel.','.$lunch_rate;
									}
									
								}
								else if($value == 'dinner_rate')
								{
									$dinnerrate_arr=decode_unserialize($row_food['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinner_rate=$dinnerrate_arr[$ss-1];
									else
									$dinner_rate=$dinnerrate_arr[0];
									
									if($rates_hotel=='')
									{
										$rates_hotel=$dinner_rate;
									}else
									{
										$rates_hotel=$rates_hotel.','.$dinner_rate;
									}
								}else if($value == 'both_food')
								{
									$lunchrate_arr=decode_unserialize($row_food['lunch_rate']);
									if(isset($lunchrate_arr[$ss-1]))
									$lunchrate=$lunchrate_arr[$ss-1];
									else
									$lunchrate=$lunchrate_arr[0];
									
									$dinnerrate_arr=decode_unserialize($row_food['dinner_rate']);
									if(isset($dinnerrate_arr[$ss-1]))
									$dinnerrate=$dinnerrate_arr[$ss-1];
									else
									$dinnerrate=$dinnerrate_arr[0];
									
									$both=$lunch_rate+$dinner_rate;
									$strinp=$lunch_rate.','.$dinner_rate;
									if($rates_hotel=='')
									{
										$rates_hotel=$both.','.$strinp;
									}else
									{
										$rates_hotel=$rates_hotel.','.$both;
									}
								}
}//for end
if(trim($rates_hotel) =='')
{
	echo '0';
}else
{
	echo $rates_hotel;
}

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==13)
{ 
	$fr=$_GET['fr'];
	$value=explode(',',$_GET['val']);
	//echo $_GET['hot_id'];
	$hotel_id=explode(',',$_GET['hot_id']);
	
	if(isset($_GET['date']) && trim($_GET['date']) != '')
	{
		$tdate=$_GET['date'];
	}else
	{
		$tdate=$today;
	}
	
	//echo "hto ".count($hotel_id);
	//echo "valc ".count($value);
	
	$rates_hotel2=0;
	if(count($hotel_id)>0)
	{
		if(trim($value[0]) != '')
		{
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE '$tdate' BETWEEN from_date AND to_date");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
									$ses_id=$row_sdate['sno'];
								}else
								{
									$ses_id='season1_rate';
								}
								$ss=$ses_id+1;
	
$rates_hotel1=0;

for($rt=0; $rt<count($hotel_id);$rt++)
{
	$strink='';
								$other=$conn->prepare("SELECT * FROM hotel_food WHERE hotel_id =?");
								$other->execute(array($hotel_id[$rt]));
								$row_other=$other->fetch(PDO::FETCH_ASSOC);
								
								//$arr_vl=$value[0];
								//echo $row_other[$arr_vl];
								$tot=0;
								for($rt1=0; $rt1<count($value);$rt1++)
								{
									$arr_vl=$value[$rt1];
									$rates_hotel1=explode('\\',$row_other[$arr_vl]);
									if($strink != '')
									{
										$strink=$strink.','.$rates_hotel1[$ss-1];
									}else{
										$strink=$rates_hotel1[$ss-1];
									}
									$tot=$tot+$rates_hotel1[$ss-1];
								}
								
								if($rates_hotel2 == 0)
								{
									$rates_hotel2=$tot.','.$strink;
								}else
								{
									$rates_hotel2=$rates_hotel2.','.$tot;
								}
								
}//for end

if((trim($rates_hotel2) != '') && $rates_hotel2 != '0' )
{
echo $rates_hotel2;
}
else
{
echo "0";
}
}//if end-values
	}//if end-hotel
}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==14)
{ 
     $seled=$_GET['val'];
	 $no=$_GET['no'];
	 
	 if($seled==3)
	 {?>
		 <select class="form-control chosen" id="youth_sel<?php echo $no; ?>"  data-placeholder="No." name="youth_sel<?php echo $no; ?>" onchange="change_below5(this.value,'<?php echo $seled; ?>','<?php echo $no; ?>')" >
         <option ></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         </select>
		 
	 <?php }else if($seled==2)
	 {?>
		 <select class="form-control chosen" id="youth_sel<?php echo $no; ?>" data-placeholder="No." name="youth_sel<?php echo $no; ?>" onchange="change_below5(this.value,'<?php echo $seled; ?>','<?php echo $no; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         <option value="2">2</option>
         </select>
	 <?php }else if($seled==1)
	 {?>
		 <select class="form-control chosen" id="youth_sel<?php echo $no; ?>" data-placeholder="No." name="youth_sel<?php echo $no; ?>" onchange="change_below5(this.value,'<?php echo $seled; ?>','<?php echo $no; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         <option value="2">2</option>
         </select>
	<?php  }else{?>
		 <input type="text" class="form-control" disabled="disabled" />
	 <?php }
	 
}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==15)
{ 
	$seled=$_GET['val'];
	 $pno=$_GET['pno'];
	  $cno=$_GET['cno'];
	 
	 if($seled==3)
	 {?>
		 <select class="form-control chosen" id="youth_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No."  name="youth_sel<?php echo $pno.'_'.$cno; ?>" onchange="change_below51(this.value,'<?php echo $seled; ?>','<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option ></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         </select>
		 
	 <?php }else if($seled==2)
	 {?>
		 <select class="form-control chosen" id="youth_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No." name="youth_sel<?php echo $pno.'_'.$cno; ?>" onchange="change_below51(this.value,'<?php echo $seled; ?>','<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         <option value="2">2</option>
         </select>
	 <?php }else if($seled==1)
	 {?>
		 <select class="form-control chosen" id="youth_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No." name="youth_sel<?php echo $pno.'_'.$cno; ?>" onchange="change_below51(this.value,'<?php echo $seled; ?>','<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         <option value="2">2</option>
         </select>
	<?php  }else{?>
		 <input type="text" class="form-control" disabled="disabled" />
	 <?php }

}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==16)
{ 
     $seled=$_GET['val'];
	 $adl_val=$_GET['adl_val'];
	 $no=$_GET['no'];
	 
	 if($adl_val==3 && $seled==0)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $no; ?>" data-placeholder="No." name="child_sel<?php echo $no; ?>" onchange="extra_below5(this.value,'<?php echo $no; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         <option value="2">2</option>
         </select>
		 
	 <?php }else if($adl_val==3 && $seled==1)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $no; ?>" data-placeholder="No." name="child_sel<?php echo $no; ?>" onchange="extra_below5(this.value,'<?php echo $no; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         </select>
	 <?php }else if($adl_val==2 && $seled==2)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $no; ?>" data-placeholder="No." name="child_sel<?php echo $no; ?>" onchange="extra_below5(this.value,'<?php echo $no; ?>')">
         <option ></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         </select>
	<?php  }else if($adl_val==2 && $seled==1)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $no; ?>" data-placeholder="No." name="child_sel<?php echo $no; ?>" onchange="extra_below5(this.value,'<?php echo $no; ?>')">
         <option ></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
          <option value="2">2</option>
         </select>
	<?php  }else if($adl_val==2 && $seled==0)
	 		{?>
		 <select class="form-control chosen" id="child_sel<?php echo $no; ?>" data-placeholder="No." name="child_sel<?php echo $no; ?>" onchange="extra_below5(this.value,'<?php echo $no; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
          <option value="2">2</option>
         </select>
	<?php  }else if(($adl_val==1 && $seled==2) || ($adl_val==1 && $seled==1) || ($adl_val==1 && $seled==0))
	 		{?>
		 <select class="form-control chosen" id="child_sel<?php echo $no; ?>" data-placeholder="No." name="child_sel<?php echo $no; ?>" onchange="extra_below5(this.value,'<?php echo $no; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
          <option value="2">2</option>
         </select>
	<?php  }else{?>
		 <input type="text" class="form-control" disabled="disabled" />
	 <?php }
	 
}
?>



<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==17)
{ 
     $seled=$_GET['val'];
	 $adl_val=$_GET['adl_val'];
	 $pno=$_GET['pno'];
	 $cno=$_GET['cno'];
	 
	 if($adl_val==3 && $seled==0)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No."  name="child_sel<?php echo $pno.'_'.$cno; ?>" onchange="extra_below51(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         <option value="2">2</option>
         </select>
		 
	 <?php }else if($adl_val==3 && $seled==1)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No."  name="child_sel<?php echo $pno.'_'.$cno; ?>" onchange="extra_below51(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option ></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         </select>
	 <?php }else if($adl_val==2 && $seled==2)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No." name="child_sel<?php echo $pno.'_'.$cno; ?>" onchange="extra_below51(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option ></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
         </select>
	<?php  }else if($adl_val==2 && $seled==1)
	 {?>
		 <select class="form-control chosen" id="child_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No." name="child_sel<?php echo $pno.'_'.$cno; ?>" onchange="extra_below51(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
          <option value="2">2</option>
         </select>
	<?php  }else if($adl_val==2 && $seled==0)
	 		{?>
		 <select class="form-control chosen" id="child_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No." name="child_sel<?php echo $pno.'_'.$cno; ?>" onchange="extra_below51(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
          <option value="2">2</option>
         </select>
	<?php  }else if(($adl_val==1 && $seled==2) || ($adl_val==1 && $seled==1) || ($adl_val==1 && $seled==0))
	 		{?>
		 <select class="form-control chosen" id="child_sel<?php echo $pno.'_'.$cno; ?>" data-placeholder="No." name="child_sel<?php echo $pno.'_'.$cno; ?>" onchange="extra_below51(this.value,'<?php echo $pno; ?>','<?php echo $cno; ?>')">
         <option></option>
         <option value="0">Nil</option>
         <option value="1">1</option>
          <option value="2">2</option>
         </select>
	<?php  }else{?>
		 <input type="text" class="form-control" disabled="disabled" />
	 <?php }
	 
}
?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==18)
{ 
    $city_id=$_GET['cid'];
	$fr=$_GET['fr'];
$no=$_GET['no'];
$tdate=date("Y-m-d",strtotime($_GET['tdate']));

  $sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date) ");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{

								$hotel=$conn->prepare("select * from hotel_pro where city=?  and status='0' GROUP BY category ");
								$hotel->execute(array($city_id));
								//$row_hotel=mysql_fetch_assoc($hotel);
								$row_hotel_main=$hotel->fetchAll();
								$tot_hotel=$hotel->rowCount();
								if($tot_hotel>0)
								{?>
									<select  class="form-control chosen" id="<?php echo $fr; ?>_hotel_categ_id<?php echo $no; ?>" name="<?php echo $fr; ?>_hotel_categ_id<?php echo $no; ?>" onChange="find_stay_hotel('<?php echo $fr; ?>',this.value,'<?php echo $city_id; ?>','<?php echo $no; ?>')"  data-placeholder="Choose">
                                    <option  value="all"> All </option>
                                   
                                    <?php foreach($row_hotel_main as $row_hotel){?>
                                    <option value="<?php echo $row_hotel['category']; ?>"><?php echo $row_hotel['category']; ?> </option>
                                    <?php } ?>
                                    </select>
                                  
								<?php }else{
									?>
                                    <input type="text" class="form-control" value="No Category" disabled="disabled"/>
								<?php }
								}
								else
								{?>
								 <input type="text" class="form-control" value="No Category" disabled="disabled"/>	
								<?php }
}?>

<?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==19)
{
	$stt_id=$_GET['sid'];

$dvicity = $conn->prepare("SELECT * FROM reg_cities where region=?");
$dvicity->execute(array($stt_id));
//$row_dvicity= mysql_fetch_assoc($dvicity);
$row_dvicity_main=$dvicity->fetchAll();
$tt=$dvicity->rowCount();
if($tt>0)
{
?>
<select id="add_city" name="add_city"  class="inp form-control ">
<?php foreach($row_dvicity_main as $row_dvicity){
?>
	<option value="<?php echo $row_dvicity['id']; ?>"><?php echo $row_dvicity['name']; ?></option>
<?php 
}?>
</select><?php
}else{
?>
<input type="text" class="form-control" name="add_city"  />
<?php
}
 }?>
 
 
 <?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==20)
{
	$cpass=$_GET['cpass'];

$pass = $conn->prepare("SELECT * FROM login_secure where passwd=? and uid=?");
$pass->execute(array(md5($cpass),$_SESSION['uid']));
$row_pass= $pass->fetch(PDO::FETCH_ASSOC);
$tt=$pass->rowCount();
if($tt>0)
{
	echo "yes";
}else{
echo "no";
}
 }?>
 
  <?php
//finding hotel
if(isset($_GET['type']) && $_GET['type']==21)
{
	$fr=$_GET['fr'];
	$cid=$_GET['cid'];
	$no=$_GET['pno'];
	$tdate=date("Y-m-d",strtotime($_GET['tdate']));
	
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and ('$tdate' BETWEEN from_date AND to_date) ");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
							//for finding hotel other than given hotel-catagory in paricular city..
                                $hotel1=$conn->prepare("select * from hotel_pro where city=? and status='0' and ('$tdate' NOT BETWEEN hotel_slock AND hotel_elock) ");
								$hotel1->execute(array($cid));
								//$row_hotel1=mysql_fetch_assoc($hotel1);
								$row_hotel1_main=$hotel1->fetchAll();
								$tot_hotel1=$hotel1->rowCount();
								if($tot_hotel1>0)
								{?>
                                
                                <select class="form-control chosen" id="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" name="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" onChange="find_hotel_rooms('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>')" data-placeholder="Choose Hotel">
                                    <option></option>
                                   
                                    <?php foreach($row_hotel1_main as $row_hotel1){
										?>
                                    <option value="<?php echo $row_hotel1['hotel_id']; ?>"><?php echo $row_hotel1['hotel_name']; ?></option>
                                    <?php
									}?>
                                    </select>
                                     
                                <?php
                                }else{ ?>
                                <input type="text" id="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" name="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" class="form-control"  disabled="disabled"/>
                                <?php	}
								}else{
									?>
                                    <input type="text" id="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" name="<?php echo $fr; ?>_hotel_sel_id<?php echo $no; ?>" class="form-control"  disabled="disabled"/>
								<?php }
								
}?>
<?php 
if(isset($_GET['type']) && $_GET['type']==22)
{
	$fr=$_GET['fr'];
	$hid=$_GET['hid'];
	$no=$_GET['pno'];
	$ddate=date("Y-m-d",strtotime($_GET['daty']));
	
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE '$ddate' BETWEEN from_date AND to_date");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								
								//print_r($row_sdate);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
											$ses_id=$row_sdate['sno'];
											$num_ses=$ses_id+1;
											
										$special=$conn->prepare("SELECT * FROM hotel_food WHERE hotel_id =?");
										$special->execute(array($hid));
										$row_special=$special->fetch(PDO::FETCH_ASSOC);
										$tot_special=$special->rowCount();
										
										if($tot_special>0)
										{
							
											$flow_bed_arr=decode_unserialize($row_special['flower_bed']);
											if(isset($flow_bed_arr[$num_ses-1]))
											$flow_bed_rate=$flow_bed_arr[$num_ses-1];
											else
											$flow_bed_rate=$flow_bed_arr[0];
											//print_r($flow_bed);
											
											$cand_lig_arr=decode_unserialize($row_special['candle_light']);
											if(isset($cand_lig_arr[$num_ses-1]))
											$cand_lig_rate=$cand_lig_arr[$num_ses-1];
											else
											$cand_lig_rate=$cand_lig_arr[0];
										
											$cake_rat_arr=decode_unserialize($row_special['cake_rate']);
											if(isset($cake_rat_arr[$num_ses-1]))
											$cake_rat_rate=$cake_rat_arr[$num_ses-1];
											else
											$cake_rat_rate=$cake_rat_arr[0];
										
											$fruit_bas_arr=decode_unserialize($row_special['fruit_basket']);
											if(isset($fruit_bas_arr[$num_ses-1]))
											$fruit_bas_rate=$fruit_bas_arr[$num_ses-1];
											else
											$fruit_bas_rate=$fruit_bas_arr[0];
											
																												
											if($flow_bed_rate>0 || $cand_lig_rate>0 || $fruit_bas_rate>0 || $cake_rat_rate>0)
											{
											?>
                                            
                                            <select id='<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>' name='<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>[]' onchange="find_others_rate('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>')" data-placeholder='Choose here to create happy moments' class='form-control chosen-select' multiple tabindex='4'><option></option>
                                            <?php 
												if($flow_bed_rate>0)
												{?>
					<option value='flower_bed'> Flower Bed </option>								
                                                    <?php
												}
												if($cand_lig_rate>0)
												{?>
                     <option value='candle_light'> Candle Light </option>                           
                                                <?php
												}
												if($cake_rat_rate>0)
												{?>
                      <option value='cake_rate'> Special Cake </option>                          
                                                <?php 
												}
												if($fruit_bas_rate>0)
												{?>
                       <option value='fruit_basket'> Fruit Basket </option>                         
                                                <?php
												}
										?>
                                        </select>
                                        <input type='hidden' id='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' value='0' />
                                        <?php }else{ ?>
                                        <input type="text" class="form-control tooltips" data-original-title='Unavailable Special Amenities' data-placeholder="Unavailable Amenities" value="" id="<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>" name="<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>" disabled="disabled" /><input type='hidden' id='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' value='0' />
                                        <?php }
                                        
										}else{?>
											<input type="text" class="form-control tooltips" data-original-title='Unavailable Special Amenities' data-placeholder="Unavailable Special Amenities" value="" id="<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>" name="<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>" disabled="disabled" /><input type='hidden' id='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' value='0' />
										<?php }
								}else
								{
									?><input type="text" class="form-control  tooltips" value="" data-original-title='Unavailable Special Amenities' data-placeholder="Unavailable Special Amenities" id="<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>" name="<?php echo $fr; ?>_ext_item_id<?php echo $no; ?>" disabled="disabled" /><input type='hidden' id='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_others_rate<?php echo $no; ?>' value='0' /><?php
								}
	
}?>

<?php 
if(isset($_GET['type']) && $_GET['type']==23)
{
	$fr=$_GET['fr'];
	$hid=$_GET['hid'];
	$no=$_GET['pno'];
	$ddate=date("Y-m-d",strtotime($_GET['daty']));
	
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE '$ddate' BETWEEN from_date AND to_date");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
											$ses_id=$row_sdate['sno'];
											 $ss=$ses_id+1;
											
										$special=$conn->prepare("SELECT * FROM hotel_food WHERE hotel_id =?");
										$special->execute(array($hid));
										$row_special=$special->fetch(PDO::FETCH_ASSOC);
										$tot_special=$special->rowCount();
										
										if($tot_special>0)
										{
										
											$lunchrate_arr=decode_unserialize($row_special['lunch_rate']);
											if(isset($lunchrate_arr[$ss-1]))
											$lunchrate=$lunchrate_arr[$ss-1];
											else
											$lunchrate=$lunchrate_arr[0];
										
											$dinnerrate_arr=decode_unserialize($row_special['dinner_rate']);
											if(isset($dinnerrate_arr[$ss-1]))
											$dinnerrate=$dinnerrate_arr[$ss-1];
											else
											$dinnerrate=$dinnerrate_arr[0];
											?>
                                            
                                            <select onchange="find_food_rate('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>')" data-placeholder='Choose Food ' class='form-control chosen-select' id='<?php echo $fr; ?>_food_id<?php echo $no; ?>' name='<?php echo $fr; ?>_food_id<?php echo $no; ?>'>
                                           <option></option>
                                            <?php 
											
												if($lunchrate>0 )
												{ $h1="yes";?>
					<option value='lunch_rate'> Breakfast & Lunch Only </option>								
                                                    <?php
												}else{
													$h1="no";
												}
												
												if($dinnerrate>0)
												{ $h2="yes";?>
                     <option value='dinner_rate'> Breakfast & Dinner Only </option>                          
                                                <?php
												}else{
												$h2="no";	
												}
												
												if($h1==$h2)
												{?>
						<option value='both_food'> Breakfast, Lunch & Dinner </option>				
												<?php }
										?>
                                        <option> Breakfast Only</option>
                                        </select>
                                        <input type='hidden' id='<?php echo $fr; ?>_foood_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_foood_rate<?php echo $no; ?>' value='0' />
                                        <?php
										}else{?>
											<input type="text" class="form-control" data-placeholder="Unavailable Food" value="" id="<?php echo $fr; ?>_food_id<?php echo $no; ?>" name="<?php echo $fr; ?>_food_id<?php echo $no; ?>" disabled="disabled" /><input type='hidden' id='<?php echo $fr; ?>_foood_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_foood_rate<?php echo $no; ?>' value='0' />
										<?php }
								}else
								{
									?><input type="text" value="" class="form-control" data-placeholder="Unavailable Food"  id="<?php echo $fr; ?>_food_id<?php echo $no; ?>" name="<?php echo $fr; ?>_food_id<?php echo $no; ?>" disabled="disabled" /><input type='hidden' id='<?php echo $fr; ?>_foood_rate<?php echo $no; ?>' name='<?php echo $fr; ?>_foood_rate<?php echo $no; ?>' value='0' /><?php
								}
	
}?>

<?php 
if(isset($_GET['type']) && $_GET['type']==24)
{
	$no=$_GET['no'];
	?>
    <select id='extra_bed<?php echo $no; ?>' name='extra_bed<?php echo $no; ?>' class='form-control chosen' data-placeholder='Choose' onchange="find_rate_cbed(this.value,'<?php echo $no; ?>')"><option></option><option value='0'> Child Bed</option><option value='1'>No Child Bed</option></select><input type='hidden' id='extra_rate<?php echo $no; ?>' name='extra_rate<?php echo $no; ?>'  value='0'/>
    <?php
}?>

<?php 
if(isset($_GET['type']) && $_GET['type']==25)
{
	$pno=$_GET['pno'];
	$cno=$_GET['cno'];
	?>
    <select  id='extra_bed<?php echo $pno."_".$cno; ?>' name='extra_bed<?php echo $pno."_".$cno; ?>' class='form-control chosen ' data-placeholder='Choose' onchange="find_rate_cbed1(this.value,'<?php echo $pno; ?>',<?php echo $cno; ?>)"><option></option><option value='0'> Child Bed</option><option value='1'>No Child Bed</option></select><input type='hidden' id='extra_rate<?php echo $pno."_".$cno; ?>' name='extra_rate<?php echo $pno."_".$cno; ?>'  value='0'/>
    <?php
}?>
<?php  //final conformation
if(isset($_GET['type']) && $_GET['type']==26)
{
	$_GET['spid']=$_GET['spid1'].'#'.$_GET['spid2'];
	$upd=$conn->prepare("update travel_master set tr_name=?, tr_mobile=?, tr_arrdet=?, tr_depdet=?, status='2', comp_status='0' where plan_id=? and tr_name =?");
	$upd->execute(array($_GET['gname'],$_GET['gmobi'],$_GET['garrdet'],$_GET['gdepdet'],$_GET['spid'],$_GET['spid']));
	
}?>

<?php  //final conformation
if(isset($_GET['type']) && $_GET['type']==27)
{
	$_GET['spid']=$_GET['spid1'].'#'.$_GET['spid2'];
	
			$upd=$conn->prepare("update travel_master set status='3', comp_status='0' where plan_id=?");
			$upd->execute(array($_GET['spid']));
		
}?>
<?php  //final conformation
if(isset($_GET['type']) && $_GET['type']==28)
{
	$_GET['spid']=$_GET['spid1'].'#'.$_GET['spid2'];
	
			$upd=$conn->prepare("update travel_master set status='5', comp_status='0' where plan_id=?");
			$upd->execute(array($_GET['spid']));
		
}?>

<?php  //final conformation
if(isset($_GET['type']) && $_GET['type']==29)
{
	  $plan_ids=trim($_POST['sub_planid']);
	  $trv=$conn->prepare("SELECT * FROM travel_master WHERE plan_id=?");
	  $trv->execute($plan_ids);
	  $row_trv=$trv->fetch(PDO::FETCH_ASSOC);
	  $tot_trv=$trv->rowCount();

								$breakstay_arr=explode('-',$row_trv['sub_paln_id']);
								//print_r($breakstay_arr);

$tform=$_POST['tot_num_of_form'];
$itn=0;
for($frms=0;$frms<=$tform;$frms++)
{
	$fr="br".$frms;
	if(isset($_POST['num_room_htls_'.$fr]))
	{
	$food=$_POST['food_categ_dvi'];
	$troom=$_POST['num_room_htls_'.$fr];
	$tadult=$_POST['num_traveller_'.$fr];
	$tch512=$_POST['num_chd512_'.$fr];
	$tch5blw=$_POST['num_chd_b5_'.$fr];
	$tot_fpax=(int)$tadult+(int)$tch512;
	$tot_pax=(int)$tadult+(int)$tch512+(int)$tch5blw;
	$tot1=0;
	$tot2=0;
	$tot3=0;
	$extbed='';
	$adl='';
	$c12='';
	$cb5='';

	for($l=1; $l<=$troom; $l++)
    {
    	if($adl=='')
        {
            $adl=$_POST[$fr.'_sel_adlt_nw'.$l];
        }else{
            $adl=$adl.','.$_POST[$fr.'_sel_adlt_nw'.$l];
        }

        if($c12=='')
        {
            $c12=$_POST[$fr.'_sel_nw_512ch'.$l];
        }else{
            $c12=$c12.','.$_POST[$fr.'_sel_nw_512ch'.$l];
        }

        if($cb5=='')
        {
            $cb5=$_POST[$fr.'_sel_nw_512ch'.$l];
        }else{
            $cb5=$cb5.','.$_POST[$fr.'_sel_nw_512ch'.$l];
        }

        if($extbed=='')
        {
            $extbed=$_POST[$fr.'_sel_nw_extr'.$l];
        }else{
            $extbed=$extbed.','.$_POST[$fr.'_sel_nw_extr'.$l];
        }
    }

  	$tot_room=$adl.'/'.$c12.'/'.$cb5.'/'.$extbed.'/'.$food; //adultperroom/child512 perroom/childb5 perroom/extra bed/food
    $upd=$conn->prepare("update travel_master set room_info='".$tot_room."', comp_status='0' where plan_id=? and status='5'");
	$upd->execute(array($breakstay_arr[$itn]));
    $itn++;
	}
}

}?>

<?php  //checking seasons are locked or not
if(isset($_GET['type']) && $_GET['type']==30)
{
	$check="no";
	$startTime = strtotime($_GET['checkdate1']);
	$endTime = strtotime($_GET['checkdate2']);

	// Loop between timestamps, 24 hours at a time
	for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
	    $thisDate = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
		$ttdate=$thisDate;
								$sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$ttdate' BETWEEN from_date AND to_date) ");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate==0)
								{
									$check='yes';
								}
	}
	echo $check;
}

//finding rooms to houseboat
if(isset($_GET['type']) && $_GET['type']==31)
{ 
	$fr=$_GET['fr'];
	$hotel_id=$_GET['hid'];
	$no=$_GET['no'];
	$tdate=date("Y-m-d",strtotime($_GET['tdate']));
	$rooms=$_GET['rooms'];

 $sdate=$conn->prepare("SELECT * FROM setting_season WHERE lock_sts != '1' and  ('$tdate' BETWEEN from_date AND to_date) ");
								$sdate->execute();
								$row_sdate=$sdate->fetch(PDO::FETCH_ASSOC);
								$tot_sdate=$sdate->rowCount();
								if($tot_sdate>0)
								{
									 $ses_id=$row_sdate['sno'];
								}

$room=$conn->prepare("select * from hotel_season where hotel_id=? and status='0' and season_sno = ?  ORDER by season_rate ASC");
					$room->execute(array($hotel_id,$ses_id));
								//$row_room=mysql_fetch_assoc($room);
								$row_room_main=$room->fetchAll();
								if($tot_room>0)
								{?>
									<table width="100%" >
                                    <tr>
                                    <td style="padding:9px; text-align:center" width="100%" colspan="3">Special Rooms</td></tr>
									<?php for($room_no=1;$room_no<=$rooms;$room_no++)
									{?> 
                                	<tr>
                                    <td style="padding:9px;" width="5%"><?php echo $room_no.") ";?></td><td style="padding:9px;" width="50%">
									<select class="form-control chosen" id="<?php echo $fr; ?>_hot_rm_id<?php echo $no."_".$room_no;; ?>" name="<?php echo $fr; ?>_hot_rm_id<?php echo $no."_".$room_no; ?>" onchange="find_room_rent('<?php echo $fr; ?>',this.value,'<?php echo $no; ?>','<?php echo $room_no; ?>')"  data-placeholder="Choose Room" > <!-- onChange="find_room_adult(this.value,'<?php// echo $no; ?>')" -->
                                    <option ></option>
                                    <?php foreach($row_room_main as $row_room){?>
                                    <option value="<?php echo $row_room['sno']; ?>"><?php echo $row_room['room_type']; ?></option>
                                    <?php } ?>
                                    </select>
                               <input type="hidden" id="<?php echo $fr; ?>_hot_rm_rent<?php echo $no."_".$room_no; ?>" name="<?php echo $fr; ?>_hot_rm_rent<?php echo $no."_".$room_no; ?>"  />
                                    </td>
                                    <td style="padding:9px;" width="40%">
                                    <select id="sel_nw_extr1" name="sel_nw_extr1" class="form-control chosen-select" >
                                    <option value="-" selected="">Nil</option>
                                    <option value="0" >With Bed</option>
                                    <option value="1">Without Bed</option>
                                    </select>
                                    </td>
                                    <td style="padding:9px;" width="15%"><a class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a></td>
                                    </tr>
                                    <?php 
									$room=$conn->prepare("select * from hotel_season where hotel_id=? and status='0' and season_sno = ?  ORDER by season_rate ASC");
									$room->execute(array($hotel_id,$ses_id));
									
									} ?>
                                    </table>
								<?php
								//finding hotel address for particular hotel_id
								$hotel_add=$conn->prepare("select * from hotel_pro where hotel_id=?  and status='0'");
								$hotel_add->execute(array($hotel_id));
								$row_hotel_add=$hotel_add->fetch(PDO::FETCH_ASSOC);
								$tot_hotel_add=$hotel_add->rowCount();
								?>
                                <input type="hidden" value="<?php echo $row_hotel_add['category']."&nbsp;Hotel<br>"; ?>" id="<?php echo $fr; ?>_hot_addrs<?php echo $no; ?>"  />
                                <?php
								
								 }else{
								?>
                                <input  type="text" class="form-control" value="Rooms - Unavailable" disabled="disabled"/>
                                <?php	
								}
}

?>

