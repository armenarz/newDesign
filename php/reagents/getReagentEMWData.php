<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

if(isset($_POST["reagent_id"])) $reagent_id = $_POST["reagent_id"];
$sql = "SELECT * FROM reagent WHERE ReagentId='".$reagent_id."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row_cnt = mysqli_num_rows($result);
    if($row_cnt == 0)
    {
        $msg = "no_reagent";
        echo $msg;
        return;
    }
    $row = mysqli_fetch_array($result);
    $ReagentDesc = $row["ReagentDesc"];
    $ReagentDescRus = $row["ReagentDescRus"];
    $ReagentDescArm = $row["ReagentDescArm"];
    $UnitPrice = $row["UnitPrice"];
    $Loinc = $row["Loinc"];
    $AnalysisPrice = $row["AnalysisPrice"];
    $Method = $row["Method"];
    $Norm_male = $row["Norm_male"];
    $norm_male_top = $row["norm_male_top"];
    $norm_male_bottom = $row["norm_male_bottom"];
    $Norm_female = $row["Norm_female"];
    $norm_female_top = $row["norm_female_top"];
    $norm_female_bottom = $row["norm_female_bottom"];
    $Calibration = $row["Calibration"];
    $Control = $row["Control"];
    $dilution = $row["dilution"];
    $GroupId = $row["GroupId"];
    $ProducerId = $row["ProducerId"];
    $ReagentEquivalent = $row["ReagentEquivalent"];
    //$Material = $row["Material"];
    $num = $row["num"];
    $activ = $row["activ"];
    $ed_ismer = $row["ed_ismer"];
    $Mashinid = $row["Mashinid"];
    $probirka = $row["probirka"];
    $Title = $row["Title"];
    $do12 = $row["do12"];
    $posle12 = $row["posle12"];
    $Method2 = $row["Method2"];
    $Method2id = $row["Method2id"];

    $probirka_z = array();
    if(json_decode($row["probirka_z"],true) == NULL)
    {
        $probirka_z = explode(',',$row["probirka_z"]);
    }
    else
    {
        $probirka_zAssoc = json_decode($row["probirka_z"],true);
        if(count($probirka_zAssoc) > 0)
        {
            foreach($probirka_zAssoc as $key => $value)
            {
                $probirka_z[] = $key;
            }
        }
    }
    $gotovnost = $row["gotovnost"];
    $srok_gotovnosti = $row["srok_gotovnosti"];
    $gotovnostN = $row["gotovnostN"];
    $probirka2 = $row["probirka2"];
    $probirka3 = $row["probirka3"];
    $visibility = $row["visibility"];
    $MaterialId = $row["material_id"];
}
//<!-- BEGIN Tabs HTML Markup -->
$msg ='
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="MashinidEdit">Mashinid</label>
                    <input type="number" min="0" id="MashinidEdit" class="form-control" placeholder="Mashinid" name="MashinidEdit" value="'.$Mashinid.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentIdEdit">ReagentId</label>
                    <input type="text" id="ReagentIdEdit" class="form-control" placeholder="ReagentId" name="ReagentIdEdit" readonly value="'.$reagent_id.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="LoincEdit">Loinc</label>
                    <input type="number" min="0" id="LoincEdit" class="form-control" placeholder="Loinc" name="LoincEdit" value="'.$Loinc.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentDescEdit">ReagentDesc</label>
                    <input type="text" id="ReagentDescEdit" class="form-control" placeholder="ReagentDesc" name="ReagentDescEdit" value="'.$ReagentDesc.'">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentDescRusEdit">ReagentDescRus</label>
                    <input type="text" id="ReagentDescRusEdit" class="form-control" placeholder="ReagentDescRus" name="ReagentDescRusEdit" value="'.$ReagentDescRus.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentDescArmEdit">ReagentDescArm</label>
                    <input type="text" id="ReagentDescArmEdit" class="form-control" placeholder="ReagentDescArm" name="ReagentDescArmEdit" value="'.$ReagentDescArm.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="GroupIdEdit">GroupId</label>
                    <select id="GroupIdEdit" class="form-control" placeholder="GroupId" name="GroupIdEdit">
                        <option value="0"></option>
';

$sql = "SELECT GroupId, GroupDesc, GroupDescRus FROM reagentgroup";
$result = mysqli_query($link,$sql);
if($result)
{
while($row = mysqli_fetch_array($result))
{
$msg .=  '<option value="'.$row["GroupId"].'"';
if($GroupId == $row["GroupId"]) $msg .= ' selected';
$msg .='>'.FillNonBreak($row["GroupId"],2).'&nbsp;'.ConcatWithBrackets($row["GroupDesc"],$row["GroupDescRus"]).'</option>';
}
}

$msg .= '
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="MethodIdEdit">MethodId</label>
                    <select id="MethodIdEdit" class="form-control" placeholder="MethodIdEdit" name="MethodIdEdit">
                        <option value="0"></option>
';
$sql = "SELECT MethodId, Method FROM method";
$result = mysqli_query($link,$sql);
if($result)
{
while($row = mysqli_fetch_array($result))
{
$msg .=  '<option value="'.$row["MethodId"].'"';
if($Method == $row["Method"]) $msg .= ' selected';
$msg .='>'.FillNonBreak($row["MethodId"],2).'&nbsp;'.$row["Method"].'</option>';
}
}
$msg .='
                    </select>
                </div>
            </div>    
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="Norm_maleEdit">Norm_male</label>
                    <textarea id="Norm_maleEdit" class="form-control" placeholder="Norm_male" name="Norm_maleEdit">'.$Norm_male.'</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                <label for="Norm_femaleEdit">Norm_female</label>
                <textarea id="Norm_femaleEdit" class="form-control" placeholder="Norm_female" name="Norm_femaleEdit">'.$Norm_female.'</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_male_topEdit">norm_male_top</label>
                    <input type="number" min="0" step="0.001" id="norm_male_topEdit" class="form-control" placeholder="norm_male_top" name="norm_male_topEdit" value="'.$norm_male_top.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_male_bottomEdit">norm_male_bottom</label>
                    <input type="number" min="0" step="0.001" id="norm_male_bottomEdit" class="form-control" placeholder="norm_male_bottom" name="norm_male_bottomEdit" value="'.$norm_male_bottom.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_female_topEdit">norm_female_top</label>
                    <input type="number" min="0" step="0.001" id="norm_female_topEdit" class="form-control" placeholder="norm_female_top" name="norm_female_topEdit" value="'.$norm_female_top.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_female_bottomEdit">norm_female_bottom</label>
                    <input type="number" min="0" step="0.001" id="norm_female_bottomEdit" class="form-control" placeholder="norm_female_bottom" name="norm_female_bottomEdit" value="'.$norm_female_bottom.'">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="CalibrationEdit">Норма мужчин</label>
                    <input type="text" id="CalibrationEdit" class="form-control" placeholder="Calibration" name="CalibrationEdit" value="'.$Calibration.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ControlEdit">Норма женщин</label>
                    <input type="text" id="ControlEdit" class="form-control" placeholder="Control" name="ControlEdit" value="'.$Control.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ed_ismerEdit">ed_ismer</label>
                    <input type="text" id="ed_ismerEdit" class="form-control" placeholder="ed_ismer" name="ed_ismerEdit" value="'.$ed_ismer.'">
                </div>
            </div>        
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="dilutionEdit">Склад</label>
                    <input type="number" min="0" id="dilutionEdit" class="form-control" placeholder="видимый/невидимый" name="dilutionEdit" value="'.$dilution.'">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="UnitPriceEdit">Натощак</label>
                    <input type="number" min="0" step="0.01" id="UnitPriceEdit" class="form-control" placeholder="Натощак" name="UnitPriceEdit" value="'.$UnitPrice.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="AnalysisPriceEdit">AnalysisPrice</label>
                    <input type="number" min="0" id="AnalysisPriceEdit" class="form-control" placeholder="AnalysisPrice" name="AnalysisPriceEdit" value="'.$AnalysisPrice.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ProducerIdEdit">ProducerId</label>
                    <input type="number" min="1" id="ProducerIdEdit" class="form-control" placeholder="ProducerId" name="ProducerIdEdit" value="'.$ProducerId.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentEquivalentEdit">ReagentEquivalent</label>
                    <input type="number" min="0" id="ReagentEquivalentEdit" class="form-control" placeholder="ReagentEquivalent" name="ReagentEquivalentEdit" value="'.$ReagentEquivalent.'">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="MaterialIdEdit">Material</label>
                    <select id="MaterialIdEdit" class="form-control" placeholder="MaterialIdEdit" name="MaterialIdEdit">
                        <option value="1"></option>
                        ';
$sql = "SELECT id, Material FROM material WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'"';
        if($MaterialId == $row["id"]) $msg .= ' selected';
        $msg .= '>'.FillNonBreak($row["id"],2).'&nbsp;'.$row["Material"].'</option>';
    }
}
                        $msg .='                        
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="probirkaIdEdit">probirka</label>
                    <select id="probirkaIdEdit" class="form-control" placeholder="probirkaIdEdit" name="probirkaIdEdit">
                        <option value="0"></option>
';

$sql = "SELECT id, prob, prob_arm, short_name FROM probirka WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
while($row = mysqli_fetch_array($result))
{
$msg .=  '<option value="'.$row["id"].'"';
if($probirka == $row["prob"]) $msg .= ' selected';
$msg .='>'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["prob"],$row["prob_arm"]).'</option>';
}
}

$msg .='
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="probirka2IdEdit">probirka2</label>
                    <select id="probirka2IdEdit" class="form-control" placeholder="probirka2IdEdit" name="probirka2IdEdit">
                        <option value="0"></option>
';

$sql = "SELECT id, prob, prob_arm, short_name FROM probirka WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
while($row = mysqli_fetch_array($result))
{
$msg .=  '<option value="'.$row["id"].'"';
if($probirka2 == $row["prob"]) $msg .= ' selected';
$msg .='>'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["prob"],$row["prob_arm"]).'</option>';
}
}

$msg .='
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="probirka3IdEdit">probirka3</label>
                    <select id="probirka3IdEdit" class="form-control" placeholder="probirka3IdEdit" name="probirka3IdEdit">
                        <option value="0"></option>
';

$sql = "SELECT id, prob, prob_arm, short_name FROM probirka WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
while($row = mysqli_fetch_array($result))
{
$msg .=  '<option value="'.$row["id"].'"';
if($probirka3 == $row["prob"]) $msg .= ' selected';
$msg .='>'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["prob"],$row["prob_arm"]).'</option>';
}
}

$msg .='
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="activEdit">activ</label>
                    <select id="activEdit" class="form-control" placeholder="activEdit" name="activEdit">
                        <option value="0"></option>
                        <option value="1" 
';
if($activ == "activ") $msg .= 'selected';
$msg .='                >1&nbsp;activ</option>
                <option value="2" ';
if($activ == "not activ") $msg .=   'selected';
$msg .='
                        >2&nbsp;not activ</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="TitleEdit">Title</label>
                    <input type="text" id="TitleEdit" class="form-control" placeholder="Title" name="TitleEdit" value="'.$Title.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="do12Edit">do12</label>
                    <input type="text" id="do12Edit" class="form-control" placeholder="do12" name="do12Edit" value="'.$do12.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="posle12Edit">posle12</label>
                    <input type="text" id="posle12Edit" class="form-control" placeholder="posle12" name="posle12Edit" value="'.$posle12.'">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="Method2IdEdit">Method2</label>
                    <select id="Method2IdEdit" class="form-control" placeholder="Method2IdEdit" name="Method2IdEdit">
                        <option value="0"></option>
';

$sql = "SELECT MethodId, Method FROM method2";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["MethodId"].'"';
        if($Method2id == $row["MethodId"]) $msg .= ' selected';
        $msg .='>'.FillNonBreak($row["MethodId"],3).'&nbsp;'.$row["Method"].'</option>';
    }
}
$msg .='
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="gotovnostEdit">gotovnost</label>
                    <input type="text" id="gotovnostEdit" class="form-control" placeholder="gotovnost" name="gotovnostEdit" value="'.$gotovnost.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="probirka_zEdit[]">probirka_z</label>
                    <select id="probirka_zEdit" class="form-control" placeholder="probirka_zEdit" name="probirka_zEdit[]" size="6" multiple>
                        <option value="0"></option>
';

$sql = "SELECT id, prob FROM probirka_z";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'"';
        if(in_array($row["id"],$probirka_z)) $msg .= ' selected';
        $msg .='>'.FillNonBreak($row["id"],2).'&nbsp;'.$row["prob"].'</option>';
    }
}
$msg .='
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="srok_gotovnostiEdit">srok_gotovnosti</label>
                    <input type="text" id="srok_gotovnostiEdit" class="form-control" placeholder="srok_gotovnosti" name="srok_gotovnostiEdit" value="'.$srok_gotovnosti.'">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="gotovnostNEdit">gotovnostN</label>
                    <input type="text" id="gotovnostNEdit" class="form-control" placeholder="gotovnostN" name="gotovnostNEdit" value="'.$gotovnostN.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="visibilityEdit">visibility</label>
                    <select id="visibilityEdit" class="form-control" placeholder="visibilityEdit" name="visibilityEdit">
                        <option value="0"></option>
                        <option value="1" 
';
if($visibility == 1) $msg .= 'selected';
$msg .='                >1&nbsp;Видимый</option>
                        <option value="2" 
';
if($visibility == 2) $msg .= 'selected';
$msg .='                >2&nbsp;Скрытый</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
';

echo $msg;
//<!-- END Tabs HTML Markup -->
?>
