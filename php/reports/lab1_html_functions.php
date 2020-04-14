<?php
function sumAnalyzesLab1($link, $reportDate)
{
	$cena1 = 0;
	$sql = "SELECT 
                SUM(cena_analizov) AS cena 
            FROM orders 
            WHERE
                OrderDate='$reportDate' AND lab='lab1' AND usr != 'Davinci' AND usr != 'ARMMED' AND usr != 'Tonoyan' 
			";
	$result = mysqli_query($link, $sql);
	if($result)
	{
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result); 
            $cena1 = intval($row["cena"]);
        }
	}

	$cena2 = 0;
	$sql = "SELECT 
                (SUM(cena_analizov)/2) AS cena 
            FROM orders 
            WHERE 
                OrderDate='$reportDate' AND lab='lab1' AND usr = 'Davinci' 
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cena2 = intval($row["cena"]);
	}

	$cena3 = 0;
	$sql = "SELECT 
                (SUM(cena_analizov) * 0.7) AS cena 
            FROM orders 
            WHERE 
                OrderDate='$reportDate' AND lab='lab1' AND usr = 'ARMMED' 
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cena3 = intval($row["cena"]);
	}
	
	$cena4 = 0;
	$sql = "SELECT 
                (sum(cena_analizov) * 0.7) AS cena 
            FROM orders 
            WHERE 
                OrderDate='$reportDate' AND lab='lab1' AND usr = 'Tonoyan' 
            ";
	$result = mysqli_query($link, $sql);
	if($result)
	{
		$row = mysqli_fetch_array($result); 
		$cena4 = intval($row["cena"]);
	}
	
    $cena = $cena1 + $cena2 + $cena3 + $cena4;
    return $cena;
}
?>