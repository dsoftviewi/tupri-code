<div class="sidebar col-sm-4 col-md-3">
                      <!--  <div class="travelo-box">
                            <h5 class="box-title">Search Stories</h5>
                            <div class="with-icon full-width">
                                <input type="text" class="input-text full-width" placeholder="story name or category">
                                <button class="icon green-bg white-color"><i class="soap-icon-search"></i></button>
                            </div>
                        </div>-->
                        
                        <div class="tab-container box">
                            <ul class="tabs full-width">
                                <li><a data-toggle="tab" href="#recent-posts">Recent</a></li>
                                <li class="active"><a data-toggle="tab" href="#popular-posts">Popular</a></li>
                                <li><a data-toggle="tab" href="#new-posts">New</a></li>
                            </ul>
                            <div class="tab-content">
 <?php
$itenarary=$conn->prepare("SELECT * FROM travel_master where status='0' ORDER BY sno DESC LIMIT 3");
$itenarary->execute();
//$row_itenarary = $itenarary->fetch(PDO::FETCH_ASSOC);
$row_itenarary_main= $itenarary->fetchAll();
$total_itenarary= $itenarary->rowCount();
  ?> 
                            
                                <div id="recent-posts" class="tab-pane fade">
                                    <div class="image-box style14">
                                    <?php foreach($row_itenarary_main as $row_itenarary){
										$plan=substr($row_itenarary['plan_id'],0,2);
										$aff=explode('#',$row_itenarary['plan_id']);
										?>
                                        <article class="box">
                                     <figure><a title="View Details" href="tour_details.php?tid1=<?php echo $aff[0]; ?>&tid2=<?php echo $aff[1]; ?>">
                                     <img class="full-width" src="images/flight_img.png" alt="flight" style="height:59px; width:60px;" alt="tourist vehicle Operator in trichy" title="travel agencies in trichy" /></a></figure>
                                            <div class="details" style="padding:1px ">
                                            
                                                <?php
											$arr1=array();
												$r=0;
												//mysql_select_db($database_divdb, $divdb);
												?>
                                                <h5 class="box-title"><a title="View Details" href="tour_details.php?tid1=<?php echo $aff[0]; ?>&tid2=<?php echo $aff[1]; ?>"><?php echo "Southern Region";//echo $packages; ?></a></h5>
                                                <label class="price-wrapper">Tour Package</label>
                                                <br />
                                            <span class="price-per-unit"><?php echo "More Spots To Visit.."; ?></span>
                                            </div>
                                        </article>
                                              <?php }?>
                                        
                                       
                                    </div>
                                </div>
                                
                                <div id="popular-posts" class="tab-pane fade in active">
<?php
$popular= $conn->prepare("SELECT * FROM `hotspots_pro` WHERE spot_images != '' and status=0 GROUP BY spot_state  ORDER BY RAND() LIMIT 3");
$popular->execute();
//$row_popular = $popular->fetch(PDO::FETCH_ASSOC);
$row_popular_main= $popular->fetchAll();
$total_popular= $popular->rowCount();
?> 
                                    <div class="image-box style14">
                                    <?php foreach($row_popular_main as $row_popular)
									{
										$spot_arr=explode(',',$row_popular['spot_images']);
										$rand_spot=$spot_arr[array_rand($spot_arr)];
										
$cities = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cities->execute(array($row_popular['spot_city']));
$row_cities = $cities->fetch(PDO::FETCH_ASSOC);
$total_cities = $cities->rowCount();

$sts =$conn->prepare("SELECT * FROM dvi_states where code =?");
$sts->execute(array($row_popular['spot_state']));
$row_sts = $sts->fetch(PDO::FETCH_ASSOC);
$total_sts = $sts->rowCount();
										
										?>
                                        <article class="box">
                                            <figure><a href="hotspots_galary.php?cid=<?php echo $row_popular['spot_city']; ?>&sid=<?php echo $row_popular['spot_state']; ?>" title="">
                                            <img style="width:63px; height:50px; " src="img_upload/hot_spots/<?php echo $rand_spot; ?>" ></a></figure>
                                            <div class="details" style="padding:1px 15px 0">
                                                <h5 class="box-title" style="word-wrap:break-word;">
                                                <a href="hotspots_galary.php?cid=<?php echo $row_popular['spot_city']; ?>&sid=<?php echo $row_popular['spot_state']; ?>"><?php
												if(strlen($row_popular['spot_name'])>17)
												{
													 echo substr($row_popular['spot_name'],0,15)."..";
												}else{
													 echo $row_popular['spot_name'];
												}
												?></a></h5>
                                                <label style="padding:0px"><?php echo $row_cities['name'].', ';?></label>
                                                <label style="padding:0px"><?php echo $row_sts['name'];?></label>
                                            </div>
                                        </article>
                                        <?php }?>
                                        
                                    </div>
                                </div>
   <?php
 $itenarary1=$conn->prepare("SELECT * FROM travel_master where status='0' ORDER BY sno DESC LIMIT 1");
$itenarary1->execute();
//$row_itenarary1 =$itenarary1->fetch(PDO::FETCH_ASSOC);
$row_itenarary1_main=$itenarary1->fetchAll();
$total_itenarary1= $itenarary1->rowCount();
  ?>                              
                                
                                <div id="new-posts" class="tab-pane fade">
                                    <div class="image-box style14">
                                    <?php foreach($row_itenarary1_main as $row_itenarary1){
										$plan=substr($row_itenarary1['plan_id'],0,2);
										$aff=explode('#',$row_itenarary1['plan_id']);
										?>
                                        <article class="box">
                                     <figure><a title="View Details" href="tour_details.php?tid1=<?php echo $aff[0]; ?>&tid2=<?php echo $aff[1]; ?>">
                                     <img class="full-width" src="images/flight_img.png" alt="tourist vehicle Operator in trichy" title="travel agencies in trichy" alt="flight" style="height:59px; width:60px;" /></a></figure>
                                            <div class="details" style="padding:1px ">
                                            
                                                <h5 class="box-title"><a title="View Details" href="tour_details.php?tid1=<?php echo $aff[0]; ?>&tid2=<?php echo $aff[1]; ?>"><?php echo "New Itinerary"; ?></a></h5>
                                                <label class="price-wrapper">Tour Package</label>
                                                <br />
                                                <span class="price-per-unit"><?php echo "More Spots To Enjoy.."; ?></span>
                                            </div>
                                        </article>
                                              <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
 //hotels
$hotel= $conn->prepare("select COUNT(*) as cnt from hotel_pro where status='0'");
$hotel->execute();
$row_hotel_main=$hotel->fetchAll();
$row_hotel = $row_hotel_main['cnt'];
?>
                        <div class="travelo-box book-with-us-box">
                            <h4>Why Book with us?</h4>
                            <ul>
                                <li>
                                    <i class="soap-icon-hotel-1 circle"></i>
                                    <h5 class="title"><a href="contact.php"><?php echo $row_hotel; ?>+ Hotels</a></h5>
                                    <p>Dvi provides hotels with world class quality.</p>
                                </li>
                                <li>
                                    <i class="soap-icon-savings circle"></i>
                                    <h5 class="title"><a href="contact.php">Low Rates &amp; Savings</a></h5>
                                    <p>We provide you with optimized travel route for your itinerary.</p>
                                </li>
                                <li>
                                    <i class="soap-icon-support circle"></i>
                                    <h5 class="title"><a href="contact.php">Excellent Support</a></h5>
                                    <p>We treat our guests with good hospitality.</p>
                                </li>
                            </ul>
                        </div>
<?php
$contact= $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$contact->execute();
$row_contact = $contact->fetch(PDO::FETCH_ASSOC);
$total_contact= $contact->rowCount();
?>                       
                        <div class="travelo-box contact-box">
                            <h4 class="box-title">Need DVI Help?</h4>
                            <p>We would be more than happy to help you. Our team advisor are 24/7 at your service to help you.</p>
                            <address class="contact-details">
                                <span class="contact-phone"><i class="soap-icon-phone"></i> <?php echo $row_contact['phone']; ?></span>
                                <br />
                                <a href="contact.php" class="contact-email"><i class="soap-icon-generalmessage" style="font-size:30px; color:#FDB747; margin-left:-25px;"></i> <strong style="color:#28B7F2; font-size:21px;"><?php echo "&nbsp;".$row_contact['email']; ?></strong></a>
                            </address>
                        </div>
                    </div>