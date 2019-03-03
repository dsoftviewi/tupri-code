<?php require_once('Connections/divdb.php'); ?>
<title>DVI Holidays : Travel Agency : Tourism</title>
<link rel="stylesheet" href="core/css/bootstrap.min.css">
    <link rel="stylesheet" href="core/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="core/css/style.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="core/css/custom.css">
    <link rel="shortcut icon" href="images/logo2.png" type="image/x-icon">
    <!-- Responsive Styles -->
    <link rel="stylesheet" href="core/css/responsive.css">
     <script type="text/javascript" src="core/js/jquery-1.11.1.min.js"></script>
     <script src="core/assets/js/jquery.min.js"></script>     
<style>
.ns-attached {
	top: 30px;
	left: 40%;
	max-width:500px;
	border-radius: 5px;
}
.ns-type-dark
{
	background-color:#2C3E50;
	color:#fff;
	/*border:2px dashed #FFB503;*/
	border:3px dashed #E7573E;
}
.ns-type-dark a
{
	color:#fff;
}
.ns-type-dark .ns-close:before,.ns-type-dark .ns-close:after
{
	background-color:#fff;
}
#login-box-inner{background: hsla(0, 0%, 0%, 0.15) none repeat scroll 0 0!important;border-style:none!important;padding: 17px 25px!important;}
.vie{width: 50px;height: 50px;border-radius: 50%;border:2px solid;background-color:#248FED;color:#fff; float:right;cursor:hand;cursor:pointer;  top:14px;padding:6px;font-size: 32px;}
<style>.flashit{ background:; color: #000; text-align:center; } /* Flash class and keyframe animation */ .flashit{ -webkit-animation: flash linear 1s infinite; animation: flash linear 1s infinite; } @-webkit-keyframes flash { 0% { opacity: 1; } 350% { opacity: .1; } 100% { opacity: 1; } } @keyframes flash { 0% { opacity: 1; } 50% { opacity: .1; } 100% { opacity: 1; } } /* Pulse class and keyframe animation */ .pulseit{ -webkit-animation: pulse linear .5s infinite; animation: pulse linear .5s infinite; } @-webkit-keyframes pulse { 0% { width:200px; } 50% { width:240px; } 100% { width:200px; } } @keyframes pulse { 0% { width:200px; } 50% { width:240px; } 100% { width:200px; } } </style>
</style>
<style type="text/css">body {
  margin: 0;
  background: #000; 
}
video { 
    position: fixed;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    z-index: -100;
    transform: translateX(-50%) translateY(-50%);
 background: url('//demosthenes.info/assets/images/polina.jpg') no-repeat;
  background-size: cover;
  transition: 1s opacity;
}
.stopfade { 
   opacity: .5;
}

#polina { 
  font-family: Agenda-Light, Agenda Light, Agenda, Arial Narrow, sans-serif;
  font-weight:100;
  height: 508px; 
  background: rgba(0,0,0,0.3);
  color: white;
  padding: 2rem;
  width: 33%;
  margin:2rem;
  float: right;
  font-size: 1.2rem;
}
h1 {
  font-size: 3rem;
  text-transform: uppercase;
  margin-top: 0;
  letter-spacing: .3rem;
}
/*#polina button { 
  display: block;
  

  padding: .4rem;
  border: none; 
  margin: 1rem auto; 
  font-size: 1.3rem;
  background: rgba(255,255,255,0.23);
  
  border-radius: 3px; 
  cursor: pointer;
  transition: .3s background;
}*/
/*#polina button:hover { 
   background: rgba(0,0,0,0.5);
}*/

a {
  display: inline-block;
  color: #fff;
  text-decoration: none;
   transition: .6s background; 
}

@media screen and (max-width: 500px) { 
  div{width:70%;} 
}
@media screen and (max-device-width: 800px) {
  html { background: url(//demosthenes.info/assets/images/polina.jpg) #000 no-repeat center center fixed; }
  #bgvid { display: none; }
}</style>
<script type="text/javascript">
var vid = document.getElementById("bgvid");
var pauseButton = document.querySelector("#polina button");

function vidFade() {
  vid.classList.add("stopfade");
}

vid.addEventListener('ended', function()
{
// only functional if "loop" is removed 
vid.pause();
// to capture IE10
vidFade();
}); 


pauseButton.addEventListener("click", function() {
  vid.classList.toggle("stopfade");
  if (vid.paused) {
    vid.play();
    pauseButton.innerHTML = "Pause";
  } else {
    vid.pause();
    pauseButton.innerHTML = "Paused";
  }
})
</script>
    <div id="page-wrapper" >
        <header id="header" class="navbar-static-top">
            <div class="topnav hidden-xs">
                <div class="container">
                 <ul class="quick-menu pull-left">
<li><a><i class="soap-icon-message"></i>  vsr@v-i.in</a></li>
<li><a><i class="soap-icon-phone"></i>  0431 2403615</a></li>
</ul> 
                </div>
            </div>
        </header>

<video poster="vedio_banner.png" id="bgvid" playsinline autoplay muted loop>
  <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
<source src="Create Itinerary and tour in 3 Minutes.mp4" type="video/webm">
<source src="Create Itinerary and tour in 3 Minutes.mp4" type="video/mp4">
</video>
<div id="polina">
		<!-- Signup Details -->
	<div class="modal fade" id="View_signup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="width:60%">
	  <form  name="hotel_add"  id="hotel_add"  method="post" enctype="multipart/form-data"  onSubmit="return validate_final()">
<div class="modal-content modal-no-shadow modal-no-border" >
											  <div class="modal-header bg-info no-border" style="background-color:rgb(237, 238, 239);padding-bottom: 5px;padding-top: 5px;">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												 <img src="images/logo.png" alt="DVI Logo" />
                                               
											  </div>
 <div class="modal-body" style=" padding-bottom: 5px;">
                                                <div class="row">
              <div class="col-sm-12">
                                
                                   <div id="first_div_id" >
                               
                                   <center><strong style="color:#F00" id="reg_head"> Registration Form</strong></center>
                                   <br />
                                                <div class="row">
                  <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="First Name" ><i class="fa fa-tag fa-fw"  ></i></span>
                      <input type="text" name="agn_fname" id="agn_fname"  class="form-control" placeholder="First Name">
                    </div>
                        </div>
                                        </div>
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Last Name" ><i class="fa fa-tag fa-fw"  ></i></span>
                      <input type="text" name="agn_lname" id="agn_lname"  class="form-control" placeholder="Last Name">
                    </div>
                        </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="margin-top:5px">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Company Name" ><i class="fa fa-building-o fa-fw"  ></i></span>
                      <input type="text" name="agn_cname" id="agn_cname"  class="form-control" placeholder="Company Name">
                    </div>
                     </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Email ID"><i class="fa fa-envelope  fa-fw"></i></span>
                     <input type="text" placeholder="Email ID" class="form-control" id="agn_email" name="agn_email">
                    </div>
                     </div>
                                        </div>
                                </div>
                                
                                    <div class="row" style="margin-top:5px">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Mobile Number" ><i class="fa  fa-mobile fa-fw"  ></i></span>
                      <input type="text" name="agn_mobile" id="agn_mobile" class="form-control" placeholder="Mobile Number">
                    </div>
                     </div>
                                        </div>
                                    
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group ">
                                    <?php 
                  $hotelcountry = $conn->prepare("SELECT * FROM dvi_country");
                  $hotelcountry->execute();
                  //$row_hotelstate= $hotelcountry->fetch(PDO::FETCH_ASSOC);
				  $row_hotelcountry_main=$hotelcountry->fetchAll();
                  ?>
                  <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Living State"><i class="fa fa-globe fa-fw"></i></span>
                     <select data-placeholder="Choose a Country" name="agn_count" id="agn_count" class="form-control chosen-select col-lg-12 " tabindex="2" onChange="find_state(this.value)"   >                  
                                         <option value='nil'>Choose a Country</option>  
                     <?php foreach($row_hotelcountry_main as $row_hotelcountry) {?>
                    <option value="<?php echo $row_hotelcountry['ciso'];?>"><?php echo $row_hotelcountry['cname'];?></option>
                                        <?php } ?>
                  </select>
                    </div>
                                        </div>
                                        </div>
                                </div>
                                
                                <!-- <div class="row" style="margin-top:5px">   
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_state_id">
                    
                  <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Living State"><i class="fa fa-globe fa-fw"></i></span>
                     <select data-placeholder="Choose country initially" name="agn_state" id="agn_state" class="form-control chosen-select col-lg-12 " tabindex="2"    >                  
                                         <option value='nil'>Choose country initially</option>  
                                       
                        </select>
                    </div>
                                        </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                    <div class="form-group">
                                    <div class="input-group " id="default_city_id">
                  <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="City Name"><i class="fa fa-map-marker fa-fw"></i></span>
                     <select data-placeholder="Choose A City" class="form-control chosen-select col-lg-12 " tabindex="2">           <option value="" disabled>Choose state - initially</option> 
                    
                  </select >
                    </div>
                                        </div>
                                        </div>
                                </div> -->
                                    
                                    <div class="row" style="margin-top:5px">
                                <div class="col-sm-12">
                                <div class="form-group">
                     <div class="input-group">
                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Residential Address"><i class="fa fa-home fa-fw"></i></span>
                      <textarea class="form-control no-resize" name="addr" id="addr" style="resize:none" placeholder="Residential Address"></textarea>
                    </div>
                                       
                                        </div>
                                </div>
                                </div>
                                <hr style=" margin-top: 5px;margin-bottom: 5px;border-color: #f5f5f5;">
                                
                                <div class="row" style="margin-top:5px;display:none">
                                    <div class="col-sm-6">
                                <div class="form-group">
                     <div class="input-group">
              <h6 style="font-size:16px;margin-left: 42px;"><i style="color:#F00">*</i> &nbsp;Which post do you want to apply ? </h6>
                    </div>
                                        </div>
                                </div>
                                    
                                <div class="col-sm-6">
                                    <table width="100%"><tr>
                                    <td  width="45%"><label class="btn btn-sm" style="background-color: rgb(252, 252, 252);" ><input type="radio" class="" id="distrr" name="person" value="1"  onClick="hide_distr()" >&nbsp;&nbsp;Distributor</label></td>
                                    <td  width="5%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td  width="45%"><label class="btn btn-sm" style="background-color: rgb(252, 252, 252);"><input type="radio" class="" id="agentt" name="person" value="0"  checked='checked' onClick="show_distr()">&nbsp;&nbsp;Agent</label></td></tr></table>
                                    
                                    <div id="disr_sel" class="form-group" style="display:none;">
                                    <div class="input-group">
                                    <span class="input-group-addon tooltips" data-toggle="tooltip" data-original-title="Choose Your Distributor"><i class="fa fa-home fa-fw"></i></span>
                                     <?php
                  $distr = $conn->prepare("SELECT * FROM distributor_pro");
                  $distr->execute();
				  $row_distr_main=$distr->fetchAll();
                  ?>
                    <select id="distr_sel" data-placeholder="Choose Distributor" name="distributor" class="form-control chosen-select col-lg-12 " tabindex="2"  >                 
                                         <option value="nil">Choose Distributor</option>  
                     <?php foreach($row_distr_main as $row_distr) {?>
                    <option <?php if($row_distr['distr_id']=='DSR128'){ echo "selected";} ?> value="<?php echo $row_distr['distr_id'];?>"><?php echo $row_distr['distr_fname']."&nbsp;".$row_distr['distr_lname'];?></option>
                                        <?php } ?>
                  </select>
                                    </div>
                                    </div>
                                </div>
                                </div>d
                                </div><!-- first_div_id -->
                                </div>
                </div>
                        </div>
											   <div class="modal-footer" style="margin-top:0px">
												<button type="button" id="modal_sub_cancel" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="submit_id" name="submit_modal" value="submit_modal_val" class="btn btn-success pull-right"  ><i class="fa fa-thumbs-o-up"></i>&nbsp;Submit</button>
											  </div><!-- /.modal-footer -->
											</div>
	  </form>							  
	</div></div>
<header id="login-header" >
<div id="" style="text-transform:capitalize !important;" align="center">
<img src="images/Dvi Hols.png" width="175px">
</div>
</header>
<div id="login-box-inner" >
	<div align="center"><a  href="http://esdev001.com/DVI_Holidays/" data-toogle="tooltips" title="Home page"><i class="fa fa-home icon-circle icon-xs icon-primary vie"></i></a></div>
	<br>
<form role="form">
	<div id="errlogin"></div>
<div id="error" style="display:none" align="center"><span style="font-size:14px;font-weight:bolder;color:red">Login Credentials Invalid!</span></div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-user" style="color:#2C3E50"></i></span>
<input class="form-control" id="uname" type="text" placeholder="User Name">
</div></div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-key" style="color:#2C3E50"></i></span>
<input type="password" id="passwd" class="form-control" placeholder="Password">
</div></div>
<div id="remember-me-wrapper">
<div class="row">

	<div class="pull-left">
<div class="checkbox checkbox-inline" >
<label style="color: #FFF;font-size: 13px;font-weight: bold;">
<input id="remember" type="checkbox" onkeydown="if (event.keyCode ==13) document.getElementById('loguser').click()" value="1" name="remember">
Remember me
</label>
</div></div>
<div class="pull-right">
<a  style="color: #FFFF1F;float:right;font-weight:bold;text-decoration:underline;background:none" class="flashit" href="javascript:void(0)" data-toggle="modal" data-target="#View_signup"><i class="soap-icon-list"></i>&nbsp;Signup Here</a>
</div>
</div></div>
</div>
<div class="row">
<div class="col-xs-12">
	<br>
<button type="button" class="btn btn-info pull-right" onclick="return check_login()">Login</button>

</div>
</div>


</form>
</div>
</div>
<script type="text/javascript" src="core/js/jquery.noconflict.js"></script>
    <script type="text/javascript" src="core/js/modernizr.2.7.1.min.js"></script>
    <script type="text/javascript" src="core/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="core/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="core/js/jquery-ui.1.10.4.min.js"></script>
    
    <script type="text/javascript" src="core/js/theme-scripts.js"></script>
<!-- my edit on 02-dec-2015 end -->   
    
    <!-- Twitter Bootstrap -->
    <script type="text/javascript" src="core/js/bootstrap.js"></script>
    
    <!-- load revolution slider scripts -->
    <script type="text/javascript" src="core/components/revolution_slider/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="core/components/revolution_slider/js/jquery.themepunch.revolution.min.js"></script>
    
    <!-- load BXSlider scripts -->
    <script type="text/javascript" src="core/components/jquery.bxslider/jquery.bxslider.min.js"></script>
    
    <!-- load FlexSlider scripts -->
    <script type="text/javascript" src="core/components/flexslider/jquery.flexslider-min.js"></script>
    
    <!-- Google Map Api -->
    <script type='text/javascript' src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
    <script type="text/javascript" src="core/js/gmap3.min.js"></script>
    <!-- parallax -->
    <script type="text/javascript" src="core/js/jquery.stellar.min.js"></script>
    <!-- waypoint -->
    <script type="text/javascript" src="core/js/waypoints.min.js"></script>
    <!-- load page Javascript -->
   <!-- <script type="text/javascript" src="core/js/theme-scripts.js"></script>-->
   <script src="core/assets/plugins/fancybox/lib/jquery-1.8.2.min.js"></script>
        <link href="core/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
<script src="core/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <script src="core/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>  
    <script type="text/javascript" src="core/js/scripts.js"></script>
    <script type="text/javascript">
        tjq(document).ready(function() {
            tjq('.revolution-slider').revolution(
            {
                dottedOverlay:"none",
                delay:9000,
                startwidth:1300,
                startheight:450,
                onHoverStop:"on",
                hideThumbs:10,
                fullWidth:"on",
                forceFullWidth:"on",
                navigationType:"none",
                shadow:0,
                spinner:"spinner4",
                hideTimerBar:"on",
            });
        });
    </script>
 <script>
 $(document).ready(function(e) {
    
});
 function getXMLHTTP() { //fuction to return the xml http object
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
    var check='';
function check_login()
{
var uname=document.getElementById('uname').value;
	var passwd=document.getElementById('passwd').value;
	var remember=0;
	
	if (document.getElementById('remember').checked) 
	{
		remember = '1';
	}
	var uid="-";
	var type=1;
	var swt=0;
	
	var strURL="login_check.php?uname="+uname+"&passwd="+passwd+"&ty="+type+"&remember="+remember+"&swt="+swt+"&uid="+uid;
	function getXMLHTTP() { //fuction to return the xml http object
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
	var ses;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() 
		{
			if (req.readyState == 4 && req.status == 200) 
			{
				 check=req.responseText.trim();
				 //alert(check);
				 if (check == 'not')
				 {
					document.getElementById('errlogin').innerHTML = "<p style='color:red'><i style='color:red' class='fa fa-bell'></i> &nbsp;Login Credentials Invalid!</p>";
				 }
				 else
				 {
          window.location.href='dashboard_maintain.php';
          return false;
					if(check == 'AGENT')
					{
						window.location.href='agent_manaorder.php?mm=23311f54cbcb20fd815e2574e8b07b39&sm=f0e2efabf331f439ad99596cea1accf3';	
        
      }else{
						window.location.href='dashboard1.php';	
					}
				 }
			}  
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}
	
 var check='';
function validate_final()
{
  var type=2;
  var email_check='';
  var ag_nme=document.getElementById('agn_fname').value;
  var agn_email=document.getElementById('agn_email').value;
  var agmobile=document.getElementById('agn_mobile').value.trim();
  var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,10}|[0-9]{1,3})(\]?)$/;
  var numbers =  /^\d+$/; 
  var strin = /^[a-zA-Z ]{4,30}$/;
  var lstrin = /^[a-zA-Z ]{1,30}$/;

  //alert(document.getElementById('agentt').checked);
  if(document.getElementById('agn_fname').value.trim()=='')
  {
    alert('Please Enter valid first name');
    document.getElementById('agn_fname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_fname').value.trim().length<4  )
  {
    alert('First name should be minimum 4 charactors');
    document.getElementById('agn_fname').focus();
    check=0;
    //return false;
  }else if(!strin.test(ag_nme))
  {
    alert('Characters only acceptable on first-name');
    document.getElementById('agn_fname').focus();
    check=0;
    //return false;
  }
  else if(document.getElementById('agn_lname').value.trim()=='')
  {
    alert('Please Enter valid last name');
    document.getElementById('agn_lname').focus();
    check=0;
    //return false;
  }else if(!lstrin.test(document.getElementById('agn_lname').value.trim()))
  {
    alert('Characters only acceptable on last-name');
    document.getElementById('agn_lname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_cname').value.trim()=='')
  {
    alert('Please Enter valid company name');
    document.getElementById('agn_cname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_cname').value.trim().length<4)
  {
    alert('company name should be minimum 4 charactors');
    document.getElementById('agn_cname').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_mobile').value.trim()=='')
  {
    alert('Please Enter Mobile number');
    document.getElementById('agn_mobile').focus();
    check=0;
    //return false;
  }else if(!numbers.test(agmobile))
  {
    alert('Please Enter Valid Mobile Number');
    document.getElementById('agn_mobile').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_mobile').value.trim().length<10 || document.getElementById('agn_mobile').value.trim().length>13)
  {
    alert('Invalid Mobile Number');
    document.getElementById('agn_mobile').focus();
    check=0;
    //return false;
  }
  else if(document.getElementById('agn_email').value.trim()=='')
  {
    alert('Please Enter valid email id');
    document.getElementById('agn_email').focus();
    check=0;
    //return false;
  }else if(!expr.test(agn_email))
  {
    alert('Invalid email id, Please Enter Valid email id');
    document.getElementById('agn_email').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agn_count').value.trim()=='nil')
  {
    alert('Please choose your country');
    document.getElementById('agn_count').focus();
    check=0;
    //return false;
  }
  // else if(document.getElementById('agn_state').value.trim()=='nil')
  // {
  //   alert('Please choose your state');
  //   document.getElementById('agn_state').focus();
  //   check=0;
  //   //return false;
  // }
  // else if(document.getElementById('hotel_city').value.trim()=='')
  // {
  //   alert('Please choose your city');
  //   document.getElementById('hotel_city').focus();
  //   check=0;
  //   //return false;
  // }
  else if(document.getElementById('addr').value.trim()=='')
  {
    alert('Please Enter Your Address');
    document.getElementById('addr').focus();
    check=0;
    //return false;
  }else if(document.getElementById('addr').value.trim().length<5)
  {
    alert('Please Enter Your Valid Address');
    document.getElementById('addr').focus();
    check=0;
    //return false;
  }else if(document.getElementById('agentt').checked && document.getElementById('distr_sel').value=='nil')
  {
      alert('Please Choose Your Distributor');
      document.getElementById('distr_sel').focus();
      check=0;
    //return false;
  }else{
      var strURL="login_check.php?email="+agn_email+"&ty="+type;
      var req = getXMLHTTP();
      if (req) {
        req.onreadystatechange = function() 
        {
          if (req.readyState == 4 && req.status == 200) 
          {
                   email_check=req.responseText.trim();
                  // alert(email_check);
            if(email_check == 'yes')
            {
              check=1;
              //alert('submit'+check);
                  //return true;      
            }else{
              check=0;
              alert("This Email ID already exists, Please give alternate mailid ..");
              document.getElementById('agn_email').focus();
              //return false;
            }
          }  
        }     
        req.open("GET", strURL, false);
        req.send(null);
      }
    }
    
      if(check==0)
      {
        return false;
      }else{
        fun_noitartsiger();
        return false;
        //return true;  
      }
}
function fun_noitartsiger()
{
	$('#reg_head').empty().prepend('Registration Form [ Processing .. ]');
	var datastring = $("#hotel_add").serialize();
        $.ajax({
            type: "POST",
            url: "login_check.php?ty=3",
            data: datastring,
            success: function(res) {
				$('#reg_head').empty().prepend('Registration Form [ Completed ]')
                alert("Wow! That's great you are in. Your registration may take 2 to 8 working hrs, check your e-mail for password");
				$('#modal_sub_cancel').trigger('click');
            }
        });
}
function show_distr()
{
	document.getElementById("disr_sel").style.display='block';
	//document.getElementById("distr_sel").removeAttribute('disabled');
}

function hide_distr()
{ 
	document.getElementById("disr_sel").style.display='none';
    //document.getElementById('distr_sel').disabled="false";
}
 
  function login()
  {

	var uname=document.getElementById('uname').value;
	var passwd=document.getElementById('passwd').value;
	var remember=0;
	
	if (document.getElementById('remember-me').checked) 
	{
		remember = '1';
	}

	var uid="-";
	var type=1;
	var swt=0;
	
	var strURL="login_check.php?uname="+uname+"&passwd="+passwd+"&ty="+type+"&remember="+remember+"&swt="+swt+"&uid="+uid;
	
	function getXMLHTTP() { //fuction to return the xml http object
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
	var ses;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() 
		{
			if (req.readyState == 4 && req.status == 200) 
			{
				 check=req.responseText.trim();
				//alert(check);
				 if (check == 'not')
				 {
				document.getElementById("error").style.display='block';
					//document.getElementById('errlogin').innerHTML = "<p style='color:red'><i style='color:red' class='fa fa-bell'></i> &nbsp;Login Credentials Invalid!</p>";
					//notify('<span style="font-size:14px;font-weight:bolder">Login Credentials Invalid!</span>');

					
				 }
				 else
				 {
				 	document.getElementById("error").style.display='none';
					if(check == 'AGENT')
					{
						window.location.href='agent_manaorder.php?mm=23311f54cbcb20fd815e2574e8b07b39&sm=f0e2efabf331f439ad99596cea1accf3';	
					}else{
						window.location.href='dashboard.php';	
					}
				 }
			}  
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}
 
 function notify(msg)
{
	alert(msg);
var notification = new NotificationFx({
					message : msg,
					layout : 'attached',
					effect : 'bouncyflip',
					type : 'dark',
				});
 notification.show();
				
} 
function find_state(state_id)
{
  var type=16;
  var strURL="ajax_page.php?sid="+state_id+"&type="+type;
  
  var req = getXMLHTTP();
  if (req) {
    req.onreadystatechange = function() 
    {
      if (req.readyState == 4 && req.status == 200) 
      {
        document.getElementById('default_state_id').innerHTML = req.responseText;
        }  
    }     
    req.open("GET", strURL, true);
    req.send(null);
  }
}
function find_city(state_id)
{
  var type=15;
  var strURL="ajax_page.php?sid="+state_id+"&type="+type;
  
  var req = getXMLHTTP();
  if (req) {
    req.onreadystatechange = function() 
    {
      if (req.readyState == 4 && req.status == 200) 
      {
        document.getElementById('default_city_id').innerHTML = req.responseText;
        }  
    }     
    req.open("GET", strURL, true);
    req.send(null);
  }
}
  </script>
