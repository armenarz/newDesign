<?php
    function usr_to_name($link, $user_id, $reportDate)
    {
        $sql = "(SELECT 
                    id AS user_id, 
                    '1970-01-01' AS name_date, 
                    log AS user_name 
                FROM us22
                WHERE id='".$user_id."')
                UNION
                (SELECT 
                    user_id,
                    name_date,
                    user_name
                FROM altered_user_names 
                WHERE user_id='".$user_id."' AND name_date<='".$reportDate."')
                ORDER BY name_date DESC
                LIMIT 0, 1
                ";
        $result = mysqli_query($link, $sql);
        $user_name = "undefined user";
        if($result)
        {
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                $user_name = $row["user_name"];
            }
        }
        return $user_name;
    }
?>
