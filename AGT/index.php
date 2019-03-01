<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>DVI Login | Users </title>
		<!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- PLUGINS CSS -->
		<link href="../core/assets/plugins/weather-icon/css/weather-icons.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="../ore/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/morris-chart/morris.min.css" rel="stylesheet">
		<link href="../core/assets/plugins/toastr/toastr.css" rel="stylesheet">
				
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="../core/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="../core/assets/css/style.css" rel="stylesheet">
		<link href="../core/assets/css/style-responsive.css" rel="stylesheet">
 
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="login tooltips" style="background-color:rgb(34, 100, 137);">
		<div class="login-header text-center" style="background-color:#FFF">
			<img src="dvi_pdf_new.jpg" height="80%" width="15%" style="margin-top: 16px;"> 
			<div id="errlogin"></div>
		</div>
		<div class="login-wrapper" id="login_my">
			<form role="form">
				
				<div class="form-group has-feedback lg left-feedback no-label">
				  <input type="text" class="form-control no-border input-lg rounded" placeholder="Enter username" autofocus name="uname" id="uname">
				  <span class="fa fa-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback lg left-feedback no-label">
				  <input type="password" class="form-control no-border input-lg rounded" placeholder="Enter password"  name="passwd" id="passwd">
				  <span class="fa fa-unlock-alt form-control-feedback"></span>
				</div>
				<div class="form-group">
				  <div class="checkbox">
					<label>
			 <input type="checkbox" class="i-yellow-flat" id="remember" name="remember"> Remember me
					</label>
				  </div>
				</div>
				<div class="form-group" align="center">
					<button type="button" class=" btn btn-info" onclick="check_login()">LOGIN</button>
				</div>
			</form>
			<p class="text-center"><strong>
<a  href="javascript:void(0)" class="forgot-password" onClick="forgot_pass()"> Forgot password?</a>
</strong></p>
			<!--<p class="text-center">or</p>
			<p class="text-center"><strong><a href="register.html">Create new account</a></strong></p> -->
		</div><!-- /.login-wrapper -->


		<div class="login-wrapper" id='forgot_pass' style="display:none;">
			<form role="form">
				<div class="form-group has-feedback lg left-feedback no-label">
<input type="text" class="form-control no-border input-lg rounded" placeholder="Registered Mail ID" autofocus name="reg_emailid" id="reg_emailid">
				  
				  <span class="fa fa-envelope form-control-feedback"></span>
				</div>
				<div class="form-group" align="center">

	<button name="forgotuser" type="button" id="forgotuser" onClick="check_forgot_pass()" class=" btn btn-info" >Send Password</button>

	<button type="button" name="backtologin" id="backtologin" onClick="bacttologin()" class=" btn btn-warning" >Back To Login</button>
					
				</div>
			</form>
			<!--<p class="text-center">or</p>
			<p class="text-center"><strong><a href="register.html">Create new account</a></strong></p> -->
		</div><!-- /.login-wrapper -->

		<script src="../core/assets/js/jquery.min.js"></script>
		<script src="../core/assets/js/bootstrap.min.js"></script>
		<script src="../core/assets/plugins/retina/retina.min.js"></script>
		<script src="../core/assets/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="../core/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="../core/assets/plugins/backstretch/jquery.backstretch.min.js"></script>
		<script src="../core/assets/plugins/toastr/toastr.js"></script>
		<script src="../core/assets/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="../core/assets/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script>

function forgot_pass()
{
	$('#errlogin').empty().prepend('Please Enter Your Registered Email ID').css('color','rgb(230, 45, 1)');
	$('#errlogin').show();
	$('#login_my').hide();
	$('#forgot_pass').show();
}

function bacttologin()
{
	$('#errlogin').hide();
	$('#login_my').show();
	$('#forgot_pass').hide();
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
	
	if(uname.trim()=="")
	{

		document.getElementById('errlogin').innerHTML = "<p style='color:red'><i style='color:red' class='fa fa-bell'></i> &nbsp;Please Enter Your Username</p>";
		document.getElementById('uname').focus();
		$('#errlogin').show();
	}else if(passwd.trim()=="")
	{
		document.getElementById('errlogin').innerHTML = "<p style='color:red'><i style='color:red' class='fa fa-bell'></i> &nbsp;Please Enter Your Password</p>";
		document.getElementById('passwd').focus();
		$('#errlogin').show();
	}else{

	var type=1;
	var strURL="../login_check.php?uname="+uname+"&passwd="+passwd+"&ty="+type+"&remember="+remember;
	
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
					if(check == 'AGENT')
					{
						window.location.href='../agent_manaorder.php?mm=23311f54cbcb20fd815e2574e8b07b39&sm=f0e2efabf331f439ad99596cea1accf3';	
					}else{
						window.location.href='../dashboard.php';	
					}
				 }
			}  
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
	}//else end
}

function check_forgot_pass()
{
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	var reg_mid=$('#reg_emailid').val().trim();
	var res;
	
	if(reg_mid=='')
	{
		$('#errlogin').empty().prepend('Please Enter Your Registered Email ID..').css('color','rgb(230, 45, 1)');
	}else if(!expr.test(reg_mid))
	{
		$('#errlogin').empty().prepend('Invalid Mail ID, Please Enter Valid Email ID').css('color','rgb(230, 45, 1)');
		document.getElementById('reg_emailid').focus();
	}else{
		$('#errlogin').empty().prepend('Please Wait..').css('color','#C93');
		$.get('../login_check.php?ty=4&fb='+reg_mid,function(result)
		{
			res=result.trim();
			if(res=='yes')
			{
				$('#errlogin').empty().prepend('Password sent to given mail id').css('color','rgb(36, 95, 17)');
			}else{
				$('#errlogin').empty().prepend('Kindly varify your mail id').css('color','rgb(230, 45, 1)');
			}
		});
	}
}

	</script> 
	</body>
</html>