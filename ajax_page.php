<?php 
require_once('Connections/divdb.php');
session_start();

if(isset($_GET['type']) && $_GET['type']==15)
{ $state_id=$_GET['sid'];
									
									$hotelcity = $conn->prepare("SELECT * FROM reg_cities where region=?");
									$hotelcity->execute(array($state_id));
									//$row_hotelstate= mysql_fetch_assoc($hotelstate);
									$row_hotelcity_main =$hotelcity->fetchAll();
									?>
									<span class="input-group-addon tooltips" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
										 <select data-placeholder="Choose a city" name="hotel_city" id="hotel_city" class="form-control chosen-select " tabindex="2">									<option value="">Choose City</option>	
										 <?php foreach($row_hotelcity_main as $row_hotelcity) {?>
										<option value="<?php echo $row_hotelcity['id'];?>"><?php echo $row_hotelcity['name'];?></option>
                                        <?php } ?>
									</select>
			
<?php } if(isset($_GET['type']) && $_GET['type']==16)
{ $state_id=$_GET['sid'];
									
                              
                  
                  $hotelstate = $conn->prepare("SELECT * FROM dvi_states where country=?");
                  $hotelstate->execute(array($state_id));
                  //$row_hotelstate= mysql_fetch_assoc($hotelstate);
				  $row_hotelstate_main=$hotelstate->fetchAll();
                  ?>
                  <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Living State"><i class="fa fa-globe fa-fw"></i></span>
                     <select data-placeholder="Choose a State" name="agn_state" id="agn_state" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_city(this.value)"   >                  
                                         <option value='nil'>Choose a State</option>  
                     <?php foreach($row_hotelstate_main as $row_hotelstate) {?>
                    <option value="<?php echo $row_hotelstate['code'];?>"><?php echo $row_hotelstate['name'];?></option>
                                        <?php } ?>
                  </select>
                    
			
<?php } ?>