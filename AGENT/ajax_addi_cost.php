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
//additional cost places add-ons from tourplan.php #addi_cost_toggle
if(isset($_GET['type']) && $_GET['type']==1)
{ 

	?>
    <div class="row">
    <div class="col-sm-12">
    <div class="col-sm-1" style="color:#D8800F; font-weight:700" > Date </div>
    <div class="col-sm-3" style="color:#D8800F; font-weight:700"> Selected Cities </div>
    <div class="col-sm-6" align="center" style="color:#D8800F; font-weight:700"> Choose Add-ons </div>
    <div class="col-sm-2" align="center" style="color:#D8800F; font-weight:700">Quantity</div>
    </div>
    <?php

$tform=$_POST['tot_num_of_form'];

for($tfr=0;$tfr<=$tform;$tfr++)
{
	$fr="br".$tfr;
	if(isset($_POST[$fr.'_kit_cityidd_prev']))
	{
	$city_id_arr=explode(',',$_POST[$fr.'_kit_cityidd_prev']);
	$arr_dat=$_POST['arrdate_'.$fr];
	$tot_pers=(int)$_POST['num_traveller_'.$fr]+(int)$_POST['num_chd512_'.$fr];

	for($c=0;$c<count($city_id_arr);$c++)
	{
		if(isset($city_id_arr[$c+1]))
		{$cchek=0;
		?>
        <div class="col-sm-12" style="margin-top:10px;padding-left: 0px;padding-right: 0px;">
            <div class="col-sm-1" align="center" style="padding-left: 0px;padding-right: 0px;"><?php 
				if($c==0)
				{
						echo date('d-M',strtotime($arr_dat));	
				}else{
						echo date('d-M',strtotime($arr_dat));
				}?></div>
                
            <div class="col-sm-3" style="padding-left: 0px;padding-right: 0px;"><?php 
					
					$cityy_to1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
					$cityy_to1->execute(array($city_id_arr[$c]));
					$row_cityy_to1 = $cityy_to1->fetch(PDO::FETCH_ASSOC);
					
					$cityy_to2 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
					$cityy_to2->execute(array($city_id_arr[$c+1]));
					$row_cityy_to2 =$cityy_to2->fetch(PDO::FETCH_ASSOC);
					
			echo $row_cityy_to1['name'].' <i class="fa fa-arrows-h"></i> '.$row_cityy_to2['name']; 
			?></div>
            
            <div class="col-sm-6" style="padding-left: 0px;"><?php 
					
					$travel_via = $conn->prepare("SELECT * FROM travel_sched where travel_id=? and  tr_date=? and (trim(via_cities)!='-')");
					$travel_via->execute(array($_SESSION['com_plan_id'],$arr_dat));
					$row_travel_via = $travel_via->fetch(PDO::FETCH_ASSOC);
					$tot_travel_via= $travel_via->rowCount();
			
			if($tot_travel_via>0)
			{
				$trl_via_ary=explode('-',$row_travel_via['via_cities']);
								 $ses="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (";
				 
				 for($tv=0;$tv<count($trl_via_ary);$tv++)
				 {
					$ses=$ses."city_id='".$trl_via_ary[$tv]."'";
					if(isset($trl_via_ary[$tv+1]))
					{
						$ses=$ses." or ";
					}
				 }
				 $ses=$ses.")";
				
			}else{
				 $ses="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (city_id='".$city_id_arr[$c]."' or city_id='".$city_id_arr[$c+1]."')";
			}
			
				 $saddi=$conn->prepare($ses);
				 

			


					$travel_alr = $conn->prepare("SELECT * FROM travel_sched where travel_id=? and  tr_date=?");
					$travel_alr->execute(array($_SESSION['com_plan_id'],$arr_dat));
					$row_travel_alr = $travel_alr->fetch(PDO::FETCH_ASSOC);
					$tot_travel_alr=$travel_alr->rowCount();
$already_arr=explode('/',$row_travel_alr ['addi_cost_for']);
$already_sno='';
$already_cost='';
           //  $saddi="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (city_id='".$city_id_arr[$c]."' or city_id='".$city_id_arr[$c+1]."')";
                                    
                                    $saddi->execute();
                                    //$row_saddi=mysql_fetch_assoc($saddi);
									$row_saddi_main=$saddi->fetchAll();
                                    $tot_saddi=$saddi->rowCount();
									if($tot_saddi>0)
									{?>
                                    <select class="chosen-select" id="<?php echo $fr; ?>_addi_cst_sel_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_cst_sel_<?php echo $arr_dat; ?>" multiple onChange="addi_add_on_change('<?php echo $arr_dat; ?>','<?php echo $fr; ?>')" data-placeholder="Choose some add-ons">
                                        <option ></option>
                                        <?php
                                        foreach($row_saddi_main as $row_saddi)
										{

											?>
											 <option value="<?php echo $row_saddi['sno'];?>"
<?php
											if (in_array($row_saddi['short_desc'], $already_arr))
											{?>
												selected='selected'
											<?php 
														if($already_sno=='')
														{
															$already_sno=$row_saddi['sno'];
															$already_cost=$row_saddi['amount'];
														}else{
															$already_sno=$already_sno.','.$row_saddi['sno'];
															$already_cost=$already_cost.','.$row_saddi['amount'];
														}
										} ?>
											 	><?php echo $row_saddi['short_desc'].'- Rs.'.$row_saddi['amount'];?></option>
										<?php }//while end
										?>
                                        </select>
                                        <input type="hidden" id="<?php echo $fr; ?>_addi_sno_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_sno_<?php echo $arr_dat; ?>" value="<?php echo $already_sno; ?>">
                                        <input type="hidden" id="<?php echo $fr; ?>_addi_cst_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_cst_<?php echo $arr_dat; ?>" value="<?php echo $already_cost; ?>">
									<?php }else{ ?>
										<input type="text" value="No Add-ons Available" class="form-control" readonly>
                                        
									<?php $cchek=1; } ?>
            </div>
            <div class="col-sm-2" >
            <?php if($cchek=='1'){?> <input type="text" value="Nil" class="form-control" readonly> <?php }
			else {?>
         <input type="number" min='1' max='50' value="<?php echo $tot_pers; ?>" class="form-control" id="<?php echo $fr; ?>_addi_persons<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_persons<?php echo $arr_dat; ?>" onkeypress="only_number('<?php echo $arr_dat; ?>')"> <?php }?> </div>
        </div>
		<?php 
				$date=date_create($arr_dat);
				date_add($date,date_interval_create_from_date_string("1 days"));
				$arr_dat=date_format($date,"Y-m-d");
		}

	}//for each 
	}//live if

}//main for loop?>
    
    <div class="col-sm-12" style="margin-top:20px; margin-bottom:10px;" align="right">
    <a class="btn btn-sm btn-default" onClick="no_need_add_ons()">No Need</a>&nbsp;&nbsp;&nbsp;
    <a class="btn btn-sm btn-info" onClick="go_with_add_ons()">Go with these add-ons</a>&nbsp;&nbsp;&nbsp;
    <br>
    </div>
    </div>
<?php 
}

//calculation add-ons amount to additonal cost from tourplan.php - addi_add_on_change()
if(isset($_GET['type']) && $_GET['type']==2)
{
	$sadd_val=explode(',',$_GET['sadd_val']);
	$amount='';
	foreach($sadd_val as $sadd)
	{
		$saddi=$conn->prepare("SELECT * FROM additional_cost WHERE sno=?");
        $saddi->execute(array($sadd));
        $row_saddi=$saddi->fetch(PDO::FETCH_ASSOC);
		                			if($amount=='')
									{
										$amount=$row_saddi['amount'];
									}else{
										$amount=$amount.','.$row_saddi['amount'];
									}
	}
	echo $amount;
}

//insert add-ons amount to additonal cost from tourplan.php - go_with_add_ons()
if(isset($_GET['type']) && $_GET['type']==3)
{
	$tform=$_POST['tot_num_of_form'];
	$master_break=$conn->prepare("SELECT * FROM travel_master WHERE  plan_id=?");
    $master_break->execute(array($_SESSION['com_plan_id']));
    $row_master_break=$master_break->fetch(PDO::FETCH_ASSOC);
    $break_up_arr= explode('-',$row_master_break['sub_paln_id']);
	$brkk=0;
	for($tfr=0;$tfr<=$tform;$tfr++)
	{
		$fr="br".$tfr;
		$addi_cst_name='';
		$addi_cst_amt='';
		$itiner_city = $_POST[$fr.'_citydata'];
		$tr_dates = $_POST['arrdate_'.$fr];
		$itiner_city1 = implode(',', $itiner_city);
		$itiner_city2 = explode(',', $itiner_city1);
		$addi_costs_tot=0;
		//print_r($itiner_city2);
		//echo count($itiner_city2);
		for ($detl_itn=0;$detl_itn<count($itiner_city2);$detl_itn++)
		{
			$exp_itin_city = explode('-', $itiner_city2[$detl_itn]);
			$ssdist = $exp_itin_city[4] - $exp_itin_city[2];
		
			if(isset($_POST[$fr.'_start_date'.$detl_itn]))
			{
				    $ssddate=date("Y-m-d",strtotime($_POST[$fr.'_start_date'.$detl_itn]));
			}else{
					$ssddate='';
			}

			$addi_cst_name='';
			$addi_cst_amt='';
			$num_pers=0;
			
			if(isset($_POST[$fr.'_addi_sno_'.$ssddate]) && $_POST[$fr.'_addi_sno_'.$ssddate]!='')
			{
				$num_pers=trim($_POST[$fr.'_addi_persons'.$ssddate]);
				$addi_cst_arry=explode(',',$_POST[$fr.'_addi_sno_'.$ssddate]);
				for($ac=0;$ac<count($addi_cst_arry);$ac++)
				{
									$saddi=$conn->prepare("SELECT * FROM additional_cost WHERE sno=?");
                                    $saddi->execute(array($addi_cst_arry[$ac]));
                                    $row_saddi=$saddi->fetch(PDO::FETCH_ASSOC);
                                    
									if($addi_cst_name=='')
									{
										$addi_cst_name=$row_saddi['short_desc'];
									}else{
										$addi_cst_name=$addi_cst_name.'/'.$row_saddi['short_desc'];
									}
				}
				$addi_cst_amt=$_POST[$fr.'_addi_cst_'.$ssddate];
	
				$addi_cst_addition_ary=explode(',',$_POST[$fr.'_addi_cst_'.$ssddate]);
				foreach($addi_cst_addition_ary as $addi_costs)
				{
					echo $addi_costs_tot=$addi_costs_tot+(((int)$addi_costs)*((int)$num_pers));
				}

				$insertSQL2 = $conn->prepare("update travel_sched set addi_cost_for=?, addi_amount=?, num_person=? where tr_date=? and travel_id=?");
				$insertSQL2->execute(array($addi_cst_name,$addi_cst_amt,$num_pers,$ssddate,$break_up_arr[$brkk]));
			}else if(isset($_POST[$fr.'_addi_sno_'.$ssddate]) && $_POST[$fr.'_addi_sno_'.$ssddate]=='')
			{
				echo $insertSQL2 = $conn->prepare("update travel_sched set addi_cost_for='', addi_amount='', num_person='' where tr_date=? and travel_id=?");
				    $insertSQL2->execute(array($ssddate,$break_up_arr[$brkk]));
			}
		}
	
		$master=$conn->prepare("SELECT * FROM travel_master WHERE  plan_id=?");
        $master->execute(array($break_up_arr[$brkk]));
        $row_master=$master->fetch(PDO::FETCH_ASSOC);
									
		$org_cost= (int)$row_master['tr_net_amt']+(int)$row_master['stay_tot_amt']+(int)$addi_costs_tot;
		$org_cost1=$org_cost+($org_cost*($row_master['agent_perc']/100));
		$org_cost2=$org_cost1+($org_cost1*($row_master['agnt_adm_perc']/100));
		
		 $insertSQL2 = $conn->prepare("update travel_master set tot_additional_cost=?, grand_tot=?, agnt_grand_tot=? where plan_id=?");
		 $insertSQL2->execute(array($addi_costs_tot,$org_cost,$org_cost2,$break_up_arr[$brkk]));
			$brkk++;
			}//main for loop
}


//additional cost places add-ons from ordstatus.php #addi_cost_toggle
if(isset($_GET['type']) && $_GET['type']==4)
{
	//////////////////////////////////////////////start
 /*
	?>
    <div class="row">
    <div class="col-sm-12">
    <div class="col-sm-1" style="color:#D8800F; font-weight:700" > Date </div>
    <div class="col-sm-3" style="color:#D8800F; font-weight:700"> Selected Cities </div>
    <div class="col-sm-6" align="center" style="color:#D8800F; font-weight:700"> Choose Add-ons </div>
    <div class="col-sm-2" align="center" style="color:#D8800F; font-weight:700">Persons</div>
    </div>
    <?php

$tform=$_POST['tot_num_of_form'];

for($tfr=0;$tfr<=$tform;$tfr++)
{
	$fr="br".$tfr;
	if(isset($_POST[$fr.'_kit_cityidd_prev']))
	{
	$city_id_arr=explode(',',$_POST[$fr.'_kit_cityidd_prev']);
	$arr_dat=$_POST['arrdate_'.$fr];
	$tot_pers=(int)$_POST['num_traveller_'.$fr]+(int)$_POST['num_chd512_'.$fr];

	for($c=0;$c<count($city_id_arr);$c++)
	{
		if(isset($city_id_arr[$c+1]))
		{$cchek=0;
		?>
        <div class="col-sm-12" style="margin-top:10px;padding-left: 0px;padding-right: 0px;">
            <div class="col-sm-1" align="center" style="padding-left: 0px;padding-right: 0px;"><?php 
				if($c==0)
				{
						echo date('d-M',strtotime($arr_dat));	
				}else{
						echo date('d-M',strtotime($arr_dat));
				}?></div>
                
            <div class="col-sm-3" style="padding-left: 0px;padding-right: 0px;"><?php 
					
					$query_cityy_to1 = "SELECT * FROM dvi_cities where id ='".$city_id_arr[$c]."'";
					$cityy_to1= mysql_query($query_cityy_to1, $divdb) or die(mysql_error());
					$row_cityy_to1 = mysql_fetch_assoc($cityy_to1);
					
					$query_cityy_to2 = "SELECT * FROM dvi_cities where id ='".$city_id_arr[$c+1]."'";
					$cityy_to2= mysql_query($query_cityy_to2, $divdb) or die(mysql_error());
					$row_cityy_to2 = mysql_fetch_assoc($cityy_to2);
					
			echo $row_cityy_to1['name'].' <i class="fa fa-arrows-h"></i> '.$row_cityy_to2['name']; 
			?></div>
            
            <div class="col-sm-6" style="padding-left: 0px;"><?php 
					
					$query_travel_via = "SELECT * FROM travel_sched where travel_id='".$_SESSION['com_plan_id']."' and  tr_date='".$arr_dat."' and (trim(via_cities)!='-')";
					$travel_via= mysql_query($query_travel_via, $divdb) or die(mysql_error());
					$row_travel_via = mysql_fetch_assoc($travel_via);
					$tot_travel_via= mysql_num_rows($travel_via);
			
			if($tot_travel_via>0)
			{
				$trl_via_ary=explode('-',$row_travel_via['via_cities']);
				 $ses="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (";
				 
				 for($tv=0;$tv<count($trl_via_ary);$tv++)
				 {
					$ses=$ses."city_id='".$trl_via_ary[$tv]."'";
					if(isset($trl_via_ary[$tv+1]))
					{
						$ses=$ses." or ";
					}
				 }
				 $ses=$ses.")";
				
			}else{
				 $ses="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (city_id='".$city_id_arr[$c]."' or city_id='".$city_id_arr[$c+1]."')";
			}
			


					$query_travel_alr = "SELECT * FROM travel_sched where travel_id='".$_SESSION['com_plan_id']."' and  tr_date='".$arr_dat."'";
					$travel_alr= mysql_query($query_travel_alr, $divdb) or die(mysql_error());
					$row_travel_alr = mysql_fetch_assoc($travel_alr);
					$tot_travel_alr= mysql_num_rows($travel_alr);
$already_arr=explode('/',$row_travel_alr ['addi_cost_for']);
$already_sno='';
$already_cost='';
           //  $ses="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (city_id='".$city_id_arr[$c]."' or city_id='".$city_id_arr[$c+1]."')";
                                    
                                    $saddi= mysql_query($ses, $divdb) or die(mysql_error());
                                    //$row_saddi=mysql_fetch_assoc($saddi);
                                    $tot_saddi=mysql_num_rows($saddi);
									if($tot_saddi>0)
									{?>
                                    <select class="chosen-select" id="<?php echo $fr; ?>_addi_cst_sel_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_cst_sel_<?php echo $arr_dat; ?>" multiple onChange="addi_add_on_change('<?php echo $arr_dat; ?>','<?php echo $fr; ?>')" data-placeholder="Choose some add-ons">
                                        <option ></option>
                                        <?php
                                        while($row_saddi=mysql_fetch_assoc($saddi))
										{

											?>
											 <option value="<?php echo $row_saddi['sno'];?>"
<?php
											if (in_array($row_saddi['short_desc'], $already_arr))
											{?>
												selected='selected'
											<?php 
														if($already_sno=='')
														{
															$already_sno=$row_saddi['sno'];
															$already_cost=$row_saddi['amount'];
														}else{
															$already_sno=$already_sno.','.$row_saddi['sno'];
															$already_cost=$already_cost.','.$row_saddi['amount'];
														}
										} ?>
											 	><?php echo $row_saddi['short_desc'].'- Rs.'.$row_saddi['amount'];?></option>
										<?php }//while end
										?>
                                        </select>
                                        <input type="hidden" id="<?php echo $fr; ?>_addi_sno_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_sno_<?php echo $arr_dat; ?>" value="<?php echo $already_sno; ?>">
                                        <input type="hidden" id="<?php echo $fr; ?>_addi_cst_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_cst_<?php echo $arr_dat; ?>" value="<?php echo $already_cost; ?>">
									<?php }else{ ?>
										<input type="text" value="No Add-ons Available" class="form-control" readonly>
                                        
									<?php $cchek=1; } ?>
            </div>
            <div class="col-sm-2" >
            <?php if($cchek=='1'){?> <input type="text" value="Nil" class="form-control" readonly> <?php }
			else {?>
         <input type="number" min='1' max='50' value="<?php echo $tot_pers; ?>" class="form-control" id="<?php echo $fr; ?>_addi_persons<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_persons<?php echo $arr_dat; ?>" onkeypress="only_number('<?php echo $arr_dat; ?>')"> <?php }?> </div>
        </div>
		<?php 
				$date=date_create($arr_dat);
				date_add($date,date_interval_create_from_date_string("1 days"));
				$arr_dat=date_format($date,"Y-m-d");
		}

	}//for each 
	}//live if

}//main for loop?>
    
    <div class="col-sm-12" style="margin-top:20px; margin-bottom:10px;" align="right">
    <a class="btn btn-sm btn-default" onClick="no_need_add_ons()">No Need</a>&nbsp;&nbsp;&nbsp;
    <a class="btn btn-sm btn-info" onClick="go_with_add_ons()">Go with these add-ons</a>&nbsp;&nbsp;&nbsp;
    <br>
    </div>
    </div>
<?php 

*/
	/////////////////////////////////////////////end


	$plan_id=$_GET['pid1'].'#'.$_GET['pid2'];
	?>
   <div class="row">
    <div class="col-sm-12">
    <div class="col-sm-1" style="color:#D8800F; font-weight:700" > Date </div>
    <div class="col-sm-3" style="color:#D8800F; font-weight:700"> Selected Cities </div>
    <div class="col-sm-6" align="center" style="color:#D8800F; font-weight:700"> Choose Add-ons </div>
    <div class="col-sm-2" align="center" style="color:#D8800F; font-weight:700">Quantity</div>
    </div>
    <?php


$travel_multi = $conn->prepare("SELECT * FROM travel_master where plan_id=?");
$travel_multi->execute(array($plan_id));
$row_travel_multi = $travel_multi->fetch(PDO::FETCH_ASSOC);
$tot_travel_multi= $travel_multi->rowCount();

$break_arr=explode('-',$row_travel_multi['sub_paln_id']);

for($fb=0;$fb<count($break_arr);$fb++)
{
	$fr="fr".$fb;
	$plan_id=$break_arr[$fb];
		
		$travel = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
		$travel->execute(array($plan_id));
		//$row_travel = mysql_fetch_assoc($travel);
		$row_travel_main=$travel->fetchAll();
		$tot_travel= $travel->rowCount();
		foreach($row_travel_main as $row_travel)
		{
			$adsno="";
			$adamt="";
		?>
        <div class="col-sm-12" style="margin-top:10px;">
            <div class="col-sm-1" align="center"><?php 
				echo date('d-M',strtotime($row_travel['tr_date']));	
				$arr_dat=$row_travel['tr_date'];
			?></div>
                
            <div class="col-sm-3"><?php 
			echo $row_travel['tr_from_cityid'].' <i class="fa fa-arrows-h"></i> '.$row_travel['tr_to_cityid']; 
			?></div>
            
            <div class="col-sm-6"><?php 
			
				//	echo $query_travel_via = "SELECT * FROM travel_sched where travel_id='".$plan_id."' and  tr_date='".$arr_dat."' and (trim(via_cities)!='-')";
		            $travel_via = $conn->prepare("SELECT * FROM travel_sched where travel_id=? and  tr_date=? and (trim(via_cities)!='-')");
					$travel_via->execute(array($plan_id,$arr_dat));
					$row_travel_via =$travel_via->fetch(PDO::FETCH_ASSOC);
					$tot_travel_via= $travel_via->rowCount();
				
			if($tot_travel_via>0)
			{
				$trl_via_ary=explode('-',$row_travel_via['via_cities']);
				$ses="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (";
				 
				 for($tv=0;$tv<count($trl_via_ary);$tv++)
				 {
					$ses=$ses."city_id='".$trl_via_ary[$tv]."'";
					if(isset($trl_via_ary[$tv+1]))
					{
						$ses=$ses." or ";
					}
				 }
				 $ses=$ses.")";
				
			}else{
				 
					
					$cityy_to1 = $conn->prepare("SELECT * FROM dvi_cities where trim(name)=?");
					$cityy_to1->execute(array(trim($row_travel['tr_from_cityid'])));
					$row_cityy_to1 = $cityy_to1->fetch(PDO::FETCH_ASSOC);
					
					
					$cityy_to2 = $conn->prepare("SELECT * FROM dvi_cities where trim(name)=?");
					$cityy_to2->execute(array(trim($row_travel['tr_to_cityid'])));
					$row_cityy_to2 =$cityy_to2->fetch(PDO::FETCH_ASSOC);
					
					
				
				    $ses="SELECT * FROM additional_cost WHERE status = '0' and ('$arr_dat' BETWEEN fdate AND tdate) and (city_id='".$row_cityy_to1['id']."' or city_id='".$row_cityy_to2['id']."')";
			}      
					$saddi=$conn->prepare($ses);
					$saddi->execute();
                    //$row_saddi=mysql_fetch_assoc($saddi);
					$row_saddi_main=$saddi->fetchAll();
                    $tot_saddi=$saddi->rowCount();
									if($tot_saddi>0)
									{?>
     <select class="chosen-select" id="<?php echo $fr; ?>_addi_cst_sel_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_cst_sel_<?php echo $arr_dat; ?>" multiple onChange="addi_add_on_change('<?php echo $arr_dat; ?>','<?php echo $fr; ?>')" data-placeholder="Choose some add-ons">
                                        <option ></option>
                                        <?php
                                        foreach($row_saddi_main as $row_saddi)
										{?>
											 <option value="<?php echo $row_saddi['sno'];?>"
 <?php if($row_travel['addi_cost_for']==$row_saddi['short_desc']){ 
 	$adsno=$row_saddi['sno']; $adamt=$row_travel['addi_amount']; ?> selected <?php }?>
                                             ><?php echo $row_saddi['short_desc'];?></option>
										<?php }//while end
										?>
                                        </select>
      <input type="hidden" id="<?php echo $fr; ?>_addi_sno_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_sno_<?php echo $arr_dat; ?>" value="<?php echo $adsno; ?>">
       <input type="hidden" id="<?php echo $fr; ?>_addi_cst_<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_cst_<?php echo $arr_dat; ?>" value="<?php echo $adamt; ?>">
									<?php }else{ ?>
										<input type="text" value="No Add-ons" class="form-control" readonly>
									<?php } ?>
            </div>
            <div class="col-sm-2" >
           
 <input type="number" min='1' max='50' value="<?php echo $row_travel['num_person']; ?>" class="form-control" id="<?php echo $fr; ?>_addi_persons<?php echo $arr_dat; ?>" name="<?php echo $fr; ?>_addi_persons<?php echo $arr_dat; ?>" > 

        </div>
        </div>
		<?php 
		}//while end
	}//main for loop
		 ?>
    
    <div class="col-sm-12" style="margin-top:20px; margin-bottom:10px;" align="right">
    <a class="btn btn-sm btn-default" onClick="no_need_add_ons()">No Need</a>&nbsp;&nbsp;&nbsp;
    <a class="btn btn-sm btn-info" onClick="go_with_add_ons()">Go with these add-ons</a>&nbsp;&nbsp;&nbsp;
    <br>
    </div>
    
    </div>
    
<?php 
}

if(isset($_GET['type']) && $_GET['type']==5)
{
	        echo $plan_id=$_GET['pid1'].'#'.$_GET['pid2'];


$travel_break = $conn->prepare("SELECT * FROM travel_master where plan_id=? ORDER BY sno ASC");
$travel_break->execute(array($plan_id));
$row_travel_break = $travel_break->fetch(PDO::FETCH_ASSOC);
$tot_travel_break= $travel_break->rowCount();

$breaks_arr=explode('-',$row_travel_break['sub_paln_id']);

for($fb=0;$fb<count($breaks_arr);$fb++)
{
	$addi_costs_tot=0;
	$fr="fr".$fb;
	$plan_id=$breaks_arr[$fb];

			
			$travel = $conn->prepare("SELECT * FROM travel_sched where travel_id=? ORDER BY sno ASC");
			$travel->execute(array($plan_id));
			//$row_travel = mysql_fetch_assoc($travel);
			$row_travel_main =$travel->fetchAll();
			$tot_travel= $travel-rowCount();
			
			
		
			
		foreach($row_travel_main as $row_travel)
		{
			
				$num_pers=0;
			$ssddate=trim($row_travel['tr_date']);
			$addi_cst_name='';
			$addi_cst_amt='';
			$num_pers=trim($_POST[$fr.'_addi_persons'.$ssddate]);
			if(isset($_POST[$fr.'_addi_sno_'.$ssddate]) && $_POST[$fr.'_addi_sno_'.$ssddate]!='')
			{
				$addi_cst_arry=explode(',',$_POST[$fr.'_addi_sno_'.$ssddate]);
				for($ac=0;$ac<count($addi_cst_arry);$ac++)
				{
									$saddi=$conn->prepare("SELECT * FROM additional_cost WHERE sno=?");
                                    $saddi->execute(array($addi_cst_arry[$ac]));
                                    $row_saddi=$saddi->fetch(PDO::FETCH_ASSOC);
                                    
									if($addi_cst_name=='')
									{
										$addi_cst_name=$row_saddi['short_desc'];
									}else{
										$addi_cst_name=$addi_cst_name.'/'.$row_saddi['short_desc'];
									}
				}
				$addi_cst_amt=$_POST[$fr.'_addi_cst_'.$ssddate];
				
				/*$addi_cst_addition_ary=explode(',',$_POST[$fr.'_addi_cst_'.$ssddate]);
				foreach($addi_cst_addition_ary as $addi_costs)
				{
					$addi_costs_tot=$addi_costs_tot+(int)$addi_costs;
				}*/

				$addi_cst_addition_ary=explode(',',$_POST[$fr.'_addi_cst_'.$ssddate]);
				foreach($addi_cst_addition_ary as $addi_costs)
				{
					echo $addi_costs_tot=$addi_costs_tot+(((int)$addi_costs)*((int)$num_pers));
				}
			}
				
		$insertSQL2 = $conn->prepare("update travel_sched set addi_cost_for=?, addi_amount=?, num_person=? where tr_date=? and travel_id=?");
		$insertSQL2->execute(array($addi_cst_name,$addi_cst_amt,$num_pers,$ssddate,$plan_id));	
		}
		
		$master=$conn->prepare("SELECT * FROM travel_master WHERE  plan_id=?");
        $master->execute(array($plan_id));
        $row_master=$master->fetch(PDO::FETCH_ASSOC);
									
		$org_cost= (int)$row_master['tr_net_amt']+(int)$row_master['stay_tot_amt']+(int)$addi_costs_tot;
		$org_cost1=$org_cost+($org_cost*($row_master['agent_perc']/100));
		$org_cost2=$org_cost1+($org_cost1*($row_master['agnt_adm_perc']/100));
		
	echo $insertSQL2 = $conn->prepare("update travel_master set tot_additional_cost=?, grand_tot=?, agnt_grand_tot=? where plan_id=?");
		 $insertSQL2->execute(array($addi_costs_tot,$org_cost,$org_cost2,$plan_id));
	
	}//main for  loop
}

?>