<?php
include('../Connections/divdb.php');
session_start();

	$tr=$_POST['nos'];
	$vias=$_POST['vias'];
	$from_city_selt_txt=$_POST['from_city_selt_txt'];
	$to_city_selt_txt=$_POST['to_city_selt_txt'];
	$from_city=$_POST['frm_cy'];
	$end_city=$_POST['to_cy'];
	
		
		$gendist = $conn->prepare("SELECT * FROM setting_dist");
		$gendist->execute();
		$row_gendist= $gendist->fetch(PDO::FETCH_ASSOC);
		$via_dist_gen=$row_gendist['via_dist'];
		$GLOBALS['via_dist_gen'];
		
?>
<div class="modal fade trv_via" tabindex="-1" role="dialog" aria-hidden="true" id="mod_via_<?php echo $tr.'_'.$vias; ?>" data-backdrop="static" data-keyword='false'>
										  <div class="modal-dialog ">
											<div class="modal-content modal-no-shadow modal-no-border bg-default ">
											  <div class="modal-header" style="background-color: #EFE1CE;color: #BD6D13;">
												<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
												<h4 class="modal-title" style="font-size: 22px;"><i class="fa fa-random"></i>&nbsp; From <?php echo $from_city_selt_txt.' To '.$to_city_selt_txt; ?></h4>
											  </div>
                                              <!--<table class="table">-->
                              <div class="modal-body">
                              <?php 
			
				$region1 = $conn->prepare("SELECT * FROM dvi_cities where id=? and status='0'");
				$region1->execute(array($from_city));
				$row_region1 = $region1->fetch(PDO::FETCH_ASSOC);
				$tot_region1 =$region1->rowCount();
				
				$region2 = $conn->prepare("SELECT * FROM dvi_cities where id=? and status='0'");
				$region2->execute(array($end_city));
				$row_region2 =$region2->fetch(PDO::FETCH_ASSOC);
				$tot_region2 =$region2->rowCount();
							  
							  
		
		// $query_city = "SELECT * FROM dvi_cities where (id!='".$from_city."' and id!='".$end_city."') and status='0' and (region='".$row_region1['region']."' or region='".$row_region2['region']."') ORDER BY name ASC ";
		 $city = $conn->prepare("SELECT * FROM dvi_cities where (id!=? and id!=?) and status='0' ORDER BY name ASC ");
		$city->execute(array($from_city,$end_city));
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
//echo "M=".$middle;

				$viacity1 = $conn->prepare("SELECT * FROM dvi_citydist where ((from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)) and status='0'");
				$viacity1->execute(array($from_city,$middle,$middle,$from_city));
				$row_viacity1= $viacity1->fetch(PDO::FETCH_ASSOC);
				$tot_viacity1=$viacity1->rowCount();
				
				$viacity2 = $conn->prepare("SELECT * FROM dvi_citydist where ((from_cityid=? and to_cityid=?) or (from_cityid=? and to_cityid=?)) and status='0'");
				$viacity2->execute(array($end_city,$middle,$middle,$end_city));
				$row_viacity2= $viacity2->fetch(PDO::FETCH_ASSOC);
				$tot_viacity2=$viacity2->rowCount();
				
				$total_dist=($row_viacity1['dist']+$row_viacity2['dist']);
				if($total_dist<=$row_gendist['gen_dist'])
				{
					//echo "<br>".$total_dist;
					$via_arr[$va]=$middle;
					$off_distvia_arr[$va]=$row_viacity1['dist'];
					$full_distvia_arr[$va]=$total_dist;
					$va++;
				}
			}
		}
		//print_r($off_distvia_arr);
							  ?>
                              <div class="row" id="pick_div_<?php echo $tr.'_'.$vias.'_1'; ?>">
             <input type="hidden" id="sel_via_trav_cids_<?php echo $tr.'_'.$vias; ?>" name="sel_via_trav_cids_<?php echo $tr.'_'.$vias; ?>" />
             <input type="hidden" id="sel_via_trav_cnames_<?php echo $tr.'_'.$vias; ?>" name="sel_via_trav_cnames_<?php echo $tr.'_'.$vias; ?>"  />
             <input type="hidden" id="sel_via_trav_totdis_<?php echo $tr.'_'.$vias; ?>" name="sel_via_trav_totdis_<?php echo $tr.'_'.$vias; ?>"  />
            
            
                               <div class="col-sm-12">
                              <?php
							   $tttt=0;
							   if(count($via_arr)>0){
								   $tttt=1;
								   ?>
                              <div class="col-sm-2" style="color:#B9771F">Via - 1</div>
                              <div class="col-sm-7">
                              <select class="chosen-select form-control" data-placeholder="Choose Via" id="via_sel_pick<?php echo $tr.'_'.$vias.'_1'; ?>" name="via_sel_pick<?php echo $tr.'_'.$vias.'_1'; ?>">
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
                              <a class="btn btn-info btn-sm" id="btn_extend<?php echo $tr.'_'.$vias.'_1'; ?>" onclick="extent_via('<?php echo $tr; ?>','<?php echo $vias; ?>','<?php echo $from_city; ?>','<?php echo $end_city; ?>','1')"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <!--  <a class="btn btn-danger btn-sm" id="btn_reduce<?php echo $tr.'_'.$vias.'_1'; ?>" onclick="reduce_via('<?php echo $tr; ?>','<?php echo $vias; ?>','1')"><i class="fa fa-minus"></i></a>-->
                              </div>
                              </div>
                              <?php }else{ 
							  	echo '<center>This is long distance route, so direct route only available.. <br> i.e:('.$from_city_selt_txt.' To '.$to_city_selt_txt.'  )</center>';
							  }?>
                              </div>
                              </div>
     <input type="hidden" id="tot_vias<?php echo $tr.'_'.$vias; ?>" name="tot_vias<?php echo $tr.'_'.$vias; ?>" value="<?php echo $tttt; ?>" />
                              </div>
                                              <!--</table>-->
											  <div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss='true' onclick="cancel_via_route('<?php echo $tr; ?>','<?php echo $vias; ?>')">Cancel Via</button>
                                                <button type="button" class="btn btn-info" onclick="create_via_route('<?php echo $tr; ?>','<?php echo $vias; ?>','<?php echo $from_city; ?>','<?php echo $end_city; ?>','<?php echo $from_city_selt_txt?>','<?php echo $to_city_selt_txt?>')">Proceed</button>
											  </div>
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>