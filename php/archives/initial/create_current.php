<?php
header('Content-Type: text/html; charset=utf-8');
require_once("archivation_functions.php");
set_time_limit(0);

$script_start_time = time();  

/**
 * Հայտարարում ենք հաստատունները
 */
define("SERVER","localhost");
define("USER","root");
define("PASSWORD","1");
define("SOURCE_DATABASE","promtest_server");
define("CURRENT_DATABASE","pt_current");
define("ARCHIVED_DATABASE","pt2018");
define("BACKUP_FILE","promtest_backup.sql");
define("START_YEAR",2019);
define("END_YEAR",2020);
define("PREVIOUS_START_YEAR",2012);
define("PREVIOUS_END_YEAR",2018);
define("PREVIOUS_RESULTS_LIMIT",5);

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
 * Պատճենում է բազայի տեղեկատվությունը նոր բազայի մեջ
 */
copy_db_using_mysqldump(SERVER, USER, PASSWORD, SOURCE_DATABASE, CURRENT_DATABASE, BACKUP_FILE);

/**
 * Բազայից հեռացնում է այն աղյուսակները, 
 * որոնց անվանումը ավարտվում է _dropit վերջավորությամբ
 */
delete_dropit_tables($link, CURRENT_DATABASE);

/**
 * Պատճենում է ամբողջ բազան, օգտագործելով PHP/MySQL-ի հնարավորությունները
 */
//copy_database($link, SOURCE_DATABASE, CURRENT_DATABASE);

/**
 * Նոր բազայի նախասահմանված աղյուսակներից հեռացվում են սկզբնական և վերջնական տարեթվերով 
 * սահմանափակված ժամանակաշրջանին չառնչվող գրառումները
 */
delete_rows_using_date($link, CURRENT_DATABASE, $tables_with_date, START_YEAR, END_YEAR);

/**
 * Նոր բազայի նախասահմանված աղյուսակներից հեռացվում են գրառումները, 
 * որոնց orderid-ները առկա չեն orders աղյուսակում
 */
delete_rows_using_orderid($link, CURRENT_DATABASE, $tables_with_orderid);

/**
 * Նոր բազայի նախասահմանված աղյուսակներից հեռացվում են գրառումները, 
 * որոնց OrderId-ները առկա չեն orders աղյուսակում
 */
delete_rows_using__OrderId($link, CURRENT_DATABASE, $tables_with__OrderId);

/**
 * callibration, control, dilution, prixod և vibros աղյուսակներում
 * մուտքագրվում են նախորդ ժամանակաշրջանի հանրագումարները
 */
//insert_totals($link, ARCHIVED_DATABASE, CURRENT_DATABASE, $tables_with_totals);

/**
 * Ստեղծում է անալիզների նախորդ արդյունքների previous_result աղյուսակը
 */
//create_previous_results_table($link, CURRENT_DATABASE);

/**
 * previous_results աղյուսակի մեջ լրացնում է ռեագենտների արդյունքները ըստ պացիենտների
 */
//fill_previous_results($link, SOURCE_DATABASE, CURRENT_DATABASE, PREVIOUS_START_YEAR, PREVIOUS_END_YEAR, PREVIOUS_RESULTS_LIMIT);

/**
 * Ստեղծում է անալիզների նախորդ քանակների previous_counts աղյուսակը
 */
create_previous_counts_table($link, CURRENT_DATABASE);

/**
 * previous_counts աղյուսակի մեջ լրացնում է ռեագենտների քանակները ըստ պացիենտների
 */
fill_previous_counts($link, SOURCE_DATABASE, CURRENT_DATABASE, PREVIOUS_START_YEAR, PREVIOUS_END_YEAR);

/**
 * Ստեղծում է անալիզների նախորդ քանակների previous_counts_double աղյուսակը
 */
create_previous_counts_double_table($link, CURRENT_DATABASE);

/**
 * previous_counts_double աղյուսակի մեջ լրացնում է ռեագենտների քանակները ըստ պացիենտների
 */
fill_previous_counts_double($link, SOURCE_DATABASE, CURRENT_DATABASE, PREVIOUS_START_YEAR, PREVIOUS_END_YEAR);

$script_end_time = time();
$duration = $script_end_time - $script_start_time;
$hours = intval($duration / 60 / 60);
$minutes = intval(($duration - $hours * 60 * 60) / 60);
$seconds = $duration - $hours * 60 * 60 - $minutes * 60;

echo "Բազայի հետ աշխատանքը հաջողությամբ ավարտվեց, այն տևեց՝ ".$hours." ժամ, ".$minutes." րոպե, ".$seconds." վայրկյան։";
mysqli_close($link);
?>