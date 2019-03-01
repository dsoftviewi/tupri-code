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

//$idd=explode('#',$_GET['planid']);
$str="3029";
//print_r($idd);

$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($str));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();

$html='<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<table width="100%" border="0">
  <tr>
    <td colspan="6"> <img src="../images/dvi_pdf1.png" alt="DVI Logo" style="margin-top:20px;"/></td>
  </tr>
  
  <tr>
    <td width="29%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 62px">Welcomes</td>
  </tr>
  <tr>
    <td colspan="6" style="text-align: center; font-family:sans-serif; font-weight: bold; font-size: 62px;"> Mr/Mrs.Srinivas</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Arrival flight/Train Details</font></td>
    <td><strong>:</strong></td>
    <td width="22%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">1234</font></td>
    <td width="16%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Guest Mobile No</font></td>
    <td width="1%"><strong>:  </strong></td>
    <td width="30%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">9857777412</font></td>
  </tr>
  <tr>
    <td><font style="font-weight: bold; text-align: center; font-family:sans-serif; font-size: 12px">Departure flight/ Train Details  </font></td>
    <td><strong>:</strong></td>
    <td><font style="font-weight: bold; text-align: center; font-family:sans-serif; font-size: 12px">6546</font></td>
    <td><font style="font-weight: bold; text-align: center; font-family:sans-serif; font-size: 12px">Guest MailID</font></td>
    <td><strong>:</strong></td>
    <td> <font style="font-weight: bold; text-align: center; font-family:sans-serif; font-size: 12px">admin@gmail.com</font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="0">
      <tr >
        <td colspan="3"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Hotel Details:</font></td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr >
        <td width="12%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Guest Name</font></td>
        <td width="1%">:</td>
        <td width="87%"><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px"> Mr.xxxxxxxxxxx</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Occupancy</font></td>
        <td>:</td>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">01 Double Room</font></td>
      </tr>
      <tr>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Meal Plan</font></td>
        <td>:</td>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">MAPAI</font></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="0">
      <tr style="font-weight: bold; text-align: left; font-family:sans-serif; font-size: 12px">
        <td width="5%">Sno</td>
        <td width="11%">Date</td>
        <td width="18%">Place</td>
        <td width="32%">Hotel</td>
        <td width="18%">Room Category</td>
        <td width="16%">T Nights</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>1</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>2</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>3</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>4</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>5</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>6</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>7</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
      <tr style="text-align: left; font-family:sans-serif; font-size: 12px">
        <td>8</td>
        <td>14-16-Apr</td>
        <td>Munar</td>
        <td>Hotel Hill View</td>
        <td>Deluxe</td>
        <td>2</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Itenary Details:</font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="6">
    <table width="100%" border="0">
      <tr>
        <td width="14%" rowspan="3" style="background-color:#E9E9E9"><p style="text-align:center; font-family:sans-serif; font-size: 12px;">14th Apr</p></td>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Arrival - Cochi- Munnar - 150 kms </font>( 4 hrs up hill drive ) - ( SG 3236 MAA 10.35 hrs COK 11.55 hrs )</td>
      </tr>
      <tr>
        <td>Overnight Munnar</td>
      </tr>
      <tr>
        <td><p style="text-align:justify; font-family:sans-serif; font-size: 12px">Lorem Ipsumis simply dummy text of the printing and   typesetting industry. Lorem Ipsum has been the industrys standard   dummy text ever since the 1500s, when an unknown printer took a galley   of type and scrambled it to make a type specimen book. It has survived   not only five centuries, but also the leap into electronic typesetting,   remaining essentially unchanged. It was popularised in the 1960s with   the release of Letraset sheets containing Lorem Ipsum passages, and more   recently with desktop publishing software like Aldus PageMaker   including versions of Lorem Ipsum.</p></td>
      </tr>
     </table>
    </td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">
    <table width="100%" border="0">
      <tr>
        <td width="14%" rowspan="3" style="background-color:#E9E9E9"><p style="text-align:center; font-family:sans-serif; font-size: 12px;">15th Apr</p></td>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Arrival - Cochi- Munnar - 150 kms </font>( 4 hrs up hill drive ) - ( SG 3236 MAA 10.35 hrs COK 11.55 hrs )</td>
      </tr>
      <tr>
        <td>Overnight Munnar</td>
      </tr>
      <tr>
        <td><p style="text-align:justify; font-family:sans-serif; font-size: 12px">Lorem Ipsumis simply dummy text of the printing and   typesetting industry. Lorem Ipsum has been the industrys standard   dummy text ever since the 1500s, when an unknown printer took a galley   of type and scrambled it to make a type specimen book. It has survived   not only five centuries, but also the leap into electronic typesetting,   remaining essentially unchanged. It was popularised in the 1960s with   the release of Letraset sheets containing Lorem Ipsum passages, and more   recently with desktop publishing software like Aldus PageMaker   including versions of Lorem Ipsum.</p></td>
      </tr>
     </table>
    </td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">
    <table width="100%" border="0">
      <tr>
        <td width="14%" rowspan="3" style="background-color:#E9E9E9"><p style="text-align:center; font-family:sans-serif; font-size: 12px;">16th Apr</p></td>
        <td><font style="font-weight: bold; font-family:sans-serif; text-align: center; font-size: 12px">Arrival - Cochi- Munnar - 150 kms </font>( 4 hrs up hill drive ) - ( SG 3236 MAA 10.35 hrs COK 11.55 hrs )</td>
      </tr>
      <tr>
        <td>Overnight Munnar</td>
      </tr>
      <tr>
        <td><p style="text-align:justify; font-family:sans-serif; font-size: 12px">Lorem Ipsumis simply dummy text of the printing and   typesetting industry. Lorem Ipsum has been the industrys standard   dummy text ever since the 1500s, when an unknown printer took a galley   of type and scrambled it to make a type specimen book. It has survived   not only five centuries, but also the leap into electronic typesetting,   remaining essentially unchanged. It was popularised in the 1960s with   the release of Letraset sheets containing Lorem Ipsum passages, and more   recently with desktop publishing software like Aldus PageMaker   including versions of Lorem Ipsum.</p></td>
      </tr>
     </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>'.
 
  $html='<tr>
    <td colspan="6"><font style="font-weight: bold; color:#900; font-family:sans-serif; text-align: center; font-size: 16px">Voucher Details:</font></td>
  </tr>
 <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="0">
      <tr>
        <td><font style="font-weight: bold; float:left; font-family:sans-serif; text-align: left; font-size: 12px; margin-left:5px">Voucher Date : 08.05.2015</font> </td>
        <td><font style="font-weight: bold; float:right; font-family:sans-serif; text-align: left; font-size: 12px; margin-right:5px">Voucher No : 14.04.2015/DVI-HTL-704</font></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="1" style="font-family: sans-serif; text-align: left; font-size: 12px">
      <tr>
        <td colspan="2" style="text-align: center; font-weight: bold;">Hotel Exchange Voucher</td>
        </tr>
      <tr>
        <td width="48%">Guest Name</td>
        <td width="52%">Mr.xxxxxxxxxxxx</td>
      </tr>
      <tr>
        <td>Check In Date</td>
        <td>14.04.2015</td>
      </tr>
      <tr>
        <td>Check Out Date</td>
        <td>16.04.2015</td>
      </tr>
      <tr>
        <td>Hotel Name</td>
        <td>Hotel Hill View - Munnar</td>
      </tr>
      <tr>
        <td>Address</td>
        <td><p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx,</p></td>
      </tr>
      <tr>
        <td>Accommodation</td>
        <td>01 Double Room</td>
      </tr>
      <tr>
        <td>Room Category</td>
        <td>Deluxe</td>
      </tr>
      <tr>
        <td>Total Rooms</td>
        <td>01</td>
      </tr>
      <tr>
        <td>Meal Plan</td>
        <td>MAPAI (Break fast &amp; Lunch)</td>
      </tr>
      <tr>
        <td>Billing</td>
        <td>Room on Meal Plan</td>
      </tr>
      <tr>
        <td>Confirmed By</td>
        <td>Mr.xxxxxxxxxxx</td>
      </tr>
      <tr>
        <td>Customer Care Numbers</td>
        <td>0000000000000000000000</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center; font-weight: bold;">DVI Holidays wishes you a pleasant stay</td>
        </tr>
      <tr>
        <td colspan="2" style="text-align: center">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><p style="font-weight: bold; font-family:sans-serif; font-size: 12px; float:right; margin-right:10px;margin-top:-2px;">Authorised Signatory,</p></td>
      </tr>
      <tr>
        <td style="text-align: center">&nbsp;</td>
        <td><p style="font-family: sans-serif; font-size: 12px; float: right; margin-right: 10px; margin-top: -2px;">xxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left; font-weight: bold;">General policies :</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
	  <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
      </tr>
	  
    </table></td>
  </tr>
   <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr> <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr> <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr> <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr> <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr> <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="0">
         <tr>
        <td><font style="font-weight: bold; float:left; font-family:sans-serif; text-align: center; font-size: 12px; margin-left:5px">Dear : Mr. xxxxxxxxxxxxxxx</font> </td>
        <td><font style="font-weight: bold; float:right; font-family:sans-serif; text-align: center; font-size: 12px; margin-right:5px">Tour Dae : 14th April 2015 to 21th April 2015 </font></td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="0" style="font-family: sans-serif; text-align: left; font-size: 12px">
      <tr>
        <td colspan="2" style="text-align: left; font-weight: bold;">Greetings from DVI Holidays !!!</td>
        </tr>
      <tr>
        <td colspan="2">Thank you for your choice to use DVI Holidays</td>
        </tr>
      <tr>
        <td colspan="2">The Motto of our company is to provide satisfactory servies to our entire guest. In order to achevieve this aim, we need to know your opinion on it. prasie would be a motivation for us to continue our services. And any critic would naturally be a reason for us to improve our services according to the requirements and desires of our Guests.</td>
        </tr>
      <tr>
        <td colspan="2"><strong>Please tell your Friends what would you like about us!</strong></td>
        </tr>
      <tr>
        <td colspan="2"><strong>Please tell us what you dislike.</strong></td>
        </tr>
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="20%"><p>1) Tell Us about the vechiles and its drivers for your whole trip?</p></td>
      </tr>
      <tr>
        <td height="22">&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vechile provided :</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;2) Is the vechile is on Time at the airport on your arrival?</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vechle Provided : </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>3) &nbsp; How about the drivers services to you?</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Driver Name : </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">Tell us about the hotels which you have been used for your whole trip.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left; font-weight: bold;">Day 1 : Munar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hotel Hill View &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Check-In : 14.04.2015 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check-Out: 16.04.2015</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left"><table width="100%" border="0"  style="font-family: sans-serif; text-align: left; font-size: 12px">
          <tr>
            <td width="6%">Rooms</td>
            <td width="9%" style="text-align: center">Poor</td>
            <td width="9%" style="text-align: center">Good</td>
            <td width="11%" style="text-align: center">Very Good</td>
            <td width="9%" style="text-align: center">Excellent</td>
            <td width="56%">&nbsp;</td>
            </tr>
          <tr>
            <td>Food</td>
            <td style="text-align: center">Poor</td>
            <td style="text-align: center">Good</td>
            <td style="text-align: center">Very Good</td>
            <td style="text-align: center">Excellent</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>Staff</td>
            <td style="text-align: center">Poor</td>
            <td style="text-align: center">Good</td>
            <td style="text-align: center">Very Good</td>
            <td style="text-align: center">Excellent</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="6">Anything needs to be improved, please Mention.</td>
            </tr>
          
          
          <tr>
            <td colspan="6">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left; font-weight: bold;">Day 2 : Munar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hotel Hill View &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Check-In : 14.04.2015 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check-Out: 16.04.2015</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left"><table width="100%" border="0"  style="font-family: sans-serif; text-align: left; font-size: 12px">
          <tr>
            <td width="6%">Rooms</td>
            <td width="9%" style="text-align: center">Poor</td>
            <td width="9%" style="text-align: center">Good</td>
            <td width="11%" style="text-align: center">Very Good</td>
            <td width="9%" style="text-align: center">Excellent</td>
            <td width="56%">&nbsp;</td>
            </tr>
          <tr>
            <td>Food</td>
            <td style="text-align: center">Poor</td>
            <td style="text-align: center">Good</td>
            <td style="text-align: center">Very Good</td>
            <td style="text-align: center">Excellent</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>Staff</td>
            <td style="text-align: center">Poor</td>
            <td style="text-align: center">Good</td>
            <td style="text-align: center">Very Good</td>
            <td style="text-align: center">Excellent</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="6">Anything needs to be improved, please Mention.</td>
            </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left; font-weight: bold;">Day 3 : Munar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hotel Hill View &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Check-In : 14.04.2015 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check-Out: 16.04.2015</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left"><table width="100%" border="0"  style="font-family: sans-serif; text-align: left; font-size: 12px">
          <tr>
            <td width="6%">Rooms</td>
            <td width="9%" style="text-align: center">Poor</td>
            <td width="9%" style="text-align: center">Good</td>
            <td width="11%" style="text-align: center">Very Good</td>
            <td width="9%" style="text-align: center">Excellent</td>
            <td width="56%">&nbsp;</td>
          </tr>
          <tr>
            <td>Food</td>
            <td style="text-align: center">Poor</td>
            <td style="text-align: center">Good</td>
            <td style="text-align: center">Very Good</td>
            <td style="text-align: center">Excellent</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Staff</td>
            <td style="text-align: center">Poor</td>
            <td style="text-align: center">Good</td>
            <td style="text-align: center">Very Good</td>
            <td style="text-align: center">Excellent</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6">Anything needs to be improved, please Mention.</td>
          </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left">&nbsp;</td>
      </tr>
  </table>

</body>
</html>';


$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream("dis.pdf", array("Attachment" => false));

//$pdf = $dompdf->output();
?>