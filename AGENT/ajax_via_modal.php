<?php
include('../Connections/divdb.php');
session_start();

	$tr=$_POST['nos'];
	$vias=$_POST['vias'];
	 $from_city_selt_txt=$_POST['from_city_selt_txt'];
	 $to_city_selt_txt=$_POST['to_city_selt_txt'];
	 $from_city=$_POST['frm_cy'];
	 $end_city=$_POST['to_cy'];
	
	
		
		$already = $conn->prepare("SELECT * FROM dvi_trav_via where from_cityid= and to_cityid=?");
		$already->execute(array($from_city,$end_city));
		//$row_already= mysql_fetch_assoc($already);
		$row_already=$already->fetch(PDO::FETCH_ASSOC);
		$tot_already=$already->rowCount();
		
		//if($tot_already==0){//if already available via means 

	
		
		$gendist = $conn->prepare("SELECT * FROM setting_dist");
		$gendist->execute();
		$row_gendist= $gendist->fetch(PDO::FETCH_ASSOC);
		$via_dist_gen=$row_gendist['via_dist'];
		$GLOBALS['via_dist_gen'];
		
function trav_via_fun($avr1,$tv)
{
	//echo "<br>GG ";
	//print_r($avr1);
	$GLOBALS['from_city'];
$hostname_divdb = "localhost";
$database_divdb = "dvidb";
$username_divdb = "root";
$password_divdb = "";
$divdb = mysql_pconnect($hostname_divdb, $username_divdb, $password_divdb) or trigger_error(mysql_error(),E_USER_ERROR);


		$gendist = $conn->prepare("SELECT * FROM setting_dist");
		$gendist->execute();
		$row_gendist=$gendist->fetch(PDO::FETCH_ASSOC);

$gen_via_dist=$GLOBALS['via_dist_gen'];
	//$arr_name=$trv_arr.$tv;
	$trv_arr1=array();
	$arrv1=explode('-',$avr1);
	$befr_city=$arrv1['0'];
	$to_city=$GLOBALS['end_city'];
	$before_dist=$arrv1['3'];
	
		
		$dist = $conn->prepare("SELECT * FROM  dvi_citydist where (from_cityid=? and dist<=? and dist !='0' and to_cityid != ?) or (to_cityid=? and dist<=? and dist !='0' and to_cityid != ?) and status='0' ORDER BY dist ASC");
		$dist->execute(array($befr_city,$gen_via_dist,$to_city,$befr_city,$gen_via_dist,$to_city));
		//$row_dist= mysql_fetch_assoc($dist);
		$row_dist_main=$dist->fetchAll();
		$tot_dist=$dist->rowCount();
		
		if($tot_dist>0)
		{
			$r=0;
			foreach($row_dist_main as $row_dist)
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
				
				
				if((int)$row_gendist['gen_dist']>=(int)$sum && ($GLOBALS['from_city'] != $city_id) && ($GLOBALS['end_city'] != $city_id))
				{
					
					$cityname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
					$cityname->execute(array($city_id));
					$row_cityname= $cityname->fetch(PDO::FETCH_ASSOC);
					
					$tot_ds=$row_discalc1['dist']+$before_dist;
					$trv_arr1[$r++]=$city_id.'-'.$row_cityname['name'].'-'.$row_discalc1['dist'].'-'.$tot_ds;
				 }
			 } //while end
			
		}
		return $trv_arr1;
}
		
		
		
		$dist = $conn->prepare("SELECT * FROM  dvi_citydist where (from_cityid=? and dist<=? and dist !='0') or (to_cityid=? and dist<=? and dist !='0') and status='0' ORDER BY dist ASC");
		$dist->execute(array($from_city,$row_gendist['via_dist'],$from_city,$row_gendist['via_dist']));
		//$row_dist= mysql_fetch_assoc($dist);
		$row_dist_main=$dist->fetchAll();
		$tot_dist=$dist->rowCount();
	?>
	<div class="modal fade trv_via" tabindex="-1" role="dialog" aria-hidden="true" id="mod_via_<?php echo $tr.'_'.$vias; ?>">
										  <div class="modal-dialog modal-lg">
											<div class="modal-content modal-no-shadow modal-no-border bg-default ">
											  <div class="modal-header" style="background-color: #EFE1CE;color: #BD6D13;">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" style="font-size: 22px;"><i class="fa fa-random"></i>&nbsp; From <?php echo $from_city_selt_txt.' To '.$to_city_selt_txt; ?></h4>
											  </div>
                                              <div class="modal-body" style="height:420px; padding:5px; overflow-y:scroll">
             <input type="text" id="sel_via_trav_cids_<?php echo $tr.'_'.$vias; ?>" name="sel_via_trav_cids_<?php echo $tr.'_'.$vias; ?>" />
             <input type="text" id="sel_via_trav_cnames_<?php echo $tr.'_'.$vias; ?>" name="sel_via_trav_cnames_<?php echo $tr.'_'.$vias; ?>"  />
             <input type="text" id="sel_via_trav_totdis_<?php echo $tr.'_'.$vias; ?>" name="sel_via_trav_totdis_<?php echo $tr.'_'.$vias; ?>"  />
                                              <!--<table class="table">-->
                                              
                                              <?php  
											  $trv_arr=array();
				if($tot_dist>0)
				{	$tarr1=0;
					foreach($row_dist_main as $row_dist)
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
						
						if((int)$row_gendist['gen_dist']>=(int)$sum && ($from_city != $city_id) && ($end_city != $city_id))
						{
							
							$cityname = $conn->prepare("SELECT * FROM dvi_cities where id=?");
							$cityname->execute(array($city_id));
							$row_cityname= $cityname->fetch(PDO::FETCH_ASSOC);
							 //echo $from_city_selt_txt.' => ';
							 //echo $city_id.'-'.$row_discalc1['dist']; 
							 $trv_arr[$tarr1]=$city_id.'-'.$row_cityname['name'].'-'.$row_discalc1['dist'].'-'.$row_discalc1['dist'];
							//echo $row_cityname['name']." => "; 
							$tarr1++;
						}
						
					 } //while end
					// print_r($trv_arr);
					 
					 $glob=0;
					 $glob_via_name_array=array();
					 $glob_via_id_array=array();
					 $glob_via_dist_array=array();
					// echo "<br>========";
					 $h=0;
					 $flag=1;
					 if(count($trv_arr)>0)
					 {
					 
					 for($tt=0;$tt<count($trv_arr);$tt++)
					 {
						//echo "********^^^^^^******";
						$res=trav_via_fun($trv_arr[$tt],$tt);
						//echo "<br>";
						if(!isset($res[0]))
						{
							$name_ar =explode('-',$trv_arr[$tt]);
							$namev=$name_ar[1];
							$namev_id=$name_ar[0];
							$namev_dist=$name_ar[2];
							//echo "<br>Par ".$from_city_selt_txt.' ==> '.$namev." ==> ".$to_city_selt_txt;
							
							//echo "<br>Par ".$from_city.'-'.$namev_id.'-'.$end_city;
							$glob_via_name_array[$glob]=$from_city_selt_txt.'-'.$namev.'-'.$to_city_selt_txt;
							$glob_via_id_array[$glob]=$from_city.'-'.$namev_id.'-'.$end_city;
							$glob++;
							
						}else{
							//$agn_trv_arr[$h]=$res;
							//print_r($agn_trv_arr[$h]);
							//print_r($res);
							for($k=0;$k<count($res);$k++)
							{
								$name_ar =explode('-',$trv_arr[$tt]);
								$namev=$name_ar[1];
								$namev_id=$name_ar[0];
								$res1=trav_via_fun($res[$k],$k);
									
									if(!isset($res1[0]))
									{
										$name_ark =explode('-',$res[$k]);
										$namevk=$name_ark[1];
										$namevk_id=$name_ark[0];
										//echo "<br>".$from_city_selt_txt.' ==> '.$namev." ==> ".$namevk." == >".$to_city_selt_txt;
										$glob_via_name_array[$glob]=$from_city_selt_txt.'-'.$namev.'-'.$namevk.'-'.$to_city_selt_txt;
										$glob_via_id_array[$glob]=$from_city.'-'.$namev_id.'-'.$namevk_id.'-'.$end_city;
										$glob++;
										
									}else{
												//print_r($res1);
												for($k1=0;$k1<count($res1);$k1++)
												{
													$name_ar =explode('-',$trv_arr[$tt]);
													$namev=$name_ar[1];
													$namev_id=$name_ar[0];
													
  													$name_ark =explode('-',$res[$k]);
													$namevk=$name_ark[1];
													$namevk_id=$name_ark[0];
														$res2=trav_via_fun($res1[$k1],$k1);
														
														if(!isset($res2[0]))
														{
															$name_arkf =explode('-',$res1[$k1]);
															$namevkf=$name_arkf[1];
															$namevkf_id=$name_arkf[0];
															//echo "<br>".$from_city_selt_txt.' ==> '.$namev." ==> ".$namevk." == >".$namevkf.' ==> '.$to_city_selt_txt;
															$glob_via_name_array[$glob]=$from_city_selt_txt.'-'.$namev.'-'.$namevk.'-'.$namevkf.'-'.$to_city_selt_txt;
															$glob_via_id_array[$glob]=$from_city.'-'.$namev_id.'-'.$namevk_id.'-'.$namevkf_id.'-'.$end_city;
															$glob++;
															
														}else{
																	//print_r($res2);
																	for($k2=0;$k2<count($res2);$k2++)
																	{
																		$name_ar =explode('-',$trv_arr[$tt]);
																		$namev=$name_ar[1];
																		$namev_id=$name_ar[0];
													
  																		$name_ark =explode('-',$res[$k]);
																		$namevk=$name_ark[1];
																		$namevk_id=$name_ark[0];
																		
																		$name_arkf =explode('-',$res1[$k1]);
																		$namevkf=$name_arkf[1];
																		$namevkf_id=$name_arkf[0];
																		$res3=trav_via_fun($res2[$k2],$k2);
																			
																			if(!isset($res3[0]))
																			{
																				$name_arkfff =explode('-',$res2[$k2]);
																				$namevkfff=$name_arkfff[1];
																				$namevkfff_id=$name_arkfff[0];
																			//	echo "<br>".$from_city_selt_txt.' ==> '.$namev." ==> ".$namevk." ==> ".$namevkf.' ==> '.$namevkfff.' ==> '.$to_city_selt_txt;
																				
															$glob_via_name_array[$glob]=$from_city_selt_txt.'-'.$namev.'-'.$namevk.'-'.$namevkf.'-'.$namevkfff.'-'.$to_city_selt_txt;
															$glob_via_id_array[$glob]=$from_city.'-'.$namev_id.'-'.$namevk_id.'-'.$namevkf_id.'-'.$namevkfff_id.'-'.$end_city;
															$glob++;
																				
																			}else{
																						//print_r($res3);
																						for($k3=0;$k3<count($res3);$k3++)
																						{
																						$name_ar =explode('-',$trv_arr[$tt]);
																						$namev=$name_ar[1];
																						$namev_id=$name_ar[0];
																	
																						$name_ark =explode('-',$res[$k]);
																						$namevk=$name_ark[1];
																						$namevk_id=$name_ark[0];
																						
																						$name_arkf =explode('-',$res1[$k1]);
																						$namevkf=$name_arkf[1];
																						$namevkf_id=$name_arkf[0];
																						
																						$name_arkfff =explode('-',$res2[$k2]);
																						$namevkfff=$name_arkfff[1];
																						$namevkfff_id=$name_arkfff[0];
																						$res4=trav_via_fun($res3[$k3],$k3);
																							
																							if(!isset($res4[0]))
																							{
																								$name_arkfff4 =explode('-',$res3[$k3]);
																								$namevkfff4=$name_arkfff4[1];
																								$namevkfff4_id=$name_arkfff4[0];
																							//	echo "<br>444 ".$from_city_selt_txt.' ==> '.$namev." ==> ".$namevk." ==> ".$namevkf.' ==> '.$namevkfff.' ==> '.$namevkfff4.' ==>'.$to_city_selt_txt;
																								
				$glob_via_name_array[$glob]=$from_city_selt_txt.'-'.$namev.'-'.$namevk.'-'.$namevkf.'-'.$namevkfff.'-'.$namevkfff4.'-'.$to_city_selt_txt;
				$glob_via_id_array[$glob]=$from_city.'-'.$namev_id.'-'.$namevk_id.'-'.$namevkf_id.'-'.$namevkfff_id.'-'.$namevkfff4_id.'-'.$end_city;
				$glob++;
																							}else{
																										//print_r($res4);
																										
																						for($k4=0;$k4<count($res4);$k4++)
																						{
																						$name_ar =explode('-',$trv_arr[$tt]);
																						$namev=$name_ar[1];
																						$namev_id=$name_ar[0];
																	
																						$name_ark =explode('-',$res[$k]);
																						$namevk=$name_ark[1];
																						$namevk_id=$name_ark[0];
																						
																						$name_arkf =explode('-',$res1[$k1]);
																						$namevkf=$name_arkf[1];
																						$namevkf_id=$name_arkf[0];
																						
																						$name_arkfff =explode('-',$res2[$k2]);
																						$namevkfff=$name_arkfff[1];
																						$namevkfff_id=$name_arkfff[0];
																						
																						$name_arkfff4 =explode('-',$res3[$k3]);
																						$namevkfff4=$name_arkfff4[1];
																						$namevkfff4_id=$name_arkfff4[0];
																						$res5=trav_via_fun($res4[$k4],$k4);
																							
																							if(!isset($res5[0]))
																							{
																								$name_arkfff5 =explode('-',$res4[$k4]);
																								$namevkfff5=$name_arkfff5[1];
																								$namevkfff5_id=$name_arkfff5[0];
																							//	echo "<br>".$from_city_selt_txt.' ==> '.$namev." ==> ".$namevk." ==> ".$namevkf.' ==> '.$namevkfff.' ==> '.$namevkfff4.' ==>'.$namevkfff5.' ==> '.$to_city_selt_txt;
																								
				$glob_via_name_array[$glob]=$from_city_selt_txt.'-'.$namev.'-'.$namevk.'-'.$namevkf.'-'.$namevkfff.'-'.$namevkfff4.'-'.$namevkfff5.'-'.$to_city_selt_txt;
				$glob_via_id_array[$glob]=$from_city.'-'.$namev_id.'-'.$namevk_id.'-'.$namevkf_id.'-'.$namevkfff_id.'-'.$namevkfff4_id.'-'.$namevkfff5_id.'-'.$end_city;
				$glob++;
																							}else{
																										//print_r($res5);
																										echo "More..";
																							}
																						}
																										
																										
																							}
																						}
																						
																			}
																	}
																	
														}
												}
												
									}
							}
							$h++;
							$flag=1;
						}
						//echo "**************<br>";
					 }
					 }else{ //no main- array (Possible only longer distance from fromid to toid)
						 
						// echo $from_city_selt_txt.' ==> '.$to_city_selt_txt;
						 	$glob_via_name_array[$glob]=$from_city_selt_txt.'-'.$to_city_selt_txt;
							$glob_via_id_array[$glob]=$from_city.'-'.$end_city;
							$glob++;
					 }
				
				
					//echo "Tot ".count($glob_via_name_array);
					//echo "Tot id".count($glob_via_id_array);
					//echo "=======================================";
					//print_r($glob_via_name_array);
					?>
					 <table class="table " id="via_tab__<?php echo $tr.'_'.$vias; ?>" width="100%" ><?php
					 for($gb=0;$gb<count($glob_via_name_array);$gb++)
					 {?>
						 <tr>
                         <td width="95%"><?php
						  		$glob_via_name_array[$gb];
						 		$vnames=explode('-',$glob_via_name_array[$gb]);
								$vids=explode('-',$glob_via_id_array[$gb]);
								$arr_comb=array_combine($vids,$vnames);
								
								//print_r($vnames);
								//echo "<br>";
								//print_r($vids);
								//echo "<br>";
								//print_r($arr_comb);
								
								$uniq_comb=array_unique($arr_comb);
								//echo "=====<br>";
								//print_r($uniq_comb);
								
								
								//showing city with distance
								
								$arr_cityid=array();
								$arr_cityname=array();
								$ms=0;
								foreach($uniq_comb as $cid=>$cname)
								{
										$arr_cityid[$ms]=$cid;
										$arr_cityname[$ms]=$cname;
										$ms++;
								}
								//print_r($arr_cityname);
								$sep_name=explode(',',$arr_cityname[0]);
								
								if(isset($sep_name[1]))//for from and to city having same city id 
								{
									$ll=count($arr_cityid);
									$arr_cityid[$ll]=$arr_cityid[0];
									$arr_cityname[$ll]=$arr_cityname[0];
									$arr_cityname[0]=$sep_name[0];
								}
								//print_r($arr_cityname);
								
								$tot_distance=0;
						 			for($mn=0;$mn<count($arr_cityid);$mn++)
									{ 
											$mn_ad=$mn+1;
											
											if(isset($arr_cityid[$mn_ad]))
											{//echo $arr_cityid[$mn_ad];
											$visdist = $conn->prepare("SELECT * FROM  dvi_citydist where (from_cityid=? and to_cityid =?) or (from_cityid=? and to_cityid =?) ");
		$visdist->execute(array($arr_cityid[$mn],$arr_cityid[$mn_ad],$arr_cityid[$mn_ad],$arr_cityid[$mn]));
		$row_visdist= $visdist->fetch(PDO::FETCH_ASSOC);
		$kms=$row_visdist['dist'].' Kms';
		$tot_distance=$tot_distance+(int)$row_visdist['dist'];
									}
											
							echo '<span class="btn btn-sm" style="color: #C77315;font-size: 16px;background-color:#F7F6F6">'.$arr_cityname[$mn].'</span>';
												if($mn != count($arr_cityid)-1)
												{?>
                                             <!--   <img src="images/car.png" style="width: 28px;height: 26px;"/>-->
												&nbsp;&nbsp;<i class="fa fa-arrow-right tooltips" data-original-title='<?php echo $kms ?>.' style="color:#888C86"></i>&nbsp;&nbsp;
												<?php }
									}
									//optimization code
									$via_cids=implode('-',$arr_cityid);
									$via_cnms=implode('-',$arr_cityname);
								 $ins_via=$conn->prepare("insert into dvi_trav_via (from_cityid, to_cityid, cities_names, cities_ids)values(?, ?, ?, ?)");
								 $ins_via->execute(array($from_city,$end_city,$via_cids,$via_cnms));
									
						  ?></td>
                         <td width="10%">
                         <?php $via_cities_idss=implode('-',$arr_cityid);
						  $via_cities_nms=implode('-',$arr_cityname);
						 ?>
                         <input type="radio" name="rad" value="" onclick="put_val_via_fun('<?php echo $tr.'_'.$vias; ?>','<?php echo $via_cities_idss; ?>','<?php echo $via_cities_nms; ?>','<?php echo $tot_distance; ?>')" /><?php //  echo $tot_distance; ?> <?php // echo  $from_city_selt_txt; ?>
                         </td>
                         </tr>
					 <?php }
					 ?>
					 </table>
                    
					 <?php 
				
				}//if tot end
						?>
                                              <!--</table>--> </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Proceed</button>
												
                                                <!--<button type="button" class="btn btn-info" id="subplan" value="SUBMIT FOR APPROVAL">Save</button>-->
											  </div>
											</div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .success .full -->
										  </div><!-- /.modal-dialog -->
										</div>
                                        
                                        
                                        <?php // }else{?>
										
                                        
                                        <?php // }?>