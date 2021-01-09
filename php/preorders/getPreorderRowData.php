<?php
require_once "../connect.php";
require_once "../authorization.php";

//getting preorderId
if(isset($_POST["preorder_id"]))
{
	$preorderId = $_POST["preorder_id"];
}
else
{
	$msg = "Код доктора отсутствует";
	echo $msg;
	return;
}


$sql = "SELECT * FROM preorders 
        WHERE preorderId='".$preorderId."'";

$result = mysqli_query($link,$sql);
if($result)
{
	$row = mysqli_fetch_array($result);

    $msg.= '
        <td><input type="radio" name="radioPreorder" value="'.$row["preorderId"].'" aria-label="Выберите предзаказ"></td>
        <td scope="row"><strong></strong></td>
        <td>'.$row["preorderId"].'</td>
        <td>'.$row["preorderDate"].'</td>
        <td>'.$row["customerLastName"].'</td>
        <td>'.$row["customerFirstName"].'</td>
        <td>'.$row["customerMidName"].'</td>
        <td>'.$row["customerPhone"].'</td>
        <td>'.$row["customerAddress"].'</td>
        <td>'.$row["customerEmail"].'</td>
        <td>'.$row["additionalInfo"].'</td>
        <td>
        ';
        if($row["preorderStatus"] == 1) $msg.='необработан';
        else if($row["preorderStatus"] == 2) $msg.='подтвержден';
        else if($row["preorderStatus"] == 3) $msg.='отклонен';
        $msg.= '
        </td>
        <td>'.$row["statusInfo"].'</td>
        <td>'.$row["orderId"].'</td>
    ';

}

echo $msg;
?>