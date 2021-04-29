<?php
header("Content-Type: application/xls");

require_once "../connect.php";
require_once "../authorization.php";
require_once "export_labs_html.php";
require_once "export_lab_html.php";
require_once "export_lab1_html.php";


$utf8_bom = chr(239).chr(187).chr(191);

$msg = $utf8_bom;

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
    <table class="table" border="1">
        <caption>
            <h2>Дневной</h2>
            <h3>на '.$reportDate.'</h3>
        </caption>
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
        </tbody>
    </table>
    ';
}

header("Content-Disposition: attachement; filename=daily.xls");
echo $msg;
?>