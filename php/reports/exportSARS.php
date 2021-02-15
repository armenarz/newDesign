<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../../../PHPExcel-1.8/Classes/PHPExcel.php";
require_once "../../../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php";

if(!isset($_POST["startDate"]) || !isset($_POST["endDate"]))
{
    $msg .= "The reporting period is not defined.";
    echo $msg;
    return;
}
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

$startTime = "";
if(isset($_POST["startTime"]))
{
    $startTime = $_POST["startTime"];
}

$endTime = "";
if(isset($_POST["endTime"]))
{
    $endTime = $_POST["endTime"];
}

if(!isset($_POST["menuId"]))
{
    $msg .= "The menu id is not defined. menuId=".$_POST["menuId"];
    echo $msg;
    return;
}
$menuId = $_POST["menuId"];

$filter = "";

$doctorId = $_POST["doctorId"];
if($doctorId > 0)
{
    $filter = " and orders.DoctorId='".$doctorId."' ";
}
else
{
    $filter = ' ';
}

if($_POST["BezSARSCheck"]=="true")
{
    $BezSARSCheck = 1;
}
elseif($_POST["BezSARSCheck"]=="false")
{
    $BezSARSCheck = 0;
}

if($_POST["onlyArmenian"]=="true")
{
    $onlyArmenian = 1;
}
elseif($_POST["onlyArmenian"]=="false")
{
    $onlyArmenian = 0;
}

if($BezSARSCheck == 1) {
	$filter .= " AND orders.is_bez_kov = '$BezSARSCheck'";
}

if($menuId == "SARSLink")
{
    $arr = array(   'Դրական/ positive/ положительный' => 'Դրական', 
                    'Դրական/positive/положительный' => 'Դրական',
                    'Բացասական/ negative/ отрицательный' => 'Բացասական',
                    'Բացասական/ Отрицательный/ Negative' => 'Բացասական',
                    'Բացասական/negative/отрицательный' => 'Բացասական'
                    );

    $xls = new PHPExcel();

    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();
    $sheet->setTitle("Sars");

    ///Параметры печати
    // Формат
    $sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
    
    // Ориентация
    // ORIENTATION_PORTRAIT — книжная
    // ORIENTATION_LANDSCAPE — альбомная
    $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
    
    // Поля
    $sheet->getPageMargins()->setTop(1);
    $sheet->getPageMargins()->setRight(0.75);
    $sheet->getPageMargins()->setLeft(0.75);
    $sheet->getPageMargins()->setBottom(1);
    
    // Верхний колонтитул
    $sheet->getHeaderFooter()->setOddHeader("Название листа");
    
    // Нижний колонтитул
    $sheet->getHeaderFooter()->setOddFooter('&L&B Название листа &R Страница &P из &N');


    //title
    $sheet->setCellValueExplicit("A1", 'Անուն', PHPExcel_Cell_DataType::TYPE_STRING);

    $sheet->setCellValueExplicit("B1", 'Ազգանուն', PHPExcel_Cell_DataType::TYPE_STRING);

    $sheet->setCellValueExplicit("C1", 'Ծննդյան ամսաթիվ', PHPExcel_Cell_DataType::TYPE_STRING);

    $sheet->setCellValueExplicit("D1", 'ՀԾՀ', PHPExcel_Cell_DataType::TYPE_STRING);

    $sheet->setCellValueExplicit("E1", 'Բարկոդ', PHPExcel_Cell_DataType::TYPE_STRING);

    $sheet->setCellValueExplicit("F1", 'Ամսաթիվ', PHPExcel_Cell_DataType::TYPE_STRING);

    $sheet->setCellValueExplicit("G1", 'Առաջադրանքի պատասխանի ամսաթիվ', PHPExcel_Cell_DataType::TYPE_STRING);
                
    $sheet->setCellValueExplicit("H1", 'Թեստավորման պատասխան', PHPExcel_Cell_DataType::TYPE_STRING);	
            
    $sheet->setCellValueExplicit("I1", 'Թեստավորման ամսաթիվ', PHPExcel_Cell_DataType::TYPE_STRING);
                    
    $sheet->setCellValueExplicit("J1", 'Նմուշառման ամսաթիվ', PHPExcel_Cell_DataType::TYPE_STRING);
                
    $sheet->setCellValueExplicit("K1", 'Կրկնակի թեստավորման տարբերություն', PHPExcel_Cell_DataType::TYPE_STRING);	
                    
    $sheet->setCellValueExplicit("L1", 'Կրկնակի թեստավորում', PHPExcel_Cell_DataType::TYPE_STRING);

    $sheet->setCellValueExplicit("M1", 'Ուղեգրող հաստատություն', PHPExcel_Cell_DataType::TYPE_STRING);
                        
    $sheet->setCellValueExplicit("N1", 'Գրանցման հասցե', PHPExcel_Cell_DataType::TYPE_STRING);
                
    $sheet->setCellValueExplicit("O1", 'Բնակության հասցե', PHPExcel_Cell_DataType::TYPE_STRING);	
        
    $sheet->setCellValueExplicit("P1", 'OrderId', PHPExcel_Cell_DataType::TYPE_STRING);
                
    $sheet->setCellValueExplicit("Q1", 'Համար', PHPExcel_Cell_DataType::TYPE_STRING);			
                
    //data		
    /* $sql = "SELECT 
                pacients.FirstName,
                pacients.LastName,
                pacients.birthday,
                pacients.dopolnitelno,
                orderresult.OrderId,
                orderresult.AnalysisResult
                FROM orderresult
                INNER JOIN orders ON orders.OrderId=orderresult.OrderId
                INNER JOIN pacients ON pacients.id=orders.pac_id
                WHERE orders.OrderDate >= '$startDate' and orders.OrderDate <= '$endDate'
                    AND orderresult.ReagentId = '1142' and orderresult.double_check = '1'						
                ORDER BY orderresult.OrderId"; */
    /*
    $sql = "SELECT 
                pacients.FirstName,
                pacients.LastName,
                pacients.birthday,
                pacients.dopolnitelno,
                orderresult.OrderId,
                orderresult.AnalysisResult,
                orders.DoctorId
            FROM 
            (
                SELECT * FROM 
                (
                    SELECT 
                        orderid, 
                        check_method AS reagent_id, 
                        chkk, 
                        check_date, 
                        block_or_dbl 
                    FROM quality_vvod_d 
                    WHERE 
                        check_date >= '".$startDate." ".$startTime."' AND 
                        check_date <= '".$endDate." ".$endTime."' AND 
                        chkk=1 AND 
                        block_or_dbl='dbl' AND
                        check_method='1142'
                    ORDER BY orderid, check_method, check_date DESC
                ) AS r
                GROUP BY r.orderid, r.reagent_id
                ORDER BY r.orderid, r.reagent_id
            ) AS t
            INNER JOIN orders ON orders.OrderId=t.orderid
            INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
            INNER JOIN doctor ON orders.DoctorId=doctor.DoctorId
            INNER JOIN pacients ON orders.pac_id=pacients.id
            WHERE $filter
            ORDER BY t.orderid
            "; */               
    
	$sql0 = "select quality_vvod_d.orderid 
			from orders
			INNER JOIN quality_vvod_d ON orders.OrderId = quality_vvod_d.orderid
	        WHERE 
				quality_vvod_d.check_date >= '".$startDate." ".$startTime."' AND 
				quality_vvod_d.check_date <= '".$endDate." ".$endTime."' AND 
				(quality_vvod_d.check_method='1142' or quality_vvod_d.check_method='1166')
				and quality_vvod_d.chkk = 1
				$filter
				GROUP BY quality_vvod_d.orderid
	";
	
	$res0 = mysqli_query($link,$sql0);
	
	$arr22 = array();
	
	while($row0 = mysqli_fetch_array($res0))
	{
		array_push($arr22, $row0["orderid"]);
	}
	
	$cnt = count($arr22);
	
	$arr33 = array();
	
	for($i=0; $i<$cnt; $i++)
	{
		$orderid = $arr22[$i];
		
		$sql0 = "SELECT chkk 
				FROM quality_vvod_d 
				WHERE orderid = '$orderid'
				AND (check_method='1142' or check_method='1166' )
				ORDER BY check_date DESC
				LIMIT 0,1
		";
		
		$res0 = mysqli_query($link,$sql0);
		
		$row0 = mysqli_fetch_array($res0);
		
		if($row0["chkk"] == 1)
		{
			array_push($arr33, $orderid);
		}		
	}
	
	$cnt = count($arr33);
	$i = 1;
	
	for($k=0; $k<$cnt; $k++)
	{
		$orderid = $arr33[$k];
		
		$sql = "SELECT 					
					pacients.FirstName,
					pacients.LastName,
					pacients.birthday,
					pacients.dopolnitelno,
					orderresult.AnalysisResult
				FROM orders				
				INNER JOIN pacients ON orders.pac_id=pacients.id
				INNER JOIN orderresult ON orders.OrderId=orderresult.OrderId
				WHERE orderresult.OrderId = '$orderid'
					AND (orderresult.ReagentId = '1142' or orderresult.ReagentId = '1166' )
			
		";
	
		$res = mysqli_query($link,$sql);
		if($res)
		{
			
			$row = mysqli_fetch_array($res);
			
			$i++;
			
            $firstName = $row["FirstName"];
            $lastName = $row["LastName"];

            if($onlyArmenian == 1)
            {
                $tempFirtsName = explode(" ",$firstName);
                $firstName = $tempFirtsName[0];
                $tempLastName = explode(" ",$lastName);
                $lastName = $tempLastName[0];
            }

			$d1 = $row["birthday"];
			$date = new DateTime("$d1");
			
			$date_format = $date->format('Y-m-d');
			
			$sheet->setCellValueExplicit("A".$i, $firstName, PHPExcel_Cell_DataType::TYPE_STRING);
			
			$sheet->setCellValueExplicit("B".$i, $lastName, PHPExcel_Cell_DataType::TYPE_STRING);

			$sheet->setCellValueExplicit("C".$i, $row["birthday"], PHPExcel_Cell_DataType::TYPE_STRING);

			$sheet->setCellValueExplicit("D".$i, $row["dopolnitelno"], PHPExcel_Cell_DataType::TYPE_STRING);

			$sheet->setCellValueExplicit("E".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);

			$sheet->setCellValueExplicit("F".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);

			$sheet->setCellValueExplicit("G".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
						
			$sheet->setCellValueExplicit("H".$i, $arr[$row["AnalysisResult"]], PHPExcel_Cell_DataType::TYPE_STRING);	
					
			$sheet->setCellValueExplicit("I".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
							
			$sheet->setCellValueExplicit("J".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
						
			$sheet->setCellValueExplicit("K".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);	
					
			$sheet->setCellValueExplicit("L".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
							
			$sheet->setCellValueExplicit("M".$i, "ՊՐՈՄ-ՏԷՍՏ ՍՊԸ", PHPExcel_Cell_DataType::TYPE_STRING);

			$sheet->setCellValueExplicit("N".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
								
			$sheet->setCellValueExplicit("O".$i, "", PHPExcel_Cell_DataType::TYPE_STRING);
						
			$sheet->setCellValueExplicit("P".$i, $orderid, PHPExcel_Cell_DataType::TYPE_STRING);
						
			$sheet->setCellValueExplicit("Q".$i, ($i-1), PHPExcel_Cell_DataType::TYPE_STRING);				
				
			
		}
	}
}

header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sars.xls");
	
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('php://output'); 	

?>