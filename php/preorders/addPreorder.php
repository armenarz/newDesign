<?php 
require_once "../connect.php";
require_once "../safe_string.php";

$fixedKey =  "1318dc396312e1f349ad65cb7c82b459";

/**
 * Security Key
 */
if(isset($_POST["securityKey"]) && isset($_POST["preorderDate"]))
{
    $securityKey = safe_string($_POST["securityKey"]);
    $preorderDate = safe_string($_POST["preorderDate"]);
}
else
{
    //echo "Unauthorized users can't add preorder.";
    echo "There is no security key or preorder date.";
    return;
}
// echo "securityKey=".$securityKey."<br>";
// echo "preorderDate=".$preorderDate."<br>";

$createdKey = md5($fixedKey.$preorderDate);
// echo "createdKey=".$createdKey."<br>";

if($securityKey != $createdKey)
{
    echo "Unauthorized users can't add preorder.";
    return;
}

/**
 * Customer's last name
 */
if(isset($_POST["customerLastName"]))
{
    $customerLastName = safe_string($_POST["customerLastName"]);
}
else
{
    echo "There is no customer's last name.";
    return;
}

/**
 * Customer's first name
 */
if(isset($_POST["customerFirstName"]))
{
    $customerFirstName = safe_string($_POST["customerFirstName"]);
}
else
{
    echo "There is no customer's first name.";
    return;
}

/**
 * Customer's middle name
 * Not mandatory field
 */
if(isset($_POST["customerMidName"]))
{
    $customerMidName = safe_string($_POST["customerMidName"]);
}
else
{
    $customerMidName = "";
}

/**
 * Customer's phone number.
 */
if(isset($_POST["customerPhone"]))
{
    $customerPhone = safe_string($_POST["customerPhone"]);
}
else
{
    echo "There is no customer's phone number.";
    return;
}

/**
 * Customer's address
 */
if(isset($_POST["customerAddress"]))
{
    $customerAddress = safe_string($_POST["customerAddress"]);
}
else
{
    echo "There is no customer's address.";
    return;
}

/**
 * Customer's email
 */
if(isset($_POST["customerEmail"]))
{
    $customerEmail = safe_string($_POST["customerEmail"]);
}
else
{
    echo "There is no customer's email.";
    return;
}

/**
 * Customer's additional info
 * Not mandatory field
 */
if(isset($_POST["additionalInfo"]))
{
    $additionalInfo = safe_string($_POST["additionalInfo"]);
}
else
{
    $additionalInfo = "";
}

$sql = "INSERT INTO 
        preorders (
            preorderDate, 
            customerLastName, 
            customerFirstName, 
            customerMidName, 
            customerPhone, 
            customerAddress, 
            customerEmail, 
            additionalInfo) 
        VALUES (
            '".$preorderDate."',
            '".$customerLastName."',
            '".$customerFirstName."',
            '".$customerMidName."',
            '".$customerPhone."',
            '".$customerAddress."',
            '".$customerEmail."',
            '".$additionalInfo."')";

$result = mysqli_query($link, $sql);
if($result)
{
    $preorderId = mysqli_insert_id($link);
    
    $sql_select = " SELECT 
                        preorderId, 
                        preorderDate, 
                        customerLastName, 
                        customerFirstName, 
                        customerMidName, 
                        customerPhone, 
                        customerAddress, 
                        customerEmail, 
                        additionalInfo 
                    FROM preorders 
                    WHERE preorderId='".$preorderId."'";
    $result_select = mysqli_query($link,$sql_select);
    if($result_select)
    {
        if(mysqli_num_rows($result_select) > 0)
        {
            $row = mysqli_fetch_assoc($result_select);
            $response = json_encode($row);
            echo $response;
        }
    }
    //echo $preorderId;
}
else
{
    echo "Error number:".mysqli_errno($link)." ".mysqli_error($link);
}
?>