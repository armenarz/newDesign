<?php 
/**
 * Creating safe string
 */
function safe_string($unsafe_string)
{
    $safe_string = strip_tags($unsafe_string);
    $safe_string = htmlspecialchars($safe_string);
    $safe_string = mysql_escape_string($safe_string);
    return $safe_string;
}
?>