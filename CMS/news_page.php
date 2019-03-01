<?php
$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
 $today=date("d_M_Y_H_i_s");
  


 if(isset($_POST['news_sett']) && ($_POST['news_sett']=="news_sett_val"))
 {
	 $from_dt='';
	 $end_dt='';
		 $news=$_POST['news'];
		 $orders=$_POST['orders'];
		 $limits=$_POST['limits'];
		 if($limits=='limit')
		 {
			 	$from_dt=$_POST['from_date'];
	 			$end_dt=$_POST['end_date'];
		 }
		 
		 $attachment=$_FILES['news_attach']['name'];
		 if(trim($attachment)!='')
		 {
		 	$FileType = pathinfo($attachment,PATHINFO_EXTENSION);
  			$profile=$today.".".$FileType;
			$target_file='ADMIN/img_upload/news_img/'.$profile;

				if(!move_uploaded_file($_FILES["news_attach"]["tmp_name"], $target_file))
				{
					$attachment="default_img.png";
				}else{
					$attachment=$profile;	
				}
		 }else{
			 $attachment="default_img.png";
		 }
	$insert_news="insert into news_scroller(news,from_date,to_date,images,priority)values('".$news."', '".$from_dt."','".$end_dt."','".$attachment."','".$orders."')";
	mysql_select_db($database_divdb, $divdb);
	$Resultupd = mysql_query($insert_news, $divdb) or die(mysql_error());
		echo "<script>parent.document.location.href='admin_news.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost=".md5(7)."';</script>"; 
 }
 
if(isset($_POST['updnews_sett']) && ($_POST['updnews_sett']=="updnews_sett_val"))
 {
	 $from_dt='';
	 $end_dt='';
		 $news=$_POST['updnews'];
		 $orders=$_POST['udporders'];
		 $limits=$_POST['updlimits'];
		 if($limits=='limit')
		 {
			 	$from_dt=$_POST['updfrom_date'];
	 			$end_dt=$_POST['updend_date'];
		 }
		 
		 $query_news2 = "SELECT * FROM news_scroller where sno='".$_POST['ssno']."'";
	$news2 = mysql_query($query_news2, $divdb) or die(mysql_error());
	$row_news2= mysql_fetch_assoc($news2);
	$totalRows_news2=mysql_num_rows($news2);
		 
		 $attachment=$_FILES['updnews_attach']['name'];
		 if(trim($attachment)!='')
		 {
		 	$FileType = pathinfo($attachment,PATHINFO_EXTENSION);
  			$profile=$today.".".$FileType;
			$target_file='ADMIN/img_upload/news_img/'.$profile;

				if(!move_uploaded_file($_FILES["updnews_attach"]["tmp_name"], $target_file))
				{
					$attachment="default_img.png";
				}else{
					$attachment=$profile;	
				}
		 }else{
			 $attachment=$row_news2['images'];
		 }
		 
		 if(trim($_POST['rem_upd_img'])!='' && trim($_POST['rem_upd_img'])!='default_img.png')
		 {
			unlink('ADMIN/img_upload/news_img/'.$_POST['rem_upd_img']); 
			$attachment="default_img.png";
		 }
		 
	$insert_news="UPDATE news_scroller set news='".$news."', from_date='".$from_dt."', to_date='".$end_dt."' , images='".$attachment."', priority='".$orders."' where sno='".$_POST['ssno']."'";
	mysql_select_db($database_divdb, $divdb);
	$Resultupd = mysql_query($insert_news, $divdb) or die(mysql_error());
	
	echo "<script>parent.document.location.href='admin_news.php?&mm=".$_GET['mm']."&sm=".$_GET['sm']."&tost1=".md5(6)."';</script>"; 
 }
?>

<style>
		.datepicker{z-index:1050 !important;}
</style>

<?php 
	mysql_select_db($database_divdb, $divdb);
	$query_news = "SELECT * FROM news_scroller  ORDER BY sno ASC";
	$news = mysql_query($query_news, $divdb) or die(mysql_error());
	//$row_news = mysql_fetch_assoc($news);
	$totalRows_news = mysql_num_rows($news);
?>
	<div class="container-fluid">
				
				<!-- Begin page heading -->
				<h1 class="page-heading">News<small>&nbsp;News Header</small></h1>
				<div class="modal fade" id="news_settings" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
										  <div class="modal-dialog">
                    <form name="form_distr_sett" id="form_distr_sett" method="post" enctype="multipart/form-data" onsubmit="return checkk1()">
											<div class="modal-content modal-no-shadow modal-no-border">
											  <div class="modal-header bg-info no-border">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5 class="modal-title" style="font-family:Verdana, Geneva, sans-serif; font-weight:600;"> <i class="fa fa-cogs"></i>&nbsp;Add - News </h5>
											  </div>
											  <div class="modal-body">
                                                <div class="row">
									<div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="news">News Content</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                                    <div class="form-group">
                                    <div class="input-group">
                        <textarea name="news" id="news" style="overflow-y:scroll; height:70px; width:400px; resize:none" maxlength="250"></textarea>
										</div>
									      </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="news_attach">Attachment<br><small>(Optional)</small></label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-9">
                                    <div class="form-group">
                                    <div class="input-group">
                        <input type="file" name="news_attach" id="news_attach" >
										</div>
									      </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                   	<div class="row">
									<div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                       						<label for="orders">Priority</label>
									</div>
									</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                                           <select class=" form-control " style="width:100%" name="orders" id="orders">
                                           <?php for($t=1; $t<=$totalRows_news+1; $t++){?>
                                           <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                           <?php }?>
                                           </select>
									</div>
									</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="limits">Behaviours</label>
									</div>
									</div>
                                    </div>
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
									<select class="form-control" name="limits" id="limits" onChange="fun_dates(this.value)">
                       				<option value="default" selected>Default</option>
                       				<option value="limit">Limits</option>
                     				</select>
										</div>
									      </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-sm-12" style="border-top:1px solid #C3BFBF; background-color:#EAEAEA; display:none;" id="dates" >
                                   	<div class="row" style="margin-top:10px;">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="from_date">From Date</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                      <input type="text" class=" form-control datepickerrr" name="from_date" id="from_date" data-date-format="dd-mm-yyyy" data-placeholder="From Date">
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
										<label for="end_date">End Date</label>
										</div>
									      </div>
                                        </div>
                                        <div class="col-sm-3">
                                    <div class="form-group">
                                    <div class="input-group">
                       <input type="text" class="form-control  datepickerrr" name="end_date" id="end_date" data-date-format="dd-mm-yyyy" data-placeholder="End Date">
										</div>
									      </div>
                                        </div>
                                    </div>
                                </div>
                                
							  </div>
                                                
											  </div>
											  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="news_sett" name="news_sett" value="news_sett_val" class="btn btn-success">Submit</button>
											  </div>
											</div>                                </form>
										  </div>
										</div>
                                        
                                        
                                        <!-- update news -->
                  <div class="modal fade" id="news_updates" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
				  </div>
                                        
                                        <!-- ending update news -->
                                        
                                        
                                        
                                        
					<div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                <div class="right-content">
           <a id="edit_id" class="btn btn-info " data-target="#news_settings" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp; Add News</a>
								</div>
                                <h3 class="panel-title"><i class="fa   fa-volume-up icon-sidebar"></i>&nbsp;News Scroller - Settings</h3>
                                </div>
                                <div id="panel-collapse-3" class="collapse in">
                                <div class="panel-body" id="tabid">
                                    <div class="table-responsive" id="default_table">
                                   <?php 
								 if($totalRows_news>0)  {
								   ?>
						<table class="table table-striped table-hover datatable-example" >
							<thead class="the-box dark full">
								<tr>
								<th width="10%"><center> S.No.</center> </th>
                                <th width="25%" colspan="2"><i class="fa fa-cloud-upload "></i>&nbsp; News </th>
								<th width="20%" ><center><i class="fa fa-calendar-o "></i>&nbsp; Date</center></th>
                                <th width="15%" ><center><i class="fa fa-calendar "></i>&nbsp; Attachment</center></th>
                                <th width="15%" ><center><i class="fa fa-flag "></i>&nbsp; Action</center></th>
								</tr>
							</thead>
                            <?php 
							$s=1;
							while($row_news = mysql_fetch_assoc($news)){ ?>
							<tr id="<?php echo "tr_".$row_news['sno']; ?>">
                            <td style="text-align:center"><?php echo $s; ?></td>
                            <td><?php echo $row_news['news']; ?></td><td>
                                <span class="badge badge-info icon-count pull-right tooltips" data-toggle='tooltip' data-original-title='Priority'>
                                        <?php echo $row_news['priority']; ?>
                                </span>
                            </td>
                            <td style="text-align:center"><?php if(trim($row_news['from_date'])!='' && trim($row_news['to_date'])!='') {
									echo date('d-M-Y',strtotime($row_news['from_date']))." -> ".date('d-M-Y',strtotime($row_news['from_date']));
								 }else{
									echo "No Limits (Default)"; 
								 }?></td>
                            <td style="text-align:center">
                            <?php 
							$FileType = pathinfo($row_news['images'],PATHINFO_EXTENSION);
							if($FileType=='jpg' || $FileType=='png' || $FileType=='jpeg')
							{?>
								<a href="ADMIN/img_upload/news_img/<?php echo $row_news['images']; ?>" download>
                                <img src="ADMIN/img_upload/news_img/<?php echo $row_news['images']; ?>"  style="width:80px ; height:60px;" alt="<?php echo $row_news['images']; ?>"></a>
							<?php }else{ ?>
								<a href="ADMIN/img_upload/news_img/<?php echo $row_news['images']; ?>" download>
                                <img src="ADMIN/img_upload/news_img/attach_pin.jpg"  style="width:80px ; height:60px;" alt="<?php echo $row_news['images']; ?>"></a>
							<?php }
							?>
                          </td>
                            <td style="text-align:center">
                            <a class="btn btn-sm btn-info"  onclick="fun_edit_me('<?php echo $row_news['sno']; ?>')"> <i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-danger" onclick="fun_remove_me('<?php echo $row_news['sno']; ?>')"> <i class="fa fa-trash-o"></i></a>
                            </td>
                            </tr>
                             <?php $s++; }//while end ?>
                                </table>
                                <?php } else{
									?>
                                    <p style="text-align:center; font-size:16px; color:#900; font-weight:600">No Entry Found .. </p>
                                    <?php
									} ?>
                                </div>
                                
                                </div>
                                </div>
                            </div>
                        </div><!-- /.col-sm-8 -->
                    
					</div><!-- /.row -->
				</div>
                <!-- /.container-fluid -->
<script>

$(document).ready(function(e) {
	// $('.datepickerrr').datepicker();
    //$('.form-control').css('width','100%');
	//$('.chosen-select').chosen({width : '100%'});
});

function getXMLHTTP() 
{ //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
}

function fun_dates(vall)
{
	$('.datepickerrr').datepicker();
	if(vall=='limit')
	{
	 	$('#dates').fadeIn();	
	}else{
		$('#dates').fadeOut();
	}
}

function fun_updates(vall)
{
	$('.datepickerrr').datepicker();
	if(vall=='limit')
	{
	 	$('#updates').fadeIn();	
	}else{
		$('#updates').fadeOut();
	}
}



function fun_remove_me(sno)
{
	var t=confirm('To Remove Press " OK "');
	if(t==true)
	{
		$.get('ADMIN/ajax_others.php?type=14&sno='+sno,function(res){
			$('#tr_'+sno).hide();
		});
	}
}

function fun_edit_me(sno)
{
	$.get('ADMIN/ajax_others.php?type=15&sno='+sno,function(res){
			$('#news_updates').empty().html(res);
			$('#news_updates').modal('show');
			$('.datepickerrr').datepicker();
	});	
}

function check_img(name)
{
	$('#upimg_id').css('opacity','0.4');
	$('#rem_upd_img').val(name);
}

function checkk1()
{
	var news=$('#news').val().trim();
	var limits=$('#limits').val().trim();
	var ch='no';
	
	if(news!='')
	{
		if(limits!='default')
		{
			if($('#from_date').val().trim()!='' && $('#end_date').val().trim()!='')
			{
				ch='yes'
			}else{
				alert('Please Pick A Date ..');
				ch='no';
			}
					if($('#from_date').val()=='')
						$('#from_date').focus();
					else
						$('#end_date').focus();
		}else{
			ch='yes';	
		}
	}else{
		alert('Please Enter Any News..');
		$('#news').focus();
		ch='no';	
	}
	
	if(ch=='yes')
	{
		return true;	
	}else{
		return false;	
	}
	
}


function checkk2()
{
	var news=$('#updnews').val().trim();
	var limits=$('#updlimits').val().trim();
	var ch='no';
	
	if(news!='')
	{
		if(limits!='default')
		{
			if($('#updfrom_date').val().trim()!='' && $('#updend_date').val().trim()!='')
			{
				ch='yes'
			}else{
				alert('Please Pick A Date ..');
				ch='no';
			}
					if($('#updfrom_date').val()=='')
						$('#updfrom_date').focus();
					else
						$('#updend_date').focus();
		}else{
			ch='yes';	
		}
	}else{
		alert('Please Enter Any News..');
		$('#updnews').focus();
		ch='no';	
	}
	
	if(ch=='yes')
	{
		return true;	
	}else{
		return false;	
	}
	
}
</script>