<?php
require_once "../connect.php";
require_once "../authorization.php";

$FirstNameAdd = $_POST["FirstNameAdd"];
$LastNameAdd = $_POST["LastNameAdd"];
$MidNameAdd = $_POST["MidNameAdd"];
$personality_typeAdd = $_POST["personality_typeAdd"];
$loyaltyAdd = $_POST["loyaltyAdd"];

$BirthDateAdd = $_POST["BirthDateAdd"];
if($BirthDateAdd == '') $BirthDateAdd = '00-00-0000';

$DiscountAdd = $_POST["DiscountAdd"];
if($DiscountAdd == '') $DiscountAdd = 0;

$Phone1Add = $_POST["Phone1Add"];
$Phone2Add = $_POST["Phone2Add"];
$EmailAdd = $_POST["EmailAdd"];
$WorkPlaceIdAdd = $_POST["WorkPlaceIdAdd"];

$LoginAdd = $_POST["LoginAdd"];
$PasswordAdd = $_POST["PasswordAdd"];
$SalesIdAdd = $_POST["SalesIdAdd"];

if(isset($_POST["SpecialityIdAdd"])) 
{
    $SpecialityIdAdd = $_POST["SpecialityIdAdd"];
    
    $sql = "SELECT Method FROM profession WHERE MethodId='".$SpecialityIdAdd."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $SpecialityAdd = $row["Method"];
    }
}

$ActiveIdAdd = $_POST["ActiveIdAdd"];

$sql = "
INSERT INTO doctor(
    FirstName, 
    LastName, 
    MidName, 
    personality_type, 
    loyalty, 
    BirthDate, 
    Discount, 
    Phone1, 
    Phone2, 
    Phone3, 
    WorkPlaceId, 
    Comment, 
    wp, 
    profession,  
    active,  
    sales_id
    ) VALUES (
    '".$FirstNameAdd."',
    '".$LastNameAdd."',
    '".$MidNameAdd."',
    '".$personality_typeAdd."',
    '".$loyaltyAdd."',
    '".$BirthDateAdd."',
    '".$DiscountAdd."',
    '".$Phone1Add."',
    '".$Phone2Add."',
    '".$EmailAdd."',
    '".$WorkPlaceIdAdd."',
    '".$LoginAdd."',
    '".$PasswordAdd."',
    '".$SpecialityAdd."',
    '".$ActiveIdAdd."',
    '".$SalesIdAdd."'
)";
var_dump($sql);
$result = mysqli_query($link,$sql);
if($result)
{
    $msg = "New doctor successfully added.";
}
else
{
    $msg = mysqli_error($link);
}
echo $msg;
?>