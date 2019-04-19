<?php
require_once "../connect.php";
require_once "../authorization.php";

$DoctorIdEdit = $_POST["DoctorIdEdit"];
$FirstNameEdit = $_POST["FirstNameEdit"];
$LastNameEdit = $_POST["LastNameEdit"];
$MidNameEdit = $_POST["MidNameEdit"];
$personality_typeEdit = $_POST["personality_typeEdit"];
$loyaltyEdit = $_POST["loyaltyEdit"];

$BirthDateEdit = $_POST["BirthDateEdit"];
if($BirthDateEdit == '') $BirthDateEdit = '00-00-0000';

$DiscountEdit = $_POST["DiscountEdit"];
if($DiscountEdit == '') $DiscountEdit = 0;

$Phone1Edit = $_POST["Phone1Edit"];
$Phone2Edit = $_POST["Phone2Edit"];
$EmailEdit = $_POST["EmailEdit"];
$WorkPlaceIdEdit = $_POST["WorkPlaceIdEdit"];
$LoginEdit = $_POST["LoginEdit"];
$PasswordEdit = $_POST["PasswordEdit"];
$SalesIdEdit = $_POST["SalesIdEdit"];

$SpecialityIdEdit = $_POST["SpecialityIdEdit"];
$sql = "SELECT Method FROM profession WHERE MethodId='".$SpecialityIdEdit."'";
$result = mysqli_query($link,$sql);
$SpecialityEdit = "";
if($result)
{
    $row = mysqli_fetch_array($result);
    $SpecialityEdit = $row["Method"];
}
$ActiveIdEdit = $_POST["ActiveIdEdit"];

$sql = "
UPDATE doctor SET 
FirstName='".$FirstNameEdit."',
LastName='".$LastNameEdit."',
MidName='".$MidNameEdit."',
personality_type='".$personality_typeEdit."',
loyalty='".$loyaltyEdit."',
BirthDate='".$BirthDateEdit."',
Discount='".$DiscountEdit."',
Phone1='".$Phone1Edit."',
Phone2='".$Phone2Edit."',
Phone3='".$EmailEdit."',
WorkPlaceId='".$WorkPlaceIdEdit."',
profession='".$SpecialityEdit."',
active='".$ActiveIdEdit."',
sales_id='".$SalesIdEdit."' 
WHERE DoctorId='".$DoctorIdEdit."'
";

$result = mysqli_query($link,$sql);
if(!$result)
{
    $msg = mysqli_error($link);
    echo $msg;
    return;
}

//Setting login and password
$sql_lp = "
UPDATE us22 
INNER JOIN usr_priv ON us22.id = usr_priv.usr_id
SET
us22.log='".$LoginEdit."',
us22.passw='".$PasswordEdit."'
WHERE usr_priv.DoctoId =  '".$DoctorIdEdit."'
";
$result_lp = mysqli_query($link,$sql_lp);
if(!$result_lp)
{
    $msg = mysqli_error($link);
    echo $msg;
    return;
}
$msg = "Doctor data successfully updated.";
echo $msg;
?>