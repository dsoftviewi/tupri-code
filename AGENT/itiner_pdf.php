<?php 
require_once("../assets/dompdf-master/dompdf_config.inc.php");
require_once("../Connections/divdb.php");

$id=$_GET['planid'];


$orders = $conn->prepare("SELECT * FROM travel_master where plan_id =?");
$orders->execute(array($id));
$row_orders = $orders->fetch(PDO::FETCH_ASSOC);
$totalRows_orders = $orders->rowCount();

$html=
'
<link href="../assets/css/pdf_design.css" rel="stylesheet" />
<body>
<div>
<img src="../images/logo2.png">
<h1 align="center" style="opacity:10.0; margin-top:-30">Plan Details</h1>
</div>

<div  style="opacity:10.0;">
<h3 > Planid: '.$id.' </h3>
</div>';

	if(substr($row_orders['plan_id'],0,1) != 'H')
	{
		
		$routes = $conn->prepare("SELECT * FROM travel_sched where travel_id =?");
		$routes->execute(array($_GET['planid']));
		$row_routes_main = $routes->fetchAll();
		$totalRows_routes = $routes->rowCount();
									
        $html.='<div class="CSSTableGenerator">
        <table align="center">
        <tr>
		   <td>
		   DAY
		   </td>
           <td>
           TRAVEL DATE
           </td>
           <td>
           TRAVEL FROM
           </td>
		   <td>
			TRAVEL TO
			</td>
			<td>
			DRIVING DISTANCE(Kms)
			</td>
			<td>
			DRIVING TIME(approx.)
			</td>
           </tr>';
			$inc=1;
			foreach($row_routes_main as $row_routes)
			{
            $html.='
			<tr>
		   <td>
		  '.$inc.'
		   </td>
           <td>
          '.date("F jS, Y",strtotime($row_routes['tr_date'])).'
           </td>
           <td >
           '.$row_routes['tr_from_cityid'].'
           </td>
           <td>
          '.$row_routes['tr_to_cityid'].'
           </td>
			<td>
			 '.$row_routes['tr_dist'].'
			</td>
			<td>
			 '.$row_routes['tr_time'].'
			</td>
            </tr>';
			}
			
                    
            $html.='</table>';
		}
		$html.='</div>
		<body>';


$dompdf = new DOMPDF();
$dompdf->load_html($html);
  //$paper_size = array(0,0,612.00,792.00);
$dompdf->set_paper('A4','portrait');
$dompdf->render();
$dompdf->stream("dis.pdf", array("Attachment" => false));

?>