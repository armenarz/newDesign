<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

if(isset($_POST["doctor_id"])) $doctor_id = $_POST["doctor_id"];
$sql = "SELECT * FROM doctor WHERE DoctorId='".$doctor_id."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row_cnt = mysqli_num_rows($result);
    if($row_cnt == 0)
    {
        $msg = "no_doctor";
        echo $msg;
        return;
    }
    $row = mysqli_fetch_array($result);
    $FirstName = $row["FirstName"];
    $LastName = $row["LastName"];
    $MidName = $row["MidName"];
    $personality_type = $row["personality_type"];
    $loyalty = $row["loyalty"];
    $BirthDate = $row["BirthDate"];
    $Discount = $row["Discount"];
    $Phone1 = $row["Phone1"];
    $Phone2 = $row["Phone2"];
    $Email = $row["Phone3"];
    $WorkPlaceId = $row["WorkPlaceId"];
    $Login = $row["Comment"];
    $Password = $row["wp"];
    $SalesId = $row["sales_id"];
    $Speciality = $row["profession"];
    $ActiveId = $row["active"];
}
//<!-- BEGIN Tabs HTML Markup -->
$msg = '
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="DoctorIdEdit">DoctorId</label>
            <input type="number" min="0" id="DoctorIdEdit" class="form-control" placeholder="DoctorId" name="DoctorIdEdit" readonly value="'.$doctor_id.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="FirstNameEdit">FirstName</label>
            <input type="text" id="FirstNameEdit" class="form-control" placeholder="FirstName" name="FirstNameEdit" value="'.$FirstName.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="LastNameEdit">LastName</label>
            <input type="text" id="LastNameEdit" class="form-control" placeholder="LastName" name="LastNameEdit" value="'.$LastName.'">
        </div>
    </div>
</div>
<div class="row">            
    <div class="col">
        <div class="form-group d-print-none">
            <label for="MidNameEdit">MidName</label>
            <input type="text" id="MidNameEdit" class="form-control" placeholder="MidName" name="MidNameEdit" value="'.$MidName.'">
        </div>
    </div>    
    <div class="col">
        <div class="form-group d-print-none">
            <label for="personality_typeEdit">Тип личности</label>
            <input type="text" id="personality_typeEdit" class="form-control" placeholder="Тип личности" name="personality_typeEdit" value="'.$personality_type.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="loyaltyEdit">Лояльность</label>
            <input type="text" id="loyaltyEdit" class="form-control" placeholder="Лояльность" name="loyaltyEdit" value="'.$loyalty.'">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="BirthDateEdit">Дата рождения</label>
            <input type="text" id="BirthDateEdit" class="form-control" placeholder="dd-mm-yyyy" name="BirthDateEdit" value="'.$BirthDate.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="DiscountEdit">Скидка</label>
            <input type="number" min="0" id="DiscountEdit" class="form-control" placeholder="Discount" name="DiscountEdit" value="'.$Discount.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="Phone1Edit">Номер телефона N1</label>
            <input type="text" id="Phone1Edit" class="form-control" placeholder="Phone1" name="Phone1Edit" value="'.$Phone1.'">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none">
            <label for="Phone2Edit">Номер телефона N2</label>
            <input type="text" id="Phone2Edit" class="form-control" placeholder="Phone2" name="Phone2Edit" value="'.$Phone2.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="EmailEdit">Электронная почта</label>
            <input type="email" id="EmailEdit" class="form-control" placeholder="Email" name="EmailEdit" value="'.$Email.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="WorkPlaceIdEdit">Место работы</label>
            <select id="WorkPlaceIdEdit" class="form-control" name="WorkPlaceIdEdit">
                <option value="0"></option>
';
$sql = "SELECT WorkPlaceId, WorkPlaceDesc FROM cworkplace";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["WorkPlaceId"].'"';
        if($WorkPlaceId == $row["WorkPlaceId"]) $msg .= ' selected';
        $msg .=  '>'.FillNonBreak($row["WorkPlaceId"],2).'&nbsp;'.$row["WorkPlaceDesc"].'</option>';
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
            <label for="LoginEdit">Логин</label>
            <input type="text" id="LoginEdit" class="form-control" placeholder="Login" name="LoginEdit" value="'.$Login.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="PasswordEdit">Пароль</label>
            <input type="text" id="PasswordEdit" class="form-control" placeholder="Password" name="PasswordEdit" value="'.$Password.'">
        </div>
    </div>
    <div class="col">
        <div class="form-group d-print-none">
            <label for="SalesIdEdit">Sales</label>
            <select id="SalesIdEdit" class="form-control" name="SalesIdEdit">
                <option value="0"></option>
';
$sql = "SELECT salesId, salesName FROM sales WHERE salesId<>'1'";
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
            <label for="SpecialityIdEdit">Специальность</label>
            <select id="SpecialityIdEdit" class="form-control" name="SpecialityIdEdit">
                <option value="0"></option>
';
$sql = "SELECT MethodId, Method FROM profession";
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
            <label for="ActiveIdEdit">Активность</label>
            <select id="ActiveIdEdit" class="form-control" name="ActiveIdEdit">
                <option value="0" 
';
if($ActiveId == 0) $msg .= 'selected';
$msg .='                >0&nbsp;not active</option>
                        <option value="1" ';
if($ActiveId == 1) $msg .=   'selected';
$msg .='
                        >1&nbsp;active</option>
                    </select>
                </div>
            </div>
            <div class="col">
            </div>
        </div>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->
echo $msg;
?>
