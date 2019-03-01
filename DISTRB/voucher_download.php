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

$multi_itin_arr=explode('-',$row_orders['sub_paln_id']);
//print_r($multi_itin_arr);
$multi_itin='';
for($mia=0;$mia<count($multi_itin_arr);$mia++)
{
	if($multi_itin=='')
	{
		$multi_itin="'".$multi_itin_arr[$mia]."'";
	}else{
		$multi_itin=$multi_itin.",'".$multi_itin_arr[$mia]."'";
	}
}


$you = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
$you->execute(array($_SESSION['uid']));
$row_you = $you->fetch(PDO::FETCH_ASSOC);
$totalRows_you = $you->rowCount();

$customer_name=$_GET['customers'];
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=document_name.doc");

$html='<html xmlns="http://www.w3.org/1999/xhtml">
<body style="margin-top:30px; margin-bottom:5px; font-family:;">
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

.tag_you
{
	background:url(../img_upload/agent_img/logo/'.$row_you['comp_logo'].');
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
</style> 

<div id="header">
  <table>
    <tr>
      <td style="border-bottom:1px solid #000; border-top:1px solid #FFF;border-left:1px solid #FFF;border-right:1px solid #FFF">
<span>';
if(trim($row_you['comp_logo'])=='' || trim($row_you['comp_logo'])=='-')
{
	$html.='<img  src="../images/dvi_pdf.png" height="65px" width="65px" alt="DVI Logo" style="margin-left:630px;">';
	$water_mark='tag';
}else{
	$html.='<img  src="../img_upload/agent_img/logo/'.$row_you['comp_logo'].'" height="65px" width="65px" alt="Your Logo"  style="margin-left:630px;">';
	$water_mark='tag_you';
}

$html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<br><b style="margin-left:550px; font-size:12px;" >An ISO 9001 - 2008 company</b></td>

    </tr>
  </table>
</div>
<div id="footer"  style="margin-top:-20px" > 
<strong>Head Office : </strong><strong>#51, Vijaya Nagar, Dheeran Nagar (Extn), Karumandapam, Trichirappalli, Tamilnadu - 620009</strong><br />
<strong>Ph : </strong><strong>0431-2403615 </strong>&nbsp;&nbsp;&nbsp;<strong> H Phone :</strong><strong>9443164494</strong>&nbsp;&nbsp;&nbsp;<strong> Windows Live ID : </strong><strong> <u>vsr@v-i.in</u></strong><br />
<strong>BRANCHES :: </strong>&nbsp;<strong>NEW DELHI | MADURAI | COCHIN | VIJAYAWADA</strong>
</div>

<div class="the-box" style="vertical-align: text-middle; border:thin #666 1px;">';


if(!isset($_GET['fdate']) && !isset($_GET['tdate']))
{
		 $sspro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id IN (?) ORDER BY sno ASC ");
}else{
		$sspro1 = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and (`sty_date`>=? and `sty_date`<=?) ORDER BY sno ASC ");
}
$sspro1->execute(array($multi_itin,$_GET['planid'],date('Y-m-d',strtotime($_GET['fdate'])),date('Y-m-d',strtotime($_GET['tdate']))));
//$row_sspro1 = mysql_fetch_assoc($sspro1);
$row_sspro1_main=$sspro1->fetchAll();
$totalRows_sspro1 = $sspro1->rowCount();
if($totalRows_sspro1>0)
{
	$first_day=0;
	$last_day=1;
	$ro=0;;
foreach($row_sspro1_main as $row_sspro1)
{
	if($ro!=0)
	{
		$html.='<hr>';	
	}
$ro++;
  $html.='<table class="'.$water_mark.'" style="border-top:#FFF; border-bottom:#FFF; border-left:#FFF; border-right:#FFF; margin-top:60px;" ><tr>
    <td class="hide_border" colspan="6"><center><font style="font-weight: bold; color:#900; font-family:; text-align: center; font-size: 16px">Voucher Details</font></center></td>
  </tr>
 <tr>
    <td class="hide_border" colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td class="hide_border" colspan="6"><table width="100%" border="0">
      <tr>
        <td><font style="font-weight: bold; float:left; font-family:; text-align: left; font-size: 14px; margin-left:5px">Voucher Date : ' .$today.'</font> </td>
        <td><font style="font-weight: bold; float:right; font-family:; text-align: right; font-size: 14px; ">Voucher No : ' .$row_sspro1['sty_date']."/DVI-HTL-".$idd[1].'</font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="hide_border" colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="1" style="font-family: ; text-align: left; font-size: 14px">
      <tr class="hide_border">
        <td colspan="2" height="25px" class="hide_border"  style="text-align: center; font-weight: bold;">Hotel Exchange Voucher</td>
        </tr>
      <tr class="hide_border">
        <td width="48%;" height="30px" >Guest Name</td>
        <td width="52%" height="30px">'.$customer_name." * ".$row_orders['pax_cnt'];'.</td>
      </tr>';
		
		$sp = $conn->prepare("SELECT * FROM stay_sched where stay_id =? and hotel_id=?  ORDER BY sno ASC ");
		$sp->execute(array($_GET['planid'],$row_sspro1['hotel_id']));
		$row_sp = $sp->fetch(PDO::FETCH_ASSOC);
		$totalRows_sp = $sp->rowCount();
								
		$old_date= date('d-M-Y',strtotime($row_sspro1['sty_date']));
		if($totalRows_sp>1)
		{			
			$totalRows_sp2=$totalRows_sp;
			$derf=$totalRows_sp2;
			$date=date_create($row_sspro1['sty_date']);
			date_add($date,date_interval_create_from_date_string($totalRows_sp2." days"));
			
			$next_datt=date_format($date,"d-M-Y");
		}
		else
		{
			$totalRows_sp2=0;
			$derf=1;
			$date=date_create($row_sspro1['sty_date']);
			date_add($date,date_interval_create_from_date_string("1 days"));
			
			$next_datt=date_format($date,"d-M-Y");
		}
		$html.='<tr><td width="48%;" height="30px" >Check In Date</td>
		<td width="48%;" height="30px" >'.$old_date.'</td></tr>
      <tr>
        <td height="25px">Check Out Date</td>
        <td height="25px">'.$next_datt.'</td>
      </tr>
      <tr>
        <td height="25px" >Hotel Name</td>
        <td height="25px">';

$hotell = $conn->prepare("SELECT * FROM hotel_pro where hotel_id =?");
$hotell->execute(array($row_sspro1['hotel_id']));
$row_hotell = $hotell->fetch(PDO::FETCH_ASSOC);
$totalRows_hotell =$hotell->rowCount();


$cityy1 = $conn->prepare("SELECT * FROM dvi_cities where id =?");
$cityy1->execute(array($row_hotell['city']));
$row_cityy1 =$cityy1->fetch(PDO::FETCH_ASSOC);
$totalRows_cityy1 =$cityy1->rowCount();


$stt = $conn->prepare("SELECT * FROM dvi_states where code =?");
$stt->execute(array($row_hotell['state']));
$row_stt = $stt->fetch(PDO::FETCH_ASSOC);
$totalRows_stt = $stt->rowCount();

$html.= $row_hotell['hotel_name']."&nbsp;";
		$html.='</td>
      </tr>
      <tr>
        <td height="25px">Address</td>
        <td height="25px"><p>'.$row_hotell['location'].",&nbsp;".$row_cityy1['name'].",&nbsp;".$row_stt['name'].'</p></td>
      </tr>
      <tr>
        <td height="25px">Accomodation</td>
        <td height="25px">';
		$html.=$row_orders['pax_adults']."-Adults ";
		if($row_orders['pax_512child']!=0 && $row_orders['pax_512child']!='')
		$html.=' ,'.$row_orders['pax_512child']."-Child(5-12) ";
		if($row_orders['pax_child']!=0 && $row_orders['pax_child']!='')
		$html.=' ,'.$row_orders['pax_child']."-Child(below 5)";
		$html.='</td>
      </tr>
      <tr>
        <td height="25px">Room Category</td>
        <td height="25px">';
		$rrom=explode(',',$row_sspro1['sty_room_name']);
		$rrom1=array_unique($rrom);
		$rrom1=array_values($rrom1);
		$rrom2=array_count_values($rrom);
		for($tt=0;$tt<count($rrom1);$tt++)
		{
			if(isset($rrom1[$tt+1]) && $rrom1[$tt+1] !='')
			{
				$html.= $rrom1[$tt].'-'.$rrom2[$rrom1[$tt]].', '; 
				$no_of_rrr=$rrom2[$rrom1[$tt]];
			}else
			{
				$html.= $rrom1[$tt].'-'.$rrom2[$rrom1[$tt]]; 
				$no_of_rrr=$rrom2[$rrom1[$tt]];
			}
		}
		$html.='</td>
      </tr>
      <tr>
        <td height="25px">Total Rooms</td>
        <td height="25px">'.$row_orders['stay_rooms'].'</td>
      </tr>
	  <tr>
        <td height="25px">Extra Bed</td>
        <td height="25px">';
		$extra_bed=explode(',',$row_sspro1['sty_child_bed']); 
			   $with_bd_ctn=0;
			   $without_bd_ctn=0;
			   for($t=0;$t<count($extra_bed);$t++)
			   {
					if($extra_bed[$t]=='0')
					{
						$with_bd_ctn++;
					}else if($extra_bed[$t]=='1')
					{
						$without_bd_ctn++;
					}
			   }
			   if($with_bd_ctn>0)
			   {
					$html.= "Extra with bed - ".$with_bd_ctn;
			   }
			   if($without_bd_ctn>0)
			   {
				 $html.=  "<br> Extra without bed - ".$without_bd_ctn;  
			   }
			   if($without_bd_ctn==0 && $with_bd_ctn==0)
			   {
				$html.= "Nil";   
			   }
			   $html.='</td>
      </tr>
      <tr>
        <td height="25px">Meal Plan</td>
        <td height="25px">';
		if($row_sspro1['sty_food']=='dinner_rate')
		 {
			$html.= "Breakfast & Dinner only "; 
			 							// if($first_day==0)
										 // {
											//  $html.="Dinner only";
											//  $first_day++;
											  
										 // }else
										 // {	
										 // 	if($totalRows_sspro1==$last_day)
											// {
											// 	$html.="Breakfast only";
											// }else
											// {
											// 	$html.="Breakfast & Dinner only"; 
											// }
										 // }
			
		 }
		 else if($row_sspro1['sty_food']=='lunch_rate')
		 {
			 $html.= "Breakfast & Lunch only"; 
			
			 							// if($first_day==0)
										 // {
											//  $html.="Lunch only";
											//  $first_day++;
											  
										 // }else
										 // {
											// if($totalRows_sspro1==$last_day)
											// {
											// 	$html.="Breakfast only";
											// }else
											// {
											// 	$html.="Breakfast & Lunch only"; 
											// }
										 // }
			
		 }
		 else if($row_sspro1['sty_food']=='both_food')
		 {
			 $html.= "Breakfast,Lunch & Dinner"; 
			 
										 //  if($first_day==0)
										 // {
											// $html.="Lunch & Dinner only";
											//  $first_day++;
											  
										 // }else
										 // {
											// if($totalRows_sspro1==$last_day)
											// {
											// 	$html.="Breakfast & Lunch only";
											// }else
											// {
											// 	$html.="Breakfast,Lunch & Dinner"; 
											// }
										 // }
									 
			 
		 }else
		 {
			  $html.= "Breakfast only";
			   // if($first_day!=0)
						// 				 {
						// 					$html.="Breakfast only";
						// 				 }else{
						// 					$html.="Breakfast only";
						// 				 }
		 }
		$html.='</td>
      </tr>';
	  if(trim($row_sspro1['sty_extra']) != '') { 
	   $spl_amen=explode(',',$row_sspro1['sty_extra']);
	  $html.='<tr>
        <td height="25px">Special Amenities</td>
        <td height="25px">';
		for($sa=0;$sa<count($spl_amen);$sa++){
		if($spl_amen[$sa]=='candle_light')
		{
			$html.= "Candle Light";
		}
		else if($spl_amen[$sa]=='fruit_basket')
		{
			$html.= "Fruit Basket";
		}else if($spl_amen[$sa]=='flower_bed')
		{
			$html.= "Flower Bed";
		}else if($spl_amen[$sa]=='cake_rate')
		{
			$html.= "Special Cake";
		}
		if(isset($spl_amen[$sa+1]))
		{
			$html.= ",&nbsp;";
		}
		}
		$html.='</td>
      </tr>';
	  }
	  $html.='<tr>
        <td height="25px">Billing</td>
        <td height="25px">';
		$html.=$row_sspro1['sty_date']."/DVI-HTL-".$idd[1];
		$html.='</td>
      </tr>
      
      <tr>
        <td height="25px">Customer Care Numbers</td>
        <td height="25px">';
		
		$agent = $conn->prepare("SELECT * FROM agent_pro where agent_id =?");
		$agent->execute(array($row_orders['agent_id']));
		$row_agent = $agent->fetch(PDO::FETCH_ASSOC);
		$totalRows_agent = $agent->rowCount();

		$html.= "24*7 @ All India Customer Care - 9843288844";
		$html.='</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center; font-weight: bold;border:none">&nbsp;</td>
        </tr>
		<tr>
        <td colspan="2" style="text-align: center; font-weight: bold;border:none">DVI Holidays wishes you a pleasant stay</td>
        </tr>
      <tr>
        <td style="border:none">&nbsp;</td>
        <td style="border:none"><p style="font-weight: bold; font-family:; font-size: 14px; text-align: right; margin-right:10px;">Authorised Signatory,</p></td>
      </tr>
      <tr>
        <td colspan="2" style="border:none"><p style="font-family: ; text-align: right;"><strong style="font-size:10px">(System generated voucher. No signature required.)</strong></p></td>
      </tr>
      
	   
      <tr>
        <td colspan="2" style="text-align: left">';
		$html.='<b>General Policies</b><br>
                                <b>As per Government of India rules, it is mandatory for all guests over the age of 18 years to present a valid photo identification ( ID ) on check-in.</b><br>
                                <b>Entry to the hotel is at the sole discretion of the hotel authority. If the address on the photo identification card matches the city where the hotel is located, the hotel may refuse to provide accommodation.</b><br>
                                <b>Dvi will not be responsible for any check-in denied by the hotel due to the aforesaid reasons. Due to any natural or political or local issues if there is any damage to personal or tour DVI may not take the responsibility.</b><br>
                                <b>If the booking includes the extra bed it is facilitated with a folding cot or a mattress as an extra bed, as pert eh hotel policy.</b><br>';
		$html.='</td>
      </tr>
    </table></td>
  </tr>
 </table></td></tr></table>';
			if($totalRows_sp2>1)
			{
				for($rt=0;$rt<$derf-1;$rt++)
				{
					$row_sspro1 = $sspro1->fetch(PDO::FETCH_ASSOC);
				}
			}	
	
	}//while end
}
                            
						$html.='</div>
</body>
<html>';

//echo $html;
$fnfile=$row_orders['tr_name'].'_'.$_GET['planid']."'s_hotel_voucher.pdf";
$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream($fnfile, array("Attachment" => false));
?>