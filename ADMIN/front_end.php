<?php
require_once('Connections/divdb.php');

 if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}




$fes = $conn->prepare("SELECT * FROM dvi_front_settings");
$fes->execute();
$row_fes = $fes->fetch(PDO::FETCH_ASSOC);
$totalRows_fes = $fes->rowCount();


if(isset($_POST['faq_forms']) && $_POST['faq_forms']=='faq_forms_val')
{
    
	$faq = $conn->prepare("insert into dvi_front_faq(faq_quest,faq_ans,status) values(?,?,0)");
	$faq->execute(array($_POST['faq_quest'],$_POST['faq_answer']));


}

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
					<h1 class="page-heading">Front-end Settings</h1>
					<!-- End page heading -->
				
					<!-- Begin breadcrumb -->
					<ol class="breadcrumb default square rsaquo sm">
						<li><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
						<li><a href="dashboard.php">Dashboard</a></li>
						<li class="active">Front End</li>
					</ol>
					<!-- End breadcrumb -->
					<!-- BEGIN DATA TABLE -->
					<div class="the-box">
                    	<div class="panel with-nav-tabs panel-info panel-square panel-no-border">
						  <div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-home"></i>&nbsp; Home</a></li>
                                <li><a href="#about_us" data-toggle="tab"><i class="fa fa-group (alias)"></i>&nbsp; About Us</a></li>
								<li><a href="#faq" data-toggle="tab"><i class="fa fa-ra (alias)"></i>&nbsp; FAQ </a></li>
                                <li><a href="#contact_us" data-toggle="tab"><i class="fa fa-user"></i>&nbsp; Contact Us</a></li>
                                 <li><a href="#feedbacks" data-toggle="tab"><i class="fa fa-envelope "></i>&nbsp; Feedbacks</a></li>
								 <li><a href="#currency" data-toggle="tab"><i class="fa fa-user"></i>&nbsp; Currency</a></li>
								 <li><a href="#timings" data-toggle="tab"><i class="fa fa-user"></i>&nbsp; Arr/Dep Timings</a></li>
								 
							
							</ul>
                            
                            
                            
                            
						  </div>
							<div id="panel-collapse-1" class="collapse in">
								<div class="panel-body">
									<div class="tab-content">
										<div class="tab-pane fade in active" id="home">
                                       		    <?php 

$home= $conn->prepare("SELECT * FROM dvi_front_home where status='0'");
$home->execute();
$row_home =$home->fetch(PDO::FETCH_ASSOC);
$total_home =$home->rowCount();
?>
										<div class="col-sm-12" id="" style="border:1px rgb(245, 241, 241) solid; margin:20px;background-color:#F7F7F7;">
                                    
                                         <p align="center" style="font-weight:600; color:#CCC">Welcome - Details
                                         <a id="welcome_edit_btn" class="btn btn-default pull-right" onclick="show_welcome_edit()"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                         <a id="welcome_cancel_btn" class="btn btn-default pull-right" style="display:none;" onclick="cancel_welcome_edit()"><i class="fa fa-times"></i></a>
                                         <a id="welcome_upd_btn" class="btn btn-default pull-right" style="display:none;" onclick="upload_home_dvi('W')"><i class="fa fa-upload"></i></a>
                                         </p>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:#1F469B; font-weight:600">
                                           DVI Welcome - Heading : </div>
                                            <div class="col-sm-9">
                                        <div style="height:40px; border:1px solid #CCC; overflow-y:scroll" id="welcome_view">
                                        <?php if(trim($row_home['welcome_heading'])!=''){ echo "<strong>".$row_home['welcome_heading']."</strong>"; }else {?> <strong style="text-align:center; font-size:24px; color:#CCC;">Not given</strong><?php } ?></div>
                                            <input type="text" id="welcome_tarea" style=" display:none;"  class="form-control" name="off_address" value="<?php echo $row_home['welcome_heading'];?>"  /></div>
                                            </div>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:#1F469B; font-weight:600">
                                            <br><br><br><br>DVI Welcome - Description : </div>
                                            <div class="col-sm-9">
                                         <div style="height:200px; border:1px solid #CCC; overflow-y:scroll" id="welcome_descview"><?php if(trim($row_home['welcome_desc'])!=''){ echo "<strong>".$row_home['welcome_desc']."</strong>"; }else {?> <strong style="text-align:center; font-size:24px; color:#CCC;">Not given</strong><?php } ?></div>
                                            <textarea id="welcome_desctarea" rows="9" style=" resize: vertical; display:none;" class="form-control" name="off_address"><?php echo $row_home['welcome_desc'];?></textarea></div>
                                            </div>
                                            <hr />
                                            <p align="center" style="font-weight:600; color:#CCC">Feature - Details
                                             <a id="feature_edit_btn" class="btn btn-default pull-right" onclick="show_feature_edit()"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                         <a id="feature_cancel_btn" class="btn btn-default pull-right" style="display:none;" onclick="cancel_feature_edit()"><i class="fa fa-times"></i></a>
                                         <a id="feature_upd_btn" class="btn btn-default pull-right" style="display:none;" onclick="upload_home_dvi('F')"><i class="fa fa-upload"></i></a>
                                            </p>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:#1F469B; font-weight:600">
                                            DVI Feature - Heading : </div>
                                            <div class="col-sm-9">
                                            <p id="feature_view" style="border:1px solid #CCC; height:30px"><?php if(trim($row_home['feature_heading'])!=''){ echo "<strong>".$row_home['feature_heading']."</strong>"; }else {?> <strong style="text-align:center; font-size:15px; color:#CCC;">Not given</strong><?php } ?></p>
                                            <input id="feature_tarea" type="text" class="form-control" style="display:none; " value="<?php echo $row_home['feature_heading']; ?>" /></div>
                                            </div>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="  color:#1F469B; font-weight:600">
                                            <br><br><br><br>DVI Feature - Description : </div>
                                            <div class="col-sm-9">
                                            <div  id="feature_descview" style="height:200px; overflow-y:scroll; border:1px solid #CCC;">
                                            <?php if(trim($row_home['feature_desc'])!=''){ echo "<strong>".$row_home['feature_desc']."</strong>"; }else {?> <strong style="text-align:center; font-size:24px; color:#CCC;">Not given</strong><?php } ?>
                                            </div>
                                            <textarea id="feature_desctarea" rows="9" style=" resize: vertical; display:none;" class="form-control" name="featurez"><?php echo $row_home['feature_desc']; ?></textarea></div>
                                            </div>
                                             <hr />
                                          
                                       </div>
                                       
                                        
                                        </div>
										<div class="tab-pane fade" id="about_us">
<?php 

$about = $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$about->execute();
$row_about = $about->fetch(PDO::FETCH_ASSOC);
$total_about=$about->rowCount();
if($total_about>0)
{
?>
                                            <div class="col-sm-12" style="background-color:#F2F2F2; color:#CCC;" align="center">
                                            <div class="col-sm-10"><strong>Our Mission</strong></div>
                                            <div class="col-sm-2"  id="mission_btn"><a class="btn btn-default" onclick="show_edit_mission()"><i class="fa fa-edit"></i>&nbsp;Edit</a></div>
                                            <div class="col-sm-2"  id="mission_upd" style="display:none;"><table><tr><td><a class="btn btn-default"  onclick="update_about_us('M')" ><i class="fa fa-upload"></i></a>&nbsp;</td><td>&nbsp;<a class="btn btn-default" onclick="cancel_edit_mission()" ><i class="fa fa-times"></i></a></td></tr></table></div>
                                            </div>
                                            <div class="col-sm-12" style="background-color:" id="mission_div">
                                            <div id="mission_strong" style="height:250px; overflow-y:scroll; background-color:#FCFCFC">
                                            <?php if(trim($row_about['mission'])!=''){ echo "<strong><br>".$row_about['mission']."</strong>"; }else{ ?>
                                            <br /><br /><center><strong style="color:#999; font-size:18px">Not Given</strong></center>
                                            <?php } ?></div>
                                            <textarea id="mission_tarea" name="mission_tarea" rows="11" style="width:100%; display:none; ">
                                            <?php echo $row_about['mission']; ?></textarea>
                                            </div>
                                            
                                            <!-- for vission -->
                                            <div class="col-sm-12" style="background-color:#F2F2F2; margin-top:20px; color:#CCC;" align="center">
                                            <div class="col-sm-10"><strong>Our Vision </strong></div>
                                            <div class="col-sm-2"  id="vision_btn"><a class="btn btn-default" onclick="show_edit_vision()"><i class="fa fa-edit"></i>&nbsp;Edit</a></div>
                                            <div class="col-sm-2"  id="vision_upd" style="display:none;"><table><tr><td><a class="btn btn-default" ><i class="fa fa-upload" onclick="update_about_us('V')"></i></a>&nbsp;</td><td>&nbsp;<a class="btn btn-default" onclick="cancel_edit_vision()" ><i class="fa fa-times"></i></a></td></tr></table></div>
                                            </div>
                                            <div class="col-sm-12" style="background-color:" id="vision_div">
                                            <div id="vision_strong" style="height:250px; overflow-y:scroll; background-color:#FCFCFC">
                                            <?php if(trim($row_about['vision'])!=''){ echo "<strong><br>".$row_about['vision']."</strong>"; }else{ ?>
                                            <br /><br /><center><strong style="color:#999; font-size:18px">Not Given</strong></center>
                                            <?php } ?></div>
                                            <textarea id="vision_tarea" name="vision_tarea" rows="11" style="width:100%; display:none; ">
                                            <?php echo $row_about['vision']; ?></textarea>
                                            </div>
                                            
                                             <!-- our services -->
                                            
                                             <div class="col-sm-12" style="background-color:#F2F2F2; margin-top:20px; color:#CCC;" align="center">
                                            <div class="col-sm-10"><strong>Our Services </strong></div>
                                            <div class="col-sm-2"  id="services_btn"><a class="btn btn-default" onclick="show_edit_services()"><i class="fa fa-edit"></i>&nbsp;Edit</a></div>
                                            <div class="col-sm-2"  id="services_upd" style="display:none;"><table><tr><td><a class="btn btn-default"  onclick="update_about_us('S')" ><i class="fa fa-upload"></i></a>&nbsp;</td><td>&nbsp;<a class="btn btn-default" onclick="cancel_edit_services()" ><i class="fa fa-times"></i></a></td></tr></table></div>
                                            </div>
                                            <div class="col-sm-12" style="background-color:" id="services_div">
                                            <div id="services_strong" style="height:250px; overflow-y:scroll; background-color:#FCFCFC">
                                            <?php if(trim($row_about['services'])!=''){ echo "<strong><br>".$row_about['services']."</strong>"; }else{ ?>
                                            <br /><br /><center><strong style="color:#999; font-size:18px">Not Given</strong></center>
                                            <?php } ?></div>
                                            <textarea id="services_tarea" name="services_tarea" rows="11" style="width:100%; display:none; ">
                                            <?php echo $row_about['services']; ?></textarea>
                                            </div>
                                            
                                            <!-- about us -->
                                            
                                             <div class="col-sm-12" style="background-color:#F2F2F2; margin-top:20px; color:#CCC;" align="center">
                                            <div class="col-sm-10"><strong>About Us </strong></div>
                                            <div class="col-sm-2"  id="aboutus_btn"><a class="btn btn-default" onclick="show_edit_aboutus()"><i class="fa fa-edit"></i>&nbsp;Edit</a></div>
                                            <div class="col-sm-2"  id="aboutus_upd" style="display:none;"><table><tr><td><a class="btn btn-default"  onclick="update_about_us('A')" ><i class="fa fa-upload"></i></a>&nbsp;</td><td>&nbsp;<a class="btn btn-default" onclick="cancel_edit_aboutus()" ><i class="fa fa-times"></i></a></td></tr></table></div>
                                            </div>
                                            <div class="col-sm-12" style="background-color:" id="aboutus_div">
                                            <div id="aboutus_strong" style="height:350px; overflow-y:scroll; background-color:#FCFCFC">
                                            <?php if(trim($row_about['aboutus'])!=''){ echo "<strong><br>".$row_about['aboutus']."</strong>"; }else{ ?>
                                            <br /><br /><center><strong style="color:#999; font-size:18px">Not Given</strong></center>
                                            <?php } ?></div>
                                            <textarea id="aboutus_tarea" name="aboutus_tarea" rows="15" style="width:100%; display:none; ">
                                            <?php echo $row_about['aboutus']; ?></textarea>
                                            </div>
                                            
<?php } ?>
										</div>
										<div class="tab-pane fade" id="faq">
											<div class="col-sm-12" style="background-color:#F2F2F2;" align="right" id="form_faq_div">
                                           <br />
                                            <a class="btn btn-info" onclick="show_insert_faq()" ><i class="fa fa-edit"></i>&nbsp;Add New</a><br /><br />
                                            </div>
                                            <div class="col-sm-12" id="insert_faq_div" style="display:none;">
                                            <br />
                                            <p align="center" style="font-weight:600; color:#CCC">Frequently Asked Question </p>
                                            <form name="faq_form_name" id="faq_form_name" method="post">
                                           <div class="row" style="margin-top:20px">
                                            <div class="col-sm-2" align="right" style="color:##1F469B; font-weight:600">
                                           <br>Insert Question : </div>
                                            <div class="col-sm-10"><textarea style=" height:60px; resize: vertical" class="form-control" name="faq_quest"></textarea></div>
                                            </div>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-2" align="right" style="color:##1F469B; font-weight:600">
                                           <br><br><br>Insert Answer : </div>
                                            <div class="col-sm-10"><textarea style=" height:120px; resize: vertical" class="form-control" name="faq_answer"></textarea></div>
                                            </div>
                                            
                                            <div class="row" style="margin-top:20px" align="center">
                                            <a class="btn btn-default" id="faq_cancel" onclick="cancel_insert_faq()" ><i class="fa fa-times"></i>&nbsp;Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <button type="submit" class="btn btn-success" name="faq_forms" id="faq_forms" value="faq_forms_val"><i class="fa fa-check-square-o"></i>&nbsp;Insert</button>
                                            </div>
                                            </form>
                                            
                                            </div>
                                            
                                         
                                            <div id="view_faq">
                                            <?php 

$faq_view = $conn->prepare("SELECT * FROM dvi_front_faq where status='0'");
$faq_view->execute();
//$row_faq_view = mysql_fetch_assoc($faq_view);
$row_faq_view_main=$faq_view->fetchAll();
$total_faq_view = $faq_view->rowCount();
   
											if($total_faq_view>0)
											{
												$f=1;
												foreach($row_faq_view_main as $row_faq_view)
												{ ?>
                                            
                                            <div class="col-sm-12" style="margin-top:10px; border: #999 1px solid; background-color:#FFF9EF; ">
					<div class="row show_hide_all " id="show_hide<?php echo $f; ?>"  style="height:auto" onclick="comm_div(<?php echo $f; ?>)">
                    <div class="col-sm-10">
                    
                  <p id="dis_quest<?php echo $f; ?>" style="height:27px;"><?php echo "&nbsp;&nbsp;".$f."&nbsp;)&nbsp;".$row_faq_view['faq_quest']; ?></p>
                    <p id="edit_quest<?php echo $f; ?>" style="display:none;" ><label> Question <?php echo $f;?></label><textarea class="form-control" style="width:100%; resize:vertical" id="upd_quest<?php echo $f; ?>"  name="upd_quest<?php echo $f; ?>"><?php echo $row_faq_view['faq_quest']; ?></textarea></p>
                    </div>
                    <div class="col-sm-2" id="edit_btn<?php echo $f; ?>">
                    <table><tr><td>&nbsp;</td><td><a class="btn btn-default" style="margin-left:" onclick="show_editable(<?php echo $f; ?>)"><i class="fa fa-edit"></i>&nbsp;Edit</a></td></tr></table></div>
                    <div class="col-sm-2" id="update_btn<?php echo $f; ?>" style="display:none;">
                 <table style="margin-top:10px;"><tr><td><a class="btn btn-default" style="margin-left:" onclick="update_me(<?php echo $f; ?>,<?php echo $row_faq_view['sno']; ?>)"><i class="fa fa-upload"></i></a>&nbsp;</td><td>
                     <a class="btn btn-default" style="margin-left:" onclick="make_default(<?php echo $f; ?>)"><i class="fa fa-times"></i></a></td></tr></table></div>
                    </div>

                    <div class=" col-sm-12 row slidingDiv_all" id="slidingDiv<?php echo $f; ?>" style="display: block; margin-top:15px">
                  	<p id="dis_answ<?php echo $f; ?>" style="margin-left:50px;"><?php echo " Answer : ".$row_faq_view['faq_ans']; ?></p>
                    <p id="edit_answ<?php echo $f; ?>" style="display:none;" ><label> Answer <?php echo $f;?></label><textarea class="form-control" rows="5" style="width:100%; resize:vertical" id="upd_answ<?php echo $f; ?>"  name="upd_answ<?php echo $f; ?>"><?php echo $row_faq_view['faq_ans']; ?></textarea></p>
                    </div>
                    </div>
											<?php 
											$f++;
												}//while end
											}else{
											?>
                                            <div class="col-sm-12" align="center" style=" margin-top:40px;height:60px; background-color:#F5F5F5; color:#930">
                                            <br />
                                            <strong>Unavailable - FAQ </strong>
                                            <br />
                                            </div>
                                            <?php	
											}
											?>
                                    
                                            </div>
                                            
										</div>
                                        <div class="tab-pane fade" id="contact_us">
                                                              <?php 

$cnt= $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$cnt->execute();
$row_cnt = $cnt->fetch(PDO::FETCH_ASSOC);
$total_cnt = $cnt->rowCount();
?>
										<div class="col-sm-12" id="" style="border:1px rgb(245, 241, 241) solid; margin:20px;background-color:#F7F7F7;">
                                    
                                         <p align="center" style="font-weight:600; color:#CCC">Office Location Information 
                                         <a id="addr_edit_btn" class="btn btn-default pull-right" onclick="show_location_edit()"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                         <a id="addr_cancel_btn" class="btn btn-default pull-right" style="display:none;" onclick="cancel_location_edit()"><i class="fa fa-times"></i></a>
                                         <a id="addr_upd_btn" class="btn btn-default pull-right" style="display:none;" onclick="upload_contact_dvi('A')"><i class="fa fa-upload"></i></a>
                                         </p>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:#1F469B; font-weight:600">
                                            <br><br>DVI Office Address : </div>
                                            <div class="col-sm-9">
                                        <div style="height:100px; border:1px solid #CCC; overflow-y:scroll" id="addr_view">
                                        <?php if(trim($row_cnt['location'])!=''){ echo "<strong>".$row_cnt['location']."</strong>"; }else {?> <strong style="text-align:center; font-size:24px; color:#CCC;">Not given</strong><?php } ?></div>
                                            <textarea id="addr_tarea" style=" resize: vertical; display:none;" rows="4" class="form-control" name="off_address"><?php echo $row_cnt['location'];?></textarea></div>
                                            </div>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:##1F469B; font-weight:600">
                                            <br>Office Short Description : </div>
                                            <div class="col-sm-9">
                                         <div style="height:100px; border:1px solid #CCC; overflow-y:scroll" id="addr_descview"><?php if(trim($row_cnt['location'])!=''){ echo "<strong>".$row_cnt['location']."</strong>"; }else {?> <strong style="text-align:center; font-size:24px; color:#CCC;">Not given</strong><?php } ?></div>
                                            <textarea id="addr_desctarea" style=" height:60px; resize: vertical; display:none;" class="form-control" name="off_address"><?php echo $row_cnt['location_desc'];?></textarea></div>
                                            </div>
                                            <hr />
                                            <p align="center" style="font-weight:600; color:#CCC">Official Mail Information 
                                             <a id="mail_edit_btn" class="btn btn-default pull-right" onclick="show_mail_edit()"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                         <a id="mail_cancel_btn" class="btn btn-default pull-right" style="display:none;" onclick="cancel_mail_edit()"><i class="fa fa-times"></i></a>
                                         <a id="mail_upd_btn" class="btn btn-default pull-right" style="display:none;" onclick="upload_contact_dvi('M')"><i class="fa fa-upload"></i></a>
                                            </p>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:##1F469B; font-weight:600">
                                            DVI Official EMail ID : </div>
                                            <div class="col-sm-9">
                                            <p id="mail_view" style="border:1px solid #CCC; height:30px"><?php if(trim($row_cnt['email'])!=''){ echo "<strong>".$row_cnt['email']."</strong>"; }else {?> <strong style="text-align:center; font-size:15px; color:#CCC;">Not given</strong><?php } ?></p>
                                            <input id="mail_tarea" type="email" class="form-control" style="display:none; " value="<?php echo $row_cnt['email']; ?>" /></div>
                                            </div>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:#1F469B; font-weight:600">
                                            <br>Email Short Description : </div>
                                            <div class="col-sm-9">
                                            <div  id="mail_descview" style="height:60px; overflow-y:scroll; border:1px solid #CCC;">
                                            <?php if(trim($row_cnt['email'])!=''){ echo "<strong>".$row_cnt['email']."</strong>"; }else {?> <strong style="text-align:center; font-size:24px; color:#CCC;">Not given</strong><?php } ?>
                                            </div>
                                            <textarea id="mail_desctarea" style=" height:60px; resize: vertical; display:none;" class="form-control" name="off_address"><?php echo $row_cnt['email_desc']; ?></textarea></div>
                                            </div>
                                             <hr />
                                            <p align="center" style="font-weight:600; color:#CCC">Help-line Information 
                                             <a id="help_edit_btn" class="btn btn-default pull-right" onclick="show_help_edit()"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                         <a id="help_cancel_btn" class="btn btn-default pull-right" style="display:none;" onclick="cancel_help_edit()"><i class="fa fa-times"></i></a>
                                         <a id="help_upd_btn" class="btn btn-default pull-right" style="display:none;" onclick="upload_contact_dvi('H')"><i class="fa fa-upload"></i></a>
                                            </p>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:##1F469B; font-weight:600">
                                            DVI Helpline Number : </div>
                                            <div class="col-sm-9">
                                             <p id="help_view" style="border:1px solid #CCC; height:30px">
                                             <?php if(trim($row_cnt['phone'])!=''){ echo "<strong>".$row_cnt['phone']."</strong>"; }else {?> <strong style="text-align:center; font-size:15px; color:#CCC;">Not given</strong><?php } ?>
                                             </p>
                                            <input id="help_tarea" type="text" class="form-control" style="display:none; " value="<?php echo $row_cnt['phone']; ?>"  /></div>
                                            </div>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:##1F469B; font-weight:600">
                                            <br>Helpline Short Description : </div>
                                            <div class="col-sm-9">
                                            <div  id="help_descview" style="height:60px; overflow-y:scroll; border:1px solid #CCC;">
                                             <?php if(trim($row_cnt['phone'])!=''){ echo "<strong>".$row_cnt['phone']."</strong>"; }else {?> <strong style="text-align:center; font-size:24px; color:#CCC;">Not given</strong><?php } ?></div>
                                            <textarea  id="help_desctarea" style=" height:60px; resize: vertical; display:none;" class="form-control" name="off_address"><?php echo $row_cnt['phone_desc']; ?></textarea></div>
                                            </div>
                                            <br />
                                       </div>
                                       
                                       
										</div>
                                         <div class="tab-pane fade" id="currency">
                                                              <?php 

$cnt= $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$cnt->execute();
$row_cnt = $cnt->fetch(PDO::FETCH_ASSOC);
$total_cnt = $cnt->rowCount();
?>
										<div class="col-sm-12" id="" style="border:1px rgb(245, 241, 241) solid; margin:20px;background-color:#F7F7F7;">
                                    
                                         
                                            <p align="center" style="font-weight:600; color:#CCC">Currency Information 
                                             <a id="currency_edit_btn" class="btn btn-default pull-right" onclick="show_currency_edit()"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                         <a id="currency_cancel_btn" class="btn btn-default pull-right" style="display:none;" onclick="cancel_currency_edit()"><i class="fa fa-times"></i></a>
                                         <a id="currency_upd_btn" class="btn btn-default pull-right" style="display:none;" onclick="upload_contact_dvi('C')"><i class="fa fa-upload"></i></a>
                                            </p>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:##1F469B; font-weight:600">
                                            Currency Rate : </div>
                                            <div class="col-sm-9">
                                            <p id="currency_view" style="border:1px solid #CCC; height:30px"><?php if(trim($row_cnt['currency_rate'])!=''){ echo "<strong>".$row_cnt['currency_rate']."</strong>"; }else {?> <strong style="text-align:center; font-size:15px; color:#CCC;">Not given</strong><?php } ?></p>
                                            <input id="currency_tarea" type="email" class="form-control" style="display:none; " value="<?php echo $row_cnt['currency_rate']; ?>" /></div>
                                            </div>
                                           
                                             <hr />
                                           
                                            <br />
                                       </div>
                                       
                                       
										</div>
										                                        <div class="tab-pane fade" id="timings">
                                                              <?php 

$cnt= $conn->prepare("SELECT * FROM dvi_front_settings where status='0'");
$cnt->execute();
$row_cnt = $cnt->fetch(PDO::FETCH_ASSOC);
$total_cnt = $cnt->rowCount();
?>
										<div class="col-sm-12" id="" style="border:1px rgb(245, 241, 241) solid; margin:20px;background-color:#F7F7F7;">
                                    
                                                                                     
                                            <p align="center" style="font-weight:600; color:#CCC">Arrival/Departure Information 
                                             <a id="timing_edit_btn" class="btn btn-default pull-right" onclick="show_timing_edit()"><i class="fa fa-edit"></i>&nbsp;Edit</a>
                                         <a id="timing_cancel_btn" class="btn btn-default pull-right" style="display:none;" onclick="cancel_timing_edit()"><i class="fa fa-times"></i></a>
                                         <a id="timing_upd_btn" class="btn btn-default pull-right" style="display:none;" onclick="upload_timing_dvi('AD')"><i class="fa fa-upload"></i></a>
                                            </p>
                                            <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:##1F469B; font-weight:600">
                                            Arrival Time : </div>
                                            <div class="col-sm-9">
                                            <p id="arr_time_view" style="border:1px solid #CCC; height:30px"><?php if(trim($row_cnt['arr_time'])!=''){ echo "<strong>".$row_cnt['arr_time']."</strong>"; }else {?> <strong style="text-align:center; font-size:15px; color:#CCC;">Not given</strong><?php } ?></p>
                                            <input id="arr_time_tarea" type="text" class="form-control" style="display:none; " value="<?php echo $row_cnt['arr_time']; ?>" /></div>
                                            </div>
											 <div class="row" style="margin-top:20px">
                                            <div class="col-sm-3" align="right" style="color:##1F469B; font-weight:600">
                                            Departure Time : </div>
                                            <div class="col-sm-9">
                                            <p id="dep_time_view" style="border:1px solid #CCC; height:30px"><?php if(trim($row_cnt['dep_time'])!=''){ echo "<strong>".$row_cnt['dep_time']."</strong>"; }else {?> <strong style="text-align:center; font-size:15px; color:#CCC;">Not given</strong><?php } ?></p>
                                            <input id="dep_time_tarea" type="text" class="form-control" style="display:none; " value="<?php echo $row_cnt['dep_time']; ?>" /></div>
                                            </div>
                                            
                                            </div>
                                            
                                            <br />
                                       </div>
                                       
                                       
										</div>
                                        <div class="tab-pane fade" id="feedbacks">
                                        <div class="row" id="insert_fdbk" style="display:none; border:#CCC 1px solid; background-color:rgb(253, 249, 242)">
                                        <div class="col-sm-12" style="margin-top:20px">
                                        <div class='col-sm-3'> <label> Client Name :</label></div>
                                        <div class="col-sm-9"><input class="form-control" type="text" id="client_name" name="client_name" /></div>
                                        </div>
                                        <div class="col-sm-12" style="margin-top:15px;">
                                        <div class='col-sm-3'> <label> Feedback :</label></div>
                                        <div class="col-sm-9"><textarea class="form-control" id="feedtarea" name="feedtarea" rows="4" style="resize:vertical" ></textarea></div>
                                        </div>
                                        <div class="col-sm-12" align="center" style="margin-top:15px; margin-bottom:10px;">
                                        <a class="btn btn-sm btn-default" onclick="cancel_fdbk_insert()">Cancel</a>
                                        <a class="btn btn-sm btn-info" onclick="feedback_submit()">Submit</a></div>
                                        </div>
                                        
											<div id="add_btn_fdbk" class="col-sm-12" style="border:#CCC 1px solid; height:60px; background-color:#F2F2F2">
                                           		<a class="btn btn-sm btn-info pull-right" style="margin-top:14px;" onclick="call_fdbk_insert()" >Add Feedback</a>
                                               
                                            </div>
                                            <div  id="view_fdbk">
                                            <?php
                                            
$fdbks = $conn->prepare("SELECT * FROM dvi_front_feedback where status='0' ORDER BY sno DESC");
$fdbks->execute();
//$row_fdbks = mysql_fetch_assoc($fdbks);
$row_fdbks_main=$fdbks->fetchAll();
$total_fdbks = $fdbks->rowCount();

$ff=1;
			foreach($row_fdbks_main as $row_fdbks)
			{
?>
<div class="col-sm-12" id="fdbk_main<?php echo $ff;?>" style="margin-top:10px; border: #999 1px solid; background-color:#FFF9EF; ">
				<div class="row show_hide_all " id="show_hide_fdbk<?php echo $ff; ?>"  style="height:auto" onclick="comm_div_fdbk(<?php echo $ff; ?>)">
                    <div class="col-sm-10">
                    
                  <p id="dis_quest_fdbk<?php echo $ff; ?>" style="height:27px;"><?php if(trim($row_fdbks['cname']) != '') { echo "Client Name : ".$row_fdbks['cname']; }else{ echo "Tourist"; }?></p>
                    <p id="edit_quest_fdbk<?php echo $ff; ?>" style="display:none;" ><label>Client Name </label><input type="text" class="form-control"  id="upd_quest_fdbk<?php echo $ff; ?>"  name="upd_quest_fdbk<?php echo $ff; ?>"  value="<?php echo $row_fdbks['cname']; ?>" /></p>
                    </div>
                    <div class="col-sm-2" id="edit_btn_fdbk<?php echo $ff; ?>">
                    <table><tr><td>&nbsp;</td><td><a class="btn btn-default" style="margin-left:" onclick="show_editable_fdbk(<?php echo $ff; ?>)"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger"  style="background-color:#E79486" onclick="delete_fdbk(<?php echo $ff; ?>,<?php echo $row_fdbks['sno']; ?>)"><i class="fa fa-times"></i></a></td></tr></table></div>
                    <div class="col-sm-2" id="update_btn_fdbk<?php echo $ff; ?>" style="display:none;">
                 <table style="margin-top:10px;"><tr><td><a class="btn btn-default" style="margin-left:" onclick="update_me_fdbk(<?php echo $ff; ?>,<?php echo $row_fdbks['sno']; ?>)"><i class="fa fa-upload"></i></a>&nbsp;</td><td>
                     <a class="btn btn-default" style="margin-left:" onclick="make_default_fdbk(<?php echo $ff; ?>)"><i class="fa fa-times"></i></a></td></tr></table></div>
                    </div>

                    <div class=" col-sm-12 row slidingDiv_all" id="slidingDiv_fdbk<?php echo $ff; ?>" style="display: none; margin-top:15px">
                  	<p id="dis_answ_fdbk<?php echo $ff; ?>" style="margin-left:50px;"><?php echo "Feedback : ".$row_fdbks['feedback']; ?></p>
                    <p id="edit_answ_fdbk<?php echo $ff; ?>" style="display:none;" ><label> Feedback </label><textarea class="form-control" rows="5" style="width:100%; resize:vertical" id="upd_answ_fdbk<?php echo $ff; ?>"  name="upd_answ_fdbk<?php echo $ff; ?>"><?php echo $row_fdbks['feedback']; ?></textarea></p>
                    </div>
                    </div>
                    
                    <?php $ff++; } //while end?>
                                            
                                            
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

$(document).ready(function(e) {
    $(".slidingDiv_all").hide();
	$(".show_hide_all").show();
});

//home
//home - welcome
function show_welcome_edit()
{
	$('#welcome_edit_btn').hide();	
	$('#welcome_upd_btn').show();
	$('#welcome_cancel_btn').show();
	
	$('#welcome_view').hide();
	$('#welcome_descview').hide();
	$('#welcome_tarea').show();
	$('#welcome_desctarea').show();
}

function cancel_welcome_edit()
{
	$('#welcome_edit_btn').show();	
	$('#welcome_upd_btn').hide();
	$('#welcome_cancel_btn').hide();
	
	$('#welcome_view').show();
	$('#welcome_descview').show();
	$('#welcome_tarea').hide();
	$('#welcome_desctarea').hide();
}

//home- feature
function show_feature_edit()
{
	$('#feature_edit_btn').hide();	
	$('#feature_upd_btn').show();
	$('#feature_cancel_btn').show();
	
	$('#feature_view').hide();
	$('#feature_descview').hide();
	$('#feature_tarea').show();
	$('#feature_desctarea').show();
}

function cancel_feature_edit()
{
	$('#feature_edit_btn').show();	
	$('#feature_upd_btn').hide();
	$('#feature_cancel_btn').hide();
	
	$('#feature_view').show();
	$('#feature_descview').show();
	$('#feature_tarea').hide();
	$('#feature_desctarea').hide();
}


function upload_home_dvi(str)
{
	var str1,tarea1,tarea2,field1,field2,id;
	if(str=='W')
	{
		field1='welcome_heading';
		field2='welcome_desc';
		
		tarea1=$('#welcome_tarea').val();
		tarea2=$('#welcome_desctarea').val();
		id='welcome';
		
	}else if(str=='F')
	{
		field1='feature_heading';
		field2='feature_desc';
		
		tarea1=$('#feature_tarea').val();
		tarea2=$('#feature_desctarea').val();
		id='feature';
	}
	
	var ty=8;
$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'field1':field1,'field2':field2,'tarea1':tarea1,'tarea2':tarea2,},function(result)
	{
		$('#'+id+'_tarea').hide();
		$('#'+id+'_desctarea').hide();
		
		$('#'+id+'_upd_btn').hide();
		$('#'+id+'_cancel_btn').hide();
		$('#'+id+'_edit_btn').show();
		
		
		$('#'+id+'_view strong').empty().prepend(tarea1);
		$('#'+id+'_view').show();
		$('#'+id+'_descview strong').empty().prepend(tarea2);
		$('#'+id+'_descview').show();
		alert("Updated Successfully..");
		
	});
	
	
}





//feedbacks
function delete_fdbk(no,sno)
{
  var ty=7;
	var cname=$('#client_name').val();
	var cfeed=$('#feedtarea').val();
	$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'sno':sno},function(result)
	{
		$('#fdbk_main'+no).hide();
	});	
}

function feedback_submit()
{
	var ty=4;
	var cname=$('#client_name').val();
	var cfeed=$('#feedtarea').val();
	$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'cname':cname,'cfeed':cfeed},function(result)
	{
		$('#insert_fdbk').hide();
		$('#view_fdbk').show();	
		$('#add_btn_fdbk').show();
		feedback_display();
	});
}

function feedback_display()
{
	var ty=5;
	$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,function(result)
	{
		$('#view_fdbk').empty().html(result);
	});
}

function update_me_fdbk(no,sno)
{
	var ty=6;
	var clname=$('#upd_quest_fdbk'+no).val();
	var clfeed=$('#upd_answ_fdbk'+no).val();
	$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'cname':clname,'cfeed':clfeed,'sno':sno},function(result)
	{
		var str1='Name : '+clname;
		var str2=' Feedback : '+clfeed;
		$('#show_hide_fdbk'+no).attr('onclick','comm_div_fdbk('+no+')');
	
	$('#dis_quest_fdbk'+no).empty().prepend(str1).show();
	$('#upd_quest_fdbk'+no).val(clname).hide();
	$('#edit_quest_fdbk'+no).hide();
	$('#dis_answ_fdbk'+no).empty().prepend(str2).show();
	$('#upd_answ_fdbk'+no).val(clfeed).hide();
$('#edit_answ_fdbk'+no).hide();
	
	$('#edit_btn_fdbk'+no).show();
	$('#update_btn_fdbk'+no).hide();
	
		alert("Updated Successfully..");
	});
}

function show_editable_fdbk(no)
{
	if($('#slidingDiv_fdbk'+no).is(':hidden'))
	{
		$("#slidingDiv_fdbk"+no).slideToggle();
	}
	
	$('#dis_quest_fdbk'+no).hide();
	$('#edit_quest_fdbk'+no).show();
	$('#upd_quest_fdbk'+no).show();
	$('#dis_answ_fdbk'+no).hide();
	$('#edit_answ_fdbk'+no).show();
	$('#upd_answ_fdbk'+no).show();
	
	$('#edit_btn_fdbk'+no).hide();
	$('#update_btn_fdbk'+no).show();
	
	$('#show_hide_fdbk'+no).removeAttr('onclick');
	
}

function make_default_fdbk(no)
{
	$('#show_hide_fdbk'+no).attr('onclick','comm_div_fdbk('+no+')');
	
	$('#dis_quest_fdbk'+no).show();
	$('#edit_quest_fdbk'+no).hide();
	$('#dis_answ_fdbk'+no).show();
	$('#edit_answ_fdbk'+no).hide();
	
	$('#edit_btn_fdbk'+no).show();
	$('#update_btn_fdbk'+no).hide();
}

function comm_div_fdbk(no)
{
	$("#slidingDiv_fdbk"+no).slideToggle();
}



function call_fdbk_insert()
{
	$('#insert_fdbk').show();
	$('#view_fdbk').hide();	
	$('#add_btn_fdbk').hide();
}

function cancel_fdbk_insert()
{
	$('#insert_fdbk').hide();
	$('#view_fdbk').show();	
	$('#add_btn_fdbk').show();
}



//contact us - address
function show_location_edit()
{
	$('#addr_edit_btn').hide();	
	$('#addr_upd_btn').show();
	$('#addr_cancel_btn').show();
	
	$('#addr_view').hide();
	$('#addr_descview').hide();
	$('#addr_tarea').show();
	$('#addr_desctarea').show();
}

function cancel_location_edit()
{
	$('#addr_edit_btn').show();	
	$('#addr_upd_btn').hide();
	$('#addr_cancel_btn').hide();
	
	$('#addr_view').show();
	$('#addr_descview').show();
	$('#addr_tarea').hide();
	$('#addr_desctarea').hide();
}


//contact us - address
function show_currency_edit()
{
	$('#currency_edit_btn').hide();	
	$('#currency_upd_btn').show();
	$('#currency_cancel_btn').show();
	
	$('#currency_view').hide();
	
	$('#currency_tarea').show();
	
}

function cancel_currency_edit()
{
	$('#currency_edit_btn').show();	
	$('#currency_upd_btn').hide();
	$('#currency_cancel_btn').hide();
	
	$('#currency_view').show();
	
	$('#currency_tarea').hide();
	
}
//contact mail 
function show_mail_edit()
{
	$('#mail_edit_btn').hide();	
	$('#mail_upd_btn').show();
	$('#mail_cancel_btn').show();
	
	$('#mail_view').hide();
	$('#mail_descview').hide();
	$('#mail_tarea').show();
	$('#mail_desctarea').show();
}

function cancel_mail_edit()
{
	$('#mail_edit_btn').show();	
	$('#mail_upd_btn').hide();
	$('#mail_cancel_btn').hide();
	
	$('#mail_view').show();
	$('#mail_descview').show();
	$('#mail_tarea').hide();
	$('#mail_desctarea').hide();
}

function show_timing_edit()
{
	$('#timing_edit_btn').hide();	
	$('#timing_upd_btn').show();
	$('#timing_cancel_btn').show();
	
	$('#arr_time_view').hide();
	$('#dep_time_view').hide();
	$('#arr_time_tarea').show();
	$('#dep_time_tarea').show();
}

function cancel_timing_edit()
{
	$('#timing_edit_btn').show();	
	$('#timing_upd_btn').hide();
	$('#timing_cancel_btn').hide();
	
	$('#arr_time_view').show();
	$('#dep_time_view').show();
	$('#arr_time_tarea').hide();
	$('#dep_time_tarea').hide();
}
//contact help line 
function show_help_edit()
{
	$('#help_edit_btn').hide();	
	$('#help_upd_btn').show();
	$('#help_cancel_btn').show();
	
	$('#help_view').hide();
	$('#help_descview').hide();
	$('#help_tarea').show();
	$('#help_desctarea').show();
}

function cancel_help_edit()
{
	$('#help_edit_btn').show();	
	$('#help_upd_btn').hide();
	$('#help_cancel_btn').hide();
	
	$('#help_view').show();
	$('#help_descview').show();
	$('#help_tarea').hide();
	$('#help_desctarea').hide();
}


function upload_timing_dvi(str){
	var str1,tarea1,tarea2,field1,field2,id;
	if(str=='AD')
	{
		field1='arr_time';
		field2='dep_time';
		
		tarea1=$('#arr_time_tarea').val();
		tarea2=$('#dep_time_tarea').val();
		id='timing';
	}
	
	var ty=3;
$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'field1':field1,'field2':field2,'tarea1':tarea1,'tarea2':tarea2,},function(result)
	{
		$('#arr_time_tarea').hide();
		$('#dep_time_tarea').hide();
		
		$('#'+id+'_upd_btn').hide();
		$('#'+id+'_cancel_btn').hide();
		$('#'+id+'_edit_btn').show();
		
		
		$('#arr_time_view strong').empty().prepend(tarea1);
		$('#arr_time_view').show();
		$('#dep_time_view strong').empty().prepend(tarea2);
		$('#dep_time_view').show();
		alert("Updated Successfully..");
		
	});
}
function upload_contact_dvi(str)
{
	var str1,tarea1,tarea2,field1,field2,id;
	if(str=='A')
	{
		field1='location';
		field2='location_desc';
		
		tarea1=$('#addr_tarea').val();
		tarea2=$('#addr_desctarea').val();
		id='addr';
		
	}else if(str=='M')
	{
		field1='email';
		field2='email_desc';
		
		tarea1=$('#mail_tarea').val();
		tarea2=$('#mail_desctarea').val();
		id='mail';
		
	}else if(str=='H')
	{
		field1='phone';
		field2='phone_desc';
		
		tarea1=$('#help_tarea').val();
		tarea2=$('#help_desctarea').val();
		id='help';
	}
	else if(str=='C')
	{
		field1='currency_rate';
		field2='status';
		
		tarea1=$('#currency_tarea').val();
		tarea2=0;
		id='currency';
	}
	
	
	var ty=3;
$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'field1':field1,'field2':field2,'tarea1':tarea1,'tarea2':tarea2,},function(result)
	{
		$('#'+id+'_tarea').hide();
		$('#'+id+'_desctarea').hide();
		
		$('#'+id+'_upd_btn').hide();
		$('#'+id+'_cancel_btn').hide();
		$('#'+id+'_edit_btn').show();
		
		
		$('#'+id+'_view strong').empty().prepend(tarea1);
		$('#'+id+'_view').show();
		$('#'+id+'_descview strong').empty().prepend(tarea2);
		$('#'+id+'_descview').show();
		alert("Updated Successfully..");
		
	});
	
	
}

//mission
function show_edit_mission()
{
	$('#mission_btn').hide();
	$('#mission_upd').show();
	$('#mission_strong').hide();
	$('#mission_tarea').show();
}

function cancel_edit_mission()
{
	$('#mission_tarea').hide();
	$('#mission_strong').show();
	$('#mission_btn').show();
	$('#mission_upd').hide();
}

//vision start
function show_edit_vision()
{
	$('#vision_btn').hide();
	$('#vision_upd').show();
	$('#vision_strong').hide();
	$('#vision_tarea').show();
}

function cancel_edit_vision()
{
	$('#vision_tarea').hide();
	$('#vision_strong').show();
	$('#vision_btn').show();
	$('#vision_upd').hide();
}

//our services
function show_edit_services()
{
	$('#services_btn').hide();
	$('#services_upd').show();
	$('#services_strong').hide();
	$('#services_tarea').show();
}

function cancel_edit_services()
{
	$('#services_tarea').hide();
	$('#services_strong').show();
	$('#services_btn').show();
	$('#services_upd').hide();
}

//about us start
function show_edit_aboutus()
{
	$('#aboutus_btn').hide();
	$('#aboutus_upd').show();
	$('#aboutus_strong').hide();
	$('#aboutus_tarea').show();
}

function cancel_edit_aboutus()
{
	$('#aboutus_tarea').hide();
	$('#aboutus_strong').show();
	$('#aboutus_btn').show();
	$('#aboutus_upd').hide();
}

//update about us
function update_about_us(str)
{
	var str1,tarea;
	if(str=='M')
	{
		str1='mission';
		tarea=$('#mission_tarea').val();
	}else if(str=='V')
	{
		str1='vision';
		tarea=$('#vision_tarea').val();
	}else if(str=='S')
	{
		str1='services';
		tarea=$('#services_tarea').val();
	}else if(str=='A')
	{
		str1='aboutus';
		tarea=$('#aboutus_tarea').val();
	}
	
	var ty=2;
	$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'str1':str1,'tarea':tarea},function(result)
	{
		$('#'+str1+'_strong strong').empty().prepend(tarea);
		$('#'+str1+'_tarea').hide();
		$('#'+str1+'_strong').show();
		
		$('#'+str1+'_upd').hide();
		$('#'+str1+'_btn').show();
		alert("Updated Successfully..");
		
	});
}

//faq
function update_me(no,sno)
{
	var ty=1;
	var qus=$('#upd_quest'+no).val();
	var ans=$('#upd_answ'+no).val();
	$.post('<?php echo $_SESSION['grp'];?>/ajax_front_end.php?type='+ty,{'quest':qus,'answ':ans,'sno':sno},function(result)
	{
		var str1=' '+no+' ) '+qus;
		var str2=' Answer : '+ans;
		$('#show_hide'+no).attr('onclick','comm_div('+no+')');
	
	$('#dis_quest'+no).empty().prepend(str1).show();
	$('#upd_quest'+no).val(qus).hide();
	$('#edit_quest'+no).hide();
	$('#dis_answ'+no).empty().prepend(str2).show();
	$('#upd_answ'+no).val(ans).hide();
$('#edit_answ'+no).hide();
	
	$('#edit_btn'+no).show();
	$('#update_btn'+no).hide();
	
		alert("Updated Successfully..");
	});
}

function show_editable(no)
{
	if($('#slidingDiv'+no).is(':hidden'))
	{
		$("#slidingDiv"+no).slideToggle();
	}
	
	$('#dis_quest'+no).hide();
	$('#edit_quest'+no).show();
	$('#upd_quest'+no).show();
	$('#dis_answ'+no).hide();
	$('#edit_answ'+no).show();
	$('#upd_answ'+no).show();
	
	$('#edit_btn'+no).hide();
	$('#update_btn'+no).show();
	
	$('#show_hide'+no).removeAttr('onclick');
	
}

function make_default(no)
{
	$('#show_hide'+no).attr('onclick','comm_div('+no+')');
	
	$('#dis_quest'+no).show();
	$('#edit_quest'+no).hide();
	$('#dis_answ'+no).show();
	$('#edit_answ'+no).hide();
	
	$('#edit_btn'+no).show();
	$('#update_btn'+no).hide();
}

function comm_div(no)
{
	$("#slidingDiv"+no).slideToggle();
}

function show_insert_faq()
{
	$('#insert_faq_div').show();
	$('#form_faq_div').hide();
	$('#view_faq').hide();
}

function cancel_insert_faq()
{
	$('#insert_faq_div').hide();
	$('#form_faq_div').show();
	$('#view_faq').show();
}


function sendappr(tpid)
{
	swal({
		title: 'APPROVE ITINERARY.. ARE YOU SURE?',
		type: 'info',
		showCancelButton: true,
		confirmButtonClass: 'btn-info',
		confirmButtonText: 'APPROVE!',
		cancelButtonText: 'REJECT',
		closeOnConfirm: false,
		allowOutsideClick: true,
		},
		function(isConfirm) 
		{
			if (isConfirm) 
			{
				$.get('<?php echo $_SESSION['grp'].'/ordappr.php' ?>', { tpid : tpid, typ : 1 }, function(data) {
	parent.location.reload();
	});
			}
			else
			{
				$.get('<?php echo $_SESSION['grp'].'/ordappr.php' ?>', { tpid : tpid, typ : 2 }, function(data) {
	parent.location.reload();
	});
			}
		});
		

}
</script>                