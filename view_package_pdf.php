<?php 
require_once("assets/dompdf-master/dompdf_config.inc.php");
include('Connections/divdb.php');

$seo = $conn->prepare("SELECT * FROM dvi_packages where sno=?");
$seo->execute(array($_GET['pack_id']));
$row_seo =$seo->fetch(PDO::FETCH_ASSOC);
$totalRows_seo = $seo->rowCount();
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
';
$i=0;
do{
	$html.=
'
<tr style="color:#1F4E79;">
<td valign="top" style="width:100px;">
<div style="margin-left:50px;margin-top:10px;">'.$exdaytitle[$i].' </div>
</td>
<td>
<div style="margin-left:50px;font-size:14px;margin-top:10px;margin-bottom:10px;">'.$expacklocatg[$i].' </div>
<div style="margin-left:50px;font-size:14px;margin-top:10px;margin-bottom:10px;text-align:justify;">'.$expackdesc[$i].' </div>
</td>
</tr>

';
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
<table width="100%" style="margin-right:20px;margin-top:20px;padding-right:20px;">

<tr style="color:#1F4E79;">
<td valign="top" style="width:100px;"><div style="margin-left:50px;margin-top:10px;">'.$row_seo['day_title'].'</td></div>
<td>
<div style="margin-left:50px;font-size:14px;margin-top:10px;margin-bottom:10px;">'.$row_seo['day_locat'].' </div>
<div style="margin-left:50px;font-size:14px;margin-top:10px;margin-bottom:10px;text-align:justify;">'.$row_seo['p_d'].' </div>
</td>
</tr>

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
