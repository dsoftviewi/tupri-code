<?php
ini_set('max_execution_time', '-1');
ini_set('memory_limit', '-1');
require_once('../Connections/divdb.php');
/** PHPExcel */
include '../xl_up/Classes/PHPExcel.php';
/** PHPExcel_Writer_Excel2007 */
include '../xl_up/Classes/PHPExcel/Writer/Excel2007.php';
// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();
// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Roja MM");
$objPHPExcel->getProperties()->setLastModifiedBy("Elysium Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);

 $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
	
$sty = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        )
    );	
$styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      );
         
  
  $objPHPExcel->getDefaultStyle("A1:G1")->applyFromArray($style);
   $objPHPExcel->getDefaultStyle("A6:G6")->applyFromArray($sty);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(5, 7);
 
		$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hotel_id');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Hotel_name');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Location');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'City');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Category');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Type');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Lunch');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Dinner');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Child with bed');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Child without bed');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Flower bed');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Candle light');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Cake');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Fruit Basket');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Season1(18th March to 14th April)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Season2(15th April to 30th April)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Season3(01st May to 31st May)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Season4 (01st Jun to 14th Jun)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Season 5(15th Jun 30th Jun)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Season 6(01st Jul to 31st Jul )');
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Season 7 (01st Aug to 15 Aug)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Season 8(16th Aug to 10th Sep)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Season 9(11st Sep to 30th Sep)');
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);


$htpro = $conn->prepare("SELECT * FROM hotel_pro  ORDER BY sno ASC");
$htpro->execute();
$row_htpro_main = $htpro->fetchAll();
$totalRows_htpro =$htpro->rowCount();
$i=2;
	foreach($row_htpro_main as $row_htpro)
	{
$loc=trim($row_htpro['location']);
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i,$row_htpro['hotel_id']);
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i,$row_htpro['hotel_name']);
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i,$loc);
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i,$row_htpro['city']);
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i,$row_htpro['category']);


$hotel_season = $conn->prepare("SELECT * FROM hotel_season WHERE hotel_id=? ORDER BY sno ASC");
$hotel_season->execute(array($row_htpro['hotel_id']));
$row_hotel_season_main =$hotel_season->fetchAll();
$room_type=$season1=$season2=$season3=$season4=$season5=$season6=$season7=$season8=$season9='';
foreach($row_hotel_season_main as $row_hotel_season){
	$room_type.=$row_hotel_season['room_type']."\\";
	$season1.=$row_hotel_season['season1_rate']."\\";
	$season2.=$row_hotel_season['season2_rate']."\\";
	$season3.=$row_hotel_season['season3_rate']."\\";
	$season4.=$row_hotel_season['season4_rate']."\\";
	$season5.=$row_hotel_season['season5_rate']."\\";
	$season6.=$row_hotel_season['season6_rate']."\\";
	$season7.=$row_hotel_season['season7_rate']."\\";
	$season8.=$row_hotel_season['season8_rate']."\\";
	$season9.=$row_hotel_season['season9_rate']."\\";
}
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i,substr($room_type,0,-1));



$hotel_food = $conn->prepare("SELECT * FROM hotel_food WHERE hotel_id=? ORDER BY sno ASC");
$hotel_food->execute(array($row_htpro['hotel_id']));
$row_hotel_food = $hotel_food->fetch(PDO::FETCH_ASSOC);
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i,$row_hotel_food['lunch_rate']);
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i,$row_hotel_food['dinner_rate']);
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i,$row_hotel_food['child_with_bed']);
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i,$row_hotel_food['child_without_bed']);
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i,$row_hotel_food['flower_bed']);
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i,$row_hotel_food['candle_light']);
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i,$row_hotel_food['cake_rate']);
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i,$row_hotel_food['fruit_basket']);
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i,substr($season1,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i,substr($season2,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i,substr($season3,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$i,substr($season4,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i,substr($season5,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('T'.$i,substr($season6,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('U'.$i,substr($season7,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('V'.$i,substr($season8,0,-1));
$objPHPExcel->getActiveSheet()->SetCellValue('W'.$i,substr($season9,0,-1));
$i++;
	}	

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');

// //echo date('H:i:s') , " Set document security" , EOL;
// $objPHPExcel->getSecurity()->setLockWindows(true);
// $objPHPExcel->getSecurity()->setLockStructure(true);
// $objPHPExcel->getSecurity()->setWorkbookPassword("PHPExcel");
// // Set sheet security
// //echo date('H:i:s') , " Set sheet security";
// $objPHPExcel->getActiveSheet()->getProtection()->setPassword('PHPExcel');
// $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); // This should be enabled in order to enable any of the following!
// $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);		
// Save Excel 2007 file
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$objWriter->save(str_replace('mas_excel.php', '.xlsx','../uploadexcel/Sample/hotel/sample_update_hoted_details.xlsx'));
	

echo "0";



?>