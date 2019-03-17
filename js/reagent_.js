//startup code
$(function()
{
    var filterObj = {};
    filterObj.groupId = 0;
    filterObj.methodId = 0;
    filterObj.visibilityId = 1;
    filterObj.generalSelectionId = 0;
    filterObj.reagentId = 0;

    setSelectGroupData();
    setSelectMethodData();
    setSelectReagentData();
    setSearchReagentData();
    setCalendar();
    updateContent(filterObj);

    //getting selected value of select tag with id "selectGroup"
    $("#selectGroup").change(function(){
        filterObj.groupId = $("#selectGroup").val();
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");
        filterObj.reagentId = 0;
        $("#selectReagent").val("0");
        $("#searchReagent").val("");
        updateContent(filterObj);
        if(filterObj.groupId != 0)
        {
            $("#exportLink").show();
            $("#addLink").show();
            $("#editLink").hide();
            $("#deleteLink").hide();
        }
        if(filterObj.methodId != 0 || filterObj.groupId != 0)
        {
            setReagentAMWData();
        }
    });

    //getting selected value of select tag with id "selectMethod" 
    $("#selectMethod").change(function(){
        filterObj.methodId = $("#selectMethod").val();
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");
        filterObj.reagentId = 0;
        $("#selectReagent").val("0");
        $("#searchReagent").val("");
        updateContent(filterObj);
        if(filterObj.methodId != 0)
        {
            $("#exportLink").show();
            $("#addLink").show();
            $("#editLink").hide();
            $("#deleteLink").hide();
        }
        if(filterObj.methodId != 0 || filterObj.groupId != 0)
        {
            setReagentAMWData();
        }
    });
    
    //getting selected value of select tag with id "selectVisibility" 
    $("#selectVisibility").change(function(){
        filterObj.visibilityId = $("#selectVisibility").val();
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");
        filterObj.reagentId = 0;
        $("#selectReagent").val("0");
        $("#searchReagent").val("");
        updateContent(filterObj);
    });

    //getting selected value of select tag with id "generalSelectionId";
    $("#generalSelectionId").change(function(){
        //alert("generalSelectionId");
        filterObj.generalSelectionId = $("#generalSelectionId").val();
        filterObj.groupId = 0;
        $("#selectGroup").val("0");
        filterObj.methodId = 0;
        $("#selectMethod").val("0");
        filterObj.reagentId = 0;
        $("#selectReagent").val("0");
        $("#searchReagent").val("");
        updateContent(filterObj);
        if(filterObj.generalSelectionId != 0)
        {
            $("#exportLink").show();
            $("#addLink").show();
            setReagentAMWData();
            $("#editLink").hide();
            $("#deleteLink").hide();
        }
    });

    //getting selected value of select tag with id "selectReagent" 
    $("#selectReagent").change(function(){
        $("#searchReagent").val("");
        filterObj.reagentId = $("#selectReagent").val();
        filterObj.groupId = 0;
        $("#selectGroup").val("0");
        filterObj.methodId = 0;
        $("#selectMethod").val("0");
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");
        updateContent(filterObj);
        if(filterObj.reagentId != 0)
        {
            $("#exportLink").show();
            $("#addLink").hide();
            $("#editLink").show();
            //$("#reagent_id").val($(this).val());
            $("#reagent_id").val(filterObj.reagentId);
            setReagentEMWData();
            $("#deleteLink").hide();
        }
    });

    //getting searched value of input tag with id "searchReagent"
    $("#searchButton").click(function()
    {
        var temp = $("#searchReagent").val();
        if(temp.length == 0)
        {
            temp = 0;
        }
        filterObj.reagentId = parseInt(temp);
        $("#selectReagent").val(filterObj.reagentId);
        if($("#selectReagent").val()==null)
        {
            $("#selectReagent").val("0");
            var loaderMsg = '';
            loaderMsg  = '<div class="alert alert-primary d-print-none" role="alert">';
            loaderMsg += 	'По данной выборке ничего не найдено.';
            loaderMsg += '</div>';   
            $("#content").html(loaderMsg);
            return;
        }

        filterObj.groupId = 0;
        $("#selectGroup").val("0");
        filterObj.methodId = 0;
        $("#selectMethod").val("0");
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");

        updateContent(filterObj);
        if(filterObj.reagentId != 0)
        {
            $("#exportLink").show();
            $("#addLink").hide();
            $("#editLink").show();
            $("#reagent_id").val(filterObj.reagentId);
            setReagentEMWData();
            $("#deleteLink").hide();
        }
    });

    $("#searchReagent").focus(function () {
        $(this).select();
     });

    $("#exportLink").click(function()
    {
        exportToExcel();
    });
    
    $("#content").height($(window).height()-237);
    $(window).resize(function() 
    {
        $("#content").height($(window).height()-237);
    });
});

function setSearchReagentData() 
{
    $.widget("custom.catcomplete", $.ui.autocomplete, 
    {
        _create: function() 
        {
            this._super();
            this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
        },
        _renderMenu: function(ul, items) 
        {
            var that = this,
            currentCategory = "";
            $.each(items, function(index, item) 
            {
                var li;
                if(item.category != currentCategory) 
                {
                    ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
                    currentCategory = item.category;
                }
                li = that._renderItemData(ul, item);
                if(item.category) 
                {
                    li.attr("aria-label", item.category + " : " + item.label);
                }
            });
        }
    });

    var data = [];
    $.ajaxSetup({
        type: "POST",
        url: "../php/getSearchReagentData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: function(result)
        {
            var searchReagentObject = JSON.parse(result);
            var dataArray = $.makeArray(searchReagentObject);
            var dataArrayLength = dataArray.length;
            var i = 0;

            for(i = 0; i < dataArrayLength; i++)
            {
                var dataObject = {};
                var label = "";
                label = dataArray[i][0];
                label = label.replace(/&nbsp;/g,"\xa0").replace(/&hellip;/g,"\u2026");
                dataObject.label = label;
                dataObject.category = dataArray[i][1];
                data.push(dataObject);
            }
        },
        error: funcError
    });
    ///process
    $.ajax();

    $("#searchReagent").catcomplete({
        delay: 0,
        source: data
    });
    $("#searchReagent").prop("disabled",false);
}



//functions
function setSelectGroupData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/getSelectGroupData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetSelectGroupData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetSelectGroupData(result)
{
    $('#selectGroup').html(result);
    $("#selectGroup").prop("disabled",false);
}
function funcError(XMLHttpRequest, textStatus, errorThrown)
{
    $("#content").html("Status: " + textStatus + ", " + "Error: " + errorThrown);
}

function setSelectMethodData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/getSelectMethodData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetSelectMethodData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetSelectMethodData(result)
{
    $('#selectMethod').html(result);
    $("#selectMethod").prop("disabled",false);
}

function setSelectReagentData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/getSelectReagentData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetSelectReagentData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetSelectReagentData(result)
{
    $('#selectReagent').html(result);
    $("#selectReagent").prop("disabled",false);
}

function updateContent(filterObj)
{
    var groupId = filterObj.groupId;
    var methodId = filterObj.methodId;
    var generalSelectionId = filterObj.generalSelectionId;
    var reagentId = filterObj.reagentId;
    
    var loaderMsg = '';
    if(groupId==0 && methodId==0 && generalSelectionId==0 && reagentId==0)
    {
        loaderMsg  = '<div class="alert alert-primary d-print-none" role="alert">';
        loaderMsg += 'Сделайте выборку с помощью фильтров методов и групп, общей выборки или же выберите конкретный реагент с помощью фильтра реагентов.';
        loaderMsg += '</div>';
        $("#content").html(loaderMsg);
        $("#exportLink").hide(); 
        $("#addLink").hide();
        $("#editLink").hide();
        $("#deleteLink").hide();
        return;
    }
       
	$.ajaxSetup({
		type: "POST",
    	url: "getReagentData.php",
   		cache:false,
        data: dataString = $("form[name='tempData']").serialize()
    });
    
    var loaderMsg = '';
    loaderMsg  = '<div class="alert alert-primary d-print-none" role="alert">';
    loaderMsg += 	'Данные загружаются...';
    loaderMsg += '</div>';
    
    $("#content").html(loaderMsg);

	$.ajax({
        success:function(msg){
            $("#content").html(msg)
            $("input[name='radioReagent']").on("click",this,function()
            {
                $("#reagent_id").val($(this).val());
                setReagentEMWData();
                $("#editLink").show();
                setReagentDMWData();
                $("#deleteLink").show();
            });
        }
    });
}
//setting editModalWindow data
function setReagentEMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/getReagentEMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetReagentEMWData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetReagentEMWData(result)
{
    $("#contentEditModal").html(result);
}
//setting addModalWindow data
function setReagentAMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/getReagentAMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetReagentAMWData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetReagentAMWData(result)
{
    $("#contentAddModal").html(result);
}

//setting deleteModalWindow data
function setReagentDMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/getReagentDMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetReagentDMWData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetReagentDMWData(result)
{
    $("#contentDeleteModal").html(result);
}

//export to excel
function exportToExcel()
{
    document.tempData.action = 'exportReagentsToExcel.php';
    document.tempData.target = '_blank';
    document.tempData.method = 'POST';
    document.tempData.submit();
    document.tempData.action = '';
    document.tempData.target = '';
}

//SetCalendar
function setCalendar()
{   
    //getting free days from database
    // ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/getFreeDays.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat("&").concat($("form[name='formCalendar']").serialize()),
        success: funcSuccessGetFreeDays,
        error: funcError
    });
    ///process
    $.ajax();

    freeDays = [];
}

function funcSuccessGetFreeDays(result)
{
    var freeDaysObject = JSON.parse(result);
    freeDays = $.makeArray(freeDaysObject);

    //initialize datepicker
   $("#contentCalendarModal").datepicker({
    prevText:"Предыдущий",
    nextText:"Следующий",
    monthNames: ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
    dayNamesMin: ["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],
    dateFormat: "yy-mm-dd",
    firstDay: 1,
    beforeShowDay: setFreeDays,
    onSelect: editFreeDays
    });
}

function setFreeDays(date)
{
    var dateFormat = $.datepicker.formatDate('yy-mm-dd', date);
	
	if ($.inArray(dateFormat, freeDays) == -1)
	{ 
		return [true, "workingDays", "Рабочий день."];
	}
	else 
	{
        return [true, "freeDays", "Не рабочий день."]; 
    }
}

function editFreeDays(selectedDate)
{
    //setting or unsetting free days to database
    // ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/editFreeDays.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat("&selectedDate=").concat(selectedDate),
        success: funcSuccessEditFreeDays,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessEditFreeDays()
{
    $("#contentCalendarModal").datepicker("destroy");
    setCalendar();
}

// editModalWindow button OK handler
$('#editModalWindow').on('click','#buttonOKEdit', function(){

    var frmEdit = CreateFormEditObject();
    frmEdit.getFormData();
    frmEdit.getActiveTab();

    frmEdit.validate();
    if(!frmEdit.isValid)
    {
        $('#messageEditModal').html(frmEdit.message);
        if(frmEdit.activeTab == frmEdit.invalidTab)
        {
            $('#' + frmEdit.invalidField).focus();
        }
        else
        {
            $('#' + frmEdit.invalidTab).on('shown.bs.tab', function(){
                $('#' + frmEdit.invalidField).focus();
            });
            $('#' + frmEdit.invalidTab).tab('show');
        }
        return;
    }
    else
    {
        $('#messageEditModal').html(frmEdit.message);
    }
    
    ///updateing reagent data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/editReagent.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formEdit']").serialize()),
        success: function(res)
        {
            var filterObj = {};
            filterObj.groupId = $("#selectGroup").val();
            filterObj.methodId = $("#selectMethod").val();
            filterObj.visibilityId = $("#selectVisibility").val();
            filterObj.reagentId = $("#selectReagent").val();
            updateContent(filterObj);
            setSelectReagentData();
           $('#editModalWindow').modal('hide');
           $("#editLink").hide();
            $("#deleteLink").hide();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            $('#messageEditModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
        }
    });
    ///process
    $.ajax();
    return;    
});
// editModalWindow close handler
$('#editModalWindow').on('hidden.bs.modal', function () {

});

/// FormEdit Object
function CreateFormEditObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Для редактирования данных реагента заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;
    frm.invalidTab = null;
    frm.activeTab = null;

    frm.getActiveTab = function()
    {
        if($('#nav-edit-part1-tab').hasClass('active')) frm.activeTab = 'nav-edit-part1-tab';
        else if($('#nav-edit-part2-tab').hasClass('active')) frm.activeTab = 'nav-edit-part2-tab';
        else if($('#nav-edit-part3-tab').hasClass('active')) frm.activeTab = 'nav-edit-part3-tab';
        else if($('#nav-edit-part4-tab').hasClass('active')) frm.activeTab = 'nav-edit-part4-tab';
        else if($('#nav-edit-part5-tab').hasClass('active')) frm.activeTab = 'nav-edit-part5-tab';     
    };
    frm.getFormData = function()
    {
        frm.getTab1Data();
        frm.getTab2Data();
        frm.getTab3Data();
        frm.getTab4Data();
        frm.getTab5Data();
    };
    frm.getTab1Data = function()
    {
        ///tab 1 ===================================================
        frm.mashinidEdit = $('#MashinidEdit').val();
        frm.reagentIdEdit = $('#ReagentIdEdit').val();
        frm.reagentDescEdit = $('#ReagentDescEdit').val();
        frm.reagentDescRusEdit = $('#ReagentDescRusEdit').val();
        frm.reagentDescArmEdit = $('#ReagentDescArmEdit').val();
        frm.groupIdEdit = $('#GroupIdEdit').val();
        frm.analysisPriceEdit = $('#AnalysisPriceEdit').val();
        frm.methodIdEdit = $('#MethodIdEdit').val();
    };
    frm.getTab2Data = function()
    {
        ///tab 2 ===================================================
        frm.norm_maleEdit = $('#Norm_maleEdit').val();
        frm.norm_male_topEdit = $('#norm_male_topEdit').val();
        frm.norm_male_bottomEdit = $('#norm_male_bottomEdit').val();
        frm.norm_femaleEdit = $('#Norm_femaleEdit').val();
        frm.norm_female_topEdit = $('#norm_female_topEdit').val();
        frm.norm_female_bottomEdit = $('#norm_female_bottomEdit').val();
    };
    frm.getTab3Data = function()
    {
        ///tab 3 ===================================================
        frm.calibrationEdit = $('#CalibrationEdit').val();
        frm.controlEdit = $('#ControlEdit').val();
        frm.ed_ismerEdit = $('#ed_ismerEdit').val();
        frm.dilutionEdit = $('#dilutionEdit').val();
        frm.unitPriceEdit = $('#UnitPriceEdit').val();
        frm.taxEdit = $('#TaxEdit').val();
        frm.producerIdEdit = $('#ProducerIdEdit').val();
        frm.reagentEquivalentEdit = $('#ReagentEquivalentEdit').val();
    };
    frm.getTab4Data = function()
    {
        ///tab 4 ====================================================
        frm.materialEdit = $('#MaterialEdit').val();
        frm.probirkaIdEdit = $('#probirkaIdEdit').val();
        frm.probirka2IdEdit = $('#probirka2IdEdit').val();
        frm.probirka3IdEdit = $('#probirka3IdEdit').val();
        frm.activEdit = $('#activEdit').val();
        frm.titleEdit = $('#TitleEdit').val();
        frm.do12Edit = $('#do12Edit').val();
        frm.posle12Edit = $('#posle12Edit').val();
    };
    frm.getTab5Data = function()
    {
        ///tab 5 ====================================================
        frm.method2IdEdit = $('#Method2IdEdit').val();
        frm.gotovnostEdit = $('#gotovnostEdit').val();
        frm.probirka_zEdit = $('#probirka_zEdit').val();
        frm.srok_gotovnostiEdit = $('#srok_gotovnostiEdit').val();
        frm.gotovnostNEdit = $('#gotovnostNEdit').val();
        frm.visibilityEdit = $('#visibilityEdit').val();
    };
    frm.validate = function()
    {
        frm.validateTab1();
        if(frm.isValid) frm.validateTab2();
        else return;
        if(frm.isValid) frm.validateTab3();
        else return;
        if(frm.isValid) frm.validateTab4();
        else return;
        if(frm.isValid) frm.validateTab5();
        else return;
    };
    //Tab1
    frm.validateTab1 = function()
    {
        frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
        
        //MashinidEdit is empty
        if(frm.mashinidEdit.length == 0)
        {
            frm.message = 'Введите код машины в поле Mashinid.';
            frm.invalidField ='MashinidEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
        //MashinidEdit is negative
        else if(frm.mashinidEdit < 0)
        {
            frm.message = 'Введите положительное число в поле Mashinid.';
            frm.invalidField ='MashinidEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
        //MashinidEdit is not unique
        else if(frm.mashinidEdit != 0 && (frm.mashinidEdit != frm.getPreviousMachineId()) && (frm.machineIdIsNotUnique() == true))
        {
            frm.message = 'Введите уникальный код машины в поле Mashinid.';
            frm.invalidField ='MashinidEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return; 
        }
        //ReagentDescEdit
        else if(frm.reagentDescEdit.length == 0)
        {
            frm.message = 'Введите описание реагента на английском в поле ReagentDesc.';
            frm.invalidField ='ReagentDescEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
        //ReagentDescRusEdit
        else if(frm.reagentDescRusEdit.length == 0)
        {
            frm.message = 'Введите описание реагента на русском в поле ReagentDescRus.';
            frm.invalidField ='ReagentDescRusEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
        //ReagentDescArmEdit
        // else if(frm.reagentDescArmEdit.length == 0)
        // {
        //     frm.message = 'Введите описание реагента на армянском в поле ReagentDescArm.';
        //     frm.invalidField ='ReagentDescArmEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part1-tab';
        //     return;
        // }
        //GroupIdEdit
        else if(frm.groupIdEdit == 0)
        {
            frm.message = 'Выберите GroupId.';
            frm.invalidField ='GroupIdEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
        //AnalysisPriceEdit
        // else if(frm.analysisPriceEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля AnalysisPrice.';
        //     frm.invalidField ='AnalysisPriceEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part1-tab';
        //     return;
        // }
        //MethodIdEdit
        else if(frm.methodIdEdit == 0)
        {
            frm.message = 'Выберите MethodId.';
            frm.invalidField ='MethodIdEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
        else
        {
            frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            frm.invalidTab = null;
            return;
        }
    };
    //Tab2
    frm.validateTab2 = function()
    {
        frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
    
        //Norm_maleEdit
        // if(frm.norm_maleEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля Norm_male.';
        //     frm.invalidField ='Norm_maleEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part2-tab';
        //     return;
        // }
        //norm_male_topEdit
        // else if(frm.norm_male_topEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_male_top.';
        //     frm.invalidField ='norm_male_topEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part2-tab';
        //     return;
        // }
        //norm_male_bottomEdit
        // else if(frm.norm_male_bottomEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_male_bottom.';
        //     frm.invalidField ='norm_male_bottomEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part2-tab';
        //     return;
        // }
        //Norm_femaleEdit
        // else if(frm.norm_femaleEdit == 0)
        // {
        //     frm.message = 'Введите значение поля Norm_female.';
        //     frm.invalidField ='Norm_femaleEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part2-tab';
        //     return;
        // }
        //norm_female_topEdit
        // else if(frm.norm_female_topEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_female_top.';
        //     frm.invalidField ='norm_female_topEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part2-tab';
        //     return;
        // }
        //norm_female_bottomEdit
        // else if(frm.norm_female_bottomEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_female_bottom.';
        //     frm.invalidField ='norm_female_bottomEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part2-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //Tab3
    frm.validateTab3 = function()
    {
        frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //CalibrationEdit
        // if(frm.calibrationEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля Calibration.';
        //     frm.invalidField ='CalibrationEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        //ControlEdit
        // else if(frm.controlEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля Control.';
        //     frm.invalidField ='ControlEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        //ed_ismerEdit
        // else if(frm.ed_ismerEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля ed_ismer.';
        //     frm.invalidField ='ed_ismerEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        //dilutionEdit
        // else if(frm.dilutionEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля dilution.';
        //     frm.invalidField ='dilutionEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        //UnitPriceEdit
        // else if(frm.unitPriceEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля UnitPrice.';
        //     frm.invalidField ='UnitPriceEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        //TaxEdit
        // else if(frm.taxEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_female_bottom.';
        //     frm.invalidField ='TaxEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        //ProducerIdEdit
        // else if(frm.producerIdEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля ProducerId.';
        //     frm.invalidField ='ProducerIdEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        //ReagentEquivalentEdit
        // else if(frm.reagentEquivalentEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля ReagentEquivalent.';
        //     frm.invalidField ='ReagentEquivalentEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part3-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //Tab4
    frm.validateTab4 = function()
    {
        frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //MaterialEdit
        // if(frm.materialEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля Material.';
        //     frm.invalidField ='MaterialEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        //probirkaIdEdit
        // else if(frm.probirkaIdEdit == 0)
        // {
        //     frm.message = 'Выберите probirkaId.';
        //     frm.invalidField ='probirkaIdEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        //probirka2IdEdit
        // else if(frm.probirka2IdEdit == 0)
        // {
        //     frm.message = 'Выберите probirka2Id.';
        //     frm.invalidField ='probirka2IdEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        //probirka3IdEdit
        // else if(frm.probirka3IdEdit == 0)
        // {
        //     frm.message = 'Выберите probirka3Id.';
        //     frm.invalidField ='probirka3IdEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        //activEdit
        // else if(frm.activEdit == 0)
        // {
        //     frm.message = 'Выберите activ.';
        //     frm.invalidField ='activEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        //TitleEdit
        // else if(frm.titleEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля Title.';
        //     frm.invalidField ='TitleEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        //do12Edit
        // else if(frm.do12Edit.length == 0)
        // {
        //     frm.message = 'Введите значение поля do12.';
        //     frm.invalidField ='do12Edit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        //posle12Edit
        // else if(frm.posle12Edit.length == 0)
        // {
        //     frm.message = 'Введите значение поля posle12.';
        //     frm.invalidField ='posle12Edit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part4-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //Tab5
    frm.validateTab5 = function()
    {
        frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //Method2IdEdit
        // if(frm.method2IdEdit == 0)
        // {
        //     frm.message = 'Выберите Method2Id.';
        //     frm.invalidField ='Method2IdEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part5-tab';
        //     return;
        // }
        //gotovnostEdit
        // else if(frm.gotovnostEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля gotovnost.';
        //     frm.invalidField ='gotovnostEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part5-tab';
        //     return;
        // }
        //probirka_zEdit
        // else if(frm.probirka_zEdit == 0)
        // {
        //     frm.message = 'Выберите probirka_z.';
        //     frm.invalidField ='probirka_zEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part5-tab';
        //     return;
        // }
        //srok_gotovnostiEdit
        // else if(frm.srok_gotovnostiEdit == 0)
        // {
        //     frm.message = 'Введите значение поля srok_gotovnosti.';
        //     frm.invalidField ='srok_gotovnostiEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part5-tab';
        //     return;
        // }
        //gotovnostNEdit
        // else if(frm.gotovnostNEdit.length == 0)
        // {
        //     frm.message = 'Введите значение поля gotovnostN.';
        //     frm.invalidField ='gotovnostNEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part5-tab';
        //     return;
        // }
        //visibilityEdit
        // else if(frm.visibilityEdit == 0)
        // {
        //     frm.message = 'Выберите visibility.';
        //     frm.invalidField ='visibilityEdit';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-edit-part5-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //MashinidIsNotUnique function
    frm.machineIdIsNotUnique = function()
    {
        resultReceived = null;
        /// ajax setup
        $.ajaxSetup({
            type: "POST",
            url: "../php/checkIfMachineIdIsNotUnique.php",
            cache: false,
            async: false,
            data: dataString = $("form[name='tempData']").serialize().concat('&').concat("Mashinid=").concat(frm.mashinidEdit),
            success: function(result)
            {
                resultReceived = result;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                $('#messageEditModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
            }
        });
        ///process
        $.ajax();
        
        return resultReceived;
    };
    //PreviousMashinid from database
    frm.getPreviousMachineId = function()
    {
        previousMachineId = -1;
        /// ajax setup
        $.ajaxSetup({
            type: "POST",
            url: "../php/getPreviousMachineId.php",
            cache: false,
            async: false,
            data: dataString = $("form[name='tempData']").serialize().concat('&').concat("ReagentId=").concat(frm.reagentIdEdit),
            success: function(result)
            {
                previousMachineId = result;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                $('#messageEditModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
            }
        });
        ///process
        $.ajax();
        
        return previousMachineId;
    };
    return frm;
}

// addModalWindow button OK handler
$('#addModalWindow').on('click','#buttonOKAdd', function(){
    
    var frmAdd = CreateFormAddObject();
    frmAdd.getFormData();
    frmAdd.getActiveTab();

    frmAdd.validate();
    if(!frmAdd.isValid)
    {
        $('#messageAddModal').html(frmAdd.message);
        if(frmAdd.activeTab == frmAdd.invalidTab)
        {
            $('#' + frmAdd.invalidField).focus();
        }
        else
        {
            $('#' + frmAdd.invalidTab).on('shown.bs.tab', function(){
                $('#' + frmAdd.invalidField).focus();
            });
            $('#' + frmAdd.invalidTab).tab('show');
        }
        return;
    }
    else
    {
        $('#messageAddModal').html(frmAdd.message);
    }
    
    ///updateing reagent data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/addReagent.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formAdd']").serialize()),
        success: function(res)
        {
            var filterObj = {};
            filterObj.groupId = $("#selectGroup").val();
            filterObj.methodId = $("#selectMethod").val();
            filterObj.visibilityId = $("#selectVisibility").val();
            filterObj.generalSelectionId = $("#generalSelectionId").val();
            filterObj.reagentId = $("#selectReagent").val();
            updateContent(filterObj);
            setSelectReagentData();
            $('#addModalWindow').modal('hide');
            $("#editLink").hide();
            $("#deleteLink").hide();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            $('#messageAddModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
        }
    });
    ///process
    $.ajax();
    return;    
});

// addModalWindow shown handler
$('#addModalWindow').on('shown.bs.modal', function () {
    $('#MashinidAdd').val('');
    $('#ReagentDescAdd').val('');
    $('#ReagentDescRusAdd').val('');
    $('#ReagentDescArmAdd').val('');
    $('#GroupIdAdd').val($('#selectGroup').val());
    $('#AnalysisPriceAdd').val('');
    $('#MethodIdAdd').val($('#selectMethod').val());
    $('#Norm_maleAdd').val('');
    $('#norm_male_topAdd').val('');
    $('#norm_male_bottomAdd').val('');
    $('#Norm_femaleAdd').val('');
    $('#norm_female_topAdd').val('');
    $('#norm_female_bottomAdd').val('');
    $('#CalibrationAdd').val('');
    $('#ControlAdd').val('');
    $('#ed_ismerAdd').val('');
    $('#dilutionAdd').val('');
    $('#UnitPriceAdd').val('');
    $('#TaxAdd').val('');
    $('#ProducerIdAdd').val('');
    $('#ReagentEquivalentAdd').val('');
    $('#MaterialAdd').val('');
    $('#probirkaIdAdd').val(0);
    $('#probirka2IdAdd').val(0);
    $('#probirka3IdAdd').val(0);
    $('#activAdd').val(0);
    $('#TitleAdd').val('');
    $('#do12Add').val('');
    $('#posle12Add').val('');
    $('#Method2IdAdd').val(0);
    $('#gotovnostAdd').val('');
    $('#probirka_zAdd').val('');
    $('#srok_gotovnostiAdd').val('');
    $('#gotovnostNAdd').val('');
    $('#visibilityAdd').val($('#selectVisibility').val());
});

// addModalWindow close handler
$('#addModalWindow').on('hidden.bs.modal', function () {

});

/// FormAdd Object
function CreateFormAddObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Для добавления нового реагента заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;
    frm.invalidTab = null;
    frm.activeTab = null;

    frm.getActiveTab = function()
    {
        if($('#nav-add-part1-tab').hasClass('active')) frm.activeTab = 'nav-add-part1-tab';
        else if($('#nav-add-part2-tab').hasClass('active')) frm.activeTab = 'nav-add-part2-tab';
        else if($('#nav-add-part3-tab').hasClass('active')) frm.activeTab = 'nav-add-part3-tab';
        else if($('#nav-add-part4-tab').hasClass('active')) frm.activeTab = 'nav-add-part4-tab';
        else if($('#nav-add-part5-tab').hasClass('active')) frm.activeTab = 'nav-add-part5-tab';     
    };
    frm.getFormData = function()
    {
        frm.getTab1Data();
        frm.getTab2Data();
        frm.getTab3Data();
        frm.getTab4Data();
        frm.getTab5Data();
    };
    frm.getTab1Data = function()
    {
        ///tab 1 ===================================================
        frm.mashinidAdd = $('#MashinidAdd').val();
        frm.reagentIdAdd = $('#ReagentIdAdd').val();
        frm.reagentDescAdd = $('#ReagentDescAdd').val();
        frm.reagentDescRusAdd = $('#ReagentDescRusAdd').val();
        frm.reagentDescArmAdd = $('#ReagentDescArmAdd').val();
        frm.groupIdAdd = $('#GroupIdAdd').val();
        frm.analysisPriceAdd = $('#AnalysisPriceAdd').val();
        frm.methodIdAdd = $('#MethodIdAdd').val();
    };
    frm.getTab2Data = function()
    {
        ///tab 2 ===================================================
        frm.norm_maleAdd = $('#Norm_maleAdd').val();
        frm.norm_male_topAdd = $('#norm_male_topAdd').val();
        frm.norm_male_bottomAdd = $('#norm_male_bottomAdd').val();
        frm.norm_femaleAdd = $('#Norm_femaleAdd').val();
        frm.norm_female_topAdd = $('#norm_female_topAdd').val();
        frm.norm_female_bottomAdd = $('#norm_female_bottomAdd').val();
    };
    frm.getTab3Data = function()
    {
        ///tab 3 ===================================================
        frm.calibrationAdd = $('#CalibrationAdd').val();
        frm.controlAdd = $('#ControlAdd').val();
        frm.ed_ismerAdd = $('#ed_ismerAdd').val();
        frm.dilutionAdd = $('#dilutionAdd').val();
        frm.unitPriceAdd = $('#UnitPriceAdd').val();
        frm.TaxAdd = $('#TaxAdd').val();
        frm.producerIdAdd = $('#ProducerIdAdd').val();
        frm.reagentEquivalentAdd = $('#ReagentEquivalentAdd').val();
    };
    frm.getTab4Data = function()
    {
        ///tab 4 ====================================================
        frm.materialAdd = $('#MaterialAdd').val();
        frm.probirkaIdAdd = $('#probirkaIdAdd').val();
        frm.probirka2IdAdd = $('#probirka2IdAdd').val();
        frm.probirka3IdAdd = $('#probirka3IdAdd').val();
        frm.activAdd = $('#activAdd').val();
        frm.titleAdd = $('#TitleAdd').val();
        frm.do12Add = $('#do12Add').val();
        frm.posle12Add = $('#posle12Add').val();
    };
    frm.getTab5Data = function()
    {
        ///tab 5 ====================================================
        frm.method2IdAdd = $('#Method2IdAdd').val();
        frm.gotovnostAdd = $('#gotovnostAdd').val();
        frm.probirka_zAdd = $('#probirka_zAdd').val();
        frm.srok_gotovnostiAdd = $('#srok_gotovnostiAdd').val();
        frm.gotovnostNAdd = $('#gotovnostNAdd').val();
        frm.visibilityAdd = $('#visibilityAdd').val();
    };
    frm.validate = function()
    {
        frm.validateTab1();
        if(frm.isValid) frm.validateTab2();
        else return;
        if(frm.isValid) frm.validateTab3();
        else return;
        if(frm.isValid) frm.validateTab4();
        else return;
        if(frm.isValid) frm.validateTab5();
        else return;
    };
    //Tab1
    frm.validateTab1 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
        
        //MashinidAdd
        if(frm.mashinidAdd.length == 0)
        {
            frm.message = 'Введите код машины в поле Mashinid.';
            frm.invalidField ='MashinidAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;            
        }
        //MashinidAdd is negative
        else if(frm.mashinidAdd < 0)
        {
            frm.message = 'Введите положительное число в поле Mashinid.';
            frm.invalidField ='MashinidAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;
        }
        //MashinidAdd is not unique
        else if(frm.mashinidAdd != 0 && frm.machineIdIsNotUnique())
        {
            frm.message = 'Введите уникальный код машины в поле Mashinid.';
            frm.invalidField ='MashinidAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return; 
        }
        //ReagentDescAdd
        else if(frm.reagentDescAdd.length == 0)
        {
            frm.message = 'Введите описание реагента на английском в поле ReagentDesc.';
            frm.invalidField ='ReagentDescAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;
        }
        //ReagentDescRusAdd
        else if(frm.reagentDescRusAdd.length == 0)
        {
            frm.message = 'Введите описание реагента на русском в поле ReagentDescRus.';
            frm.invalidField ='ReagentDescRusAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;
        }
        //ReagentDescArmAdd
        // else if(frm.reagentDescArmAdd.length == 0)
        // {
        //     frm.message = 'Введите описание реагента на армянском в поле ReagentDescArm.';
        //     frm.invalidField ='ReagentDescArmAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part1-tab';
        //     return;
        // }
        //GroupIdAdd
        else if(frm.groupIdAdd == 0)
        {
            frm.message = 'Выберите GroupId.';
            frm.invalidField ='GroupIdAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;
        }
        //AnalysisPriceAdd
        // else if(frm.analysisPriceAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля AnalysisPrice.';
        //     frm.invalidField ='AnalysisPriceAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part1-tab';
        //     return;
        // }
        //MethodIdAdd
        else if(frm.methodIdAdd == 0)
        {
            frm.message = 'Выберите MethodId.';
            frm.invalidField ='MethodIdAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;
        }
        else
        {
            frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            frm.invalidTab = null;
            return;
        }
    };
    //Tab2
    frm.validateTab2 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
    
        //Norm_maleAdd
        // if(frm.norm_maleAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля Norm_male.';
        //     frm.invalidField ='Norm_maleAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part2-tab';
        //     return;
        // }
        //norm_male_topAdd
        // else if(frm.norm_male_topAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_male_top.';
        //     frm.invalidField ='norm_male_topAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part2-tab';
        //     return;
        // }
        //norm_male_bottomAdd
        // else if(frm.norm_male_bottomAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_male_bottom.';
        //     frm.invalidField ='norm_male_bottomAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part2-tab';
        //     return;
        // }
        //Norm_femaleAdd
        // else if(frm.norm_femaleAdd == 0)
        // {
        //     frm.message = 'Введите значение поля Norm_female.';
        //     frm.invalidField ='Norm_femaleAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part2-tab';
        //     return;
        // }
        //norm_female_topAdd
        // else if(frm.norm_female_topAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_female_top.';
        //     frm.invalidField ='norm_female_topAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part2-tab';
        //     return;
        // }
        //norm_female_bottomAdd
        // else if(frm.norm_female_bottomAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_female_bottom.';
        //     frm.invalidField ='norm_female_bottomAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part2-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //Tab3
    frm.validateTab3 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //CalibrationAdd
        // if(frm.calibrationAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля Calibration.';
        //     frm.invalidField ='CalibrationAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        //ControlAdd
        // else if(frm.controlAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля Control.';
        //     frm.invalidField ='ControlAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        //ed_ismerAdd
        // else if(frm.ed_ismerAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля ed_ismer.';
        //     frm.invalidField ='ed_ismerAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        //dilutionAdd
        // else if(frm.dilutionAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля dilution.';
        //     frm.invalidField ='dilutionAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        //UnitPriceAdd
        // else if(frm.unitPriceAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля UnitPrice.';
        //     frm.invalidField ='UnitPriceAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        //TaxAdd
        // else if(frm.TaxAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля norm_female_bottom.';
        //     frm.invalidField ='TaxAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        //ProducerIdAdd
        // else if(frm.producerIdAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля ProducerId.';
        //     frm.invalidField ='ProducerIdAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        //ReagentEquivalentAdd
        // else if(frm.reagentEquivalentAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля ReagentEquivalent.';
        //     frm.invalidField ='ReagentEquivalentAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part3-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //Tab4
    frm.validateTab4 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //MaterialAdd
        // if(frm.materialAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля Material.';
        //     frm.invalidField ='MaterialAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        //probirkaIdAdd
        // else if(frm.probirkaIdAdd == 0)
        // {
        //     frm.message = 'Выберите probirkaId.';
        //     frm.invalidField ='probirkaIdAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        //probirka2IdAdd
        // else if(frm.probirka2IdAdd == 0)
        // {
        //     frm.message = 'Выберите probirka2Id.';
        //     frm.invalidField ='probirka2IdAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        //probirka3IdAdd
        // else if(frm.probirka3IdAdd == 0)
        // {
        //     frm.message = 'Выберите probirka3Id.';
        //     frm.invalidField ='probirka3IdAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        //activAdd
        // else if(frm.activAdd == 0)
        // {
        //     frm.message = 'Выберите activ.';
        //     frm.invalidField ='activAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        //TitleAdd
        // else if(frm.titleAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля Title.';
        //     frm.invalidField ='TitleAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        //do12Add
        // else if(frm.do12Add.length == 0)
        // {
        //     frm.message = 'Введите значение поля do12.';
        //     frm.invalidField ='do12Add';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        //posle12Add
        // else if(frm.posle12Add.length == 0)
        // {
        //     frm.message = 'Введите значение поля posle12.';
        //     frm.invalidField ='posle12Add';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part4-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //Tab5
    frm.validateTab5 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //Method2IdAdd
        // if(frm.method2IdAdd == 0)
        // {
        //     frm.message = 'Выберите Method2Id.';
        //     frm.invalidField ='Method2IdAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part5-tab';
        //     return;
        // }
        //gotovnostAdd
        // else if(frm.gotovnostAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля gotovnost.';
        //     frm.invalidField ='gotovnostAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part5-tab';
        //     return;
        // }
        //probirka_zAdd
        // else if(frm.probirka_zAdd == 0)
        // {
        //     frm.message = 'Выберите probirka_z.';
        //     frm.invalidField ='probirka_zAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part5-tab';
        //     return;
        // }
        //srok_gotovnostiAdd
        // else if(frm.srok_gotovnostiAdd == 0)
        // {
        //     frm.message = 'Введите значение поля srok_gotovnosti.';
        //     frm.invalidField ='srok_gotovnostiAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part5-tab';
        //     return;
        // }
        //gotovnostNAdd
        // else if(frm.gotovnostNAdd.length == 0)
        // {
        //     frm.message = 'Введите значение поля gotovnostN.';
        //     frm.invalidField ='gotovnostNAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part5-tab';
        //     return;
        // }
        //visibilityAdd
        // else if(frm.visibilityAdd == 0)
        // {
        //     frm.message = 'Выберите visibility.';
        //     frm.invalidField ='visibilityAdd';
        //     frm.isValid = false;
        //     frm.invalidTab = 'nav-add-part5-tab';
        //     return;
        // }
        // else
        // {
        //     frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        //     frm.invalidField = null;
        //     frm.isValid = true;
        //     frm.invalidTab = null;
        //     return;
        // }
    };
    //MashinidIsNotUnique function
    frm.machineIdIsNotUnique = function()
    {
        resultReceived = null;
        /// ajax setup
        $.ajaxSetup({
            type: "POST",
            url: "../php/checkIfMachineIdIsNotUnique.php",
            cache: false,
            async: false,
            data: dataString = $("form[name='tempData']").serialize().concat('&').concat("Mashinid=").concat(frm.mashinidAdd),
            success: function(result)
            {
                resultReceived = result;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                $('#messageAddModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
            }
        });
        ///process
        $.ajax();
        
        return resultReceived;
    };
    return frm;
}
// deleteModalWindow button OK handler
$('#deleteModalWindow').on('click','#buttonOKDelete', function(){

    ///updateing reagent data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../php/deleteReagent.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formDelete']").serialize()),
        success: function(res)
        {
            var filterObj = {};
            filterObj.groupId = $("#selectGroup").val();
            filterObj.methodId = $("#selectMethod").val();
            filterObj.visibilityId = $("#selectVisibility").val();
            filterObj.generalSelectionId = $("generalSelectionId").val();
            filterObj.reagentId = $("#selectReagent").val();
            updateContent(filterObj);
            setSelectReagentData();
            $('#deleteModalWindow').modal('hide');
            $("#editLink").hide();
            $("#deleteLink").hide();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            $('#messageDeleteModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
        }
    });
    ///process
    $.ajax();
    return;    
});

// deleteModalWindow close handler
$('#deleteModalWindow').on('hidden.bs.modal', function () {
    
});