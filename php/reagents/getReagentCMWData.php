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

    $gotovnost4 = $row["gotovnost4"];
    $sorting = $row["sorting"];

    $analizators = array();
    $analizators = explode(',',$row["analizators"]);
}
//<!-- BEGIN Tabs HTML Markup -->
$msg ='
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="MashinidCopy">Mashinid</label>
                    <input type="number" min="0" id="MashinidCopy" class="form-control" placeholder="Mashinid" name="MashinidCopy" value="'.$Mashinid.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentIdCopy">ReagentId</label>
                    <input type="text" id="ReagentIdCopy" class="form-control" placeholder="ReagentId" name="ReagentIdCopy" readonly value="'.$reagent_id.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="LoincCopy">Loinc</label>
                    <input type="text" id="LoincCopy" class="form-control" placeholder="Loinc" name="LoincCopy" value="'.$Loinc.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentDescCopy">ReagentDesc</label>
                    <input type="text" id="ReagentDescCopy" class="form-control" placeholder="ReagentDesc" name="ReagentDescCopy" value="'.$ReagentDesc.'">
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
                    <label for="ReagentDescRusCopy">ReagentDescRus</label>
                    <input type="text" id="ReagentDescRusCopy" class="form-control" placeholder="ReagentDescRus" name="ReagentDescRusCopy" value="'.$ReagentDescRus.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentDescArmCopy">ReagentDescArm</label>
                    <input type="text" id="ReagentDescArmCopy" class="form-control" placeholder="ReagentDescArm" name="ReagentDescArmCopy" value="'.$ReagentDescArm.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="GroupIdCopy">GroupId</label>
                    <select id="GroupIdCopy" class="form-control" placeholder="GroupId" name="GroupIdCopy">
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
                    <label for="MethodIdCopy">MethodId</label>
                    <select id="MethodIdCopy" class="form-control" placeholder="MethodIdCopy" name="MethodIdCopy">
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
                    <label for="Norm_maleCopy">Norm_male</label>
                    <textarea id="Norm_maleCopy" class="form-control" placeholder="Norm_male" name="Norm_maleCopy">'.$Norm_male.'</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                <label for="Norm_femaleCopy">Norm_female</label>
                <textarea id="Norm_femaleCopy" class="form-control" placeholder="Norm_female" name="Norm_femaleCopy">'.$Norm_female.'</textarea>
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
                    <label for="norm_male_topCopy">norm_male_top</label>
                    <input type="number" min="0" step="0.001" id="norm_male_topCopy" class="form-control" placeholder="norm_male_top" name="norm_male_topCopy" value="'.$norm_male_top.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_male_bottomCopy">norm_male_bottom</label>
                    <input type="number" min="0" step="0.001" id="norm_male_bottomCopy" class="form-control" placeholder="norm_male_bottom" name="norm_male_bottomCopy" value="'.$norm_male_bottom.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_female_topCopy">norm_female_top</label>
                    <input type="number" min="0" step="0.001" id="norm_female_topCopy" class="form-control" placeholder="norm_female_top" name="norm_female_topCopy" value="'.$norm_female_top.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_female_bottomCopy">norm_female_bottom</label>
                    <input type="number" min="0" step="0.001" id="norm_female_bottomCopy" class="form-control" placeholder="norm_female_bottom" name="norm_female_bottomCopy" value="'.$norm_female_bottom.'">
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
                    <label for="CalibrationCopy">Норма мужчин</label>
                    <input type="text" id="CalibrationCopy" class="form-control" placeholder="Calibration" name="CalibrationCopy" value="'.$Calibration.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ControlCopy">Норма женщин</label>
                    <input type="text" id="ControlCopy" class="form-control" placeholder="Control" name="ControlCopy" value="'.$Control.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ed_ismerCopy">ed_ismer</label>
                    <input type="text" id="ed_ismerCopy" class="form-control" placeholder="ed_ismer" name="ed_ismerCopy" value="'.$ed_ismer.'">
                </div>
            </div>        
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="dilutionCopy">Склад</label>
                    <input type="number" min="0" id="dilutionCopy" class="form-control" placeholder="видимый/невидимый" name="dilutionCopy" value="'.$dilution.'">
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
                    <label for="UnitPriceCopy">Натощак</label>
                    <input type="number" min="0" step="0.01" id="UnitPriceCopy" class="form-control" placeholder="Натощак" name="UnitPriceCopy" value="'.$UnitPrice.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="AnalysisPriceCopy">AnalysisPrice</label>
                    <input type="number" min="0" id="AnalysisPriceCopy" class="form-control" placeholder="AnalysisPrice" name="AnalysisPriceCopy" value="'.$AnalysisPrice.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ProducerIdCopy">ProducerId</label>
                    <input type="number" min="1" id="ProducerIdCopy" class="form-control" placeholder="ProducerId" name="ProducerIdCopy" value="'.$ProducerId.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentEquivalentCopy">ReagentEquivalent</label>
                    <input type="number" min="0" id="ReagentEquivalentCopy" class="form-control" placeholder="ReagentEquivalent" name="ReagentEquivalentCopy" value="'.$ReagentEquivalent.'">
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
                    <label for="MaterialIdCopy">Material</label>
                    <select id="MaterialIdCopy" class="form-control" placeholder="MaterialIdCopy" name="MaterialIdCopy">
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
                    <label for="probirkaIdCopy">probirka</label>
                    <select id="probirkaIdCopy" class="form-control" placeholder="probirkaIdCopy" name="probirkaIdCopy">
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
        $msg .= '>'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["prob"],$row["prob_arm"]).'</option>';
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
                    <label for="probirka2IdCopy">probirka2</label>
                    <select id="probirka2IdCopy" class="form-control" placeholder="probirka2IdCopy" name="probirka2IdCopy">
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
                    <label for="probirka3IdCopy">probirka3</label>
                    <select id="probirka3IdCopy" class="form-control" placeholder="probirka3IdCopy" name="probirka3IdCopy">
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
    <div class="col-3">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="activCopy">activ</label>
                    <select id="activCopy" class="form-control" placeholder="activCopy" name="activCopy">
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
        </div>
    </div>
    <div class="col border border-secondary">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="TitleCopy">Title</label>
                    <input type="text" id="TitleCopy" class="form-control" placeholder="Title" name="TitleCopy" value="'.$Title.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="do12Copy">do12</label>
                    <input type="text" id="do12Copy" class="form-control" placeholder="do12" name="do12Copy" value="'.$do12.'">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="posle12Copy">posle12</label>
                    <input type="text" id="posle12Copy" class="form-control" placeholder="posle12" name="posle12Copy" value="'.$posle12.'">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-1">
    <div class="col">
        <div class="row">
            <div class="col-3">
                <div class="form-group d-print-none">
                    <label for="Method2IdCopy">Method2</label>
                    <select id="Method2IdCopy" class="form-control" placeholder="Method2IdCopy" name="Method2IdCopy">
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
            <div class="col-3 border border-secondary">
                <div class="form-group d-print-none">
                    <label for="gotovnostNCopy">gotovnostN</label>
                    <input type="text" id="gotovnostNCopy" class="form-control" placeholder="gotovnostN" name="gotovnostNCopy" value="'.$gotovnost.'">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group d-print-none">
                    <label for="visibilityCopy">visibility</label>
                    <select id="visibilityCopy" class="form-control" placeholder="visibilityCopy" name="visibilityCopy">
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
            <div class="col-3 border border-secondary">
                <div class="form-group d-print-none">
                    <label for="gotovnost4Copy">Gotovnost4</label>
                    <input type="text" id="gotovnost4Copy" class="form-control" placeholder="Gotovnost4" name="gotovnost4Copy" value="'.$srok_gotovnosti.'">
                </div>
            </div>
        </div>
    </div>
    <div class="col d-none">
        <div class="row">
            <div class="col d-none">
                <div class="form-group d-print-none">
                    <label for="probirka_zCopy[]">probirka_z</label>
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
        </div>
    </div>
</div>
<div class="row mt-1">
    <div class="col border border-secondary">
        <div class="row">
			<div class="col-6">
				<div class="form-group d-print-none">
					<label for="gotovnostCopy">gotovnost</label>
					<input type="text" id="gotovnostCopy" class="form-control" placeholder="gotovnost" name="gotovnostCopy" value="'.$gotovnost.'">
				</div>
			</div>
			<div class="col-6">
				<div class="form-group d-print-none">
					<label for="srok_gotovnostiCopy">srok_gotovnosti</label>
					<input type="text" id="srok_gotovnostiCopy" class="form-control" placeholder="srok_gotovnosti" name="srok_gotovnostiCopy" value="'.$srok_gotovnosti.'">
				</div>
			</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-3">
                <div class="form-group d-print-none">
                    <label for="sortingCopy">Сортировка</label>
                    <input type="number" min="0" id="sortingCopy" class="form-control" placeholder="Введите номер сортировки." name="sortingCopy" value="'.$sorting.'">
                </div>
            </div>
            <div class="col-6">
                <label for="analizatorsCopy[]">Анализаторы</label>
                <select id="analizatorsCopy" class="form-control" placeholder="analizatorsCopy" name="analizatorsCopy[]" size="6" multiple>';

                    $sql = "SELECT id, an_name FROM analizators";
                    $result = mysqli_query($link,$sql);
                    if($result)
                    {
                        while($row = mysqli_fetch_array($result))
                        {
                            $msg .= '<option value="'.$row["id"].'"';
                            if(in_array($row["id"],$analizators)) $msg .= ' selected';
                            $msg .= '>'.FillNonBreak($row["id"],2).'&nbsp;'.$row["an_name"].'</option>';
                        }
                    }
                    
$msg .= '
                </select>
            </div>
            <div class="col-3">
            </div>
        </div>
    </div>
</div>
';

echo $msg;
//<!-- END Tabs HTML Markup -->
?>
