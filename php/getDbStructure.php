<?php
header("Content-Type: application/xls");
require_once("connect.php");

$msg = "";
$utf8_bom = chr(239).chr(187).chr(191);

//getting table list
$msg.= 	'<table class="table" border="1">';
$msg.= 	    '<caption>';
$msg.= 	        '<h2>База данных: '.$my_db.'</h2>';
$msg.= 	        '<h3>Список таблиц</h3>';
$msg.= 	    '</caption>';
$msg.= 	    '<thead>';
$msg.=          '<tr>';
$msg.= 		        '<th scope="col">#</th>';
$msg.= 		        '<th scope="col">Название таблицы</th>';
$msg.=          '</tr>';
$msg.=	    '</thead>';
$msg.=	    '<tbody>';

$sql =  'SELECT table_name FROM information_schema.tables WHERE table_schema="'.$my_db.'"';
$result = mysqli_query($link,$sql);
$tables = array();
if($result)
{
    $i = 0;
    while($row = mysqli_fetch_array($result))
    {
        $i++;
        array_push($tables,$row["table_name"]);
        $msg.=      '<tr>';
        $msg.=          '<td>'.$i.'</td>';
        $msg.=          '<td>'.$row["table_name"].'</td>';
        $msg.=      '</tr>';
    }
}
else
{
    $msg.=		    '<tr>';
    $msg.=			    '<td></td>';
    $msg.=			    '<td></td>';
    $msg.=		    '</tr>';
}

$msg.=	    '</tbody>';
$msg.=  '</table>';

//getting field list
foreach($tables as $table)
{
    $msg.=  '<table class="table" border="1">';
    $msg.=      '<caption>';
    $msg.=          '<h3>Таблица: '.$table.'</h3>';
    $msg.=      '</caption>';
    $msg.=      '<thead>';
    $msg.=          '<th scope="col">#</th>';
    $msg.=          '<th scope="col">Поле</th>';
    $msg.=          '<th scope="col">Тип</th>';
    $msg.=      '</thead>';
    $msg.=      '<tbody>';

    $sql =  'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA="'.$my_db.'" AND TABLE_NAME="'.$table.'"';
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $i = 0;
        while($row = mysqli_fetch_array($result))
        {
            $i++;
            $msg.=      '<tr>';
            $msg.=          '<td>'.$i.'</td>';
            $msg.=          '<td>'.$row["COLUMN_NAME"].'</td>';
            
            $sql_type = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "'.$table.'" AND COLUMN_NAME = "'.$row["COLUMN_NAME"].'"';
            $result_type = mysqli_query($link,$sql_type);
            if($result_type)
            {
                $row_type = mysqli_fetch_array($result_type);
                $msg.=          '<td>'.$row_type["DATA_TYPE"].'</td>';
            }
            else
            {
                $msg.=          '<td></td>';
            }
            
            $msg.=      '</tr>';
        }
    }
    else
    {
        $msg.=          '<tr>';
        $msg.=              '<td></td>';
        $msg.=              '<td></td>';
        $msg.=              '<td></td>';
        $msg.=          '</tr>';
    }
    $msg.=      '</tbody>';
}

header("Content-Disposition: attachement; filename=database_structure.xls");
echo $utf8_bom.$msg;
?>