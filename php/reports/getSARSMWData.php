<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";
require_once "../concatWithBrackets.php";

$msg = "";

//<!-- BEGIN Tabs HTML Markup -->
$msg = '
<div class="row">
    <div class="col-5">
        <div class="form-group">
            <label for="StartDateSARS">Начальная дата</label>
            <input type="text" class="form-control" id="StartDateSARS" placeholder="Выберите дату">
        </div>
    </div>
    <div class="col-7">
        <div class="form-group">
            <label for="StartTimeSARS">Начальная время (h:m:s)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">&nbsp;</span>
                </div>
                <input type="number" class="form-control" id="StartHourSARS" value="0" min="0" max="23" step="1">
                <input type="number" class="form-control" id="StartMinuteSARS" value="0" min="0" max="59" step="1">
                <input type="number" class="form-control" id="StartSecondSARS" value="0" min="0" max="59" step="1">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-5">
        <div class="form-group">
            <label for="EndDateSARS">Конечная дата</label>
            <input type="text" class="form-control" id="EndDateSARS" placeholder="Выберите дату">
        </div>
    </div>
    <div class="col-7">
        <div class="form-group">
            <label for="EndTimeSARS">Конечная время (h:m:s)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">&nbsp;</span>
                </div>
                <input type="number" class="form-control" id="EndHourSARS" value="0" min="0" max="23" step="1">
                <input type="number" class="form-control" id="EndMinuteSARS" value="0" min="0" max="59" step="1">
                <input type="number" class="form-control" id="EndSecondSARS" value="0" min="0" max="59" step="1">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group d-print-none ui-front">
            <label for="DoctorIdSARS">Врач</label>
            <input type="text" id="DoctorIdSARS" name="DoctorIdSARS" class="form-control" placeholder="Для поиска введите Id или имя врача" autocomplete="off" disabled>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="bez_covid" >
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="SARS-CoV-2bezcheck" >
            <label class="form-check-label" for="SARS-CoV-2bezcheck">Без COVID-19</label>
        </div>
    </div>
    <div class="col">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="onlyArmenian" >
            <label class="form-check-label" for="onlyArmenian">միայն Հայերեն</label>
        </div>
    </div>
</div>
';
//<!-- END Tabs HTML Markup -->


echo $msg;
?>
