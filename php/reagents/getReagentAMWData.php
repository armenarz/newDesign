<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

//<!-- BEGIN Tabs HTML Markup -->
$msg  = '
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="MashinidAdd">Mashinid</label>
                    <input type="number" min="0" id="MashinidAdd" class="form-control" placeholder="Mashinid" name="MashinidAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentIdAdd">ReagentId</label>
                    <input type="text" id="ReagentIdAdd" class="form-control" placeholder="ReagentId" name="ReagentIdAdd" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="LoincAdd">Loinc</label>
                    <input type="text" id="LoincAdd" class="form-control" placeholder="Loinc" name="LoincAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentDescAdd">ReagentDesc</label>
                    <input type="text" id="ReagentDescAdd" class="form-control" placeholder="ReagentDesc" name="ReagentDescAdd">
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
                    <label for="ReagentDescRusAdd">ReagentDescRus</label>
                    <input type="text" id="ReagentDescRusAdd" class="form-control" placeholder="ReagentDescRus" name="ReagentDescRusAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentDescArmAdd">ReagentDescArm</label>
                    <input type="text" id="ReagentDescArmAdd" class="form-control" placeholder="ReagentDescArm" name="ReagentDescArmAdd">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="GroupIdAdd">GroupId</label>
                    <select id="GroupIdAdd" class="form-control" placeholder="GroupId" name="GroupIdAdd">
                        <option value="0"></option>
';

$sql = "SELECT GroupId, GroupDesc, GroupDescRus FROM reagentgroup";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["GroupId"].'">'.FillNonBreak($row["GroupId"],2).'&nbsp;'.ConcatWithBrackets($row["GroupDesc"],$row["GroupDescRus"]).'</option>';
    }
}

$msg .='
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="MethodIdAdd">MethodId</label>
                    <select id="MethodIdAdd" class="form-control" placeholder="MethodIdAdd" name="MethodIdAdd">
                        <option value="0"></option>
';
$sql = "SELECT MethodId, Method FROM method";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["MethodId"].'">'.FillNonBreak($row["MethodId"],2).'&nbsp;'.$row["Method"].'</option>';
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
                    <label for="Norm_maleAdd">Norm_male</label>
                    <textarea id="Norm_maleAdd" class="form-control" placeholder="Norm_male" name="Norm_maleAdd"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="Norm_femaleAdd">Norm_female</label>
                    <textarea id="Norm_femaleAdd" class="form-control" placeholder="Norm_female" name="Norm_femaleAdd"></textarea>
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
                    <label for="Norm_maleAdd_haj">Norm_male_haj</label>
                    <textarea id="Norm_maleAdd_haj" class="form-control" placeholder="Norm_male_haj" name="Norm_maleAdd_haj"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="Norm_femaleAdd_haj">Norm_female_haj</label>
                    <textarea id="Norm_femaleAdd_haj" class="form-control" placeholder="Norm_female_haj" name="Norm_femaleAdd_haj"></textarea>
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
                    <label for="Norm_maleAdd_eng">Norm_male_eng</label>
                    <textarea id="Norm_maleAdd_eng" class="form-control" placeholder="Norm_male_eng" name="Norm_maleAdd_eng"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="Norm_femaleAdd_eng">Norm_female_eng</label>
                    <textarea id="Norm_femaleAdd_eng" class="form-control" placeholder="Norm_female_eng" name="Norm_femaleAdd_eng"></textarea>
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
                    <label for="Norm_maleAdd_rus">Norm_male_rus</label>
                    <textarea id="Norm_maleAdd_rus" class="form-control" placeholder="Norm_male_rus" name="Norm_maleAdd_rus"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="Norm_femaleAdd_rus">Norm_female_rus</label>
                    <textarea id="Norm_femaleAdd_rus" class="form-control" placeholder="Norm_female_rus" name="Norm_femaleAdd_rus"></textarea>
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
                    <label for="norm_male_topAdd">norm_male_top</label>
                    <input type="number" min="0" step="0.001" id="norm_male_topAdd" class="form-control" placeholder="norm_male_top" name="norm_male_topAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_male_bottomAdd">norm_male_bottom</label>
                    <input type="number" min="0" step="0.001" id="norm_male_bottomAdd" class="form-control" placeholder="norm_male_bottom" name="norm_male_bottomAdd">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_female_topAdd">norm_female_top</label>
                    <input type="number" min="0" step="0.001" id="norm_female_topAdd" class="form-control" placeholder="norm_female_top" name="norm_female_topAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="norm_female_bottomAdd">norm_female_bottom</label>
                    <input type="number" min="0" step="0.001" id="norm_female_bottomAdd" class="form-control" placeholder="norm_female_bottom" name="norm_female_bottomAdd">
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
                    <label for="CalibrationAdd">Норма мужчин</label>
                    <input type="text" id="CalibrationAdd" class="form-control" placeholder="Calibration" name="CalibrationAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ControlAdd">Норма женщин</label>
                    <input type="text" id="ControlAdd" class="form-control" placeholder="Control" name="ControlAdd">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ed_ismerAdd">ed_ismer</label>
                    <input type="text" id="ed_ismerAdd" class="form-control" placeholder="ed_ismer" name="ed_ismerAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="dilutionAdd">Склад</label>
                    <input type="number" min="0" id="dilutionAdd" class="form-control" placeholder="видимый/невидимый" name="dilutionAdd">
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
                    <label for="UnitPriceAdd">Натощак</label>
                    <input type="number" min="0" step="0.01" id="UnitPriceAdd" class="form-control" placeholder="Натощак" name="UnitPriceAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="AnalysisPriceAdd">AnalysisPrice</label>
                    <input type="number" min="0" id="AnalysisPriceAdd" class="form-control" placeholder="AnalysisPrice" name="AnalysisPriceAdd">
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="row">
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ProducerIdAdd">ProducerId</label>
                    <input type="number" min="1" id="ProducerIdAdd" class="form-control" placeholder="ProducerId" name="ProducerIdAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="ReagentEquivalentAdd">ReagentEquivalent</label>
                    <input type="number" min="0" id="ReagentEquivalentAdd" class="form-control" placeholder="ReagentEquivalent" name="ReagentEquivalentAdd">
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
                    <label for="MaterialIdAdd">Material</label>
                    <select id="MaterialIdAdd" class="form-control" placeholder="MaterialIdAdd" name="MaterialIdAdd">
                        <option value="1"></option>
';
$sql = "SELECT id, Material FROM material WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["Material"].'</option>';
    }
}
$msg .='
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="probirkaIdAdd">probirka</label>
                    <select id="probirkaIdAdd" class="form-control" placeholder="probirkaIdAdd" name="probirkaIdAdd">
                        <option value="0"></option>
';

$sql = "SELECT id, prob, prob_arm, short_name FROM probirka WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["prob"],$row["prob_arm"]).'</option>';
    }
}

$msg .='
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="probirka2IdAdd">probirka2</label>
                    <select id="probirka2IdAdd" class="form-control" placeholder="probirka2IdAdd" name="probirka2IdAdd">
                        <option value="0"></option>
';

$sql = "SELECT id, prob, prob_arm, short_name FROM probirka WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["prob"],$row["prob_arm"]).'</option>';
    }
}

$msg .='
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="probirka3IdAdd">probirka3</label>
                    <select id="probirka3IdAdd" class="form-control" placeholder="probirka3IdAdd" name="probirka3IdAdd">
                        <option value="0"></option>
';

$sql = "SELECT id, prob, prob_arm, short_name FROM probirka WHERE id <> 1";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.ConcatWithBrackets($row["prob"],$row["prob_arm"]).'</option>';
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
                    <label for="activAdd">activ</label>
                    <select id="activAdd" class="form-control" placeholder="activAdd" name="activAdd">
                        <option value="0"></option>
                        <option value="1">1&nbsp;activ</option>
                        <option value="2">2&nbsp;not activ</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col border border-secondary">
        <div class="row">
			<div class="col">
                <div class="form-group d-print-none">
                    <label for="TitleAdd">Title</label>
                    <input type="text" id="TitleAdd" class="form-control" placeholder="01:20" name="TitleAdd">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="do12Add">do12</label>
                    <input type="text" id="do12Add" class="form-control" placeholder="0 04:30" name="do12Add">
                </div>
            </div>
            <div class="col">
                <div class="form-group d-print-none">
                    <label for="posle12Add">posle12</label>
                    <input type="text" id="posle12Add" class="form-control" placeholder="3 04:30" name="posle12Add">
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
                    <label for="Method2IdAdd">Method2</label>
                    <select id="Method2IdAdd" class="form-control" placeholder="Method2IdAdd" name="Method2IdAdd">
                        <option value="0"></option>
';

$sql = "SELECT MethodId, Method FROM method2";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["MethodId"].'">'.FillNonBreak($row["MethodId"],3).'&nbsp;'.$row["Method"].'</option>';
    }
}
$msg .='
                    </select>
                </div>
            </div>
			<div class="col-3 border border-secondary">
                <div class="form-group d-print-none">
                    <label for="gotovnostNAdd">gotovnostN</label>
                    <input type="text" id="gotovnostNAdd" class="form-control" placeholder="gotovnostN" name="gotovnostNAdd">
                </div>
            </div>
			<div class="col-3">
                <div class="form-group d-print-none">
                    <label for="visibilityAdd">visibility</label>
                    <select id="visibilityAdd" class="form-control" placeholder="visibilityAdd" name="visibilityAdd">
                        <option value="0"></option>
                        <option value="1">1&nbsp;Видимый</option>
                        <option value="2">2&nbsp;Скрытый</option>
                    </select>
                </div>
            </div>
			<div class="col-3 border border-secondary">
                <div class="form-group d-print-none">
                    <label for="gotovnost4Add">Gotovnost4</label>
                    <input type="text" id="gotovnost4Add" class="form-control" placeholder="Gotovnost4" name="gotovnost4Add">
                </div>
            </div>
        </div>
    </div>
    <div class="col d-none">
        <div class="row">
            <div class="col d-none">
                <div class="form-group d-print-none">
                    <label for="probirka_zAdd[]">probirka_z</label>
                    <select id="probirka_zAdd" class="form-control" placeholder="probirka_zAdd" name="probirka_zAdd[]" size="6" multiple>
                        <option value="0"></option>
';

$sql = "SELECT id, prob FROM probirka_z";
$result = mysqli_query($link,$sql);
if($result)
{
    while($row = mysqli_fetch_array($result))
    {
        $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["prob"].'</option>';
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
                    <label for="gotovnostAdd">gotovnost</label>
                    <input type="text" id="gotovnostAdd" class="form-control" placeholder="1(8:00)-2(10:15) 2(10:16)-5(14:25) 5(14:26)-6(19:00)" name="gotovnostAdd">
                </div>
            </div>
			<div class="col-6">
                <div class="form-group d-print-none">
                    <label for="srok_gotovnostiAdd">srok_gotovnosti</label>
                    <input type="text" id="srok_gotovnostiAdd" class="form-control" placeholder="3-2-10:20 4-3-16:20 2-5-14:10" name="srok_gotovnostiAdd">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <div class="form-group d-print-none">
            <label for="sortingAdd">Сортировка</label>
            <input type="number" value="0" min="0" id="sortingAdd" class="form-control" placeholder="Введите номер сортировки." name="sortingAdd">
        </div>
    </div>
    <div class="col-6">
        <label for="analizatorsAdd[]">Анализаторы</label>
        <select id="analizatorsAdd" class="form-control" placeholder="analizatorsAdd" name="analizatorsAdd[]" size="6" multiple>';

            $sql = "SELECT id, an_name FROM analizators";
            $result = mysqli_query($link,$sql);
            if($result)
            {
                while($row = mysqli_fetch_array($result))
                {
                    $msg .=  '<option value="'.$row["id"].'">'.FillNonBreak($row["id"],2).'&nbsp;'.$row["an_name"].'</option>';
                }
            }
            
$msg .= '
        </select>
    </div>
    <div class="col-3">
    </div>
</div>
<div class="row">
    <div class="col-4">
        <div class="form-group d-print-none">
            <label for="transportationTemperatureAdd">Температура перевозки</label>
            <input type="text" id="transportationTemperatureAdd" class="form-control" placeholder="Температура перевозки." name="transportationTemperatureAdd">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group d-print-none">
            <label for="storageTemperatureAdd">Температура хранения</label>
            <input type="text" id="storageTemperatureAdd" class="form-control" placeholder="Температура хранения." name="storageTemperatureAdd">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group d-print-none">
            <label for="shelfLifeAdd">Self Life</label>
            <input type="text" id="shelfLifeAdd" class="form-control" placeholder="Self Life" name="shelfLifeAdd">
        </div>
    </div>
</div>
';

echo $msg;
//<!-- END Tabs HTML Markup -->
?>
