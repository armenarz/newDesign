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
        url: "../reagents/getSearchReagentData.php",
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
        url: "../reagents/getSelectGroupData.php",
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
        url: "../reagents/getSelectMethodData.php",
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
    console.log(result);
    $('#selectMethod').html(result);
    $("#selectMethod").prop("disabled",false);
}

function setSelectReagentData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reagents/getSelectReagentData.php",
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
    else if(groupId!=0 || methodId!=0 || generalSelectionId!=0 || reagentId!=0)
    {
        $("#exportLink").show(); 
        $("#addLink").show();
        $("#editLink").hide();
        $("#deleteLink").hide();
        setReagentAMWData();
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
        url: "../reagents/getReagentEMWData.php",
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
        url: "../reagents/getReagentAMWData.php",
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
        url: "../reagents/getReagentDMWData.php",
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
        url: "../reagents/getFreeDays.php",
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
        url: "../reagents/editFreeDays.php",
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
    frmEdit.validate();
    if(!frmEdit.isValid)
    {
        $('#messageEditModal').html(frmEdit.message);
        $('#' + frmEdit.invalidField).focus();
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
        url: "../reagents/editReagent.php",
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
    
    frm.getFormData = function()
    {
        frm.mashinidEdit = $('#MashinidEdit').val();
        frm.reagentIdEdit = $('#ReagentIdEdit').val();
        frm.reagentDescEdit = $('#ReagentDescEdit').val();
        frm.reagentDescRusEdit = $('#ReagentDescRusEdit').val();
        frm.reagentDescArmEdit = $('#ReagentDescArmEdit').val();
        frm.groupIdEdit = $('#GroupIdEdit').val();
        frm.analysisPriceEdit = $('#AnalysisPriceEdit').val();
        frm.methodIdEdit = $('#MethodIdEdit').val();
        frm.norm_maleEdit = $('#Norm_maleEdit').val();
        frm.norm_male_topEdit = $('#norm_male_topEdit').val();
        frm.norm_male_bottomEdit = $('#norm_male_bottomEdit').val();
        frm.norm_femaleEdit = $('#Norm_femaleEdit').val();
        frm.norm_female_topEdit = $('#norm_female_topEdit').val();
        frm.norm_female_bottomEdit = $('#norm_female_bottomEdit').val();
        frm.calibrationEdit = $('#CalibrationEdit').val();
        frm.controlEdit = $('#ControlEdit').val();
        frm.ed_ismerEdit = $('#ed_ismerEdit').val();
        frm.dilutionEdit = $('#dilutionEdit').val();
        frm.unitPriceEdit = $('#UnitPriceEdit').val();
        frm.loincEdit = $('#LoincEdit').val();
        frm.producerIdEdit = $('#ProducerIdEdit').val();
        frm.reagentEquivalentEdit = $('#ReagentEquivalentEdit').val();
        frm.materialEdit = $('#MaterialEdit').val();
        frm.probirkaIdEdit = $('#probirkaIdEdit').val();
        frm.probirka2IdEdit = $('#probirka2IdEdit').val();
        frm.probirka3IdEdit = $('#probirka3IdEdit').val();
        frm.activEdit = $('#activEdit').val();
        frm.titleEdit = $('#TitleEdit').val();
        frm.do12Edit = $('#do12Edit').val();
        frm.posle12Edit = $('#posle12Edit').val();
        frm.method2IdEdit = $('#Method2IdEdit').val();
        frm.gotovnostEdit = $('#gotovnostEdit').val();
        frm.probirka_zEdit = $('#probirka_zEdit').val();
        frm.srok_gotovnostiEdit = $('#srok_gotovnostiEdit').val();
        frm.gotovnostNEdit = $('#gotovnostNEdit').val();
        frm.visibilityEdit = $('#visibilityEdit').val();
    };
    frm.validate = function()
    {
        frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        
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
        //GroupIdEdit
        else if(frm.groupIdEdit == 0)
        {
            frm.message = 'Выберите GroupId.';
            frm.invalidField ='GroupIdEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
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
    //MashinidIsNotUnique function
    frm.machineIdIsNotUnique = function()
    {
        resultReceived = null;
        /// ajax setup
        $.ajaxSetup({
            type: "POST",
            url: "../reagents/checkIfMachineIdIsNotUnique.php",
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
            url: "../reagents/getPreviousMachineId.php",
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
        url: "../reagents/addReagent.php",
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
    $('#LoincAdd').val(0);
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
        frm.loincAdd = $('#LoincAdd').val();
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
        //GroupIdAdd
        else if(frm.groupIdAdd == 0)
        {
            frm.message = 'Выберите GroupId.';
            frm.invalidField ='GroupIdAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;
        }
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
    };
    //Tab3
    frm.validateTab3 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
    };
    //Tab4
    frm.validateTab4 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
    };
    //Tab5
    frm.validateTab5 = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
    };
    //MashinidIsNotUnique function
    frm.machineIdIsNotUnique = function()
    {
        resultReceived = null;
        /// ajax setup
        $.ajaxSetup({
            type: "POST",
            url: "../reagents/checkIfMachineIdIsNotUnique.php",
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
        url: "../reagents/deleteReagent.php",
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