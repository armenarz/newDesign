<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../user_to_name.php";
require_once "labs_html.php";
require_once "lab_html.php";
require_once "lab1_html.php";

$start0 = microtime(true);

$msg = "";

if(!isset($_POST["menuId"]))
{
    $msg .= "The menu id is not defined. menuId=".$_POST["menuId"];
    echo $msg;
    return;
}
$menuId = $_POST["menuId"];

if(!isset($_POST["reportDate"]))
{
    $msg .= "The report date is not defined.";
    echo $msg;
    return;
}
$reportDate = $_POST["reportDate"];

if($menuId == "dailyLink")
{
    $msg.= '
    <table class="table table-bordered table-responsive table-fixed">
        <thead>
        ';
    $sql = "SELECT 
                id, 
                lab 
            FROM labs
			WHERE id != 1
            ORDER BY sorting
            ";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        if(mysqli_num_rows($result) >= 1)
        {
            $labs = array();
            $labs["Lab"] = "Lab";
            while($row = mysqli_fetch_array($result))
            {
                $labs[$row["lab"]] = $row["id"];
            }
            $labs["Lab1"] = "Lab1";
        }
    }
    $msg.= '
            <tr>
                <!--titles-->
                ';
    foreach($labs as $lab => $id)
    {
        $msg.= '<th class="text-center p-2">'.$lab.'</th>';
    }
    $msg.= '
            </tr>
        </thead>
        <tbody>
            <tr>';
    foreach($labs as $lab => $id)
    {
        $msg.= '<td>';
        if($lab == "Lab")
        {
            $msg.= createLabHTML($link, $reportDate);
        }
        elseif($lab == "Lab1")
        {
            $msg.= createLab1HTML($link, $reportDate);
        }
        else
        {
            $msg.= createLabsHTML($link, $lab, $id, $reportDate);
        }
        $msg.= '</td>';
    }    
    $msg.= '
            </tr>
            <tr>
            ';
    foreach($labs as $lab => $id)
    {
        $msg.= '<td><img width="270" height="1" src=""/></td>';
    }       
    $msg.= '</tr>
        </tbody>
    </table>
    ';
}

/*
$f = fopen("log_dnevnoj.txt", 'a');
$str ="\r\n" . $reportDate . " getDailyReport.php " . round(microtime(true) - $start0, 4) . ' sec.' . "\r\n";
fwrite($f, $str); 
fclose($f);
*/
//echo "\r\n" . $reportDate . " getDailyReport.php " . round(microtime(true) - $start0, 4) . ' sec.' . "\r\n";

echo $msg;
?>