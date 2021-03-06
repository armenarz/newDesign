//startup code
$(function()
{
    var filterObj = {};
    filterObj.preorderStartDate = 0;
    filterObj.preorderEndDate = 0;
    filterObj.preorderId = 0;
    filterObj.generalSelectionId = 0;

    setPreorderStartDateData();
    setPreorderEndDateData();
    setSearchPreorderIdData();
    
    updateContent(filterObj);

    //getting selected value of select tag with id "preorderStartDate";
    $("#preorderStartDate").change(function(){

        filterObj.preorderId = 0;
        $("#searchPreorderId").val("0");
        let generalSelectionId = $("#generalSelectionId").val();
        filterObj.generalSelectionId = generalSelectionId;

        let preorderStartDate = $("#preorderStartDate").val();
        filterObj.preorderStartDate = preorderStartDate;
        let preorderEndDate = $("#preorderEndDate").val();
        filterObj.preorderEndDate = preorderEndDate;

        if(preorderEndDate == 0)
        {
            $("#preorderEndDate").focus();
            return;
        }
        else if(generalSelectionId == 0)
        {
            $("#generalSelectionId").focus();
            return;
        }
        $("#changeStatusLink").hide();
        updateContent(filterObj);
    });

    //getting selected value of select tag with id "preorderEndDate";
    $("#preorderEndDate").change(function(){

        filterObj.preorderId = 0;
        $("#searchPreorderId").val("0");
        let generalSelectionId = $("#generalSelectionId").val();
        filterObj.generalSelectionId = generalSelectionId;

        let preorderStartDate = $("#preorderStartDate").val();
        filterObj.preorderStartDate = preorderStartDate;
        let preorderEndDate = $("#preorderEndDate").val();
        filterObj.preorderEndDate = preorderEndDate;

        if(preorderStartDate == 0)
        {
            $("#preorderStartDate").focus();
            return;
        }
        else if(generalSelectionId == 0)
        {
            $("#generalSelectionId").focus();
            return;
        }
        $("#changeStatusLink").hide();
        updateContent(filterObj);
    });

    //getting searched value of input tag with id "searchPreorderId"
    $("#searchButton").click(function()
    {
        var temp = $("#searchPreorderId").val();
        if(temp.length == 0 || temp == null)
        {
            temp = 0;
        }
        else
        {
            temp = parseInt(temp);
        }
        
        $("#generalSelectionId").val("0");
        filterObj.generalSelectionId = 0;
        $("#preorderStartDate").val("0");
        filterObj.preorderStartDate = 0;
        $("#preorderEndDate").val("0");
        filterObj.preorderEndDate = 0;
        filterObj.preorderId = temp;
        $("#searchPreorderId").val(temp);
        $("#changeStatusLink").hide();
        updateContent(filterObj);
    });

    $("#searchPreorderId").focus(function () {
        $(this).select();
    });

    //getting selected value of select tag with id "generalSelectionId";
    $("#generalSelectionId").change(function(){
        //alert("generalSelectionId");
        filterObj.generalSelectionId = $("#generalSelectionId").val();
        filterObj.preorderStartDate = $("#preorderStartDate").val();
        filterObj.preorderEndDate = $("#preorderEndDate").val();
        filterObj.preorderId = 0;
        $("#searchPreorderId").val("0");
        $("#changeStatusLink").hide();
        updateContent(filterObj);
    });
    
    $("#exportLink").click(function(){
        exportToExcel();
    });

    //setting content div height for scrollbar appearing
    $("#content").height($(window).height()-237);
    $(window).resize(function() 
    {
        $("#content").height($(window).height()-237);
    });
});

function setPreorderStartDateData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../preorders/getPreorderStartDateData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetPreorderStartDateData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetPreorderStartDateData(result)
{
    $("#preorderStartDate").html(result);
    $("#preorderStartDate").prop("disabled",false);
}

function setPreorderEndDateData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../preorders/getPreorderStartDateData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetPreorderEndDateData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetPreorderEndDateData(result)
{
    $("#preorderEndDate").html(result);
    $("#preorderEndDate").prop("disabled",false);
}

function setSearchPreorderIdData()
{
    var data = [];

    $.ajaxSetup({
        type: "POST",
        url: "../preorders/getSearchPreorderData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: function(result)
        {
            var searchPreorderObject = JSON.parse(result);
            var dataArray = $.makeArray(searchPreorderObject);
            var dataArrayLength = dataArray.length;
            var i = 0;

            for(i = 0; i < dataArrayLength; i++)
            {
                var item = "";
                item = dataArray[i];
                item = item.replace(/&nbsp;/g,"\xa0").replace(/&hellip;/g,"\u2026");
                data.push(item);
            }
        },
        error: funcError
    });
    ///process
    $.ajax();

    $( "#searchPreorderId" ).autocomplete({
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
            
            let filterObj = {};
            filterObj.preorderId = temp;
            $("#searchPreorderId").val(temp);
            
            filterObj.preorderStartDate = 0;
            $("#preorderStartDate").val("0");
            filterObj.preorderEndDate = 0;
            $("#preorderEndDate").val("0");
            filterObj.generalSelectionId = 0;
            $("#generalSelectionId").val("0");
        }
    });
    $("#searchPreorderId").prop("disabled",false);
}

function setPreorderCSMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../preorders/getPreorderCSMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetPreorderCSMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetPreorderCSMWData(result)
{
    $("#contentChangeStatusModal").html(result);
    $("#PreorderStatusChangeStatus").change(function(){
        let preorderStatus = $(this).val();
        if(preorderStatus == 1)
        {
            $("#OrderIdChangeStatus").val("");
            $("#StatusInfoChangeStatus").val("");
        }
        else if(preorderStatus == 3)
        {
            $("#OrderIdChangeStatus").val("");
        }
    });
}

function updateRow(preorderId)
{
    var row = $("#r_" + preorderId);
    //get list of td tags in tr tag
    if(typeof row != "undefined")
    {
        var rowNumber = 0;
        $(row).find("td").each(function(index, element){
            if(index == 1)
            {
                rowNumber = parseInt($(element).text());
            }
        });
        
        if(typeof rowNumber != "undefined" && rowNumber > 0)
        {
            /// ajax setup
            $.ajaxSetup({
                type: "POST",
                url: "../preorders/getPreorderRowData.php",
                cache: false,
                data: dataString = $("form[name='tempData']").serialize(),
                success: funcSuccessGetPreorderRowData,
                error: funcError
            });
            ///process
            $.ajax();
        }
    }
}
function funcSuccessGetPreorderRowData(result)
{
    var preorderId = $("#preorder_id").val();

    var rowNumber = "";
    //getting row number
    $("#r_" + preorderId).find("td").each(function(index, element){
        if(index == 1)
        {
            rowNumber = $(element).html();
        }
    });
    
    //changing row content
    $("#r_" + preorderId).html(result);
    //setting row number
    $("#r_" + preorderId).find("td").each(function(index, element){
        if(index == 1)
        {
            $(element).html(rowNumber);
        }
    });
}

function updateContent(filterObj)
{
    let preorderStartDate = filterObj.preorderStartDate;
    
    let preorderEndDate = filterObj.preorderEndDate;
    
    let preorderId = filterObj.preorderId;
    
    let generalSelectionId = filterObj.generalSelectionId; 

    let loaderMsg = '';
    
    if((preorderStartDate == 0 || preorderEndDate == 0) && preorderId == 0 && generalSelectionId == 0)
    {
        loaderMsg  =    `<div class="alert alert-primary d-print-none" role="alert">
                            Сделайте выборку с помощью фильтров даты, общей выборки или же выберите конкретный предзаказ с помощью фильтра предзаказа.
                        </div>`;
        $("#content").html(loaderMsg);
        $("#exportLink").hide();
        $("#changeStatusLink").hide();
        return;
    }
    else if((preorderStartDate != 0 && preorderEndDate != 0) || preorderId != 0 || generalSelectionId != 0)
    {
        $("#exportLink").show();
        $("#changeStatusLink").hide();
    }

    
    $.ajaxSetup({
		type: "POST",
    	url: "../preorders/getPreorderData.php",
   		cache:false,
        data: dataString = $("form[name='tempData']").serialize()
    });
    
    loaderMsg  =    `<div class="alert alert-primary d-print-none" role="alert">
                        Данные загружаются...
                    </div>`;
    
    $("#content").html(loaderMsg);

    $.ajax({
        success:function(msg){
            $("#content").html(msg);
            $("input[name='radioPreorder']").on("click",this,function()
            {
                $("#preorder_id").val($(this).val());
                setPreorderCSMWData();
                $("#changeStatusLink").show();
            });
        }
    });
}

//export to excel
function exportToExcel()
{
    document.tempData.action = 'exportPreordersToExcel.php';
    document.tempData.target = '_blank';
    document.tempData.method = 'POST';
    document.tempData.submit();
    document.tempData.action = '';
    document.tempData.target = '';
}

// changeStatusModalWindow button buttonOKChangeStatus handler
$("#changeStatusModalWindow").on('click','#buttonOKChangeStatus', function(){
    //console.log("buttonOKChangeStatus");
    var frmChangeStatus = CreateFormChangeStatusObject();
    frmChangeStatus.getFormData();
    
    frmChangeStatus.validate();
    if(!frmChangeStatus.isValid)
    {
        $('#messageChangeStatusModal').html(frmChangeStatus.message);
        $('#' + frmChangeStatus.invalidField).focus();
        return;
    }
    else
    {
        $('#messageChangeStatusModal').html(frmChangeStatus.message);
    }

    //getting preorderId 
    var preorderId = $("#preorder_id").val();
    if(typeof preorderId == "undefined")
    {
        $('#changeStatusModalWindow').modal('hide');
        return;
    }

    ///updateing preorder data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../preorders/changeStatusPreorder.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formChangeStatus']").serialize()),
        success: function(res)
        {
            setRawPreordersCount();
            
            // when the value of searchPreorderId is greater than zero
            let searchPreorderId = parseInt($("#searchPreorderId").val());
            if(!isNaN(searchPreorderId))
            {
                if(searchPreorderId > 0)
                {
                    updateRow(preorderId);
                }
            }

            // when the value of generalSelectionId is 1 or 2 or 3
            let generalSelectionId = $("#generalSelectionId").val();
            let filterObj = {};
            if(generalSelectionId == 1 || generalSelectionId == 2 || generalSelectionId == 3)
            {
                filterObj.preorderStartDate = 0;
                filterObj.preorderEndDate = 0;
                filterObj.preorderId = 0;
                filterObj.generalSelectionId = generalSelectionId;
                updateContent(filterObj);
            }
            else if(generalSelectionId == 4)
            {
                updateRow(preorderId);
            }
            $('#changeStatusModalWindow').modal('hide');
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

/// FormChangeStatus Object
function CreateFormChangeStatusObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Для изменения статуса предзаказа заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.preorderStatusChangeStatus = $('#PreorderStatusChangeStatus').val();
        frm.orderIdChangeStatus = $('#OrderIdChangeStatus').val();
        frm.statusInfoChangeStatus = $('#StatusInfoChangeStatus').val();
    };
    frm.validate = function()
    {
        frm.message = 'Для изменения статуса предзаказа заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        
        // PreorderStatusChangeStatus
        if(frm.preorderStatusChangeStatus == 0)
        {
            frm.message = 'Выберите статус предзаказа.';
            frm.invalidField ='PreorderStatusChangeStatus';
            frm.isValid = false;
            return;            
        }
        // OrderIdChangeStatus
        else if(frm.preorderStatusChangeStatus == 1 && frm.orderIdChangeStatus.length > 0 && frm.orderIdChangeStatus != "0")
        {
            frm.message = 'Если предзаказ необработан то поле "Номер заказа" должен быть пустым или содержать ноль.';
            frm.invalidField ='OrderIdChangeStatus';
            frm.isValid = false;
            return;
        }
        // StatusInfoChangeStatus
        else if(frm.preorderStatusChangeStatus == 1 && frm.statusInfoChangeStatus.length > 0)
        {
            frm.message = 'Если предзаказ необработан то поле "Справка о статусе" должен быть пустым.';
            frm.invalidField ='StatusInfoChangeStatus';
            frm.isValid = false;
            return;
        }
        // OrderIdChangeStatus
        else if(frm.preorderStatusChangeStatus == 2 && (frm.orderIdChangeStatus.length == 0 || frm.orderIdChangeStatus == "0"))
        {
            frm.message = 'Если предзаказ подтвержден то поле "Номер заказа" не должен быть пустым или содержать ноль.';
            frm.invalidField ='OrderIdChangeStatus';
            frm.isValid = false;
            return;
        }
        // OrderIdChangeStatus
        else if(frm.preorderStatusChangeStatus == 3 && frm.orderIdChangeStatus.length > 0 && frm.orderIdChangeStatus != "0")
        {
            frm.message = 'Если предзаказ отклонен то поле "Номер заказа" должен быть пустым или содержать ноль.';
            frm.invalidField ='OrderIdChangeStatus';
            frm.isValid = false;
            return;
        }
        // StatusInfoChangeStatus
        else if(frm.preorderStatusChangeStatus == 3 && frm.statusInfoChangeStatus.length == 0)
        {
            frm.message = 'Если предзаказ отклонен то поле "Справка о статусе" не должен быть пустым.';
            frm.invalidField ='StatusInfoChangeStatus';
            frm.isValid = false;
            return;
        }
        else
        {
            frm.message = 'Для изменения статуса предзаказа заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    };
    return frm;
}


function funcError(XMLHttpRequest, textStatus, errorThrown)
{
    $("#content").html("Status: " + textStatus + ", " + "Error: " + errorThrown);
}

