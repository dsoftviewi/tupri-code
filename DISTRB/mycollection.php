<?php

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mmo=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date("Y-m-d");



$orders = $conn->prepare("SELECT * FROM travel_master where sub_paln_id!='' ORDER BY sno DESC");
$orders->execute();
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();
/*

$query_thorders = "SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'TH' ORDER BY sno DESC";
$thorders = mysql_query($query_thorders, $divdb) or die(mysql_error());
$row_thorders = mysql_fetch_assoc($thorders);
$totalRows_thorders = mysql_num_rows($thorders);


$query_torders = "SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'T#' ORDER BY sno DESC";
$torders = mysql_query($query_torders, $divdb) or die(mysql_error());
$row_torders = mysql_fetch_assoc($torders);
$totalRows_torders = mysql_num_rows($torders);


$query_horders = "SELECT * FROM travel_master where SUBSTR(plan_id,1,2) = 'H#' ORDER BY sno DESC";
$horders = mysql_query($query_horders, $divdb) or die(mysql_error());
$row_horders = mysql_fetch_assoc($horders);
$totalRows_horders = mysql_num_rows($horders);*/

?>
<style>
.nav-dropdown-contents{

	height: auto;

	min-width: 248px;

	max-width: 240px;
	overflow-y:auto;
	
}

.nav-dropdown-contents ul{

	padding: 0;

	margin: 0;

	list-style: none;

}

.nav-dropdown-contents ul li{

	display: block;

	border-bottom: 1px solid #F5F7FA;

}

.nav-dropdown-contents.static-list ul li,

.nav-dropdown-contents ul li a{

	padding: 20px 10px 10px 20px;

	display: block;

	position: relative;

	height: 60px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

	text-decoration: none;

	color: #656D78;

	background: #fff;

}

.nav-dropdown-contents ul li a:hover{

	color: #434A54;

}
.scroll-nav-dropdowns
{
	height:auto;
	width:240px;
}
.padclass
{
    padding: 15px;
	font-size:16px;
}

</style>

					<div class="container-fluid">
					<!-- Begin page heading -->
					<h1 class="page-heading">Collection <small>View Collection details</small></h1>
					<!-- End page heading -->
				
					<!-- Begin breadcrumb -->
					<ol class="breadcrumb default square rsaquo sm">
						<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li class="active">Collection Pro</li>
					</ol>
					<!-- End breadcrumb -->
					<!-- BEGIN DATA TABLE -->
					<div class="the-box">
                    	<div class="panel with-nav-tabs panel-info panel-square panel-no-border">
						  <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#view_all" data-toggle="tab"><i class="fa fa-calendar-o"></i>&nbsp;&nbsp;Year-wise Collection </a></li>
                                <li><a href="#tr_hot" data-toggle="tab" id="tr_hot1" ><i class="fa fa-calendar"></i></i>&nbsp;&nbsp;Month-wise Collection </a></li>
                                <li><a href="#agn_order" data-toggle="tab" id="agn_order1" ><i class="fa fa-user"></i></i>&nbsp;&nbsp;Agent-wise Collection </a></li>
								
							</ul>
						  </div>
							<div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="view_all">
											<div class="col-sm-12">
                                            
                                            <div class="row" style="margin-top:10px">
                                    <div class="col-sm-4">
                                <div class="form-group">
										 <div class="input-group " >
										<label></label>
										</div>
                                        </div>
                                </div>
                                    <div class="col-sm-2">
                                <div class="form-group">
										 <div class="input-group " >
										<label>Choose Year</label>
										</div>
                                        </div>
                                </div>
                                
                                <div class="col-sm-4">
                                <div class="form-group">
										 <div class="input-group " >
										<select style="width: 120px;"  class="form-control chosen-select" id="yearvis" name="yearvis" onChange="year_collect(this.value)">
                                        <?php 
										for($yy1=$yy-10; $yy1<=$yy;$yy1++)
										{
											if($yy1==$yy)
											{
										?>
                                        <option selected value="<?php echo $yy1; ?>"><?php echo $yy1; ?></option>
                                         <?php }else{ ?>
                                        <option value="<?php echo $yy1; ?>"><?php echo $yy1; ?></option> 
                                         <?php }
										}
										?>
                                        </select>
										</div>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                <div class="form-group">
										 <div class="input-group " >
										<label></label>
										</div>
                                        </div>
                                </div>
                                
                                </div>
                                            
                                     <div class="col-sm-12" id="default_year_coll">       
										
                                     </div>
                                            
												</div><!-- /.table-responsive -->
										</div>
                                        
                                        
                                        
                                        <!-- Month vis search -->
										<div class="tab-pane fade" id="tr_hot">
											
												<div class="col-sm-12">
                                            
                                            <div class="row" style="margin-top:10px">
                                    
                                    <div class="col-sm-2">
                                <div class="form-group">
										 <div class="input-group " >
										<label>Choose Year</label>
										</div>
                                        </div>
                                </div>
                                
                                <div class="col-sm-4">
                                <div class="form-group">
										 <div class="input-group " >
										<select style="width: 120px;"  class="form-control chosen" onchange="search_coll_month()" id="yr_mnt" name="yr_mnt">
                                        <?php 
										for($yy1=$yy-10; $yy1<=$yy;$yy1++)
										{
											if($yy1==$yy)
											{
										?>
                                        <option selected value="<?php echo $yy1; ?>"><?php echo $yy1; ?></option>
                                         <?php }else{ ?>
                                        <option value="<?php echo $yy1; ?>"><?php echo $yy1; ?></option> 
                                         <?php }
										}
										?>
                                        </select>
										</div>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                <div class="form-group">
										 <div class="input-group " >
										<label>Choose Month</label>
										</div>
                                        </div>
                                </div>
                                <div class="col-sm-4">
                                <div class="form-group">
										 <div class="input-group " >
										<select style="width: 180px;"  class="form-control chosen" id="mnt_of_year" name="mnt_of_year" onchange="search_coll_month()">
                                        <?php 
		for ($m=1; $m<=12; $m++) {
     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
	 $num_mon = date('m', mktime(0,0,0,$m, 1, date('Y')));
	 if($mmo==$num_mon)
	 {
	 ?>
      <option selected="selected" value="<?php echo $num_mon; ?>"><?php echo $month; ?></option>
     <?php }else{?>
     <option value="<?php echo $num_mon; ?>"><?php echo $month; ?></option>
      <?php }
		}?>
                                        </select>
										</div>
                                        </div>
                                </div>
                                
                                </div>
                                            
                                     <div class="col-sm-12" id="default_month_coll">       
										
                                     </div>
                                            
												</div>
										</div>
                                        
                                        <div class="tab-pane fade" id="agn_order">
                                                <div class="col-sm-12">
                                            
                                            <div class="row" style="margin-top:10px">
                                    <div class="col-sm-4">
                                <div class="form-group">
										 <div class="input-group " >
										<label></label>
										</div>
                                        </div>
                                </div>
                                    <div class="col-sm-2">
                                <div class="form-group">
										 <div class="input-group " >
										<label>Choose Your Agent</label>
										</div>
                                        </div>
                                </div>
                                
                                <div class="col-sm-4">
                                <div class="form-group">
										 <div class="input-group " >
                                         <?php 
 // for finding all itinerary
$agnt = $conn->prepare("SELECT * FROM  agent_pro where distr_id=?");
$agnt->execute(array($_SESSION['uid']));
//$row_agnt= mysql_fetch_assoc($agnt);
$row_agnt_main=$agnt->fetchAll();
$tot_agnt=$agnt->rowCount();
										 ?>
										<select style="width: 120px;"  class="form-control chosen" id="agntvis" name="agntvis" onChange="agent_order_fun(this.value)" data-placeholder="Choose Agent">
                                        <option></option>
                                        <?php 
										foreach($row_agnt_main as $row_agnt)
										{?>
											<option value="<?php echo $row_agnt['agent_id']; ?>"><?php echo $row_agnt['agent_fname']." ".$row_agnt['agent_lname']; ?></option>
										<?php } ?>
                                        </select>
										</div>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                <div class="form-group">
										 <div class="input-group " >
										<label></label>
										</div>
                                        </div>
                                </div>
                                
                                </div>
                                            
                                     <div class="col-sm-12" id="default_agnt_order"> 
                                      
										
                                     </div>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    
					</div><!-- /.the-box .default -->
					<!-- END DATA TABLE -->
				</div><!-- /.container-fluid -->
                <!-- /.container-fluid -->
    <script>
	$(document).ready(function(e) {
		
		var dateObj = new Date();
		var month = dateObj.getUTCMonth() + 1; //months from 1-12
		//var day = dateObj.getUTCDate();
		var year = dateObj.getUTCFullYear();

        year_collect(year);
		search_coll_month();
		
		$('#tr_hot1').click(function()
		{
		$('.chosen').chosen({width:'150px'});
		});
		
		$('#agn_order1').click(function()
		{
		$('.chosen').chosen({width:'150px'});
		});
		
    });
	

function search_coll_month()
{
	var month=$('#mnt_of_year').val();
	var yr=$('#yr_mnt').val();
	var ty=2;
	$('#dvLoading').fadeIn();
		$.get('<?php echo $_SESSION['grp'];?>/ajax_collection.php?year='+yr+'&type='+ty+'&month='+month,{ "_": $.now() },function(result)
		{
			$('#dvLoading').fadeOut(500);
			$('#default_month_coll').empty().html(result);
			$('.ttb5').dataTable({"bSort": false});
			$('.tooltips').tooltip();
		});
}
	
	function year_collect(year)
	{
		//alert(year);
		var ty=1;
		$('#dvLoading').fadeIn();
		$.get('<?php echo $_SESSION['grp'];?>/ajax_collection.php?year='+year+'&type='+ty,{ "_": $.now() },function(result)
		{
			$('#dvLoading').fadeOut(500);
			$('#default_year_coll').empty().html(result);
			$('.tooltips').tooltip();
		});
	}
	
	function agent_order_fun(aid)
	{
		var ty=3;
		$('#dvLoading').fadeIn();
		$.get('<?php echo $_SESSION['grp'];?>/ajax_collection.php?aid='+aid+'&type='+ty,{ "_": $.now() },function(result)
		{
			$('#dvLoading').fadeOut(500);
			$('#default_agnt_order').empty().html(result);
			$('.ttb').dataTable({"bSort": false});
			$('.tooltips').tooltip();
		});
	}

function hide_agndetail_div5()
{
$('#more_agndet5').show();	
$('#agnttbb5').hide();
}


function show_agndetail_div5()
{
$('#more_agndet5').hide();	
$('#agnttbb5').show();
}
	
function hide_agndetail_div()
{
$('#more_agndet').show();	
$('#agnttbb').hide();
}
	
function show_agndetail_div()
{
$('#more_agndet').hide();	
$('#agnttbb').show();
}
	</script>            