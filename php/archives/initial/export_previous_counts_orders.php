<?php
header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);

$script_start_time = time();  

/**
 * Հայտարարում ենք հաստատունները
 */
define("SERVER","localhost");
define("USER","root");
define("PASSWORD","1");
define("CURRENT_DATABASE","promtest");
define("ARCHIVED_DATABASE","pt2018");

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

/**
 * Ընթացիկ բազայում ստեղծում ենք previous_counts_orders աղյուսակը
 */
create_previous_counts_orders_table($link, CURRENT_DATABASE);

/**
 * previous_counts_orders աղյուսակի մեջ լրացնում ենք պատվերների քանակները ըստ պացիենտների
 */
fill_previous_counts_orders($link, ARCHIVED_DATABASE, CURRENT_DATABASE);

$script_end_time = time();
$duration = $script_end_time - $script_start_time;
$hours = intval($duration / 60 / 60);
$minutes = intval(($duration - $hours * 60 * 60) / 60);
$seconds = $duration - $hours * 60 * 60 - $minutes * 60;

echo "Բազայի հետ աշխատանքը հաջողությամբ ավարտվեց, այն տևեց՝ ".$hours." ժամ, ".$minutes." րոպե, ".$seconds." վայրկյան։";
mysqli_close($link);

/**
 * Ստեղծում է անալիզների նախորդ քանակների previous_counts_orders աղյուսակը
 */
function create_previous_counts_orders_table($link, $destination_db)
{
    $sql = "CREATE TABLE IF NOT EXISTS  ".$destination_db.".previous_counts_orders (
        PatientId INT NOT NULL,
        OrdersCount INT NOT NULL) ENGINE=MYISAM DEFAULT CHARSET=utf8
    ";

    echo $sql."<br>";

    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "previous_counts_orders աղյուսակը հաջողությամբ ստեղծվեց ".$destination_db." բազայի մեջ:<br><br>";
    }
    else
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $sql_index = "  CREATE INDEX idx_previous_counts_orders 
                    ON ".$destination_db.".previous_counts_orders (PatientId)
                ";
    echo $sql_index."<br>";
    $result_index = mysqli_query($link, $sql_index);
    if($result_index)
    {
        echo "idx_previous_counts_orders ինդեքսը հաջողությամբ ստեղծվեց previous_counts_orders աղյուսակի PatientId դաշտի հիման վրա։<br><br>";
    }
    else
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
}

/**
 * previous_counts_orders աղյուսակի մեջ լրացնում է պատվերների քանակները ըստ պացիենտների
 */
function fill_previous_counts_orders($link, $source_db, $destination_db)
{
    $sql = "INSERT INTO ".$destination_db.".previous_counts_orders 
            SELECT 
                pac_id AS PatientId, 
                COUNT(OrderId) AS OrdersCount 
            FROM ".$source_db.".orders
            GROUP BY pac_id
            ORDER BY pac_id
            ";

    echo $sql."<br>";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "Նախորդ պատվերների քանակների ".$destination_db.".previous_counts_orders աղյուսակի գրառումները հաջողությամբ լրացվեցին ".$source_db." բազայում առկա տեղեկատվության հիման վրա:<br><br>";
    }
    else
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
}
?>