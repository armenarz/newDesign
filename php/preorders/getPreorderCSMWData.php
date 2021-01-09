<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

if(isset($_POST["preorder_id"])) $preorder_id = $_POST["preorder_id"];
//Getting preorder data
$sql = "SELECT * FROM preorders WHERE preorderId='".$preorder_id."'";
$result = mysqli_query($link,$sql);
if($result)
{
    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        $preorderDate = $row["preorderDate"];
        $customerLastName = $row["customerLastName"];
        $customerFirstName = $row["customerFirstName"];
        $customerMidName = $row["customerMidName"];
        $customerPhone = $row["customerPhone"];
        $customerAddress = $row["customerAddress"];
        $customerEmail = $row["customerEmail"];
        $additionalInfo = $row["additionalInfo"];
        $preorderStatus = $row["preorderStatus"];
        $statusInfo = $row["statusInfo"];
        $orderId = $row["orderId"];
    }
}

//<!-- BEGIN Tabs HTML Markup -->
$html = '
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="PreorderIdChangeStatus">Id предзаказа</label>
            <input type="number" min="0" id="PreorderIdChangeStatus" class="form-control" placeholder="Id предзаказа" name="PreorderIdChangeStatus" readonly value="'.$preorder_id.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="PreorderDateChangeStatus">Дата предзаказа</label>
            <input type="text" id="PreorderDateChangeStatus" class="form-control" placeholder="Дата предзаказа" name="PreorderDateChangeStatus" readonly value="'.$preorderDate.'">
        </div>
    </div>
    <div class="col">
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="CustomerLastNameChangeStatus">Фамилия</label>
            <input type="text" id="CustomerLastNameChangeStatus" class="form-control" placeholder="Фамилия" name="CustomerLastNameChangeStatus" readonly value="'.$customerLastName.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="CustomerFirstNameChangeStatus">Имя</label>
            <input type="text" id="CustomerFirstNameChangeStatus" class="form-control" placeholder="Имя" name="CustomerFirstNameChangeStatus" readonly value="'.$customerFirstName.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="CustomerMidNameChangeStatus">Отчество</label>
            <input type="text" id="CustomerMidNameChangeStatus" class="form-control" placeholder="Отчество" name="CustomerMidNameChangeStatus" readonly value="'.$customerMidName.'">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="CustomerPhoneChangeStatus">Телефон</label>
            <input type="text" id="CustomerPhoneChangeStatus" class="form-control" placeholder="Телефон" name="CustomerPhoneChangeStatus" readonly value="'.$customerPhone.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="CustomerAddressChangeStatus">Адрес</label>
            <input type="text" id="CustomerAddressChangeStatus" class="form-control" placeholder="Адрес" name="CustomerAddressChangeStatus" readonly value="'.$customerAddress.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="CustomerEmailChangeStatus">Email</label>
            <input type="text" id="CustomerEmailChangeStatus" class="form-control" placeholder="Email" name="CustomerEmailChangeStatus" readonly value="'.$customerEmail.'">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="AdditionalInfoChangeStatus">Дополнительно</label>
            <textarea id="AdditionalInfoChangeStatus" class="form-control" placeholder="Дополниельно" name="AdditionalInfoChangeStatus" readonly>'.$additionalInfo.'</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="PreorderStatusChangeStatus">Статус предзаказа</label>
            <select id="PreorderStatusChangeStatus" class="form-control" name="PreorderStatusChangeStatus">
                <option value="0"></option>';
if($preorderStatus == 1)
{
    $html .= '<option value="1" selected>1&nbsp;необработан</option>';
}
else
{
    $html .= '<option value="1">1&nbsp;необработан</option>';
}
if($preorderStatus == 2)
{
    $html .= '<option value="2" selected>2&nbsp;подтвержден</option>';
}
else
{
    $html .= '<option value="2">2&nbsp;подтвержден</option>';
}
if($preorderStatus == 3)
{
    $html .= '<option value="3" selected>3&nbsp;отклонен</option>';
}
else
{
    $html .= '<option value="3">3&nbsp;отклонен</option>';
}
$html .= '
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="OrderIdChangeStatus">Номер заказа</label>
            <input type="text" id="OrderIdChangeStatus" class="form-control" placeholder="Номер заказа" name="OrderIdChangeStatus" value="'.$orderId.'">
        </div>
    </div>
    <div class="col">
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="StatusInfoChangeStatus">Справка о статусе</label>
            <textarea id="StatusInfoChangeStatus" class="form-control" placeholder="Справка о статусе" name="StatusInfoChangeStatus">'.$statusInfo.'</textarea>
        </div>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->
echo $html;
?>
