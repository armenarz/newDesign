<?php
require_once "../connect.php";
require_once "../authorization.php";

$PreorderIdChangeStatus = $_POST["PreorderIdChangeStatus"];
$PreorderDateChangeStatus = $_POST["PreorderDateChangeStatus"];
$CustomerLastNameChangeStatus = $_POST["CustomerLastNameChangeStatus"];
$CustomerFirstNameChangeStatus = $_POST["CustomerFirstNameChangeStatus"];
$CustomerMidNameChangeStatus = $_POST["CustomerMidNameChangeStatus"];
$CustomerPhoneChangeStatus = $_POST["CustomerPhoneChangeStatus"];
$CustomerAddressChangeStatus = $_POST["CustomerAddressChangeStatus"];
$CustomerEmailChangeStatus = $_POST["CustomerEmailChangeStatus"];
$AdditionalInfoChangeStatus = $_POST["AdditionalInfoChangeStatus"];
$PreorderStatusChangeStatus = $_POST["PreorderStatusChangeStatus"];
$StatusInfoChangeStatus = $_POST["StatusInfoChangeStatus"];
$OrderIdChangeStatus = $_POST["OrderIdChangeStatus"];
if($OrderIdChangeStatus == "" || $OrderIdChangeStatus == null)
{
    $OrderIdChangeStatus = 0;
}

$sql = "UPDATE `preorders` 
        SET 
            `preorderDate`='".$PreorderDateChangeStatus."',
            `customerLastName`='".$CustomerLastNameChangeStatus."',
            `customerFirstName`='".$CustomerFirstNameChangeStatus."',
            `customerMidName`='".$CustomerMidNameChangeStatus."',
            `customerPhone`='".$CustomerPhoneChangeStatus."',
            `customerAddress`='".$CustomerAddressChangeStatus."',
            `customerEmail`='".$CustomerEmailChangeStatus."',
            `additionalInfo`='".$AdditionalInfoChangeStatus."',
            `preorderStatus`='".$PreorderStatusChangeStatus."',
            `statusInfo`='".$StatusInfoChangeStatus."',
            `orderId`='".$OrderIdChangeStatus."' 
        WHERE `preorderId`='".$PreorderIdChangeStatus."'";
// echo $sql;
// return;
$result = mysqli_query($link,$sql);
if(!$result)
{
    $msg = mysqli_error($link);
    echo $msg;
    return;
}
$msg = "Preorder data successfully updated.";
echo $msg;
?>