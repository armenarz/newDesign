<?php
/**
 * Աղյուսակներ, որոնք պարունակում են ամսաթվի դաշտ
 */
$tables_with_date = array(
    "callibration"=>"dttime",
    "check1"=>"check_date",
    "control"=>"dttime",
    "course"=>"Date",
    "crm_mer"=>"date_cal",
    "crm_vizit"=>"calendar_date",
    "doctor_data_amis"=>"amis",
    "doctors_skidki"=>"amis_date",
    "doctors_skidki2"=>"amis_date",
    "dilution"=>"dttime",
    "feedback_a"=>"answer_date",
    "feedback_date"=>"f_date",
    "invoice"=>"DeliveryDate",
    "kassa"=>"kassa_day",
    "kassa1"=>"kassa_day",
    "kassa_all"=>"kassa_day",
    "news"=>"news_date",
    "orders"=>"OrderDate",
    "pac_edit_log"=>"edit_date",
    "perevozka_new"=>"dtime",
    "perevozka_prob"=>"pdate_time",
    "prixod"=>"prixod_date",
    "prochee"=>"strip_date",
    "prochee1"=>"strip_date",
    "prochee_all"=>"strip_date",
    "reagent_add_log"=>"AddDate",
    "reagent_edit_log"=>"EditDate",
    "schetchik"=>"den",
    "sklad_begin"=>"sklad_beg_date",
    "vibros"=>"vibros_date",
    "warehouse"=>"WHStartDate",
    "weekends"=>"weekend"
);

/**
 * Աղյուսակներ, որոնք պարունակում են պատվերի orderid դաշտ
 */
$tables_with_orderid = array(
    "a1014","a1056","a1076","a1078_1080","a1096","a1098","a1118","a1128","a255","a286_2",
    "a286_tr","a353_1","a363j","a363m","a378","a380","a390","a391","a392","a393",
    "a394","a395","a396","a458","a470","a472","a486","a488","a490","a496",
    "a512","a516","a522","a524","a524_2","a526","a528","a530","a532","a534",
    "a540","a542","a557","a559","a582","a625","a707","a709","a711","a757",
    "a759","a776","a778","a782","a784","a786","a786_1","a860","a874","a874_2",
    "a890","a902","a944","a964","a970","a974","ab255","ab458","ab860","ab928",
    "abc353","abc458","abc844","abc860","abc928","abc974_976","action_log","ad902","an_mochi","anibiotiki448",
    "antibiotiki415","antibiotiki582","check860","check_perevozka","check_ready_z","check_vozvrat","edit_akcia","factura","feedback",
    "mail","mikro448","order_comment","povtor","quality_vvod","quality_vvod_d","res415","res902","ria_week","tb353",
    "tb363","to_ingo01","users_check","vernuli_dolg","vozvrat","vvod","wcheck","zaplatili"
);

/**
 * Աղյուսակներ, որոնք պարունակում են պատվերի OrderId դաշտ
 */
$tables_with__OrderId = array("a286","analiz_krovi","analiz_mochi","blood_clotting","inf_pech_label","inf_pech_label_order","notification","orderresult");

/**
 * 
 */
/* $tables_with_totals = array(
    "callibration",
    "control",
    "dilution",
    "prixod",
    "vibros"
); */

/**
 * Պատճենում է ամբողջ բազան օգտագործելով mysqldump, mysqladmin և mysql արտաքին ծրագրերի օգնությամբ
 */
function copy_db_using_mysqldump($server, $user, $password, $source_db, $destination_db, $backup_file)
{
    /**
     * Կատարում ենք բազայի պահեստային պատճենում (backup)`
     */
    if(file_exists($backup_file))
    {
        echo "Բազայի պահեստային պատճենում չի կատարվել, քանի որ ".getcwd()."&#92;".$backup_file." ֆայլը արդեն գոյություն ունի:<br><br>";
    }
    else
    {
        exec('mysqldump --user='.$user.' --password='.$password.' --host='.$server.' '.$source_db.' > '.$backup_file);
        echo "Բազայի պահեստային պատճենումը՝ (backup)-ը կատարվեց ".getcwd()."&#92;".$backup_file." ֆայլի մեջ:<br><br>";
    }

    /**
     * Ստեղծում ենք նոր բազա` DESTINATION_DATABASE անվանումով
     */
    exec('mysqladmin --user='.$user.' --password='.$password.' --host='.$server.' create '.$destination_db);
    echo $destination_db." անվանումով բազան հաջողությամբ ստեղծվեց:<br><br>";

    /**
     * Պահեստային բազայից պատճենում ենք գրառումները նոր բազայի մեջ
     */
    exec('mysql --user='.$user.' --password='.$password.' --host='.$server.' '.$destination_db.' < '.$backup_file);
    echo $destination_db." բազայի գրառումները հաջողությամբ պատճենվեցին:<br><br>";
}

/**
 * Բազայից հեռացնում է այն աղյուսակները, 
 * որոնց անվանումը ավարտվում է _dropit վերջավորությամբ
 */
function delete_dropit_tables($link, $destination_db)
{
    //Նոր բազայից ստանում ենք աղյուսակների անվանումները, որոնք պարունակում են _dropit վերջավորություն
    $sql =  "SELECT table_name FROM information_schema.tables WHERE table_schema='".$destination_db."'";
    $result = mysqli_query($link,$sql);
    $tables = array();
    if($result)
    {
        while($row = mysqli_fetch_array($result))
        {
            $pos = strpos($row["table_name"], "_dropit");
            if($pos !== FALSE)
            {
                array_push($tables,$row["table_name"]);
            }
        }
    }

    //Հեռացնում ենք նոր բազայից _dropit վերջավորություն ունեցող աղյուսակները
    //var_dump($tables);
    foreach($tables as $table)
    {
        $sql_dropit = "DROP TABLE ".$destination_db.".".$table;
        echo $sql_dropit."<br>";
        $result_dropit = mysqli_query($link, $sql_dropit);
        if($result_dropit)
        {
            echo $table." աղյուսակը հաջողությամբ հեռացվեց։<br>";
        }
        echo "<br>";
    }
}

/**
 * Պատճենում է ամբողջ բազան, օգտագործելով PHP/MySQL-ի հնարավորությունները
 */
function copy_database($link, $source_db, $destination_db)
{
    //Ստեղծում ենք տրված անվանումով նոր բազա
    $sql_create_db = "CREATE DATABASE IF NOT EXISTS ".$destination_db;
    $result_create_db = mysqli_query($link,$sql_create_db);
    if($result_create_db)
    {
        //Ելակետային բազայից ստանում ենք աղյուսակների անվանումները
        $sql =  "SELECT table_name FROM information_schema.tables WHERE table_schema='".$source_db."'";
        $result = mysqli_query($link,$sql);
        $tables = array();
        if($result)
        {
            while($row = mysqli_fetch_array($result))
            {
                $pos = strpos($row["table_name"], "_dropit");
                if($pos === FALSE)
                {
                    array_push($tables,$row["table_name"]);
                }
            }
        }

        //Պատճենում ենք ելակետային բազայի աղյուսակները նոր բազայի մեջ
        foreach($tables as $table)
        {
            echo $table."<br>";
            copy_table($link, $source_db, $destination_db, $table);
        }
    }
}

/**
 * Պատճենում է ելակետային աղյուսակը նպատակային բազայի մեջ
 */
function copy_table($link, $source_db, $destination_db, $source_table, $destination_table = NULL)
{
    if($destination_table == NULL) $destination_table = $source_table;
    $sql_create = "CREATE TABLE IF NOT EXISTS ".$destination_db.".".$destination_table." LIKE ".$source_db.".".$source_table." ";

    echo $sql_create."<br>";
    $result_create = mysqli_query($link, $sql_create);
    if($result_create)
    {
        echo $source_table." աղյուսակի կառուցվածքը ".$source_db." բազայից հաջողությամբ պատճենվեց ".$destination_db." բազայի ".$destination_table." աղյուսակի մեջ:<br><br>";

        $sql_insert = "INSERT INTO ".$destination_db.".".$destination_table." SELECT * FROM ".$source_db.".".$source_table." ";

        echo $sql_insert."<br>";
        $result_insert = mysqli_query($link, $sql_insert);
        if($result_insert)
        {
            echo $source_table." աղյուսակի գրառումները ".$source_db." բազայից հաջողությամբ պատճենվեցին ".$destination_db." բազայի ".$destination_table." աղյուսակի մեջ:<br><br>";
        }
        else
        {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
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
 * Աղյուսակներից հեռացնել ավելորդ տողերը ըստ ամսաթվի
 */
function delete_rows_using_date($link, $destination_db, $tables_with_date, $start_year, $end_year)
{
    foreach($tables_with_date as $table => $date_field)
    {
        $sql = "DELETE FROM ".$destination_db.".".$table." 
                WHERE YEAR(".$date_field.")<".$start_year." OR YEAR(".$date_field.")>".$end_year;
        echo $table."<br>";
        echo $sql."<br>";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            echo $destination_db.".".$table." աղյուսակից հաջողությամբ հեռացվեցին ".$start_year." - ".$end_year." ժամանակաշրջանին չվերաբերվող ավելորդ տողերը:<br><br>";
        }
        else
        {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }
}

/**
 * Աղյուսակներից հեռացնել ավելորդ տողերը օգտագործելով պատվերի orderid համարը
 */
function delete_rows_using_orderid($link, $destination_db, $tables_with_orderid)
{    
    foreach($tables_with_orderid as $table)
    {
        $sql = "DELETE FROM ".$destination_db.".".$table." 
                WHERE orderid NOT IN (SELECT OrderId FROM ".$destination_db.".orders)";

        echo $table."<br>";
        echo $sql."<br>";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            echo $destination_db.".".$table." աղյուսակից հաջողությամբ հեռացվեցին orders աղյուսակում նույն orderid չունեցող ավելորդ տողերը:<br><br>";
        }
        else
        {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }   
}

/**
 * Աղյուսակներից հեռացնել ավելորդ տողերը օգտագործելով պատվերի OrderId համարը
 */
function delete_rows_using__OrderId($link, $destination_db, $tables_with__OrderId)
{
    foreach($tables_with__OrderId as $table)
    {
        $sql = "DELETE FROM ".$destination_db.".".$table." 
                WHERE OrderId NOT IN (SELECT OrderId FROM ".$destination_db.".orders)";

        echo $table."<br>";
        echo $sql."<br>";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            echo $destination_db.".".$table." աղյուսակից հաջողությամբ հեռացվեցին orders աղյուսակում նույն OrderId չունեցող ավելորդ տողերը:<br><br>";
        }
        else
        {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }
}


/**
 * Ստեղծում է անալիզների նախորդ քանակների previous_counts աղյուսակը
 */
function create_previous_counts_table($link, $destination_db)
{
    $sql = "CREATE TABLE IF NOT EXISTS  ".$destination_db.".previous_counts (
        PatientId INT NOT NULL,
        ReagentId INT NOT NULL,
        ResultsCount INT NOT NULL) ENGINE=MYISAM DEFAULT CHARSET=utf8
    ";

    echo $sql."<br>";

    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "previous_counts աղյուսակը հաջողությամբ ստեղծվեց ".$destination_db." բազայի մեջ:<br><br>";
    }
    else
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $sql_index = "  CREATE INDEX idx_previous_counts 
                    ON ".$destination_db.".previous_counts (PatientId, ReagentId)
                ";
    echo $sql_index."<br>";
    $result_index = mysqli_query($link, $sql_index);
    if($result_index)
    {
        echo "idx_previous_counts բաղադրյալ ինդեքսը հաջողությամբ ստեղծվեց previous_counts աղյուսակի PatientId և ReagentId դաշտերի հիման վրա։<br><br>";
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
 * previous_counts աղյուսակի մեջ լրացնում է ռեագենտների քանակները ըստ պացիենտների
 */
function fill_previous_counts($link, $source_db, $destination_db, $start_year, $end_year)
{
    $sql_users ="   SELECT 
                        user_id 
                    FROM ".$source_db.".partner_users
                ";
	$result_users = mysqli_query($link, $sql_users);
    if($result_users)
    {
		$array_users = array();
        while ($row_users = mysqli_fetch_array($result_users)) 
        {
			array_push($array_users, $row_users["user_id"]);
		}
	}
	
	$users = implode(",", $array_users);

    $sql = "INSERT INTO ".$destination_db.".previous_counts 
            SELECT 
                T.pac_id AS PatientId, 
                T.ReagentId AS ReagentId, 
                COUNT(T.AnalysisResult) AS ResultsCount
            FROM
            (
                SELECT 
                    orders.pac_id, 
                    orderresult.ReagentId, 
                    orderresult.AnalysisResult
                FROM ".$source_db.".orders
                LEFT JOIN ".$source_db.".orderresult ON orders.OrderId = orderresult.OrderId
                WHERE 
                    YEAR(orders.OrderDate) >= ".$start_year." AND 
                    YEAR(orders.OrderDate) <= ".$end_year." AND 
                    orders.pac_id <> 0 AND
                    orderresult.ReagentId <> 0 AND
                    orderresult.AnalysisResult IS NOT NULL AND
                    orderresult.AnalysisResult <> '' AND
                    orders.user_id NOT IN (".$users.") AND
                    orderresult.srochno = 0 
                ORDER BY orders.pac_id, orderresult.ReagentId, orders.OrderDate DESC
            ) T
            GROUP BY T.pac_id, T.ReagentId
        ";
    echo $sql."<br>";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "Նախորդ անալիզների քանակների ".$destination_db.".previous_counts աղյուսակի գրառումները հաջողությամբ լրացվեցին ".$source_db." բազայում առկա տեղեկատվության հիման վրա:<br><br>";
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
 * Ստեղծում է անալիզների նախորդ քանակների previous_counts_double աղյուսակը
 */
function create_previous_counts_double_table($link, $destination_db)
{
    $sql = "CREATE TABLE IF NOT EXISTS  ".$destination_db.".previous_counts_double (
        PatientId INT NOT NULL,
        ReagentId INT NOT NULL,
        ResultsCount INT NOT NULL) ENGINE=MYISAM DEFAULT CHARSET=utf8
    ";

    echo $sql."<br>";

    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "previous_counts աղյուսակը հաջողությամբ ստեղծվեց ".$destination_db." բազայի մեջ:<br><br>";
    }
    else
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $sql_index = "  CREATE INDEX idx_previous_counts_double 
                    ON ".$destination_db.".previous_counts_double (PatientId, ReagentId)
                ";
    echo $sql_index."<br>";
    $result_index = mysqli_query($link, $sql_index);
    if($result_index)
    {
        echo "idx_previous_counts_double բաղադրյալ ինդեքսը հաջողությամբ ստեղծվեց previous_counts_double աղյուսակի PatientId և ReagentId դաշտերի հիման վրա։<br><br>";
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
 * previous_counts_double աղյուսակի մեջ լրացնում է ռեագենտների քանակները ըստ պացիենտների
 */
function fill_previous_counts_double($link, $source_db, $destination_db, $start_year, $end_year)
{
    $sql = "INSERT INTO ".$destination_db.".previous_counts_double 
            SELECT 
                T.pac_id AS PatientId, 
                T.ReagentId AS ReagentId, 
                COUNT(T.AnalysisResult) AS ResultsCount
            FROM
            (
                SELECT 
                    orders.pac_id, 
                    orderresult.ReagentId, 
                    orderresult.AnalysisResult
                FROM ".$source_db.".orders
                LEFT JOIN ".$source_db.".orderresult ON orders.OrderId = orderresult.OrderId
                WHERE 
                    YEAR(orders.OrderDate) >= ".$start_year." AND 
                    YEAR(orders.OrderDate) <= ".$end_year." AND 
                    orders.pac_id <> 0 AND
                    orderresult.ReagentId <> 0 AND
                    orderresult.AnalysisResult IS NOT NULL AND
                    orderresult.AnalysisResult <> ''
                ORDER BY orders.pac_id, orderresult.ReagentId, orders.OrderDate DESC
            ) T
            GROUP BY T.pac_id, T.ReagentId
        ";
    echo $sql."<br>";
    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "Նախորդ անալիզների քանակների ".$destination_db.".previous_counts_double աղյուսակի գրառումները հաջողությամբ լրացվեցին ".$source_db." բազայում առկա տեղեկատվության հիման վրա:<br><br>";
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
 * Ստեղծում է անալիզների նախորդ արդյունքների previous_result աղյուսակը
 */
function create_previous_results_table($link, $destination_db)
{
    $sql = "CREATE TABLE IF NOT EXISTS  ".$destination_db.".previous_results (
                PatientId INT NOT NULL,
                ReagentId INT NOT NULL,
                Results TEXT NULL) ENGINE=MYISAM DEFAULT CHARSET=utf8
            ";

    echo $sql."<br>";

    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "previous_results աղյուսակը հաջողությամբ ստեղծվեց ".$destination_db." բազայի մեջ:<br><br>";
    }
    else
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $sql_index = "  CREATE INDEX idx_previous_results 
                    ON ".$destination_db.".previous_results (PatientId, ReagentId)
                ";
    echo $sql_index."<br>";
    $result_index = mysqli_query($link, $sql_index);
    if($result_index)
    {
        echo "idx_previous_results բաղադրյալ ինդեքսը հաջողությամբ ստեղծվեց previous_results աղյուսակի PatientId և ReagentId դաշտերի հիման վրա։<br><br>";
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
 * previous_results աղյուսակի մեջ լրացնում է ռեագենտների արդյունքները ըստ պացիենտների
 */
function fill_previous_results($link, $source_db, $destination_db, $start_year, $end_year, $results_limit)
{
    $sql = "INSERT INTO ".$destination_db.".previous_results 
            SELECT 
                T.pac_id AS PatientId, 
                T.ReagentId AS ReagentId, 
                CONCAT('{', SUBSTRING_INDEX(GROUP_CONCAT(CONCAT('\"',T.OrderDateTime,'\":{\"',T.OrderId,'\":\"',T.AnalysisResult,'\"}') SEPARATOR ','), ',', ".$results_limit."), '}') AS Results
            FROM
            (
                SELECT 
                    orders.pac_id, 
                    orderresult.ReagentId, 
                    cast(concat(orders.OrderDate, ' ', orders.OrderTime) as datetime) as OrderDateTime,
                    orders.OrderId,
                    orderresult.AnalysisResult
                FROM ".$source_db.".orders
                LEFT JOIN ".$source_db.".orderresult ON orders.OrderId = orderresult.OrderId
                WHERE 
                    YEAR(orders.OrderDate) >= ".$start_year." AND 
                    YEAR(orders.OrderDate) <= ".$end_year." AND 
                    orders.pac_id <> 0 AND
                    orderresult.ReagentId <> 0 AND
                    orderresult.AnalysisResult IS NOT NULL AND
                    orderresult.AnalysisResult <> '' 
                ORDER BY orders.pac_id, orderresult.ReagentId, OrderDateTime DESC
            ) T
            GROUP BY T.pac_id, T.ReagentId
        ";

    echo $sql."<br>";

    $result = mysqli_query($link, $sql);
    if($result)
    {
        echo "Նախորդ արդյունքների ".$destination_db.".previous_results աղյուսակի գրառումները հաջողությամբ լրացվեցին ".$source_db." բազայում առկա տեղեկատվության հիման վրա:<br><br>";
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
 * callibration, control, dilution, prixod և vibros աղյուսակներում
 * մուտքագրվում են նախորդ ժամանակաշրջանի հանրագումարները
 */
/* function insert_totals($link, $source_db, $destination_db, $tables_with_totals)
{   
    $sql = "";
    foreach($tables_with_totals as $table)
    {
        if($table == "callibration")
        {
            $sql = "INSERT INTO ".$destination_db.".callibration(reagentid, dttime, callibr_count) 
                    SELECT 
                        reagentid,
                        STR_TO_DATE('31-12-2018', '%d-%m-%Y'),
                        SUM(callibr_count) AS total 
                    FROM ".$source_db.".callibration
                    GROUP BY reagentid
                    ";
        }
        elseif($table == "control")
        {
            $sql = "INSERT INTO ".$destination_db.".control(reagentid, dttime, control_count)
                    SELECT 
                        reagentid, 
                        STR_TO_DATE('31-12-2018', '%d-%m-%Y'),
                        SUM(control_count) AS total 
                    FROM ".$source_db.".control
                    GROUP BY reagentid
                    ";
        }
        elseif($table == "dilution")
        {
            $sql = "INSERT INTO ".$destination_db.".dilution(reagentid, orderid, dttime, dil_count)
                    SELECT 
                        reagentid, 
                        0,
                        STR_TO_DATE('31-12-2018', '%d-%m-%Y'),
                        SUM(dil_count) AS total 
                    FROM ".$source_db.".dilution
                    GROUP BY reagentid
                    ";
        }
        elseif($table == "prixod")
        {
            $sql = "INSERT INTO ".$destination_db.".prixod(reagid, prixod_count, prixod_date, srok_godnosti, producerId, catalogueNumberId, proizvoditel, number_kat)
                    SELECT 
                        reagid, 
                        SUM(prixod_count) AS total,
                        STR_TO_DATE('31-12-2018', '%d-%m-%Y'),
                        STR_TO_DATE('00-00-0000', '%d-%m-%Y'),
                        0,
                        0,
                        '&nbsp;',
                        '&nbsp;'
                    FROM ".$source_db.".prixod
                    group by reagid
                    ";
        }
        elseif($table == "vibros")
        {
            $sql = "INSERT INTO ".$destination_db.".vibros(reagid, vibros_count, vibros_date)
                    SELECT 
                        reagid, 
                        SUM(vibros_count) AS total,
                        STR_TO_DATE('31-12-2018', '%d-%m-%Y')
                    FROM ".$source_db.".vibros
                    GROUP BY reagid
                    ";
        }
        echo $sql."<br>";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            echo "Նախորդ ժամանակաշրջանի ".$destination_db.".".$table." աղյուսակի հանրագումարները հաջողությամբ ավելացվեցին ".$source_db."․".$table." աղյուսակում:<br><br>";
        }
        else
        {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }
} */
?>