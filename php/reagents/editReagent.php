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

$Norm_maleEdit_haj = $_POST["Norm_maleEdit_haj"];
$Norm_maleEdit_eng = $_POST["Norm_maleEdit_eng"];
$Norm_maleEdit_rus = $_POST["Norm_maleEdit_rus"];

$norm_male_topEdit = $_POST["norm_male_topEdit"];
if($norm_male_topEdit == "") $norm_male_topEdit = 0;

$norm_male_bottomEdit = $_POST["norm_male_bottomEdit"];
if($norm_male_bottomEdit == "") $norm_male_bottomEdit = 0;

$Norm_femaleEdit = $_POST["Norm_femaleEdit"];

$Norm_femaleEdit_haj = $_POST["Norm_femaleEdit_haj"];
$Norm_femaleEdit_eng = $_POST["Norm_femaleEdit_eng"];
$Norm_femaleEdit_rus = $_POST["Norm_femaleEdit_rus"];

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

$sortingEdit = $_POST["sortingEdit"];

if(isset($_POST["analizatorsEdit"]))
{
    $analizatorsEdit = implode(',',$_POST["analizatorsEdit"]);
}

$transportationTemperatureEdit = $_POST["transportationTemperatureEdit"];
$storageTemperatureEdit = $_POST["storageTemperatureEdit"];
$shelfLifeEdit = $_POST["shelfLifeEdit"];

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
$sql .= "material_id='".$MaterialIdEdit."', ";
$sql .= "sorting='".$sortingEdit."', ";
$sql .= "analizators='".$analizatorsEdit."', ";
$sql .= "transportation_temperature='".$transportationTemperatureEdit."', ";
$sql .= "storage_temperature='".$storageTemperatureEdit."', ";
$sql .= "Norm_male_haj='".$Norm_maleEdit_haj."',";
$sql .= "Norm_male_eng='".$Norm_maleEdit_eng."',";
$sql .= "Norm_male_rus='".$Norm_maleEdit_rus."',";
$sql .= "Norm_female_haj='".$Norm_femaleEdit_haj."',";
$sql .= "Norm_female_eng='".$Norm_femaleEdit_eng."',";
$sql .= "Norm_female_rus='".$Norm_femaleEdit_rus."',";
$sql .= "shelf_life='".$shelfLifeEdit."' ";
$sql .= "WHERE ReagentId='".$ReagentIdEdit."'";

$editDate = date("Y-m-d H:i:s");
$result = mysqli_query($link,$sql);
if($result)
{
    $msg = "Reagent data successfully updated.";
    $user_id = $_POST["user_id"];
    $ReagentId = $_POST["ReagentIdOld"];
    
    //getting form's old data into variables
    $MashinidOld = $_POST["MashinidOld"];
    $LoincOld = $_POST["LoincOld"];
    $ReagentDescOld = $_POST["ReagentDescOld"];
    $ReagentDescRusOld = $_POST["ReagentDescRusOld"];
    $ReagentDescArmOld = $_POST["ReagentDescArmOld"];
    $GroupIdOld = $_POST["GroupIdOld"];
    $MethodIdOld = $_POST["MethodIdOld"];
	
    $Norm_maleOld = $_POST["Norm_maleOld"];
	
	$Norm_maleOld_haj = $_POST["Norm_maleOld_haj"];
	$Norm_maleOld_eng = $_POST["Norm_maleOld_eng"];
	$Norm_maleOld_rus = $_POST["Norm_maleOld_rus"];
	
    $Norm_femaleOld = $_POST["Norm_femaleOld"];
	
	$Norm_femaleOld_haj = $_POST["Norm_femaleOld_haj"];
	$Norm_femaleOld_eng = $_POST["Norm_femaleOld_eng"];
	$Norm_femaleOld_rus = $_POST["Norm_femaleOld_rus"];
	
    $norm_male_topOld = $_POST["norm_male_topOld"];
    $norm_male_bottomOld = $_POST["norm_male_bottomOld"];
    $norm_female_topOld = $_POST["norm_female_topOld"];
    $norm_female_bottomOld = $_POST["norm_female_bottomOld"];
    $CalibrationOld = $_POST["CalibrationOld"];
    $ControlOld = $_POST["ControlOld"];
    $ed_ismerOld = $_POST["ed_ismerOld"];
    $dilutionOld = $_POST["dilutionOld"];
    $UnitPriceOld = $_POST["UnitPriceOld"];
    $AnalysisPriceOld = $_POST["AnalysisPriceOld"];
    $ProducerIdOld = $_POST["ProducerIdOld"];
    $ReagentEquivalentOld = $_POST["ReagentEquivalentOld"];
    $MaterialIdOld = $_POST["MaterialIdOld"];
    $probirkaIdOld = $_POST["probirkaIdOld"];
    $probirka2IdOld = $_POST["probirka2IdOld"];
    $probirka3IdOld = $_POST["probirka3IdOld"];

    $activOld = "";
    if($_POST["activOld"] == 0) $activOld = "activ";
    elseif($_POST["activOld"] == 1) $activOld = "activ";
    elseif($_POST["activOld"] == 2) $activOld = "not activ";

    $TitleOld = $_POST["TitleOld"];
    $do12Old = $_POST["do12Old"];
    $posle12Old = $_POST["posle12Old"];
    $Method2IdOld = $_POST["Method2IdOld"];
    $gotovnostNOld = $_POST["gotovnostNOld"];
    $visibilityOld = $_POST["visibilityOld"];
    $gotovnost4Old = $_POST["gotovnost4Old"];
    $gotovnostOld = $_POST["gotovnostOld"];
    $srok_gotovnostiOld = $_POST["srok_gotovnostiOld"];
    $sortingOld = $_POST["sortingOld"];

    if(isset($_POST["analizatorsOld"]))
    {
        $analizatorsOld = implode(',',$_POST["analizatorsOld"]);
    }

    $transportationTemperatureOld = $_POST["transportationTemperatureOld"];
    $storageTemperatureOld = $_POST["storageTemperatureOld"];
    $shelfLifeOld = $_POST["shelfLifeOld"];

    //putting form's old data into associative array
    $formOldData = array(   "Mashinid" => $MashinidOld, 
                            "Loinc" => $LoincOld, 
                            "ReagentDesc" => $ReagentDescOld, 
                            "ReagentDescRus" => $ReagentDescRusOld, 
                            "ReagentDescArm" => $ReagentDescArmOld,
                            "GroupId" => $GroupIdOld, 
                            "MethodId" => $MethodIdOld, 
                            "Norm_male" => $Norm_maleOld,
							"Norm_male_haj" => $Norm_maleOld_haj,
							"Norm_male_eng" => $Norm_maleOld_eng,
							"Norm_male_rus" => $Norm_maleOld_rus,
                            "Norm_female" => $Norm_femaleOld,
							"Norm_female_haj" => $Norm_femaleOld_haj,
							"Norm_female_eng" => $Norm_femaleOld_eng,
							"Norm_female_rus" => $Norm_femaleOld_rus,
                            "norm_male_top" => $norm_male_topOld,
                            "norm_male_bottom" => $norm_male_bottomOld, 
                            "norm_female_top" => $norm_female_topOld, 
                            "norm_female_bottom" => $norm_female_bottomOld, 
                            "Calibration" => $CalibrationOld,
                            "Control" => $ControlOld, 
                            "ed_ismer" => $ed_ismerOld, 
                            "dilution" => $dilutionOld, 
                            "UnitPrice" => $UnitPriceOld, 
                            "AnalysisPrice" => $AnalysisPriceOld,
                            "ProducerId" => $ProducerIdOld, 
                            "ReagentEquivalent" => $ReagentEquivalentOld, 
                            "MaterialId" => $MaterialIdOld, 
                            "probirkaId" => $probirkaIdOld, 
                            "probirka2Id" => $probirka2IdOld,
                            "probirka3Id" => $probirka3IdOld, 
                            "activ" => $activOld, 
                            "Title" => $TitleOld, 
                            "do12" => $do12Old, 
                            "posle12" => $posle12Old, 
                            "Method2Id" => $Method2IdOld,
                            "gotovnostN" => $gotovnostNOld, 
                            "visibility" => $visibilityOld, 
                            "gotovnost4" => $gotovnost4Old, 
                            "gotovnost" => $gotovnostOld, 
                            "srok_gotovnosti" => $srok_gotovnostiOld,
                            "sorting" => $sortingOld,
                            "analizators" => $analizatorsOld,
                            "transportation_temperature" => $transportationTemperatureOld,
                            "storage_temperature" => $storageTemperatureOld,
                            "shelf_life" => $shelfLifeOld
                        );

    //putting form's new data into associative array
    $formNewData = array(   "Mashinid" => $MashinidEdit, 
                            "Loinc" => $LoincEdit, 
                            "ReagentDesc" => $ReagentDescEdit, 
                            "ReagentDescRus" => $ReagentDescRusEdit, 
                            "ReagentDescArm" => $ReagentDescArmEdit,
                            "GroupId" => $GroupIdEdit, 
                            "MethodId" => $MethodIdEdit, 
                            "Norm_male" => $Norm_maleEdit,
							"Norm_male_haj" => $Norm_maleEdit_haj,
							"Norm_male_eng" => $Norm_maleEdit_eng,
							"Norm_male_rus" => $Norm_maleEdit_rus,
                            "Norm_female" => $Norm_femaleEdit,
							"Norm_female_haj" => $Norm_femaleEdit_haj,
							"Norm_female_eng" => $Norm_femaleEdit_eng,
							"Norm_female_rus" => $Norm_femaleEdit_rus,
                            "norm_male_top" => $norm_male_topEdit,
                            "norm_male_bottom" => $norm_male_bottomEdit, 
                            "norm_female_top" => $norm_female_topEdit, 
                            "norm_female_bottom" => $norm_female_bottomEdit, 
                            "Calibration" => $CalibrationEdit,
                            "Control" => $ControlEdit, 
                            "ed_ismer" => $ed_ismerEdit, 
                            "dilution" => $dilutionEdit, 
                            "UnitPrice" => $UnitPriceEdit, 
                            "AnalysisPrice" => $AnalysisPriceEdit,
                            "ProducerId" => $ProducerIdEdit, 
                            "ReagentEquivalent" => $ReagentEquivalentEdit, 
                            "MaterialId" => $MaterialIdEdit, 
                            "probirkaId" => $probirkaIdEdit, 
                            "probirka2Id" => $probirka2IdEdit,
                            "probirka3Id" => $probirka3IdEdit, 
                            "activ" => $activEdit, 
                            "Title" => $TitleEdit, 
                            "do12" => $do12Edit, 
                            "posle12" => $posle12Edit, 
                            "Method2Id" => $Method2IdEdit,
                            "gotovnostN" => $gotovnostNEdit, 
                            "visibility" => $visibilityEdit, 
                            "gotovnost4" => $gotovnost4Edit, 
                            "gotovnost" => $gotovnostEdit, 
                            "srok_gotovnosti" => $srok_gotovnostiEdit,
                            "sorting" => $sortingEdit,
                            "analizators" => $analizatorsEdit,
                            "transportation_temperature" => $transportationTemperatureEdit,
                            "storage_temperature" => $storageTemperatureEdit,
                            "shelf_life" => $shelfLifeEdit
                        );
    
    foreach($formNewData as $key => $value)
    {
        if($value != $formOldData[$key])
        {
            $FieldName = $key;
            $OldValue = $formOldData[$key];
            $NewValue = $value; 

            $sql_log = " INSERT INTO 
                        reagent_edit_log 
                        (
                            UserId, 
                            EditDate, 
                            ReagentId, 
                            FieldName, 
                            OldValue, 
                            NewValue
                        )
                    VALUES 
                    ( 
                        '$user_id', 
                        '$editDate', 
                        '$ReagentId', 
                        '$FieldName', 
                        '$OldValue', 
                        '$NewValue' 
                    )";
            
            $result_log = mysqli_query($link,$sql_log);
            if(!$result_log)
            {
                echo "Error: ".mysqli_error($link)." error number: ".mysqli_errno($link);
                return;
            }
        }
    }
}
else
{
    $msg = mysqli_error($link);
}
echo $msg;
?>