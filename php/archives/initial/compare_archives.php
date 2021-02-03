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
define("PASSWORD","1");
define("SOURCE_DATABASE","promtest_server");
define("ARCHIVED_DATABASE","pt2018");
define("CURRENT_DATABASE","pt_current");

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
$tables_archived = count_tables_rows($link, ARCHIVED_DATABASE);
$tables_current = count_tables_rows($link, CURRENT_DATABASE);

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
                        <th scope="col">'.ARCHIVED_DATABASE.'</th>
                        <th scope="col">'.CURRENT_DATABASE.'</th>
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
                        <td>'.$tables_archived[$table].'</td>
                        <td>'.$tables_current[$table].'</td>
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