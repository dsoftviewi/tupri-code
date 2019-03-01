<?php 
require_once("../assets/dompdf-master/dompdf_config.inc.php");
include('../Connections/divdb.php');
mysql_select_db($database_divdb, $divdb);
$query_seo = "SELECT * FROM dvi_packages where sno='".$_GET['pack_id']."'";
$seo = mysql_query($query_seo, $divdb) or die(mysql_error());
$row_seo = mysql_fetch_assoc($seo);
$totalRows_seo = mysql_num_rows($seo);
ob_end_clean();
ob_start();
$html='';
if(strpos($row_seo['day_title'],'~'))
{
$exdaytitle=explode('~',$row_seo['day_title']);
$expackdesc=explode('~',$row_seo['p_d']);
$expackimg=explode('~',$row_seo['pack_img']);
$expacklocatg=explode('~',$row_seo['day_locat']);
	
$html=
'<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" /> 
<style type="text/css">
 body { 
 font-family: verdana, sans-serif;
 border:1px solid #000;
 } 
 .small {
    line-height: 15%;
	border-bottom:1px #000000 solid;
}
 
 .font_style{
	 font-weight:600;
	 font-family: verdana, sans-serif;
	 font-size:14px
	 line-height: 1%;
	 }

</style>
</head>
<body>
<table width="100%">
<tr>
<td>
<img src="../images/Dvi Hols.png" width="120px" height="120px" style="float:right;margin-top:15px;margin-right:15px">
</td></tr>
</table><br><br><br>
<table width="100%">
<tr style="color:red;">
<td>
<div style="margin-left:50px;">DVI HOLIDAY SPAECIAL PACKAGE</div></td>
</tr>
</table><br/>
<table width="100%" style="margin:20px;">
';
$i=0;
do{
	$html.=
'
<tr style="color:#1F4E79;">
<td>
<div style="margin-left:50px;">'.$exdaytitle[$i].' </div></td>
</tr>
<tr style="color:#C45811;">
<td>
<div style="margin-left:50px;font-size:14px;margin-top:10px;border-bottom:1px dotted #C45811;margin-bottom:10px">'.$expacklocatg[$i].' </div></td>
</tr>
<tr><td>
<div style="width:100%">
<div style="margin-left:50px;width:26%;position:relative;float:left;margin-top:20px">
<p style="text-align:justify;word-wrap:break-word;width:100%;margin:0px;padding:0px">
<img src="../packages/images/'.$expackimg[$i].'" width="200px" height="120px" style="margin-right:10px"></p>
</div>
<div style="margin-left:50px;width:100%;font: bold 13px roboto;color: #1F4E79;line-height: 22px;margin-top:20px;">
<p style="text-align:justify;width:100%;margin:0px;padding:0px">
'.$expackdesc[$i].' </p></div>
</div>
</td></tr>';

 $i++; }while($i<count($exdaytitle));
$html.= '
</table>
</body>
</html>
';
}else{
$html=
'<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" /> 
<style type="text/css">
 body { 
 font-family: verdana, sans-serif;
 border:1px solid #000;
 } 
 .small {
    line-height: 15%;
	border-bottom:1px #000000 solid;
}
 
 .font_style{
	 font-weight:600;
	 font-family: verdana, sans-serif;
	 font-size:14px
	 line-height: 1%;
	 }

</style>
</head>
<body>
<table width="100%">
<tr>
<td>
<img src="images/Dvi Hols.png" width="120px" height="120px" style="float:right;margin-top:15px;margin-right:15px">
</td></tr>
</table><br><br><br>
<table width="100%">
<tr style="color:red;">
<td>
<div style="margin-left:50px;">DVI HOLIDAY SPAECIAL PACKAGE</div></td>
</tr>
</table><br/>
<table width="100%" style="margin:20px;">

<tr style="color:#1F4E79;">
<td>
<div style="margin-left:50px;">'.$row_seo['day_title'].' </div></td>
</tr>
<tr style="color:#C45811;">
<td>
<div style="margin-left:50px;font-size:14px;margin-top:10px;border-bottom:1px dotted #C45811;margin-bottom:10px">'.$row_seo['day_locat'].' </div></td>
</tr>
<tr><td>
<div style="width:100%">
<div style="margin-left:50px;width:26%;position:relative;float:left;margin-top:20px">
<p style="text-align:justify;word-wrap:break-word;width:100%;margin:0px;padding:0px">
<img src="../packages/images/'.$row_seo['pack_img'].'" width="200px" height="120px" style="margin-right:10px"></p>
</div>
<div style="margin-left:50px;width:100%;font: bold 13px roboto;color: #1F4E79;line-height: 22px;margin-top:20px;">
<p style="text-align:justify;width:100%;margin:0px;padding:0px">
'.$row_seo['p_d'].' </p></div>
</div>
</td></tr>
</table>
</body>
</html>
';
}
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream("App_list.pdf", array("Attachment" => false));
?>
