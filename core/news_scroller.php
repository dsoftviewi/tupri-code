									<?php 
$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$mm1=$date->format('M');
$yy=$date->format('Y');
$dd=$date->format('d');
$today=date("d-m-Y");
									
								//$ses_news="SELECT * FROM news_scroller ";
								$newslimt=$conn->prepare("SELECT * FROM `news_scroller` WHERE STR_TO_DATE(`from_date`,'%d-%m-%Y')<=STR_TO_DATE('$today','%d-%m-%Y')   && STR_TO_DATE(`to_date`,'%d-%m-%Y') >= STR_TO_DATE('$today','%d-%m-%Y') && trim(from_date)!='' && trim(to_date)!='' ORDER BY priority ASC");
								$newslimt->execute();
								//$row_newslimt=mysql_fetch_assoc($newslimt);
								$row_newslimt_main=$newslimt->fetchAll();
								$tnewslimt=$newslimt->rowCount();
								
								$newslimt1=$conn->prepare("SELECT * FROM `news_scroller` WHERE trim(from_date)='' and trim(to_date)='' ORDER BY priority ASC");
								$newslimt1->execute();
								//$row_newslimt1=mysql_fetch_assoc($newslimt1);
								$row_newslimt1_main=$newslimt1->fetchAll();
								$tnewslimt1=$newslimt1->rowCount();
								
								if($tnewslimt>0 || $tnewslimt1>0)
								{
									?>
                                    <div id="bulletin" class="bulletin">
     								<ul>
                                    <?php 
									//for limited priord
									foreach($row_newslimt_main as $row_newslimt)
									{?>
        							<li> <a style="color:#FF3; font-weight:600"><?php echo $row_newslimt['news'];?></a>
                                    <?php if(trim($row_newslimt['images'])!='' && trim($row_newslimt['images'])!='default_img.png') {?>
                                    &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;<a style="color:#FF7800; font-weight:600" href="ADMIN/img_upload/news_img/<?php echo $row_newslimt['images']; ?>" download><i class="fa fa-download"></i>&nbsp;Download</a>
                                    <?php }?>
                                    </li>
                                    <?php }
									
									//for default news
									foreach($row_newslimt1_main as $row_newslimt1)
									{?>
									<li><a style="color:#FF3; font-weight:600"><?php echo $row_newslimt1['news'];?></a>
                                    <?php if(trim($row_newslimt1['images'])!='' && trim($row_newslimt1['images'])!='default_img.png') {?>
                                    &nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;<a style="color:#FF7800; font-weight:600" href="ADMIN/img_upload/news_img/<?php echo $row_newslimt1['images']; ?>" download><i class="fa fa-download"></i>&nbsp;Download</a>
                                    <?php }?>
                                    </li>
									<?php }
									?>
      								</ul>
                                    <div class="close pull-right">&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">×</a></div>
                                   <!-- <div class="pull-right"><a href="View All">View All</a></div>-->
   									</div>
                                <?php }?>
                              
 