<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

if(isset($_POST["workplaceId"])) $WorkPlaceId = $_POST["workplaceId"];
if(isset($_POST["salesId"])) $SalesId = $_POST["salesId"];
if(isset($_POST["specialityId"])) 
{
    $SpecialityId = $_POST["specialityId"];
    
    $sql = "SELECT Method FROM profession WHERE MethodId='".$SpecialityId."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $Speciality = $row["Method"];
    }
}
//<!-- BEGIN Tabs HTML Markup -->
$msg = '
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="DoctorIdAdd">DoctorId</label>
            <input type="number" min="0" id="DoctorIdAdd" class="form-control" placeholder="DoctorId" name="DoctorIdAdd" readonly>
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="FirstNameAdd">FirstName</label>
            <input type="text" id="FirstNameAdd" class="form-control" placeholder="FirstName" name="FirstNameAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="LastNameAdd">LastName</label>
            <input type="text" id="LastNameAdd" class="form-control" placeholder="LastName" name="LastNameAdd">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="MidNameAdd">MidName</label>
            <input type="text" id="MidNameAdd" class="form-control" placeholder="MidName" name="MidNameAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="personality_typeAdd">Тип личности</label>
            <input type="text" id="personality_typeAdd" class="form-control" placeholder="Тип личности" name="personality_typeAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="loyaltyAdd">Лояльность</label>
            <input type="text" id="loyaltyAdd" class="form-control" placeholder="Лояльность" name="loyaltyAdd">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="BirthDateAdd">Дата рождения</label>
            <input type="text" id="BirthDateAdd" class="form-control" placeholder="dd-mm-yyyy" name="BirthDateAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="DiscountAdd">Скидка</label>
            <input type="number" min="0" id="DiscountAdd" class="form-control" placeholder="Discount" name="DiscountAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="Phone1Add">Номер телефона N1</label>
            <input type="text" id="Phone1Add" class="form-control" placeholder="Phone1" name="Phone1Add">
        </div>
    </div>
</div>
<div class="row">       
    <div class="col">
        <div class="form-group d-print-none">
            <label for="Phone2Add">Номер телефона N2</label>
            <input type="text" id="Phone2Add" class="form-control" placeholder="Phone2" name="Phone2Add">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="EmailAdd">Электронная почта</label>
            <input type="email" id="EmailAdd" class="form-control" placeholder="Email" name="EmailAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="WorkPlaceIdAdd">Место работы</label>
            <select id="WorkPlaceIdAdd" class="form-control" name="WorkPlaceIdAdd">
                <option value="0"></option>
';
$sql = "SELECT WorkPlaceId, WorkPlaceDesc FROM cworkplace ORDER BY WorkPlaceDesc";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["WorkPlaceId"].'"';
        if($WorkPlaceId == $row["WorkPlaceId"]) $msg .= ' selected';
        $msg .=  '>'.FillNonBreak($row["WorkPlaceId"],3).'&nbsp;'.$row["WorkPlaceDesc"].'</option>';
    }
}
$msg .='
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="LoginAdd">Логин</label>
            <input type="text" id="LoginAdd" class="form-control" placeholder="Login" name="LoginAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="PasswordAdd">Пароль</label>
            <input type="text" id="PasswordAdd" class="form-control" placeholder="Password" name="PasswordAdd">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="SalesIdAdd">Sales</label>
            <select id="SalesIdAdd" class="form-control" name="SalesIdAdd">
                <option value="0"></option>
';
$sql = "SELECT salesId, salesName FROM sales WHERE salesId<>'1' ORDER BY salesName";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["salesId"].'"';
        if($SalesId == $row["salesId"]) $msg .= ' selected';
        $msg .=  '>'.FillNonBreak($row["salesId"],2).'&nbsp;'.$row["salesName"].'</option>';
    }
}
$msg .='
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="SpecialityIdAdd">Специальность</label>
            <select id="SpecialityIdAdd" class="form-control" name="SpecialityIdAdd">
                <option value="0"></option>
';
$sql = "SELECT MethodId, Method FROM profession ORDER BY Method";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["MethodId"].'"';
        if($Speciality == $row["Method"]) $msg .= ' selected';
        $msg .=  '>'.FillNonBreak($row["MethodId"],2).'&nbsp;'.$row["Method"].'</option>';
    }
}
$msg .='
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="ActiveIdAdd">Активность</label>
            <select id="ActiveIdAdd" class="form-control" name="ActiveIdAdd">
                <option value="0">0&nbsp;not active</option>
                <option value="1" selected>1&nbsp;active</option>
            </select>
        </div>
    </div>
    <div class="col">
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->


echo $msg;
?>
