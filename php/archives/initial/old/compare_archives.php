<?php
header("Content-Type: application/xls");
set_time_limit(0);

$utf8_bom = chr(239).chr(187).chr(191);
$html = $utf8_bom;

/**
 * Հայտարարում ենք հաստատունները
 */
define("SERVER","localhost");
define("USER","root");
define("PASSWORD","konte13S");
define("SOURCE_DATABASE","promtest_server");
define("DESTINATION_DATABASE1","pt2018");
define("DESTINATION_DATABASE2","pt2020");

/**
 * Ստեղծում ենք կապը MySQL Server-ի հետ
 */
$link = mysqli_connect(SERVER, USER, PASSWORD);
if (!$link)
{
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$tables_source = count_tables_rows($link, SOURCE_DATABASE);
$tables_dest1 = count_tables_rows($link, DESTINATION_DATABASE1);
$tables_dest2 = count_tables_rows($link, DESTINATION_DATABASE2);

$tables_count = count($tables_source);

$html.= '
            <table class="table" border="1">
                <caption>
                    <h2>Տվյալների բազաների համեմատական տվյալները</h2>
                </caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Աղյուսակի անվանումը</th>
                        <th scope="col">'.SOURCE_DATABASE.'</th>
                        <th scope="col">'.DESTINATION_DATABASE1.'</th>
                        <th scope="col">'.DESTINATION_DATABASE2.'</th>
                    </tr>
                </thead>
                <tbody>
        ';
$i = 0;
foreach($tables_source as $table => $cnt)
{
    $i++;
    $html.= '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$table.'</td>
                        <td>'.$cnt.'</td>
                        <td>'.$tables_dest1[$table].'</td>
                        <td>'.$tables_dest2[$table].'</td>
                    </tr
            ';
}

$html.=	'
                </tbody>
            </table>
        ';

function count_tables_rows($link, $database)
{
    $sql =  "SELECT table_name FROM information_schema.tables WHERE table_schema='".$database."'";
    //echo $sql."<br>";
    $result = mysqli_query($link, $sql);

    $tables = array();
    if($result)
    {
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $sql_count = "SELECT COUNT(*) AS cnt FROM ".$database.".".$row["table_name"];
                $result_count = mysqli_query($link, $sql_count);
                if($result_count)
                {
                    $row_count = mysqli_fetch_array($result_count);
                    $tables[$row["table_name"]] = $row_count["cnt"];
                }
            }
        }
    }

    return $tables;
}

header("Content-Disposition: attachement; filename=compare_archives.xls");
echo $html;
mysqli_close($link);
?>