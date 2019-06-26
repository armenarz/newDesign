<?php
require_once "../connect.php";
require_once "../authorization.php";

$ReagentDescAdd = $_POST["ReagentDescAdd"];
$ReagentDescRusAdd = $_POST["ReagentDescRusAdd"];
$ReagentDescArmAdd = $_POST["ReagentDescArmAdd"];

$UnitPriceAdd = $_POST["UnitPriceAdd"];
if($UnitPriceAdd == "") $UnitPriceAdd = 0;

$LoincAdd = $_POST["LoincAdd"];
if($LoincAdd == "") $LoincAdd = 0;

$AnalysisPriceAdd = $_POST["AnalysisPriceAdd"];
if($AnalysisPriceAdd == "") $AnalysisPriceAdd = 0;

$MethodAdd = "";
$MethodIdAdd = $_POST["MethodIdAdd"];
$sql = "SELECT Method FROM method WHERE MethodId='".$MethodIdAdd."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $MethodAdd = $row["Method"];
}

$Norm_maleAdd = $_POST["Norm_maleAdd"];

$norm_male_topAdd = $_POST["norm_male_topAdd"];
if($norm_male_topAdd == "") $norm_male_topAdd = 0;

$norm_male_bottomAdd = $_POST["norm_male_bottomAdd"];
if($norm_male_bottomAdd == "") $norm_male_bottomAdd = 0;

$Norm_femaleAdd = $_POST["Norm_femaleAdd"];

$norm_female_topAdd = $_POST["norm_female_topAdd"];
if($norm_female_topAdd == "") $norm_female_topAdd = 0;

$norm_female_bottomAdd = $_POST["norm_female_bottomAdd"];
if($norm_female_bottomAdd == "") $norm_female_bottomAdd = 0;

$CalibrationAdd = $_POST["CalibrationAdd"];
//if($CalibrationAdd == "") $CalibrationAdd = "&nbsp;";

$ControlAdd = $_POST["ControlAdd"];
//if($ControlAdd == "") $ControlAdd == "&nbsp;";

$dilutionAdd = $_POST["dilutionAdd"];
if($dilutionAdd == "") $dilutionAdd = 0;

$GroupIdAdd = $_POST["GroupIdAdd"];

$ProducerIdAdd = $_POST["ProducerIdAdd"];
if($ProducerIdAdd == "") $ProducerIdAdd = 0;

$ReagentEquivalentAdd = $_POST["ReagentEquivalentAdd"];
if($ReagentEquivalentAdd == "") $ReagentEquivalentAdd = 0;

$MaterialIdAdd = $_POST["MaterialIdAdd"];
$numAdd = $_POST["numAdd"];

$activAdd = "";
if($_POST["activAdd"] == 0) $activAdd = "activ";
elseif($_POST["activAdd"] == 1) $activAdd = "activ";
elseif($_POST["activAdd"] == 2) $activAdd = "not activ";

$ed_ismerAdd = $_POST["ed_ismerAdd"];
//if($ed_ismerAdd == "") $ed_ismerAdd = "&nbsp;";

$MashinidAdd = $_POST["MashinidAdd"];
if($MashinidAdd == "") $MashinidAdd = 0;

$probirkaIdAdd = $_POST["probirkaIdAdd"];
if($probirkaIdAdd == 0)
{
    //$probirkaAdd = "&nbsp;";
}
else
{
    $probirkaAdd = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirkaIdAdd."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirkaAdd = $row["prob"];
    }
}


$TitleAdd = $_POST["TitleAdd"];

$do12Add = $_POST["do12Add"];
$posle12Add = $_POST["posle12Add"];
//$Method2Add = $_POST["Method2Add"];

$Method2IdAdd = $_POST["Method2IdAdd"];
$Method2Add = "";
$sql = "SELECT Method FROM method2 WHERE MethodId='".$Method2IdAdd."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $Method2Add = $row["Method"];
}

if(isset($_POST["probirka_zAdd"]))
{
    $probirka_zAdd = array();
    $sql = "SELECT id, prob FROM probirka_z";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        while($row = mysqli_fetch_array($result))
        {
            foreach($_POST["probirka_zAdd"] as $value)
            {
                if($row["id"] == $value)
                {
                    $probirka_zAdd[$row["id"]][] = $row["prob"];
                }
            }
        }
    }
    $probirka_zAdd = json_encode($probirka_zAdd);
}
else
{
    $probirka_zAdd = "{}";
}

$gotovnostAdd = $_POST["gotovnostAdd"];
//if($gotovnostAdd == "") $gotovnostAdd = "&nbsp;";

$srok_gotovnostiAdd = $_POST["srok_gotovnostiAdd"];
//if($srok_gotovnostiAdd == "") $srok_gotovnostiAdd = "&nbsp;";

$gotovnostNAdd = $_POST["gotovnostNAdd"];
//if($gotovnostNAdd == "") $gotovnostNAdd = "&nbsp;";

$gotovnost4Add = $_POST["gotovnost4Add"];

$probirka2IdAdd = $_POST["probirka2IdAdd"];
if($probirka2IdAdd == 0)
{
    //$probirka2Add = "&nbsp;";
}
else
{
    $probirka2Add = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirka2IdAdd."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirka2Add = $row["prob"];
    }
}


$probirka3IdAdd = $_POST["probirka3IdAdd"];
if($probirka3IdAdd == 0)
{
    //$probirka3Add = "&nbsp;";
}
else
{
    $probirka3Add = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirka3IdAdd."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirka3Add = $row["prob"];
    }
}


$visibilityAdd = $_POST["visibilityAdd"];

$sql = "INSERT INTO reagent(";
$sql .= "ReagentDesc, ";
$sql .= "ReagentDescRus, ";
$sql .= "ReagentDescArm, ";
$sql .= "UnitPrice, ";
$sql .= "Loinc, ";
$sql .= "AnalysisPrice, ";
$sql .= "Method, ";
$sql .= "Norm_male, ";
$sql .= "norm_male_top, ";
$sql .= "norm_male_bottom, ";
$sql .= "Norm_female, ";
$sql .= "norm_female_top, ";
$sql .= "norm_female_bottom, ";
$sql .= "Calibration, ";
$sql .= "Control, ";
$sql .= "dilution, ";
$sql .= "GroupId, ";
$sql .= "ProducerId, ";
$sql .= "ReagentEquivalent, ";
//$sql .= "Material, ";
$sql .= "activ, ";
$sql .= "ed_ismer, ";
$sql .= "Mashinid, ";
$sql .= "probirka, ";
$sql .= "Title, ";
$sql .= "do12, ";
$sql .= "posle12, ";
$sql .= "Method2, ";
$sql .= "Method2id, ";
$sql .= "probirka_z, ";
$sql .= "gotovnost, ";
$sql .= "srok_gotovnosti, ";
$sql .= "gotovnostN, ";
$sql .= "probirka2, ";
$sql .= "probirka3, ";
$sql .= "visibility, ";
$sql .= "gotovnost4, ";
$sql .= "material_id";//material_id
$sql .= ") VALUES ('";
$sql .= $ReagentDescAdd."', '";
$sql .= $ReagentDescRusAdd."', '";
$sql .= $ReagentDescArmAdd."', '";
$sql .= $UnitPriceAdd."', '";
$sql .= $LoincAdd."', '";
$sql .= $AnalysisPriceAdd."', '";
$sql .= $MethodAdd."', '";
$sql .= $Norm_maleAdd."', '";
$sql .= $norm_male_topAdd."', '";
$sql .= $norm_male_bottomAdd."', '";
$sql .= $Norm_femaleAdd."', '";
$sql .= $norm_female_topAdd."', '";
$sql .= $norm_female_bottomAdd."', '";
$sql .= $CalibrationAdd."', '";
$sql .= $ControlAdd."', '";
$sql .= $dilutionAdd."', '";
$sql .= $GroupIdAdd."', '";
$sql .= $ProducerIdAdd."', '";
$sql .= $ReagentEquivalentAdd."', '";
//$sql .= $MaterialIdAdd."', '";
$sql .= $activAdd."', '";
$sql .= $ed_ismerAdd."', '";
$sql .= $MashinidAdd."', '";
$sql .= $probirkaAdd."', '";
$sql .= $TitleAdd."', '";
$sql .= $do12Add."', '";
$sql .= $posle12Add."', '";
$sql .= $Method2Add."', '";
$sql .= $Method2IdAdd."', '";
$sql .= $probirka_zAdd."', '";
$sql .= $gotovnostAdd."', '";
$sql .= $srok_gotovnostiAdd."', '";
$sql .= $gotovnostNAdd."', '";
$sql .= $probirka2Add."', '";
$sql .= $probirka3Add."', '";
$sql .= $visibilityAdd."', '";
$sql .= $gotovnost4Add."', '";
$sql .= $MaterialIdAdd."'";
$sql .= ")";

$result = mysqli_query($link,$sql);
if($result)
{
    $msg = "New reagent successfully added.";
}
else
{
    $msg = $sql." | ".mysqli_error($link);
}
echo $msg;
?>