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
        var reagentId = $("#selectReagent").val();
        showEditForm(reagentId);
        $("#editLink").click();
    });

    //getting searched value of input tag with id "searchReagent"
    $("#searchButton").click(function()
    {
        var temp = $("#searchReagent").val();
        if(temp.length == 0 || temp == null)
        {
            
            temp = 0;
        }
        else
        {
            temp = parseInt(temp);
        }
        showEditForm(temp);
        //$("#editLink").click();
    });

    $("#searchReagent").focus(function () {
        $("#selectReagent").val(0);
        $(this).select();
     });
    
     $("#selectReagent").focus(function () {
        $("#searchReagent").val("");
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
        source: data,
        select: function(event,ui)
        {
            var temp = ui.item.value;
            if(temp.length == 0 || temp == null)
            {
                
                temp = 0;
            }
            else
            {
                temp = parseInt(temp);
            }
            showEditForm(temp);
            //$("#editLink").click();
        }
    });
    $("#searchReagent").prop("disabled",false);
}

function showEditForm(reagentId)
{
    var formMsg = "Для редактирования данных реагента заполните нужными значениями поля формы.";
    $("#messageEditModal").html(formMsg);

    $("#reagent_id").val(reagentId);
    setReagentEMWData();
    $("#editLink").click();
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
function updateRow(reagentId)
{
    var row = $("#r_" + reagentId);
    //get list of td tags in tr tag
    if(typeof row != "undefined")
    {
        var rowNumber = 0;
        $(row).find("td").each(function(index, element){
            if(index == 1)
            {
                rowNumber = parseInt($(element).text());
                //console.log("rowNumber=" + rowNumber);
            }
        });
        
        if(typeof rowNumber != "undefined" && rowNumber > 0)
        {
            /// ajax setup
            $.ajaxSetup({
                type: "POST",
                url: "../reagents/getReagentRowData.php",
                cache: false,
                data: dataString = $("form[name='tempData']").serialize(),
                success: funcSuccessGetReagentRowData,
                error: funcError
            });
            ///process
            $.ajax();
        }
    }

}
function funcSuccessGetReagentRowData(result)
{
    //console.log(result);
    var reagentId = $("#reagent_id").val();

    var rowNumber = "";
    //getting row number
    $("#r_" + reagentId).find("td").each(function(index, element){
        if(index == 1)
        {
            rowNumber = $(element).html();
        }
    });
    
    //changing row content
    $("#r_" + reagentId).html(result);
    //setting row number
    $("#r_" + reagentId).find("td").each(function(index, element){
        if(index == 1)
        {
            $(element).html(rowNumber);
        }
    });
}
function updateContent(filterObj)
{
    var groupId = filterObj.groupId;
    var methodId = filterObj.methodId;
    var generalSelectionId = filterObj.generalSelectionId;
    var reagentId = filterObj.reagentId;
    
    var loaderMsg = '';
    if(groupId==0 && methodId==0 && generalSelectionId==0/*  && reagentId==0 */)
    {
        loaderMsg  = '<div class="alert alert-primary d-print-none" role="alert">';
        loaderMsg += 'Сделайте выборку с помощью фильтров методов и групп, общей выборки или же выберите конкретный реагент с помощью фильтра реагентов.';
        loaderMsg += '</div>';
        $("#content").html(loaderMsg);
        $("#exportLink").hide(); 
        $("#addLink").hide();
        $("#copyLink").hide();
        $("#editLink").hide();
        $("#deleteLink").hide();
        return;
    }
    else if(groupId!=0 || methodId!=0 || generalSelectionId!=0/*  || reagentId!=0 */)
    {
        $("#exportLink").show(); 
        $("#addLink").show();
        $("#copyLink").hide();
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
                setReagentCMWData();
                $("#copyLink").show();
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
    if(result == "no_reagent")
    {
        var msg = `
            По данной выборке ничего не найдено.
        `;
        $("#messageEditModal").html(msg);
        $("#contentEditModal").html("");
        return;
    }
    else
    {
        $("#contentEditModal").html(result);
    }
    
}

//setting copyModalWindow data
function setReagentCMWData()
{
    /// ajax setup
    $.ajaxSetup({
    type: "POST",
    url: "../reagents/getReagentCMWData.php",
    cache: false,
    data: dataString = $("form[name='tempData']").serialize(),
    success: funcSuccessSetReagentCMWData,
    error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetReagentCMWData(result)
{
    if(result == "no_reagent")
    {
        var msg = `
            По данной выборке ничего не найдено.
        `;
        $("#messageCopyModal").html(msg);
        $("#contentCopyModal").html("");
        return;
    }
    else
    {
        $("#contentCopyModal").html(result);
    }
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

/////////////////////////////////////////////////////




// copyModalWindow button OK handler
$('#copyModalWindow').on('click','#buttonOKCopy', function(){
    
    var frmCopy = CreateFormCopyObject();
    frmCopy.getFormData();
    frmCopy.validate();
    if(!frmCopy.isValid)
    {
        $('#messageCopyModal').html(frmCopy.message);
        $('#' + frmCopy.invalidField).focus();
        return;
    }
    else
    {
        $('#messageCopyModal').html(frmCopy.message);
    }
    
    ///updateing reagent data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reagents/copyReagent.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formCopy']").serialize()),
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
            setSearchReagentData();
            $("#copyModalWindow").modal('hide');
            $("#copyLink").hide();
            $("#editLink").hide();
            $("#deleteLink").hide();
            $("#messageTitleModal").text(res);
            $("#messageModalWindow").modal("show");

        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            $('#messageCopyModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
        }
    });
    ///process
    $.ajax();
    return;    
});

// copyModalWindow shown handler
$('#copyModalWindow').on('shown.bs.modal', function () {
 
});

// copyModalWindow close handler
$('#copyModalWindow').on('hidden.bs.modal', function () {

});

/// FormCopy Object
function CreateFormCopyObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Для добавления нового реагента заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;
    
    frm.getFormData = function()
    {
        frm.mashinidCopy = $('#MashinidCopy').val();
        frm.reagentIdCopy = $('#ReagentIdCopy').val();
        frm.reagentDescCopy = $('#ReagentDescCopy').val();
        frm.reagentDescRusCopy = $('#ReagentDescRusCopy').val();
        frm.reagentDescArmCopy = $('#ReagentDescArmCopy').val();
        frm.groupIdCopy = $('#GroupIdCopy').val();
        frm.analysisPriceCopy = $('#AnalysisPriceCopy').val();
        frm.methodIdCopy = $('#MethodIdCopy').val();
        frm.norm_maleCopy = $('#Norm_maleCopy').val();
        frm.norm_male_topCopy = $('#norm_male_topCopy').val();
        frm.norm_male_bottomCopy = $('#norm_male_bottomCopy').val();
        frm.norm_femaleCopy = $('#Norm_femaleCopy').val();
        frm.norm_female_topCopy = $('#norm_female_topCopy').val();
        frm.norm_female_bottomCopy = $('#norm_female_bottomCopy').val();
        frm.calibrationCopy = $('#CalibrationCopy').val();
        frm.controlCopy = $('#ControlCopy').val();
        frm.ed_ismerCopy = $('#ed_ismerCopy').val();
        frm.dilutionCopy = $('#dilutionCopy').val();
        frm.unitPriceCopy = $('#UnitPriceCopy').val();
        frm.loincCopy = $('#LoincCopy').val();
        frm.producerIdCopy = $('#ProducerIdCopy').val();
        frm.reagentEquivalentCopy = $('#ReagentEquivalentCopy').val();
        frm.materialCopy = $('#MaterialCopy').val();
        frm.probirkaIdCopy = $('#probirkaIdCopy').val();
        frm.probirka2IdCopy = $('#probirka2IdCopy').val();
        frm.probirka3IdCopy = $('#probirka3IdCopy').val();
        frm.activCopy = $('#activCopy').val();
        frm.titleCopy = $('#TitleCopy').val();
        frm.do12Copy = $('#do12Copy').val();
        frm.posle12Copy = $('#posle12Copy').val();
        frm.method2IdCopy = $('#Method2IdCopy').val();
        frm.gotovnostCopy = $('#gotovnostCopy').val();
        frm.probirka_zCopy = $('#probirka_zCopy').val();
        frm.srok_gotovnostiCopy = $('#srok_gotovnostiCopy').val();
        frm.gotovnostNCopy = $('#gotovnostNCopy').val();
        frm.visibilityCopy = $('#visibilityCopy').val();
    };
    frm.validate = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        
        //MashinidCopy
        if(frm.mashinidCopy.length == 0)
        {
            frm.message = 'Введите код машины в поле Mashinid.';
            frm.invalidField ='MashinidCopy';
            frm.isValid = false;
            return;            
        }
        //MashinidCopy is negative
        else if(frm.mashinidCopy < 0)
        {
            frm.message = 'Введите положительное число в поле Mashinid.';
            frm.invalidField ='MashinidCopy';
            frm.isValid = false;
            return;
        }
        //MashinidCopy is not unique
        else if(frm.mashinidCopy != 0 && frm.machineIdIsNotUnique())
        {
            frm.message = 'Введите уникальный код машины в поле Mashinid.';
            frm.invalidField ='MashinidCopy';
            frm.isValid = false;
            return; 
        }
        //ReagentDescCopy
        else if(frm.reagentDescCopy.length == 0)
        {
            frm.message = 'Введите описание реагента на английском в поле ReagentDesc.';
            frm.invalidField ='ReagentDescCopy';
            frm.isValid = false;
            return;
        }
        //ReagentDescRusCopy
        else if(frm.reagentDescRusCopy.length == 0)
        {
            frm.message = 'Введите описание реагента на русском в поле ReagentDescRus.';
            frm.invalidField ='ReagentDescRusCopy';
            frm.isValid = false;
            return;
        }
        //GroupIdCopy
        else if(frm.groupIdCopy == 0)
        {
            frm.message = 'Выберите GroupId.';
            frm.invalidField ='GroupIdCopy';
            frm.isValid = false;
            return;
        }
        //MethodIdCopy
        else if(frm.methodIdCopy == 0)
        {
            frm.message = 'Выберите MethodId.';
            frm.invalidField ='MethodIdCopy';
            frm.isValid = false;
            return;
        }
        else
        {
            frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
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
            data: dataString = $("form[name='tempData']").serialize().concat('&').concat("Mashinid=").concat(frm.mashinidCopy),
            success: function(result)
            {
                resultReceived = result;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                $('#messageCopyModal').html("Status: " + textStatus + ", " + "Error: " + errorThrown);
            }
        });
        ///process
        $.ajax();
        
        return resultReceived;
    };
    return frm;
}

////////////////////////////////////////////////////

// editModalWindow button OK handler
$('#editModalWindow').on('click','#buttonOKEdit', function(){

    var frmEdit = CreateFormEditObject();
    frmEdit.getFormData();
    if(frmEdit.reagentIdEdit == null) 
    {
        $('#editModalWindow').modal('hide');
        return;
    }
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
    
    //getting reagentId 
    var reagentId = $("#reagent_id").val();
    if(typeof reagentId == "undefined")
    {
        //console.log("reagentId="+ undefined);
        $('#editModalWindow').modal('hide');
        return;
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
            updateRow(reagentId);
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
            return;
        }
        //MashinidEdit is negative
        else if(frm.mashinidEdit < 0)
        {
            frm.message = 'Введите положительное число в поле Mashinid.';
            frm.invalidField ='MashinidEdit';
            frm.isValid = false;
            return;
        }
        //MashinidEdit is not unique
        else if(frm.mashinidEdit != 0 && (frm.mashinidEdit != frm.getPreviousMachineId()) && (frm.machineIdIsNotUnique() == true))
        {
            frm.message = 'Введите уникальный код машины в поле Mashinid.';
            frm.invalidField ='MashinidEdit';
            frm.isValid = false;
            return; 
        }
        //ReagentDescEdit
        else if(frm.reagentDescEdit.length == 0)
        {
            frm.message = 'Введите описание реагента на английском в поле ReagentDesc.';
            frm.invalidField ='ReagentDescEdit';
            frm.isValid = false;
            return;
        }
        //ReagentDescRusEdit
        else if(frm.reagentDescRusEdit.length == 0)
        {
            frm.message = 'Введите описание реагента на русском в поле ReagentDescRus.';
            frm.invalidField ='ReagentDescRusEdit';
            frm.isValid = false;
            return;
        }
        //GroupIdEdit
        else if(frm.groupIdEdit == 0)
        {
            frm.message = 'Выберите GroupId.';
            frm.invalidField ='GroupIdEdit';
            frm.isValid = false;
            return;
        }
        //MethodIdEdit
        else if(frm.methodIdEdit == 0)
        {
            frm.message = 'Выберите MethodId.';
            frm.invalidField ='MethodIdEdit';
            frm.isValid = false;
            return;
        }
        else
        {
            frm.message = 'Для редактирования данных реагента заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
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
    frmAdd.validate();
    if(!frmAdd.isValid)
    {
        $('#messageAddModal').html(frmAdd.message);
        $('#' + frmAdd.invalidField).focus();
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
            //console.log(res);
            var filterObj = {};
            filterObj.groupId = $("#selectGroup").val();
            filterObj.methodId = $("#selectMethod").val();
            filterObj.visibilityId = $("#selectVisibility").val();
            filterObj.generalSelectionId = $("#generalSelectionId").val();
            filterObj.reagentId = $("#selectReagent").val();
            updateContent(filterObj);
            setSelectReagentData();
            setSearchReagentData();
            $("#addModalWindow").modal('hide');
            $("#copyLink").hide();
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
    
    frm.getFormData = function()
    {
        frm.mashinidAdd = $('#MashinidAdd').val();
        frm.reagentIdAdd = $('#ReagentIdAdd').val();
        frm.reagentDescAdd = $('#ReagentDescAdd').val();
        frm.reagentDescRusAdd = $('#ReagentDescRusAdd').val();
        frm.reagentDescArmAdd = $('#ReagentDescArmAdd').val();
        frm.groupIdAdd = $('#GroupIdAdd').val();
        frm.analysisPriceAdd = $('#AnalysisPriceAdd').val();
        frm.methodIdAdd = $('#MethodIdAdd').val();
        frm.norm_maleAdd = $('#Norm_maleAdd').val();
        frm.norm_male_topAdd = $('#norm_male_topAdd').val();
        frm.norm_male_bottomAdd = $('#norm_male_bottomAdd').val();
        frm.norm_femaleAdd = $('#Norm_femaleAdd').val();
        frm.norm_female_topAdd = $('#norm_female_topAdd').val();
        frm.norm_female_bottomAdd = $('#norm_female_bottomAdd').val();
        frm.calibrationAdd = $('#CalibrationAdd').val();
        frm.controlAdd = $('#ControlAdd').val();
        frm.ed_ismerAdd = $('#ed_ismerAdd').val();
        frm.dilutionAdd = $('#dilutionAdd').val();
        frm.unitPriceAdd = $('#UnitPriceAdd').val();
        frm.loincAdd = $('#LoincAdd').val();
        frm.producerIdAdd = $('#ProducerIdAdd').val();
        frm.reagentEquivalentAdd = $('#ReagentEquivalentAdd').val();
        frm.materialAdd = $('#MaterialAdd').val();
        frm.probirkaIdAdd = $('#probirkaIdAdd').val();
        frm.probirka2IdAdd = $('#probirka2IdAdd').val();
        frm.probirka3IdAdd = $('#probirka3IdAdd').val();
        frm.activAdd = $('#activAdd').val();
        frm.titleAdd = $('#TitleAdd').val();
        frm.do12Add = $('#do12Add').val();
        frm.posle12Add = $('#posle12Add').val();
        frm.method2IdAdd = $('#Method2IdAdd').val();
        frm.gotovnostAdd = $('#gotovnostAdd').val();
        frm.probirka_zAdd = $('#probirka_zAdd').val();
        frm.srok_gotovnostiAdd = $('#srok_gotovnostiAdd').val();
        frm.gotovnostNAdd = $('#gotovnostNAdd').val();
        frm.visibilityAdd = $('#visibilityAdd').val();
    };
    frm.validate = function()
    {
        frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        
        //MashinidAdd
        if(frm.mashinidAdd.length == 0)
        {
            frm.message = 'Введите код машины в поле Mashinid.';
            frm.invalidField ='MashinidAdd';
            frm.isValid = false;
            return;            
        }
        //MashinidAdd is negative
        else if(frm.mashinidAdd < 0)
        {
            frm.message = 'Введите положительное число в поле Mashinid.';
            frm.invalidField ='MashinidAdd';
            frm.isValid = false;
            return;
        }
        //MashinidAdd is not unique
        else if(frm.mashinidAdd != 0 && frm.machineIdIsNotUnique())
        {
            frm.message = 'Введите уникальный код машины в поле Mashinid.';
            frm.invalidField ='MashinidAdd';
            frm.isValid = false;
            return; 
        }
        //ReagentDescAdd
        else if(frm.reagentDescAdd.length == 0)
        {
            frm.message = 'Введите описание реагента на английском в поле ReagentDesc.';
            frm.invalidField ='ReagentDescAdd';
            frm.isValid = false;
            return;
        }
        //ReagentDescRusAdd
        else if(frm.reagentDescRusAdd.length == 0)
        {
            frm.message = 'Введите описание реагента на русском в поле ReagentDescRus.';
            frm.invalidField ='ReagentDescRusAdd';
            frm.isValid = false;
            return;
        }
        //GroupIdAdd
        else if(frm.groupIdAdd == 0)
        {
            frm.message = 'Выберите GroupId.';
            frm.invalidField ='GroupIdAdd';
            frm.isValid = false;
            return;
        }
        //MethodIdAdd
        else if(frm.methodIdAdd == 0)
        {
            frm.message = 'Выберите MethodId.';
            frm.invalidField ='MethodIdAdd';
            frm.isValid = false;
            return;
        }
        else
        {
            frm.message = 'Для добавления нового реагента заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
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