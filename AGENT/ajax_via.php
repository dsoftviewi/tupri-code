<?php
require_once('../Connections/divdb.php');
session_start();
?>

<?php
if(isset($_GET['type']) && $_GET['type']==1)
{ 	
		$from_city=$_POST['frm_cy'];
		$to_city=$_POST['to_cy'];
		$vias=$_POST['vias'];
		$via_list=$_POST['via_list'];
		
		$flag_city=1;

		
		$gendist = $conn->prepare("SELECT * FROM setting_dist");
		$gendist->execute();
		$row_gendist= $gendist->fetch(PDO::FETCH_ASSOC);

		
		$dist = $conn->prepare("SELECT * FROM  dvi_citydist where (from_cityid=? and dist<=? and dist !='0') or (to_cityid=? and dist<=? and dist !='0') and status='0' ORDER BY dist ASC");
		$dist->execute(array($from_city,$row_gendist['via_dist'],$from_city,$row_gendist['via_dist']));
		//$row_dist= mysql_fetch_assoc($dist);
		$row_dist_main=$dist->fetchAll();
		$tot_dist=$dist->rowCount();
		
		if($tot_dist>0)
		{?><div class="col-sm-12" style="color: #B3792C; font-weight: 600; margin-top:5px" id="inner_via_<?php echo $vias.'_'.$via_list; ?>">
        <div class="col-sm-1"><?php echo $vias+1;?></div>
        <div class="col-sm-7">
			<select class="chosen-select" id="selvia_<?php echo $from_city.'_'.$to_city.'_'.$vias.'_'.$via_list; ?>" name="selvia_<?php echo $from_city.'_'.$to_city.'_'.$vias.'_'.$via_list; ?>" data-placeholder="Choose Via Route" >
            <option></option>
            <?php foreach($row_dist_main as $row_dist)
			{
				if((int)$row_dist['from_cityid'] == (int)$from_city)
				{
					$city_id=$row_dist['to_cityid'];
				}else{
					$city_id=$row_dist['from_cityid'];
				}
				
				
				$discalc1 = $conn->prepare("SELECT dist FROM dvi_citydist where (from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)");
				$discalc1->execute(array($from_city,$city_id,$city_id,$from_city));
				$row_discalc1= $discalc1->fetch(PDO::FETCH_ASSOC);
				
				
				$discalc2 = $conn->prepare("SELECT dist FROM dvi_citydist where (from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)");
				$discalc2->execute(array($city_id,$to_city,$to_city,$city_id));
				$row_discalc2= $discalc2->fetch(PDO::FETCH_ASSOC);
				
				$sum=(int)$row_discalc1['dist']+(int)$row_discalc2['dist'];
				
				if((int)$row_gendist['gen_dist']>=(int)$sum)
				{
					
					$cityname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
					$cityname->execute(array($city_id));
					$row_cityname= $cityname->fetch(PDO::FETCH_ASSOC);
					$flag_city++;
					
					?>
					 <option value="<?php echo $city_id.'-'.$row_discalc1['dist']; ?>"><?php echo $row_cityname['name']."--".$sum; ?></option>
				<?php }
			 } ?>
            </select>
            <input type="hidden" value="" id="tot_dist_via<?php echo $vias.'_'.$via_list; ?>" name="tot_dist_via<?php echo $vias.'_'.$via_list; ?>">
            </div>
            <div class="col-sm-4"><a class="btn btn-success btn-sm" onclick="add_via_another('<?php echo $from_city; ?>','<?php echo $to_city; ?>','<?php echo $vias; ?>','<?php echo $via_list; ?>')"><i class="fa fa-plus"></i></a>
            &nbsp;&nbsp;<a class="btn btn-danger btn-sm" onclick="remove_via_another('<?php echo $vias; ?>','<?php echo $via_list; ?>')"><i class="fa fa-minus"></i></a></div>
            </div>
		<?php }else{?>
			<div lass="col-sm-12" style="color: #B3792C; font-weight: 600; margin-top:5px">Unavailable Travel Via</div>
            <input type="hidden" value="0" id="tot_dist_via<?php echo $vias.'_'.$via_list; ?>" name="tot_dist_via<?php echo $vias.'_'.$via_list; ?>">
		<?php }

}

//adding via 
if(isset($_GET['type']) && $_GET['type']==2)
{ 	
		$from_city=$_POST['frm_cy'];
		$to_city=$_POST['to_cy'];
		$vias=$_POST['vias'];
		$via_list=$_POST['via_list'];
		$before_dist=$_POST['before_dist'];
		$befr_city=$_POST['befr_city'];
		
		
		$gendist = $conn->prepare("SELECT * FROM setting_dist");
		$gendist->execute();
		$row_gendist= $gendist->fetch(PDO::FETCH_ASSOC);

		
		$dist = $conn->prepare("SELECT * FROM  dvi_citydist where (from_cityid=? and dist<=? and dist !='0' and to_cityid !=?) or (to_cityid=? and dist<=? and dist !='0' and to_cityid !=?) and status='0' ORDER BY dist ASC");
		$dist->execute(array($befr_city,$row_gendist['via_dist'],$to_city,$befr_city,$row_gendist['via_dist'],$to_city));
		//$row_dist= mysql_fetch_assoc($dist);
		$row_dist_main=$dist->fetchAll();
		$tot_dist=$dist->rowCount();
		
		if($tot_dist>0)
		{?><div class="col-sm-12" style="color: #B3792C; font-weight: 600; margin-top:5px" id="inner_via_<?php echo $vias.'_'.$via_list; ?>">
        <div class="col-sm-1"><?php echo $vias+1;?></div>
        <div class="col-sm-7">
			<select class="chosen-select"  id="selvia_<?php echo $from_city.'_'.$to_city.'_'.$vias.'_'.$via_list; ?>" name="selvia_<?php echo $from_city.'_'.$to_city.'_'.$vias.'_'.$via_list; ?>" data-placeholder="Choose Via Route">
            <option></option>
            <?php foreach($row_dist_main as $row_dist)
			{
				if((int)$row_dist['from_cityid'] == (int)$befr_city)
				{
					$city_id=$row_dist['to_cityid'];
				}else{
					$city_id=$row_dist['from_cityid'];
				}
				
				
				$discalc1 = $conn->prepare("SELECT dist FROM dvi_citydist where (from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)");
				$discalc1->execute(array($befr_city,$city_id,$city_id,$befr_city));
				$row_discalc1= $discalc1->fetch(PDO::FETCH_ASSOC);
				
				
				$discalc2 = $conn->prepare("SELECT dist FROM dvi_citydist where (from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)");
				$discalc2->execute(array($city_id,$to_city,$to_city,$city_id));
				$row_discalc2= $discalc2->fetch(PDO::FETCH_ASSOC);
				
				$sum=(int)$row_discalc1['dist']+(int)$row_discalc2['dist']+(int)$before_dist;
				
				if((int)$row_gendist['gen_dist']>=(int)$sum)
				{
					
					$cityname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
					$cityname->execute(array($city_id));
					$row_cityname= $cityname->fetch(PDO::FETCH_ASSOC);
					
					?>
					 <option value="<?php echo $city_id.'-'.$row_discalc1['dist']; ?>"><?php echo $row_cityname['name']."--".$sum; ?></option>
				<?php }
			 } ?>
            </select>
            <input type="hidden" value="" id="tot_dist_via<?php echo $vias.'_'.$via_list; ?>" name="tot_dist_via<?php echo $vias.'_'.$via_list; ?>">
            </div>
            <div class="col-sm-4"><a class="btn btn-success btn-sm" onclick="add_via_another('<?php echo $from_city; ?>','<?php echo $to_city; ?>','<?php echo $vias; ?>','<?php echo $via_list; ?>')"><i class="fa fa-plus"></i></a>
            &nbsp;&nbsp;<a class="btn btn-danger btn-sm" onclick="remove_via_another('<?php echo $vias; ?>','<?php echo $via_list; ?>')"><i class="fa fa-minus"></i></a></div>
            </div>
		<?php }else{?>
			<div lass="col-sm-12" style="color: #B3792C; font-weight: 600; margin-top:5px">Unavailable Travel Via</div>
            <input type="hidden" value="0" id="tot_dist_via<?php echo $vias.'_'.$via_list; ?>" name="tot_dist_via<?php echo $vias.'_'.$via_list; ?>">
		<?php }
}


if(isset($_GET['type']) && $_GET['type']==3)
{
	$tr=$_GET['nos'];
	$vias=$_GET['vias'];
	$nextbox=$_GET['nextbox'];
	//$to_city_selt_txt=$_POST['to_city_selt_txt'];
	$beffrom_city=$_GET['frm_cy'];
	$from_city=$_GET['mid'];
	$end_city=$_GET['to_cy'];
	
	$befdist=$_GET['befdist'];
	
		
		$gendist = $conn->prepare("SELECT * FROM setting_dist");
		$gendist->execute(array($city_id));
		$row_gendist= $gendist->fetch(PDO::FETCH_ASSOC);
		$via_dist_gen=$row_gendist['via_dist'];
		
				$region1 = $conn->prepare("SELECT * FROM dvi_cities where id=? and status='0'");
				$region1->execute(array($from_city));
				$row_region1 = $region1->fetch(PDO::FETCH_ASSOC);
				$tot_region1 = $region1->rowCount();
				
				$region2 = $conn->prepare("SELECT * FROM dvi_cities where id=? and status='0'");
				$region2->execute(array($end_city));
				$row_region2 = $region2->fetch(PDO::FETCH_ASSOC);
				$tot_region2 =$region2->rowCount();
							  
							  
		
		$city = $conn->prepare("SELECT * FROM dvi_cities where (id!=? and id!=? and id!=?) and status='0' and (region=? or region=?) ORDER BY name ASC ");
		$city->execute(array($from_city,$beffrom_city,$end_city,$row_region1['region'],$row_region2['region']));
		//$row_city= mysql_fetch_assoc($city);
		$row_city_main=$city->fetchAll();
		$tot_city=$city->rowCount();
		$via_arr=array();
		$off_distvia_arr=array();
		$full_distvia_arr=array();
		$va=0;
		if($tot_city>0)
		{
			foreach($row_city_main as $row_city)
			{
				$middle=$row_city['id'];
				$viacity1 = $conn->prepare("SELECT * FROM dvi_citydist where ((from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)) and status='0'");
				$viacity1->execute(array($from_city,$middle,$middle,$from_city));
				$row_viacity1= $viacity1->fetch(PDO::FETCH_ASSOC);
				$tot_viacity1=$viacity1->rowCount();
				
				$viacity2 = $conn->prepare("SELECT * FROM dvi_citydist where ((from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)) and status='0'");
				$viacity2->execute(array($end_city,$middle,$middle,$end_city));
				$row_viacity2= $viacity2->fetch(PDO::FETCH_ASSOC);
				$tot_viacity2=$viacity2->rowCount();
				
				$total_dist=($row_viacity1['dist']+$row_viacity2['dist']+$befdist);
				if($total_dist<=$row_gendist['gen_dist'])
				{
					//echo "<br>".$total_dist;
					$via_arr[$va]=$middle;
					$off_distvia_arr[$va]=($row_viacity1['dist']+$befdist);
					$full_distvia_arr[$va]=$total_dist;
					$va++;
				}
			}
		}
		//print_r($via_arr);
		//echo "FFF".$befdist;
		//print_r($off_distvia_arr);
		?>
     
                              <?php
							   $tttt=0;
							   if(count($via_arr)>0){
								   $tttt=1;
								   ?>
                                    <div class="col-sm-12" id="pick_div_<?php echo $tr.'_'.$vias.'_'.$nextbox; ?>" style="margin-top:15px;">
                                    
                              <div class="col-sm-2" style="color:#B9771F">Via - <?php echo $nextbox; ?></div>
                              <div class="col-sm-7">
                              <select class="chosen-select form-control" data-placeholder="Choose Via" id="via_sel_pick<?php echo $tr.'_'.$vias.'_'.$nextbox; ?>" name="via_sel_pick<?php echo $tr.'_'.$vias.'_'.$nextbox; ?>">
                              <option></option>
                              <?php 
							    for($v=0;$v<count($via_arr);$v++) 
								{
								$vcity = $conn->prepare("SELECT * FROM dvi_cities where id=?");
								$vcity->execute(array($via_arr[$v]));
								$row_vcity = $vcity->fetch(PDO::FETCH_ASSOC);
								$tot_vcity =$vcity->rowCount();
										?>
											<option value="<?php echo $row_vcity['id'].'-'.$off_distvia_arr[$v].'-'.$full_distvia_arr[$v]; ?>"><?php echo $row_vcity['name']; ?></option>
										<?php
								}//for end ?>
                              </select>
                              </div>
                              <div class="col-sm-3">
                              <div>
                              <a class="btn btn-info btn-sm" id="btn_extend<?php echo $tr.'_'.$vias.'_'.$nextbox; ?>" onclick="extent_via('<?php echo $tr; ?>','<?php echo $vias; ?>','<?php echo $from_city; ?>','<?php echo $end_city; ?>','<?php echo $nextbox; ?>')"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                              <a class="btn btn-danger btn-sm" id="btn_reduce<?php echo $tr.'_'.$vias.'_'.$nextbox; ?>" onclick="reduce_via('<?php echo $tr; ?>','<?php echo $vias; ?>','<?php echo $nextbox; ?>')"><i class="fa fa-minus"></i></a>
                              </div>
                              </div>
                              </div>
                              <?php }else{ 
							  	echo "No Via";
							  }?>
                              
        <?php
}
?>