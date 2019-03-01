<?php

$agnt = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$agnt->execute(array($_SESSION['uid']));
$row_agnt = $agnt->fetch(PDO::FETCH_ASSOC);
$totalRows_agnt = $agnt->rowCount();

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

</style>

					<div class="container-fluid">
					<!-- Begin page heading -->
					<h1 class="page-heading">Settings <small>Agent Settings</small></h1>
					<!-- End page heading -->
				
					<!-- Begin breadcrumb -->
					<ol class="breadcrumb default square rsaquo sm">
						<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li class="active">Settings</li>
					</ol>
					<!-- End breadcrumb -->
					<!-- BEGIN DATA TABLE -->
					<div class="the-box">
                    	<div class="panel with-nav-tabs panel-info panel-square panel-no-border">
						  <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#ordset" data-toggle="tab"><i class="fa fa-database"></i>&nbsp; Order setting</a></li>
							</ul>
						  </div>
							<div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="ordset">
											<div class="the-box">
                                            <form id="imageform" method="post" action="<?php echo $_SESSION['grp'];?>/logo_upload.php" class="form-horizontal">
                                                <fieldset>
                                                    <legend>View/change details</legend>
                    								
                                                    <div class="form-group">
                                                    <label class="col-lg-2 control-label">Your company logo</label>
                                                        <div class="col-lg-2">
                                                            <div id='preview' class="text-center" style="border:#3BAFDA 1px solid">
                                                                <img src='img_upload/agent_img/logo/<?php echo $row_agnt['comp_logo'] ?>'  class='preview' width='100px' height='100px' alt="Logo not uploaded yet... Please upload">
                                                                </div>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Add/change logo</label>
                                                        <div class="col-lg-4">
                                                            <div class="input-group">
															<input type="text" class="form-control" readonly>
                                                            <span class="input-group-btn">
                                                                <span class="btn btn-default btn-file">
                                                                    Browse&hellip; <input type="file" name="photoimg" id="photoimg" name="">
                                                                </span>
                                                            </span>
									</div><!-- /.input-group -->
                                                        </div>
                                                        
                                                    </div>
                    								 <br>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">My Profit %</label>
                                                        <div class="col-lg-6">
                                                        	<div class="col-lg-5">
                                                            <input type="text" class="form-control" name="username" style="display:none" id="edit_per" value="<?php echo $row_agnt['my_percentage']; ?>" />
                                                            <div id="box_per" class="the-box rounded text-center" style="height:15px">
                                                            	<p class="light" style="margin-top:-10px"><?php echo $row_agnt['my_percentage'].' '.'%'; ?></p>
                                                                </div>
                                                                </div>
                                                                 <div class="col-lg-4">
                                                                 &nbsp;&nbsp; <button type="button" class="btn btn-xs btn-danger tooltips" title="Change %" onClick="chang_prof()" id="chang_per"> <i class="fa fa-edit"></i> </button>
                                                                 &nbsp;&nbsp; <button type="button" class="btn btn-xs btn-primary tooltips" title="Update" onClick="update_prof()" id="upd_per" style="display:none"> <i class="fa fa-check-square-o"></i> </button>
                                                                 &nbsp;&nbsp; <button type="button" class="btn btn-xs btn-warning tooltips" title="Cancel" onClick="can_prof()" id="can_per" style="display:none"> <i class="fa fa-minus-square-o"></i> </button>
                                                                 </div>
                                                        </div>
                                                        
                                                    </div>

                    								<?php /*?><div class="form-group">
                                                        <label class="col-lg-2 control-label">My Brokerage charge (%)</label>
                                                        <div class="col-lg-6">
                                                        	<div class="col-lg-5">
                                                            <div id="box_per" class="the-box rounded text-center" style="height:15px">
                                                            	<p class="light" style="margin-top:-10px"><?php echo $row_agnt['brokerage_perc'].' '.'%'; ?></p>
                                                                
                                                                </div>
                                                                
                                                                </div>
                                                                <div class="col-lg-12" style=" color:#933;font-size:12px">
                                                                [Charge to be paid in '%' to DoView Holidays for each itinerary... % charge determined by Doview director.]
                                                                </div>
                                                        </div>
                                                        
                                                    </div><?php */?>
                                                    
                                                    
                                                </fieldset>
                                            </form>
                        					</div>
										</div>
										
										<!-- /.tab-pane fade -->
									</div><!-- /.tab-content -->
								</div><!-- /.panel-body -->
							</div><!-- /.collapse in -->
						</div>
                    
					</div><!-- /.the-box .default -->
					<!-- END DATA TABLE -->
				</div><!-- /.container-fluid -->
                <!-- /.container-fluid -->

<script>
function update_prof()
{
	
	var perc = $('#edit_per').val();
	$.get('<?php echo $_SESSION['grp'].'/upd_agent.php' ?>', { perc : perc, typ : 1 }, function(data) 
	{
		//parent.location.reload();
		window.location.href = "agent_mysetting.php?mm=<?php echo $_GET['mm'] ?>&sm=<?php echo $_GET['sm']; ?>&tost=1";
	});
}

function chang_prof()
{
	$('#upd_per').show();
	$('#can_per').show();
	$('#chang_per').hide();
	$('#edit_per').show();
	$('#box_per').hide();
}

function can_prof()
{
	$('#upd_per').hide();
	$('#can_per').hide();
	$('#chang_per').show();
	$('#edit_per').hide();
	$('#box_per').show();
}

</script>                