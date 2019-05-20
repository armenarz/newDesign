<?php
require_once "../connect.php";
require_once "../authorization.php";
$ReagentIdCopy = $_POST["ReagentIdCopy"];

$ReagentDescCopy = $_POST["ReagentDescCopy"];
$ReagentDescRusCopy = $_POST["ReagentDescRusCopy"];
$ReagentDescArmCopy = $_POST["ReagentDescArmCopy"];

$UnitPriceCopy = $_POST["UnitPriceCopy"];
if($UnitPriceCopy == "") $UnitPriceCopy = 0;

$LoincCopy = $_POST["LoincCopy"];
if($LoincCopy == "") $LoincCopy = 0;

$AnalysisPriceCopy = $_POST["AnalysisPriceCopy"];
if($AnalysisPriceCopy == "") $AnalysisPriceCopy = 0;

$MethodCopy = "";
$MethodIdCopy = $_POST["MethodIdCopy"];
$sql = "SELECT Method FROM method WHERE MethodId='".$MethodIdCopy."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $MethodCopy = $row["Method"];
}

$Norm_maleCopy = $_POST["Norm_maleCopy"];

$norm_male_topCopy = $_POST["norm_male_topCopy"];
if($norm_male_topCopy == "") $norm_male_topCopy = 0;

$norm_male_bottomCopy = $_POST["norm_male_bottomCopy"];
if($norm_male_bottomCopy == "") $norm_male_bottomCopy = 0;

$Norm_femaleCopy = $_POST["Norm_femaleCopy"];

$norm_female_topCopy = $_POST["norm_female_topCopy"];
if($norm_female_topCopy == "") $norm_female_topCopy = 0;

$norm_female_bottomCopy = $_POST["norm_female_bottomCopy"];
if($norm_female_bottomCopy == "") $norm_female_bottomCopy = 0;

$CalibrationCopy = $_POST["CalibrationCopy"];
//if($CalibrationCopy == "") $CalibrationCopy = "&nbsp;";

$ControlCopy = $_POST["ControlCopy"];
//if($ControlCopy == "") $ControlCopy == "&nbsp;";

$dilutionCopy = $_POST["dilutionCopy"];
if($dilutionCopy == "") $dilutionCopy = 0;

$GroupIdCopy = $_POST["GroupIdCopy"];

$ProducerIdCopy = $_POST["ProducerIdCopy"];
if($ProducerIdCopy == "") $ProducerIdCopy = 0;

$ReagentEquivalentCopy = $_POST["ReagentEquivalentCopy"];
if($ReagentEquivalentCopy == "") $ReagentEquivalentCopy = 0;

$MaterialCopy = $_POST["MaterialCopy"];
$numCopy = $_POST["numCopy"];

$activCopy = "";
if($_POST["activCopy"] == 0) $activCopy = "activ";
elseif($_POST["activCopy"] == 1) $activCopy = "activ";
elseif($_POST["activCopy"] == 2) $activCopy = "not activ";

$ed_ismerCopy = $_POST["ed_ismerCopy"];
//if($ed_ismerCopy == "") $ed_ismerCopy = "&nbsp;";

$MashinidCopy = $_POST["MashinidCopy"];
if($MashinidCopy == "") $MashinidCopy = 0;

$probirkaIdCopy = $_POST["probirkaIdCopy"];
if($probirkaIdCopy == 0)
{
    //$probirkaCopy = "&nbsp;";
}
else
{
    $probirkaCopy = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirkaIdCopy."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirkaCopy = $row["prob"];
    }
}


$TitleCopy = $_POST["TitleCopy"];

$do12Copy = $_POST["do12Copy"];
$posle12Copy = $_POST["posle12Copy"];
//$Method2Copy = $_POST["Method2Copy"];

$Method2IdCopy = $_POST["Method2IdCopy"];
$Method2Copy = "";
$sql = "SELECT Method FROM method2 WHERE MethodId='".$Method2IdCopy."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $Method2Copy = $row["Method"];
}

if(isset($_POST["probirka_zCopy"]))
{
    $probirka_zCopy = array();
    $sql = "SELECT id, prob FROM probirka_z";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        while($row = mysqli_fetch_array($result))
        {
            foreach($_POST["probirka_zCopy"] as $value)
            {
                if($row["id"] == $value)
                {
                    $probirka_zCopy[$row["id"]][] = $row["prob"];
                }
            }
        }
    }
    $probirka_zCopy = json_encode($probirka_zCopy);
}
else
{
    $probirka_zCopy = "{}";
}

$gotovnostCopy = $_POST["gotovnostCopy"];
//if($gotovnostCopy == "") $gotovnostCopy = "&nbsp;";

$srok_gotovnostiCopy = $_POST["srok_gotovnostiCopy"];
//if($srok_gotovnostiCopy == "") $srok_gotovnostiCopy = "&nbsp;";

$gotovnostNCopy = $_POST["gotovnostNCopy"];
//if($gotovnostNCopy == "") $gotovnostNCopy = "&nbsp;";

$probirka2IdCopy = $_POST["probirka2IdCopy"];
if($probirka2IdCopy == 0)
{
    //$probirka2Copy = "&nbsp;";
}
else
{
    $probirka2Copy = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirka2IdCopy."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirka2Copy = $row["prob"];
    }
}


$probirka3IdCopy = $_POST["probirka3IdCopy"];
if($probirka3IdCopy == 0)
{
    //$probirka3Copy = "&nbsp;";
}
else
{
    $probirka3Copy = "";
    $sql = "SELECT prob FROM probirka WHERE id='".$probirka3IdCopy."'";
    $result = mysqli_query($link,$sql);
    if($result)
    {
        $row = mysqli_fetch_array($result);
        $probirka3Copy = $row["prob"];
    }
}

$visibilityCopy = $_POST["visibilityCopy"];
$MaterialIdCopy = $_POST["MaterialIdCopy"];

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
$sql .= "material_id";
$sql .= ") VALUES ('";
$sql .= $ReagentDescCopy."', '";
$sql .= $ReagentDescRusCopy."', '";
$sql .= $ReagentDescArmCopy."', '";
$sql .= $UnitPriceCopy."', '";
$sql .= $LoincCopy."', '";
$sql .= $AnalysisPriceCopy."', '";
$sql .= $MethodCopy."', '";
$sql .= $Norm_maleCopy."', '";
$sql .= $norm_male_topCopy."', '";
$sql .= $norm_male_bottomCopy."', '";
$sql .= $Norm_femaleCopy."', '";
$sql .= $norm_female_topCopy."', '";
$sql .= $norm_female_bottomCopy."', '";
$sql .= $CalibrationCopy."', '";
$sql .= $ControlCopy."', '";
$sql .= $dilutionCopy."', '";
$sql .= $GroupIdCopy."', '";
$sql .= $ProducerIdCopy."', '";
$sql .= $ReagentEquivalentCopy."', '";
$sql .= $activCopy."', '";
$sql .= $ed_ismerCopy."', '";
$sql .= $MashinidCopy."', '";
$sql .= $probirkaCopy."', '";
$sql .= $TitleCopy."', '";
$sql .= $do12Copy."', '";
$sql .= $posle12Copy."', '";
$sql .= $Method2Copy."', '";
$sql .= $Method2IdCopy."', '";
$sql .= $probirka_zCopy."', '";
$sql .= $gotovnostCopy."', '";
$sql .= $srok_gotovnostiCopy."', '";
$sql .= $gotovnostNCopy."', '";
$sql .= $probirka2Copy."', '";
$sql .= $probirka3Copy."', '";
$sql .= $visibilityCopy."', '";
$sql .= $MaterialIdCopy;
$sql .= "')";

$result = mysqli_query($link,$sql);
if($result)
{
    $newReagentIdCopy = mysqli_insert_id($link);
    $msg = "Реагент с Id=".$ReagentIdCopy." был успесшно копирован в новый реагент с Id=".$newReagentIdCopy;
    echo $msg;
    return;
}
else
{
    $msg = $sql." | ".mysqli_error($link);
    echo $msg;
}

?>