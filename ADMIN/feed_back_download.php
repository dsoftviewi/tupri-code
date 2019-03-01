<?php 
session_start();
require_once("../assets/dompdf-master/dompdf_config.inc.php");
require_once("../Connections/divdb.php");

$timezone = new DateTimeZone("Asia/Kolkata" );
  $date = new DateTime();
  $date->setTimezone($timezone );
  $mm=$date->format('m');
  $mm1=$date->format('M');
  $yy=$date->format('Y');
  $dd=$date->format('d');
  $time=date("H:i:s");
  $today=date('d.m.Y');


$idd=explode('#',$_GET['planid']);
$str=$idd[0];
//print_r($idd);

$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($_GET['planid']));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=document_name.doc");


$you = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$you->execute(array($_SESSION['uid']));
$row_you = $you->fetch(PDO::FETCH_ASSOC);
$totalRows_you = $you->rowCount();

$slen=strlen($row_orders['tr_name']);
if($slen<=10){
	$fsize='105px';
}
else if($slen<=15)
{
	$fsize='75px';
}else if($slen<25)
{
	$fsize='65px';
}else if($slen<35)
{
	$fsize='55px';
}else{
	$fsize='26px';
}


if(trim($row_you['comp_name'])=='')
{
	$company_myname='DVI Holidays';
}else{
	$company_myname=trim($row_you['comp_name']);
}
$html='<html xmlns="http://www.w3.org/1999/xhtml">

<body style="margin-top:05px; margin-bottom:5px; font-family:;">
<style>

.tag 
{
	background:url(../images/dvi_pdf1.png);
	background-position:50% 50% !important;
	background-color:#FFF;
	opacity:0.2;
	background-repeat: no-repeat;
	padding :10px;
}

.hide_border{
border-top:#FFF;
 border-bottom:#FFF; 
 border-left:#FFF; 
border-right:#FFF	
}


table{
 border-collapse: collapse;
 
}

.t1 {
 border: 1px solid #000;
 
}
table,td,th{
 border: 1px solid #000;	
}

#header,
#footer {
  position: fixed;
  left: 0;
	right: 0;
	color: #aaa;
	font-size: 0.9em;
	width:100%
}

#header {
  top: 0;

}

hr {
  page-break-after: always;
  border: 0;
}

#footer {
  bottom: 0;
  height:20px;
  border-top: 0.1pt solid #aaa;
}

#header table,
#footer table {
	width: 100%;
	
	border-collapse: collapse;
	border: none;
}

#header td,
#footer td {
  padding: 0;
	width: 50%;
}
</style><div align="center"><h2><strong>FEEDBACK FORM</strong></h2></div><br>';


$customer_name=$_GET['customers'];
				



$mst = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$mst->execute(array($_GET['planid']));
$row_mst = $mst->fetch(PDO::FETCH_ASSOC);
$totalRows_mst = $mst->rowCount();


$trl_scd = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
$trl_scd->execute(array($_GET['planid']));
$row_trl_scd =$trl_scd->fetch(PDO::FETCH_ASSOC);
//$row_trl_arr = mysql_fetch_array($trl_scd);
$totalRows_trl_scd = $trl_scd->rowCount();

$start_dtour=date("d- M- Y",strtotime($row_trl_scd['tr_date']));
for($ko=0;$ko<$totalRows_trl_scd-1;$ko++)
{
	$row_trl_scd = $trl_scd->fetch(PDO::FETCH_ASSOC);
}
$last_dtour=date("d- M- Y",strtotime($row_trl_scd['tr_date']));


$sy_scd = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
$sy_scd->execute(array($_GET['planid']));
$row_sy_scd = $sy_scd->fetch(PDO::FETCH_ASSOC);
$totalRows_sy_scd = $sy_scd->rowCount();

  $html.='<table  border="none" ><tr >
    <td colspan="6" class="hide_border" >
	<h3><font style="font-weight: bold; float:left; font-family:; text-align:left; font-size: 14px; margin-left:5px">Dear : '.$customer_name." *".$row_mst['pax_cnt'].'</font><font style="font-weight: bold; float:right; font-family:; text-align:right; font-size: 14px; margin-left:5px">Tour Date : '.$start_dtour." To ".$last_dtour." &nbsp;&nbsp;[ ".$totalRows_trl_scd.' days ]</font></h3>
   </td>
  </tr>
  <tr class="hide_border"> 
    <td class="hide_border" colspan="6">
	<table width="100%"  border="0" style="font-family: ; margin-top:20px; text-align: left; font-size: 14px">
      <tr>
        <td class="hide_border" colspan="2"  height="55px;" style="text-align: left; font-weight: bold;">Greetings from '.$company_myname.' !!!</td>
        </tr>
      <tr >
        <td class="hide_border" height="15px;" colspan="2">Thank you for your choice to use '.$company_myname.'</td>
        </tr>
      <tr>
        <td colspan="2" class="hide_border" ><p>The Motto of our company is to provide satisfactory servies to our entire guest. In order to achevieve this aim, we need to know your opinion on it. praise would be a motivation for us to continue our services. And any critic would naturally be a reason for us to improve our services according to the requirements and desires of our Guests.</p></td>
        </tr>
      <tr>
        <td colspan="2" height="30px">Please tell your Friends what would you like about us!</td>
        </tr>
      <tr>
        <td colspan="2" height="30px">Please tell us what you dislike.<br><br><br></td>
        </tr>
      <tr>
        <td  colspan="2">1) Tell Us about the vehicles and its drivers for your whole trip?</td>
      </tr>
      <tr>
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vehicle provided :<br><br><br><br></td>
      </tr>
      <tr>
        <td  colspan="2">2) Is the vehicle is on Time at the airport on your arrival?</td>
      </tr>
      <tr>
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vehicle Provided :<br><br><br><br> </td>
      </tr>
      <tr>
        <td  colspan="2">3) How about the drivers services to you?</td>
      </tr>
      <tr>
        <td  colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Driver Name :<br><br><br><br> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">Tell us about the hotels which you have been used for your whole trip.</td>
      </tr>
     </table><td></tr>';
	
	
	$trl_scd1 = $conn->prepare("SELECT * FROM travel_sched where travel_id =? ORDER BY sno ASC");
	$trl_scd1->execute(array($_GET['planid']));
	//$row_trl_scd1 = mysql_fetch_assoc($trl_scd1);
	//$row_trl_arr1 = mysql_fetch_array($trl_scd1);
	//$row_trl_scd1_main=$trl_scd1->fetchAll();
	$totalRows_trl_scd1 =$trl_scd1->rowCount();
	
	
	$sy_scd1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =?");
	$sy_scd1->execute(array($_GET['planid']));
	//$row_sy_scd1 = mysql_fetch_assoc($sy_scd1);
	//$row_sy_scd1_main=$sy_scd1->fetchAll();
	$totalRows_sy_scd1 = $sy_scd1->rowCount();


	$i=0;
	 while($totalRows_sy_scd1>0)
  {
    $row_sy_scd1 = $sy_scd1->fetch(PDO::FETCH_ASSOC);
    $row_trl_scd1 =$trl_scd1->fetch(PDO::FETCH_ASSOC);
		if($row_sy_scd1['sty_date'] == $row_trl_scd1['tr_date'])
		{
			
			$shot = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
			$shot->execute(array($row_sy_scd1['hotel_id']));
			$row_shot= $shot->fetch(PDO::FETCH_ASSOC);
			$totalRows_shot = $shot->rowCount();
      
	  $html.='<tr>
        <td colspan="6" class="hide_border"  style="text-align:left; font-weight: bold;">'.$row_trl_scd1['tr_to_cityid'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$row_shot['hotel_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Check-In :  '.date("d-M-Y",strtotime($row_trl_scd1['tr_date'])).'';
		
										$flag=true;
										while($flag)
										{
											
											$sy_ntx= $conn->prepare("SELECT * FROM stay_sched where stay_id =? and sno=?");
											$sy_ntx->execute(array($_GET['planid'],($row_sy_scd1['sno']+1)));
											$row_sy_ntx = $sy_ntx->fetch(PDO::FETCH_ASSOC);
											$totalRows_sy_ntx = $sy_ntx->rowCount();
											
											if($totalRows_sy_ntx>0)
											{
												if($row_sy_scd1['hotel_id']==$row_sy_ntx['hotel_id'])
												{
													$row_sy_scd1=$sy_scd1->fetch(PDO::FETCH_ASSOC);
													$row_trl_scd1=$trl_scd1->fetch(PDO::FETCH_ASSOC);
													$totalRows_sy_scd1--; 
													$flag=true;
												}else{
													$flag=false;
													break;	
												}
											}else{
												$flag=false;	
												break;	
											}
										}
									$date=date_create($row_trl_scd1['tr_date']);
									date_add($date,date_interval_create_from_date_string("1 days"));
		
		 $html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check-Out: '.$next_datt=date_format($date,"d-M-Y").'</td>
      </tr>
      <tr >
        <td colspan="6" class="hide_border" style="text-align: left">
		<table width="100%" border="0"  style="font-family: ; text-align: left; font-size: 14px">
          <tr>
            <td width="10%" height="25px" >Rooms</td>
            <td width="15%" height="25px" style="text-align: center">Poor</td>
            <td width="15%" height="25px" style="text-align: center">Good</td>
            <td width="15%" height="25px" style="text-align: center">Very Good</td>
            <td width="15%" height="25px" style="text-align: center">Excellent</td>
            <td width="30%" height="25px">&nbsp;</td>
            </tr>
			<tr><td colspan="6"></td></tr>
          <tr>
            <td height="25px">Food</td>
            <td height="25px" style="text-align: center">Poor</td>
            <td height="25px" style="text-align: center">Good</td>
            <td height="25px" style="text-align: center">Very Good</td>
            <td height="25px" style="text-align: center">Excellent</td>
            <td height="25px">&nbsp;</td>
            </tr>
			<tr><td colspan="6"></td></tr>
			
          <tr>
            <td>Staff</td>
            <td height="25px" style="text-align: center">Poor</td>
            <td height="25px" style="text-align: center">Good</td>
            <td height="25px" style="text-align: center">Very Good</td>
            <td height="25px" style="text-align: center">Excellent</td>
            <td height="25px">&nbsp;</td>
            </tr>
			<tr><td colspan="6"></td></tr>
			
          <tr>
            <td colspan="6">Anything needs to be improved, please mention.<br><br><br><br></td>
            </tr>
			<tr><td colspan="6"></td></tr>
			<tr><td colspan="6"></td></tr>
			<tr><td colspan="6"></td></tr>
          </table></td>
      </tr>';
	  $totalRows_sy_scd1--; 
	  $i++;
		}
	}
		$html.='<tr><td colspan="6" class="hide_border" style="text-align: left">
		<table class="hide_border">
		<tr><td colspan="2 " class="hide_border">Please tell us about the overall feedback on '.$company_myname.' for organizing your tour.</td></tr>
		<tr><td colspan="2" class="hide_border">&nbsp;</td></tr>
		<tr><td width="20%" class="hide_border">Name</td><td class="hide_border" width="10%">:</td><td class="hide_border" width=70%></td></tr>
		<tr><td width="20%" class="hide_border">Email ID</td><td class="hide_border" width="10%">:</td><td class="hide_border" width=70%></td></tr>
		<tr><td width="20%" class="hide_border">Address</td><td class="hide_border" width="10%">:</td><td class="hide_border" width=70%></td></tr>
		<tr><td colspan="2" class="hide_border">&nbsp;</td></tr>
		<tr><td colspan="2" class="hide_border">&nbsp;</td></tr>
		<tr><td colspan="2" class="hide_border" style="text-align:center">Thank you..</td></tr>
		</table><hr></td></tr>
		      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr></table></td></tr></table>';
//main for loop
	  $html.='</body></html>';

//echo $html;die;
$fnfile=$row_orders['plan_id'].'_'.$row_orders['tr_name'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream($fnfile, array("Attachment" => false));

//$pdf = $dompdf->output();
?>
