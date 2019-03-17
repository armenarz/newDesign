<?php 
header("Content-Type: application/xls");
require_once("connect.php");

$msg = "";
$utf8_bom = chr(239).chr(187).chr(191);

//getting all table names
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
    }
}

//getting varchar and text fields containing tables
$allVarcharTextTables = array();
foreach($tables as $table)
{
    $sql =  'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA="'.$my_db.'" AND TABLE_NAME="'.$table.'"';
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $i = 0;
        while($row = mysqli_fetch_array($result))
        {
            $i++;
            
            $sql_type = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "'.$table.'" AND COLUMN_NAME = "'.$row["COLUMN_NAME"].'"';
            $result_type = mysqli_query($link,$sql_type);
            if($result_type)
            {
                $row_type = mysqli_fetch_array($result_type);
                if($row_type["DATA_TYPE"] == "varchar" || $row_type["DATA_TYPE"]=="text") array_push($allVarcharTextTables,$table);
            }
        }
    }
}
$varcharTextTables = array();
$allVarcharTextTables = array_unique($allVarcharTextTables,SORT_STRING);

foreach($allVarcharTextTables as $table)
{
    $msg.='
    <table class="table" border="1">
        <caption><h3>Таблица: '.$table.'</h3></caption>
        <thead>
            <th scope="col">#</th>
            <th scope="col">Поле</th>
            <th scope="col">Тип</th>
            <th scope="col">Значение по умолчанию</th>
        </thead>
        <tbody>
';
    $sql =  'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA="'.$my_db.'" AND TABLE_NAME="'.$table.'"';
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $i = 0;
        while($row = mysqli_fetch_array($result))
        {
            $i++;
            
            $sql_type = 'SELECT DATA_TYPE, COLUMN_DEFAULT  FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "'.$table.'" AND COLUMN_NAME = "'.$row["COLUMN_NAME"].'"';
            $result_type = mysqli_query($link,$sql_type);
            if($result_type)
            {
                $row_type = mysqli_fetch_array($result_type);
                if($row_type["DATA_TYPE"] == "varchar" || $row_type["DATA_TYPE"]=="text") 
                {
                    $msg.='
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$row["COLUMN_NAME"].'</td>
                        <td>'.$row_type["DATA_TYPE"].'</td>
                        <td>'.$row_type["COLUMN_DEFAULT"].'</td>
                    </tr>
                    ';
                }
            }
        }
    }
    $msg.='
        </tbody>
    </table>
    ';
}
//print_r($varcharTextTables);
header("Content-Disposition: attachement; filename=varchar_text.xls");
echo $utf8_bom.$msg;
?>