<?php
require_once "../connect.php";
require_once "../authorization.php";

$MashinidEdit = $_POST["MashinidEdit"];
$ReagentIdEdit = $_POST["ReagentIdEdit"];
$ReagentDescEdit = $_POST["ReagentDescEdit"];
$ReagentDescRusEdit = $_POST["ReagentDescRusEdit"];
$ReagentDescArmEdit = $_POST["ReagentDescArmEdit"];
$GroupIdEdit = $_POST["GroupIdEdit"];
$AnalysisPriceEdit = $_POST["AnalysisPriceEdit"];

$MethodIdEdit = $_POST["MethodIdEdit"];
$MethodEdit = "";
$sql = "SELECT Method FROM method WHERE MethodId='".$MethodIdEdit."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $MethodEdit = $row["Method"];
}

$Norm_maleEdit = $_POST["Norm_maleEdit"];

$norm_male_topEdit = $_POST["norm_male_topEdit"];
if($norm_male_topEdit == "") $norm_male_topEdit = 0;

$norm_male_bottomEdit = $_POST["norm_male_bottomEdit"];
if($norm_male_bottomEdit == "") $norm_male_bottomEdit = 0;

$Norm_femaleEdit = $_POST["Norm_femaleEdit"];

$norm_female_topEdit = $_POST["norm_female_topEdit"];
if($norm_female_topEdit == "") $norm_female_topEdit = 0;

$norm_female_bottomEdit = $_POST["norm_female_bottomEdit"];
if($norm_female_bottomEdit == "") $norm_female_bottomEdit = 0;

$CalibrationEdit = $_POST["CalibrationEdit"];
//if($CalibrationEdit == "") $CalibrationEdit = "&nbsp;";

$ControlEdit = $_POST["ControlEdit"];
//if($ControlEdit == "") $ControlEdit = "&nbsp;";

$ed_ismerEdit = $_POST["ed_ismerEdit"];
//if($ed_ismerEdit == "") $ed_ismerEdit = "&nbsp;";

$dilutionEdit = $_POST["dilutionEdit"];
if($dilutionEdit == "") $dilutionEdit = 0;

$UnitPriceEdit = $_POST["UnitPriceEdit"];
if($UnitPriceEdit == "") $UnitPriceEdit = 0;

$LoincEdit = $_POST["LoincEdit"];
if($LoincEdit == "") $LoincEdit = 0;

$ProducerIdEdit = $_POST["ProducerIdEdit"];
if($ProducerIdEdit == "") $ProducerIdEdit = 0;

$ReagentEquivalentEdit = $_POST["ReagentEquivalentEdit"];
if($ReagentEquivalentEdit == "") $ReagentEquivalentEdit = 0;

$probirkaIdEdit = $_POST["probirkaIdEdit"];
if($probirkaIdEdit == 0)
{
    //$probirkaEdit = "&nbsp;";
}
else
{
    $probirkaEdit = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirkaIdEdit."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirkaEdit = $row["prob"];
    }
}

$probirka2IdEdit = $_POST["probirka2IdEdit"];
if($probirka2IdEdit == 0)
{
    //$probirka2Edit = "&nbsp;";
}
else
{
    $probirka2Edit = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirka2IdEdit."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirka2Edit = $row["prob"];
    }
}

$probirka3IdEdit = $_POST["probirka3IdEdit"];
if($probirka3IdEdit == 0)
{
    //$probirka3Edit = "&nbsp;";
}
else
{
    $probirka3Edit = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirka3IdEdit."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirka3Edit = $row["prob"];
    }
}

$activEdit = "";
if($_POST["activEdit"] == 0) $activEdit = "activ";
elseif($_POST["activEdit"] == 1) $activEdit = "activ";
elseif($_POST["activEdit"] == 2) $activEdit = "not activ";

$TitleEdit = $_POST["TitleEdit"];
$do12Edit = $_POST["do12Edit"];
$posle12Edit = $_POST["posle12Edit"];

$Method2IdEdit = $_POST["Method2IdEdit"];
$Method2Edit = "";
$sql = "SELECT Method FROM method2 WHERE MethodId='".$Method2IdEdit."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $Method2Edit = $row["Method"];
}

$gotovnostEdit = $_POST["gotovnostEdit"];
//if($gotovnostEdit == "") $gotovnostEdit = "&nbsp;";

if(isset($_POST["probirka_zEdit"]))
{
    $probirka_zEdit = array();
    $sql = "SELECT id, prob FROM probirka_z";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        while($row = mysqli_fetch_array($result))
        {
            foreach($_POST["probirka_zEdit"] as $value)
            {
                if($row["id"] == $value)
                {
                    $probirka_zEdit[$row["id"]][] = $row["prob"];
                }
            }
        }
    }
    $probirka_zEdit = json_encode($probirka_zEdit);
}
else
{
    $probirka_zEdit = "{}";
}

$gotovnost4Edit = $_POST["gotovnost4Edit"];


$srok_gotovnostiEdit = $_POST["srok_gotovnostiEdit"];
//if($srok_gotovnostiEdit == "") $srok_gotovnostiEdit = "&nbsp;";

$gotovnostNEdit = $_POST["gotovnostNEdit"];
//if($gotovnostNEdit == "") $gotovnostNEdit = "&nbsp;";

$visibilityEdit = $_POST["visibilityEdit"];
$MaterialIdEdit = $_POST["MaterialIdEdit"];

$sql  = "UPDATE reagent SET ";
$sql .= "ReagentDesc='".$ReagentDescEdit."',";
$sql .= "ReagentDescRus='".$ReagentDescRusEdit."',";
$sql .= "ReagentDescArm='".$ReagentDescArmEdit."',";
$sql .= "UnitPrice='".$UnitPriceEdit."',";
$sql .= "Loinc='".$LoincEdit."',";
$sql .= "AnalysisPrice='".$AnalysisPriceEdit."',";
$sql .= "Method='".$MethodEdit."',";
$sql .= "Norm_male='".$Norm_maleEdit."',";
$sql .= "norm_male_top='".$norm_male_topEdit."',";
$sql .= "norm_male_bottom='".$norm_male_bottomEdit."',";
$sql .= "Norm_female='".$Norm_femaleEdit."',";
$sql .= "norm_female_top='".$norm_female_topEdit."',";
$sql .= "norm_female_bottom='".$norm_female_bottomEdit."',";
$sql .= "Calibration='".$CalibrationEdit."',";
$sql .= "Control='".$ControlEdit."',";
$sql .= "dilution='".$dilutionEdit."',";
$sql .= "GroupId='".$GroupIdEdit."',";
$sql .= "ProducerId='".$ProducerIdEdit."',";
$sql .= "ReagentEquivalent='".$ReagentEquivalentEdit."',";
$sql .= "activ='".$activEdit."',";
$sql .= "ed_ismer='".$ed_ismerEdit."',";
$sql .= "Mashinid='".$MashinidEdit."',";
$sql .= "probirka='".$probirkaEdit."',";
$sql .= "Title='".$TitleEdit."',";
$sql .= "do12='".$do12Edit."',";
$sql .= "posle12='".$posle12Edit."',";
$sql .= "Method2='".$Method2Edit."',";
$sql .= "Method2id='".$Method2IdEdit."',";
$sql .= "probirka_z='".$probirka_zEdit."',";
$sql .= "gotovnost='".$gotovnostEdit."',";
$sql .= "srok_gotovnosti='".$srok_gotovnostiEdit."',";
$sql .= "gotovnostN='".$gotovnostNEdit."',";
$sql .= "probirka2='".$probirka2Edit."',";
$sql .= "probirka3='".$probirka3Edit."',";
$sql .= "visibility='".$visibilityEdit."',";
$sql .= "gotovnost4='".$gotovnost4Edit."',";
$sql .= "material_id='".$MaterialIdEdit."' ";
$sql .= "WHERE ReagentId='".$ReagentIdEdit."'";

$result = mysqli_query($link,$sql);
if($result)
{
    $msg = "Reagent data successfully updated.";
}
else
{
    $msg = mysqli_error($link);
}
echo $msg;
?>