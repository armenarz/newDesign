//startup code
$(function()
{
    //console.log("startup code");

    var reportObj = {};
    reportObj.menuId = 0;

    //console.log(reportObj);

    setReagentExpensesMWData();
    setReagentRemaindersMWData();
    setDoctorsMWData();
    setDebtsMWData();
    setRepaidDebtsMWData();
    setDailyMWData();
    setOrdersByLabsMWData();
    setOrdersByUsersMWData();
    updateContent(reportObj);

    //correcting content area height
    $("#content").height($(window).height()-242);//237
    $(window).resize(function() 
    {
        $("#content").height($(window).height()-242);//237
    });
});

var sidebarItems = ["reagentExpensesLink", "reagentRemaindersLink", "doctorsLink", "debtsLink", "repaidDebtsLink", "dailyLink", "ordersByLabsLink", "ordersByUsersLink"];

function updateContent(reportObj)
{
    var menuId = reportObj.menuId;

    //console.log($.param(reportObj));

    var loaderMsg = '';
    if(menuId == 0)
    {
        loaderMsg = '<div class="alert alert-primary d-print-none" role="alert">Выберите отчет...</div>';
        $("#content").html(loaderMsg);
        return;
    }
    else if(menuId == "reagentExpensesLink")
    {
        var reportTypeId = reportObj.reportTypeId;
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;
        var reagentIdArr = reportObj.reagentIdArr
        var doctorId = reportObj.doctorId;
        var workplaceId = reportObj.workplaceId;
        var userId = reportObj.userId;
        var salesId = reportObj.salesId;

        var urlString = "";
        if(reportTypeId == 1)
        {
            urlString = "../reports/getReagentExpensesConsolidatedReport.php";
        }
        else if(reportTypeId == 2)
        {
            urlString = "../reports/getReagentExpensesDetailedReport.php";
        }
    }
    else if(menuId == "reagentRemaindersLink")
    {
        var reportDate = reportObj.reportDate;
        var methodId = reportObj.methodId;
        var producerId = reportObj.producerId;
        var reportTypeId = reportObj.reportTypeId;
        var expirationDateId = reportObj.expirationDateId;
        var catalogueNumber = reportObj.catalogueNumber;

        var urlString = "";
        if(reportTypeId == 1)
        {
            urlString = "../reports/getReagentRemaindersConsolidatedReport.php";
        }
        else if(reportTypeId == 2)
        {
            urlString = "../reports/getReagentRemaindersDetailedReport.php";
        }
    }
    else if(menuId == "doctorsLink")
    {
        var reportTypeId = reportObj.reportTypeId;
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;
        var doctorId = reportObj.doctorId;
        var reagentId = reportObj.reagentId;
        var workplaceId = reportObj.workplaceId;
        var userId = reportObj.userId;
        var salesId = reportObj.salesId;

        var urlString = "";
        if(reportTypeId == 1)
        {
            urlString = "../reports/getDoctorsConsolidatedReport.php";
        }
        else if(reportTypeId == 2)
        {
            urlString = "../reports/getDoctorsDetailedReport.php";
        }
    }
    else if(menuId == "debtsLink")
    {
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;

        var urlString = "../reports/getDebtsReport.php";
    }
    else if(menuId == "repaidDebtsLink")
    {
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;

        var urlString = "../reports/getRepaidDebtsReport.php";
    }
    else if(menuId == "dailyLink")
    {
        var reportDate = reportObj.reportDate;

        var urlString = "../reports/getDailyReport.php";
    }
    else if(menuId == "ordersByLabsLink")
    {
        var reportTypeId = reportObj.reportTypeId;
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;

        var urlString = "";
        if(reportTypeId == 1)
        {
            urlString = "../reports/getOrdersByLabsConsolidatedReport.php";
        }
        else if(reportTypeId == 2)
        {
            urlString = "../reports/getOrdersByLabsDetailedReport.php";
        }
    }
    else if(menuId == "ordersByUsersLink")
    {
        var reportTypeId = reportObj.reportTypeId;
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;

        var urlString = "";
        if(reportTypeId == 1)
        {
            urlString = "../reports/getOrdersByUsersConsolidatedReport.php";
        }
        else if(reportTypeId == 2)
        {
            urlString = "../reports/getOrdersByUsersDetailedReport.php";
        }
    }

    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = $("form[name='tempData']").serialize().concat("&").concat($.param(reportObj))
    });
    
    //console.log(dataString);

    var loaderMsg = '';
    loaderMsg  = '<div class="alert alert-primary d-print-none" role="alert">';
    loaderMsg += 	'Данные загружаются...';
    loaderMsg += '</div>';
    
    $("#content").html(loaderMsg);

    $.ajax({
        success:function(msg){
            $("#content").html(msg);
            if((menuId == "reagentExpensesLink" || menuId == "doctorsLink") && reportTypeId == 2 || menuId == "debtsLink" || menuId == "repaidDebtsLink")
            {
                $("a[id^='o_']").on("click",this,function()
                {
                    var anchorId = this.id;
                    var arrayId = anchorId.split("_");
                    var orderId = arrayId[1];
                    openOrder(orderId);
                    //console.log(orderId);
                });
            }
            if(menuId == "dailyLink")
            {
                $("select[name*='selectOrderRepaidDebts']").change(function(){
                    //console.log("selectOrderRepaidDebts");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderRefunds']").change(function(){
                    //console.log("selectOrderRefunds");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderDebts']").change(function(){
                    //console.log("selectOrderDebts");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderCashPayments']").change(function(){
                    //console.log("selectOrderCashPayments");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderPayments']").change(function(){
                    //console.log("selectOrderPayments");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderTerminal']").change(function(){
                    //console.log("selectOrderTerminal");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderSales']").change(function(){
                    //console.log("selectOrderSales");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderInstruments']").change(function(){
                    //console.log("selectOrderInstruments");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderHomeVisits']").change(function(){
                    //console.log("selectOrderHomeVisits");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderUrgentCalls']").change(function(){
                    //console.log("selectOrderUrgentCalls");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderCashHandovers']").change(function(){
                    //console.log("selectOrderCashHandovers");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderChecks']").change(function(){
                    //console.log("selectOrderChecks");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderCheckRefunds']").change(function(){
                    //console.log("selectOrderCheckRefunds");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Maple_ Leafs']").change(function(){
                    //console.log("selectOrderLab_Maple_ Leafs");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Garant_Assinstance']").change(function(){
                    //console.log("selectOrderLab_Garant_Assinstance");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Gyumri']").change(function(){
                    //console.log("selectOrderLab_Gyumri");
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Jermuk']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_On-Clinic']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Maletti']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Profimed']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Nairi']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Ingo0']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_MIM']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Manasyan']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Davinci']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_ARMMED']").change(function (){
                    openSelectedOrder(this);
                });
                $("select[name*='selectOrderLab_Tonoyan']").change(function (){
                    openSelectedOrder(this);
                });
            }
        }
    });
    
}

function exportToExcel(reportObj)
{
    //console.log("exprotToExcel");
    var form = document.tempData;
    var menuId = reportObj.menuId;

    var loaderMsg = '';
    if(menuId == 0)
    {
        loaderMsg = '<div class="alert alert-primary d-print-none" role="alert">Выберите отчет...</div>';
        $("#content").html(loaderMsg);
        return;
    }
    else if(menuId == "reagentExpensesLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        var reagentIdArr = reportObj.reagentIdArr
        appendHiddenElement(form, "reagentIdArr",JSON.stringify(reagentIdArr));

        var doctorId = reportObj.doctorId;
        appendHiddenElement(form, "doctorId", doctorId);

        var workplaceId = reportObj.workplaceId;
        appendHiddenElement(form, "workplaceId", workplaceId);

        var userId = reportObj.userId;
        appendHiddenElement(form, "userId", userId);

        var salesId = reportObj.salesId;
        appendHiddenElement(form, "salesId", salesId);

        //var urlString = "";
        if(reportTypeId == 1)
        {
            //urlString = "../reports/exportReagentExpensesConsolidated.php";
            document.tempData.action = "../reports/exportReagentExpensesConsolidated.php";
        }
        else if(reportTypeId == 2)
        {
            //urlString = "../reports/exportReagentExpensesDetailed.php";
            document.tempData.action = "../reports/exportReagentExpensesDetailed.php";
        }
        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "reportTypeId");
        removeHiddenElement(form, "startDate");
        removeHiddenElement(form, "endDate");
        removeHiddenElement(form, "reagentIdArr");
        removeHiddenElement(form, "doctorId");
        removeHiddenElement(form, "workplaceId");
        removeHiddenElement(form, "userId");
        removeHiddenElement(form, "salesId");
    }
    else if(menuId == "reagentRemaindersLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportDate = reportObj.reportDate;
        appendHiddenElement(form, "reportDate", reportDate);

        var methodId = reportObj.methodId;
        appendHiddenElement(form, "methodId", methodId);

        var producerId = reportObj.producerId;
        appendHiddenElement(form, "producerId", producerId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var expirationDateId = reportObj.expirationDateId;
        appendHiddenElement(form, "expirationDateId", expirationDateId);

        var catalogueNumber = reportObj.catalogueNumber;
        appendHiddenElement(form, "catalogueNumber", catalogueNumber);

        //var urlString = "";
        if(reportTypeId == 1)
        {
            //urlString = "../reports/exportReagentRemaindersConsolidated.php";
            document.tempData.action = "../reports/exportReagentRemaindersConsolidated.php";
        }
        else if(reportTypeId == 2)
        {
            //urlString = "../reports/exportReagentRemaindersDetailed.php";
            document.tempData.action = "../reports/exportReagentRemaindersDetailed.php";
        }
        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "reportDate");
        removeHiddenElement(form, "methodId");
        removeHiddenElement(form, "producerId");
        removeHiddenElement(form, "reportTypeId");
        removeHiddenElement(form, "expirationDateId");
        removeHiddenElement(form, "catalogueNumber");
    }
    else if(menuId == "doctorsLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        var doctorId = reportObj.doctorId;
        appendHiddenElement(form, "doctorId", doctorId);

        var reagentId = reportObj.reagentId;
        appendHiddenElement(form, "reagentId", reagentId);

        var workplaceId = reportObj.workplaceId;
        appendHiddenElement(form, "workplaceId", workplaceId);

        var userId = reportObj.userId;
        appendHiddenElement(form, "userId", userId);

        var salesId = reportObj.salesId;
        appendHiddenElement(form, "salesId", salesId);

        //var urlString = "";
        if(reportTypeId == 1)
        {
            //urlString = "../reports/exportDoctorsConsolidated.php";
            document.tempData.action = "../reports/exportDoctorsConsolidated.php";
        }
        else if(reportTypeId == 2)
        {
            //urlString = "../reports/exportDoctorsDetailed.php";
            document.tempData.action = "../reports/exportDoctorsDetailed.php";
        }
        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "reportTypeId");
        removeHiddenElement(form, "startDate");
        removeHiddenElement(form, "endDate");
        removeHiddenElement(form, "doctorId");
        removeHiddenElement(form, "reagentId");
        removeHiddenElement(form, "workplaceId");
        removeHiddenElement(form, "userId");
        removeHiddenElement(form, "salesId");
    }
    else if(menuId == "debtsLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        //var urlString = "../reports/exportDebts.php";
        document.tempData.action = "../reports/exportDebts.php";

        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "startDate");
        removeHiddenElement(form, "endDate");
    }
    else if(menuId == "repaidDebtsLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        //var urlString = "../reports/exportRepaidDebts.php";
        document.tempData.action = "../reports/exportRepaidDebts.php";

        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "startDate");
        removeHiddenElement(form, "endDate");
    }
    else if(menuId == "dailyLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportDate = reportObj.reportDate;
        appendHiddenElement(form, "reportDate", reportDate);

        //var urlString = "../reports/exportDaily.php";
        document.tempData.action = "../reports/exportDaily.php";

        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "reportDate");
    }
    else if(menuId == "ordersByLabsLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        var labId = reportObj.labId
        appendHiddenElement(form, "labId", labId);

        //var urlString = "";
        if(reportTypeId == 1)
        {
            //urlString = "../reports/exportOrdersByLabsConsolidated.php";
            document.tempData.action = "../reports/exportOrdersByLabsConsolidated.php";
        }
        else if(reportTypeId == 2)
        {
            //urlString = "../reports/exportOrdersByLabsDetailed.php";
            document.tempData.action = "../reports/exportOrdersByLabsDetailed.php";
        }
        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "reportTypeId");
        removeHiddenElement(form, "startDate");
        removeHiddenElement(form, "endDate");
        removeHiddenElement(form, "labId");
    }
    else if(menuId == "ordersByUsersLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);
        
        var userId = reportObj.userId;
        appendHiddenElement(form, "userId", userId);

        //var urlString = "";
        if(reportTypeId == 1)
        {
            //urlString = "../reports/exportOrdersByUsersConsolidated.php";
            document.tempData.action = "../reports/exportOrdersByUsersConsolidated.php";
        }
        else if(reportTypeId == 2)
        {
            //urlString = "../reports/exportOrdersByUsersDetailed.php";
            document.tempData.action = "../reports/exportOrdersByUsersDetailed.php";
        }
        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        removeHiddenElement(form, "menuId");
        removeHiddenElement(form, "reportTypeId");
        removeHiddenElement(form, "startDate");
        removeHiddenElement(form, "endDate");
        removeHiddenElement(form, "userId");
    }
}

function appendHiddenElement(form, elementName, elementValue)
{
    if(form.nodeName == "FORM") 
    {
        var input = document.createElement('input');
        input.setAttribute('name', elementName);
        input.setAttribute('value', elementValue);
        input.setAttribute('type','hidden');
        form.appendChild(input);
    }
}

function removeHiddenElement(form, elementName)
{
    if(form.nodeName == "FORM")
    {
        var childNodes = form.childNodes;
        var length = childNodes.length;
        var i;
        for(i = 0; i < length; i++)
        {
            if(childNodes[i].nodeName == "INPUT")
            {
                //console.log(childNodes[i].getAttribute("name"));
                if(childNodes[i].getAttribute("name") == elementName)
                {
                    //console.log("elementName = " + elementName);
                    var r = form.removeChild(childNodes[i]);
                    length--;
                    i--;
                }
            }
        }
    }
}

function openSelectedOrder(obj)
{
    //console.log("selectOrderLab_Jermuk");
    document.tempData.num.value = obj.value;
    var user_id = document.tempData.user_id.value;
    if(user_id == 1 || user_id == 12)
    {
        document.tempData.action='../../../orders_frm.php';
    }
    document.tempData.submit();
}


function openOrder(orderId)
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getPHPFilePath.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: function(result){
            phpFilePath = result;
            $("input[name=num]").val(orderId);
            //console.log($("input[name=num]").val());
            document.tempData.action='../../' + phpFilePath;
            document.tempData.submit();
        },
        error: funcError
    });
    ///process
    $.ajax();
}

function setReagentExpensesMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getReagentExpensesMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetReagentExpensesMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetReagentExpensesMWData(result)
{
    $("#contentReagentExpensesModal").html(result);
    setSearchDoctorData();
    
    $("#DoctorIdReagentExpenses").focus(function() 
    {
        $(this).select();
        //console.log("focus");
    });
    $("#DoctorIdReagentExpenses").prop("disabled",false);

    $("#SelectReagentGroupReagentExpenses").click(function(){
        var dataGroupSelected = JSON.parse($(this).attr("data-group-selected"));
        
        $(this).attr("data-group-selected",!dataGroupSelected);
        dataGroupSelected = JSON.parse($(this).attr("data-group-selected"));

        if(dataGroupSelected)
        {//true
            $(this).html("Очистить");

            //deselecting selected values
            var selectedReagents = $("#ReagentIdReagentExpenses").val();
            $.each(selectedReagents, function(i,e){
                $("#ReagentIdReagentExpenses option[value='" + e + "']").prop("selected", false);
            });
            //selecting reagent group
            var reagentGroup = [363,378,379,380,381,382];
            $.each(reagentGroup, function(i,e){
                $("#ReagentIdReagentExpenses option[value='" + e + "']").prop("selected", true);
            //console.log("e="+e);
            });
        }
        else
        {//false
            $(this).html("Выбрать");
            
            //deselecting selected values
            var selectedReagents = $("#ReagentIdReagentExpenses").val();
            $.each(selectedReagents, function(i,e){
                $("#ReagentIdReagentExpenses option[value='" + e + "']").prop("selected", false);
            });
        }
    });
}

function setSearchDoctorData() 
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
        url: "../doctors/getSearchDoctorData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: function(result)
        {
            var searchDoctorObject = JSON.parse(result);
            var dataArray = $.makeArray(searchDoctorObject);
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

    $("#DoctorIdReagentExpenses, #DoctorIdDoctors").catcomplete({
        delay: 0,
        source: data
    });
}

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

    $("#ReagentIdDoctors").catcomplete({
        delay: 0,
        source: data
    });
}

function setReagentRemaindersMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getReagentRemaindersMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetReagentRemaindersMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetReagentRemaindersMWData(result)
{
    $("#contentReagentRemaindersModal").html(result);
}

function setDoctorsMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getDoctorsMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDoctorsMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetDoctorsMWData(result)
{
    $("#contentDoctorsModal").html(result);
    setSearchDoctorData();
    $("#DoctorIdDoctors").focus(function() 
    {
        $(this).select();
        //console.log("focus");
    });
    $("#DoctorIdDoctors").prop("disabled",false);

    setSearchReagentData();
    $("#ReagentIdDoctors").focus(function() 
    {
        $(this).select();
        //console.log("focus");
    });
    $("#ReagentIdDoctors").prop("disabled",false);
}

function setDebtsMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getDebtsMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDebtsMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetDebtsMWData(result)
{
    //console.log(result);
    $("#contentDebtsModal").html(result);
}

function setRepaidDebtsMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getRepaidDebtsMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetRepaidDebtsMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetRepaidDebtsMWData(result)
{
    //console.log(result);
    $("#contentRepaidDebtsModal").html(result);
}

function setDailyMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getDailyMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDailyMWData,
        error: funcError
    });
    ///process
    $.ajax();    
}

function funcSuccessSetDailyMWData(result)
{
    //console.log(result);
    $("#contentDailyModal").html(result);
}

function setOrdersByLabsMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getOrdersByLabsMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetOrdersByLabsMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetOrdersByLabsMWData(result)
{
    //console.log(result);
    $("#contentOrdersByLabsModal").html(result);
}

function setOrdersByUsersMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getOrdersByUsersMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetOrdersByUsersMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetOrdersByUsersMWData(result)
{
    //console.log(result);
    $("#contentOrdersByUsersModal").html(result);
}

function funcError(XMLHttpRequest, textStatus, errorThrown)
{
    $("#content").html("Status: " + textStatus + ", " + "Error: " + errorThrown);
}

// reagentExpensesModalWindow button OK handler
$('#reagentExpensesModalWindow').on('click','#buttonOKReagentExpenses', function(){
    //console.log("buttonOKReagentExpenses");
    var frmReagentExpenses = CreateFormReagentExpensesObject();
    frmReagentExpenses.getFormData();

    frmReagentExpenses.validate();
    if(!frmReagentExpenses.isValid)
    {
        $('#messageReagentExpensesModal').html(frmReagentExpenses.message);
        $('#' + frmReagentExpenses.invalidField).focus();
        return;
    }
    else
    {
        $('#messageReagentExpensesModal').html(frmReagentExpenses.message);

        var reportObj = {};
        reportObj.reportTypeId = $('#ReportTypeIdReagentExpenses').val();
        reportObj.startDate = $('#StartDateReagentExpenses').val();
        reportObj.endDate = $('#EndDateReagentExpenses').val();
        reportObj.reagentIdArr = $('#ReagentIdReagentExpenses').val();
        var tempDoctorId = $('#DoctorIdReagentExpenses').val();
        if(tempDoctorId.length == 0 || tempDoctorId == null)
        {
            tempDoctorId = 0;
        }
        else
        {
            tempDoctorId = parseInt(tempDoctorId);
        }
        reportObj.doctorId = tempDoctorId;
        reportObj.workplaceId = $('#WorkplaceIdReagentExpenses').val();
        reportObj.userId = $('#UserIdReagentExpenses').val();
        reportObj.salesId = $('#SalesIdReagentExpenses').val();
        reportObj.menuId = "reagentExpensesLink";
        setActiveItem(sidebarItems,"reagentExpensesLink");
        updateContent(reportObj);
        $('#reagentExpensesModalWindow').modal('hide');
    }
});

// reagentExpensesModalWindow button ReagentExpensesToExcel handler
$('#reagentExpensesModalWindow').on('click','#buttonReagentExpensesToExcel', function(){
    //console.log("ReagentExpensesToExcel");
    var frmReagentExpenses = CreateFormReagentExpensesObject();
    frmReagentExpenses.getFormData();

    frmReagentExpenses.validate();
    if(!frmReagentExpenses.isValid)
    {
        $('#messageReagentExpensesModal').html(frmReagentExpenses.message);
        $('#' + frmReagentExpenses.invalidField).focus();
        return;
    }
    else
    {
        $('#messageReagentExpensesModal').html(frmReagentExpenses.message);

        var reportObj = {};
        reportObj.reportTypeId = $('#ReportTypeIdReagentExpenses').val();
        reportObj.startDate = $('#StartDateReagentExpenses').val();
        reportObj.endDate = $('#EndDateReagentExpenses').val();
        reportObj.reagentIdArr = $('#ReagentIdReagentExpenses').val();
        var tempDoctorId = $('#DoctorIdReagentExpenses').val();
        if(tempDoctorId.length == 0 || tempDoctorId == null)
        {
            tempDoctorId = 0;
        }
        else
        {
            tempDoctorId = parseInt(tempDoctorId);
        }
        reportObj.doctorId = tempDoctorId;
        reportObj.workplaceId = $('#WorkplaceIdReagentExpenses').val();
        reportObj.userId = $('#UserIdReagentExpenses').val();
        reportObj.salesId = $('#SalesIdReagentExpenses').val();
        reportObj.menuId = "reagentExpensesLink";
        setActiveItem(sidebarItems,"reagentExpensesLink");
        exportToExcel(reportObj);
        $('#reagentExpensesModalWindow').modal('hide');
    }
});

/// FormReagentExpenses Object
function CreateFormReagentExpensesObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateReagentExpenses = $('#StartDateReagentExpenses').val();
        frm.EndDateReagentExpenses = $('#EndDateReagentExpenses').val();
        frm.ReagentIdReagentExpenses = $('#ReagentIdReagentExpenses').val();
        frm.DoctorIdReagentExpenses = $('#DoctorIdReagentExpenses').val();
        frm.WorkplaceIdReagentExpenses = $('#WorkplaceIdReagentExpenses').val();
        frm.UserIdReagentExpenses = $('#UserIdReagentExpenses').val();
        frm.SalesIdReagentExpenses = $('#SalesIdReagentExpenses').val();
        frm.ReportTypeIdReagentExpenses = $('#ReportTypeIdReagentExpenses').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //StartDateReagentExpenses
        if(frm.StartDateReagentExpenses == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateReagentExpenses';
            frm.isValid = false;
            return;       
        }
        //EndDateReagentExpenses
        else if(frm.EndDateReagentExpenses == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateReagentExpenses';
            frm.isValid = false;
            return;       
        }
        //ReportTypeIdReagentExpenses
        else if(frm.ReportTypeIdReagentExpenses == 0)
        {
            frm.message = 'Выберите тип отчета.';
            frm.invalidField ='ReportTypeIdReagentExpenses';
            frm.isValid = false;
            return;            
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    };
    
    return frm;
}

// reagentRemaindersModalWindow button OK handler
$('#reagentRemaindersModalWindow').on('click','#buttonOKReagentRemainders', function(){
    //console.log("buttonOKReagentRemainders");
    
    var frmReagentRemainders = CreateFormReagentRemaindersObject();
    frmReagentRemainders.getFormData();

    frmReagentRemainders.validate();
    if(!frmReagentRemainders.isValid)
    {
        $('#messageReagentRemaindersModal').html(frmReagentRemainders.message);
        $('#' + frmReagentRemainders.invalidField).focus();
        return;
    }
    else
    {
        $('#messageReagentRemaindersModal').html(frmReagentRemainders.message);

        var reportObj = {};
        reportObj.reportDate = $('#ReportDateReagentRemainders').val();
        reportObj.methodId = $('#MethodIdReagentRemainders').val();
        reportObj.producerId = $('#ProducerIdReagentRemainders').val();
        reportObj.reportTypeId = $('#ReportTypeIdReagentRemainders').val();
        reportObj.expirationDateId = $('#ExpirationDateIdReagentRemainders').val();
        reportObj.catalogueNumber = $('#CatalogueNumberReagentRemainders').val();
        
        var tempCatalogueNumber = $('#CatalogueNumberReagentRemainders').val();
        if(tempCatalogueNumber == "" || tempCatalogueNumber == null)
        {
            reportObj.catalogueNumber = 0;
        }
        else
        {
            reportObj.catalogueNumber = tempCatalogueNumber;
        }
        reportObj.menuId = "reagentRemaindersLink";
        setActiveItem(sidebarItems,"reagentRemaindersLink");
        updateContent(reportObj);
        $('#reagentRemaindersModalWindow').modal('hide');
    }
});

// reagentRemaindersModalWindow button buttonReagentRemaindersToExcel handler
$('#reagentRemaindersModalWindow').on('click','#buttonReagentRemaindersToExcel', function(){
    //console.log("buttonReagentRemaindersToExcel");
    
    var frmReagentRemainders = CreateFormReagentRemaindersObject();
    frmReagentRemainders.getFormData();

    frmReagentRemainders.validate();
    if(!frmReagentRemainders.isValid)
    {
        $('#messageReagentRemaindersModal').html(frmReagentRemainders.message);
        $('#' + frmReagentRemainders.invalidField).focus();
        return;
    }
    else
    {
        $('#messageReagentRemaindersModal').html(frmReagentRemainders.message);

        var reportObj = {};
        reportObj.reportDate = $('#ReportDateReagentRemainders').val();
        reportObj.methodId = $('#MethodIdReagentRemainders').val();
        reportObj.producerId = $('#ProducerIdReagentRemainders').val();
        reportObj.reportTypeId = $('#ReportTypeIdReagentRemainders').val();
        reportObj.expirationDateId = $('#ExpirationDateIdReagentRemainders').val();
        reportObj.catalogueNumber = $('#CatalogueNumberReagentRemainders').val();
        
        var tempCatalogueNumber = $('#CatalogueNumberReagentRemainders').val();
        if(tempCatalogueNumber == "" || tempCatalogueNumber == null)
        {
            reportObj.catalogueNumber = 0;
        }
        else
        {
            reportObj.catalogueNumber = tempCatalogueNumber;
        }
        reportObj.menuId = "reagentRemaindersLink";
        setActiveItem(sidebarItems,"reagentRemaindersLink");
        exportToExcel(reportObj);
        $('#reagentRemaindersModalWindow').modal('hide');
    }
});

/// FormReagentRemainders Object
function CreateFormReagentRemaindersObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.ReportDateReagentRemainders = $('#ReportDateReagentRemainders').val();
        frm.ProducerIdReagentRemainders = $('#ProducerIdReagentRemainders').val();
        frm.ExpirationDateIdReagentRemainders = $('#ExpirationDateIdReagentRemainders').val();
        frm.ReportTypeIdReagentRemainders = $('#ReportTypeIdReagentRemainders').val();
        frm.CatalogueNumberReagentRemainders = $('#CatalogueNumberReagentRemainders').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //ReportDateReagentRemainders
        if(frm.ReportDateReagentRemainders == 0)
        {
            frm.message = 'Выберите дату отчета.';
            frm.invalidField ='ReportDateReagentRemainders';
            frm.isValid = false;
            return;       
        }
        //CatalogueNumberReagentRemainders
        else if(frm.CatalogueNumberReagentRemainders < 0)
        {
            frm.message = 'Введите положительное число.';
            frm.invalidField ='CatalogueNumberReagentRemainders';
            frm.isValid = false;
            return;
        }
        //ReportTypeIdReagentRemainders
        else if(frm.ReportTypeIdReagentRemainders == 0)
        {
            frm.message = 'Выберите тип отчета.';
            frm.invalidField ='ReportTypeIdReagentRemainders';
            frm.isValid = false;
            return;            
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    };
    
    return frm;
}

// doctorsModalWindow button OK handler
$('#doctorsModalWindow').on('click','#buttonOKDoctors', function(){
    //console.log("buttonOKDoctors");
    
    var frmDoctors = CreateFormDoctorsObject();
    frmDoctors.getFormData();

    frmDoctors.validate();
    if(!frmDoctors.isValid)
    {
        $('#messageDoctorsModal').html(frmDoctors.message);
        $('#' + frmDoctors.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDoctorsModal').html(frmDoctors.message);

        var reportObj = {};
        reportObj.reportTypeId = $('#ReportTypeIdDoctors').val();
        reportObj.startDate = $('#StartDateDoctors').val();
        reportObj.endDate = $('#EndDateDoctors').val();

        var tempDoctorId = $('#DoctorIdDoctors').val();
        if(tempDoctorId.length == 0 || tempDoctorId == null)
        {
            tempDoctorId = 0;
        }
        else
        {
            tempDoctorId = parseInt(tempDoctorId);
        }
        reportObj.doctorId = tempDoctorId;

        var tempReagentId = $('#ReagentIdDoctors').val();
        if(tempReagentId.length == 0 || tempReagentId == null)
        {
            tempReagentId = 0;
        }
        else
        {
            tempReagentId = parseInt(tempReagentId);
        }
        reportObj.reagentId = tempReagentId;
        reportObj.workplaceId = $('#WorkplaceIdDoctors').val();
        reportObj.userId = $('#UserIdDoctors').val();
        reportObj.salesId = $('#SalesIdDoctors').val();
        reportObj.menuId = "doctorsLink";
        setActiveItem(sidebarItems,"doctorsLink");
        updateContent(reportObj);
        $('#doctorsModalWindow').modal('hide');
    }
});

// doctorsModalWindow button buttonDoctorsToExcel handler
$('#doctorsModalWindow').on('click','#buttonDoctorsToExcel', function(){
    console.log("buttonDoctorsToExcel");
    
    var frmDoctors = CreateFormDoctorsObject();
    frmDoctors.getFormData();

    frmDoctors.validate();
    if(!frmDoctors.isValid)
    {
        $('#messageDoctorsModal').html(frmDoctors.message);
        $('#' + frmDoctors.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDoctorsModal').html(frmDoctors.message);

        var reportObj = {};
        reportObj.reportTypeId = $('#ReportTypeIdDoctors').val();
        reportObj.startDate = $('#StartDateDoctors').val();
        reportObj.endDate = $('#EndDateDoctors').val();

        var tempDoctorId = $('#DoctorIdDoctors').val();
        if(tempDoctorId.length == 0 || tempDoctorId == null)
        {
            tempDoctorId = 0;
        }
        else
        {
            tempDoctorId = parseInt(tempDoctorId);
        }
        reportObj.doctorId = tempDoctorId;

        var tempReagentId = $('#ReagentIdDoctors').val();
        if(tempReagentId.length == 0 || tempReagentId == null)
        {
            tempReagentId = 0;
        }
        else
        {
            tempReagentId = parseInt(tempReagentId);
        }
        reportObj.reagentId = tempReagentId;
        reportObj.workplaceId = $('#WorkplaceIdDoctors').val();
        reportObj.userId = $('#UserIdDoctors').val();
        reportObj.salesId = $('#SalesIdDoctors').val();
        reportObj.menuId = "doctorsLink";
        setActiveItem(sidebarItems,"doctorsLink");
        exportToExcel(reportObj);
        $('#doctorsModalWindow').modal('hide');
    }
});

/// FormDoctors Object
function CreateFormDoctorsObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateDoctors = $('#StartDateDoctors').val();
        frm.EndDateDoctors = $('#EndDateDoctors').val();
        frm.ReagentIdDoctors = $('#ReagentIdDoctors').val();
        frm.DoctorIdDoctors = $('#DoctorIdDoctors').val();
        frm.WorkplaceIdDoctors = $('#WorkplaceIdDoctors').val();
        frm.UserIdDoctors = $('#UserIdDoctors').val();
        frm.SalesIdDoctors = $('#SalesIdDoctors').val();
        frm.ReportTypeIdDoctors = $('#ReportTypeIdDoctors').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //StartDateDoctors
        if(frm.StartDateDoctors == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateDoctors';
            frm.isValid = false;
            return;       
        }
        //EndDateDoctors
        else if(frm.EndDateDoctors == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateDoctors';
            frm.isValid = false;
            return;       
        }
        //ReportTypeIdDoctors
        else if(frm.ReportTypeIdDoctors == 0)
        {
            frm.message = 'Выберите тип отчета.';
            frm.invalidField ='ReportTypeIdDoctors';
            frm.isValid = false;
            return;            
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    };
    
    return frm;
}

// debtsModalWindow button OK handler
$('#debtsModalWindow').on('click','#buttonOKDebts', function(){
    //console.log("buttonOKDebts");
    
    var frmDebts = CreateFormDebtsObject();
    frmDebts.getFormData();

    frmDebts.validate();
    if(!frmDebts.isValid)
    {
        $('#messageDebtsModal').html(frmDebts.message);
        $('#' + frmDebts.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDebtsModal').html(frmDebts.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateDebts').val();
        reportObj.endDate = $('#EndDateDebts').val();
        reportObj.menuId = "debtsLink";
        setActiveItem(sidebarItems,"debtsLink");
        updateContent(reportObj);
        $('#debtsModalWindow').modal('hide');
    }
});

// debtsModalWindow button buttonDebtsToExcel handler
$('#debtsModalWindow').on('click','#buttonDebtsToExcel', function(){
    //console.log("buttonDebtsToExcel");
    
    var frmDebts = CreateFormDebtsObject();
    frmDebts.getFormData();

    frmDebts.validate();
    if(!frmDebts.isValid)
    {
        $('#messageDebtsModal').html(frmDebts.message);
        $('#' + frmDebts.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDebtsModal').html(frmDebts.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateDebts').val();
        reportObj.endDate = $('#EndDateDebts').val();
        reportObj.menuId = "debtsLink";
        setActiveItem(sidebarItems,"debtsLink");
        exportToExcel(reportObj);
        $('#debtsModalWindow').modal('hide');
    }
});

/// FormDebts Object
function CreateFormDebtsObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateDebts = $('#StartDateDebts').val();
        frm.EndDateDebts = $('#EndDateDebts').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //StartDateDebts
        if(frm.StartDateDebts == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateDebts';
            frm.isValid = false;
            return;       
        }
        //EndDateDebts
        else if(frm.EndDateDebts == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateDebts';
            frm.isValid = false;
            return;       
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    }
    
    return frm;
}

// repaidDebtsModalWindow button OK handler 
$('#repaidDebtsModalWindow').on('click','#buttonOKRepaidDebts', function(){
    //console.log("buttonOKRepaidDebts");
    
    var frmRepaidDebts = CreateFormRepaidDebtsObject();
    frmRepaidDebts.getFormData();

    frmRepaidDebts.validate();
    if(!frmRepaidDebts.isValid)
    {
        $('#messageRepaidDebtsModal').html(frmRepaidDebts.message);
        $('#' + frmRepaidDebts.invalidField).focus();
        return;
    }
    else
    {
        $('#messageRepaidDebtsModal').html(frmRepaidDebts.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateRepaidDebts').val();
        reportObj.endDate = $('#EndDateRepaidDebts').val();
        reportObj.menuId = "repaidDebtsLink";
        setActiveItem(sidebarItems,"repaidDebtsLink");
        updateContent(reportObj);
        $('#repaidDebtsModalWindow').modal('hide');
    }
});

// repaidDebtsModalWindow button buttonRepaidDebtsToExcel handler 
$('#repaidDebtsModalWindow').on('click','#buttonRepaidDebtsToExcel', function(){
    //console.log("buttonRepaidDebtsToExcel");
    
    var frmRepaidDebts = CreateFormRepaidDebtsObject();
    frmRepaidDebts.getFormData();

    frmRepaidDebts.validate();
    if(!frmRepaidDebts.isValid)
    {
        $('#messageRepaidDebtsModal').html(frmRepaidDebts.message);
        $('#' + frmRepaidDebts.invalidField).focus();
        return;
    }
    else
    {
        $('#messageRepaidDebtsModal').html(frmRepaidDebts.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateRepaidDebts').val();
        reportObj.endDate = $('#EndDateRepaidDebts').val();
        reportObj.menuId = "repaidDebtsLink";
        setActiveItem(sidebarItems,"repaidDebtsLink");
        exportToExcel(reportObj);
        $('#repaidDebtsModalWindow').modal('hide');
    }
});

/// FormRepaidDebts Object
function CreateFormRepaidDebtsObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateRepaidDebts = $('#StartDateRepaidDebts').val();
        frm.EndDateRepaidDebts = $('#EndDateRepaidDebts').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //StartDateRepaidDebts
        if(frm.StartDateRepaidDebts == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateRepaidDebts';
            frm.isValid = false;
            return;       
        }
        //EndDateRepaidDebts
        else if(frm.EndDateRepaidDebts == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateRepaidDebts';
            frm.isValid = false;
            return;       
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    }
    
    return frm;
}

// dailyModalWindow button OK handler 
$('#dailyModalWindow').on('click','#buttonOKDaily', function(){
    //console.log("buttonOKDaily");
    
    var frmDaily = CreateFormDailyObject();
    frmDaily.getFormData();

    frmDaily.validate();
    if(!frmDaily.isValid)
    {
        $('#messageDailyModal').html(frmDaily.message);
        $('#' + frmDaily.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDailyModal').html(frmDaily.message);

        var reportObj = {};
        reportObj.reportDate = $('#ReportDateDaily').val();
        reportObj.menuId = "dailyLink";
        setActiveItem(sidebarItems,"dailyLink");
        updateContent(reportObj);
        $('#dailyModalWindow').modal('hide');
    }
});

// dailyModalWindow button buttonDailyToExcel handler 
$('#dailyModalWindow').on('click','#buttonDailyToExcel', function(){
    //console.log("buttonDailyToExcel");
    
    var frmDaily = CreateFormDailyObject();
    frmDaily.getFormData();

    frmDaily.validate();
    if(!frmDaily.isValid)
    {
        $('#messageDailyModal').html(frmDaily.message);
        $('#' + frmDaily.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDailyModal').html(frmDaily.message);

        var reportObj = {};
        reportObj.reportDate = $('#ReportDateDaily').val();
        reportObj.menuId = "dailyLink";
        setActiveItem(sidebarItems,"dailyLink");
        exportToExcel(reportObj);
        $('#dailyModalWindow').modal('hide');
    }
});

/// FormDaily Object
function CreateFormDailyObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.ReportDateDaily = $('#ReportDateDaily').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        //ReportDateDaily
        if(frm.ReportDateDaily == 0)
        {
            frm.message = 'Выберите дату отчета.';
            frm.invalidField ='ReportDateDaily';
            frm.isValid = false;
            return;       
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    }
    
    return frm;
}


// ordersByLabsModalWindow button OK handler 
$('#ordersByLabsModalWindow').on('click','#buttonOKOrdersByLabs', function(){
    //console.log("buttonOKOrdersByLabs");
    
    var frmOrdersByLabs = CreateFormOrdersByLabsObject();
    frmOrdersByLabs.getFormData();

    frmOrdersByLabs.validate();
    if(!frmOrdersByLabs.isValid)
    {
        $('#messageOrdersByLabsModal').html(frmOrdersByLabs.message);
        $('#' + frmOrdersByLabs.invalidField).focus();
        return;
    }
    else
    {
        $('#messageOrdersByLabsModal').html(frmOrdersByLabs.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateOrdersByLabs').val();
        reportObj.endDate = $('#EndDateOrdersByLabs').val();
        reportObj.labId = $('#LabIdOrdersByLabs').val();
        reportObj.reportTypeId = $('#ReportTypeIdOrdersByLabs').val();
        reportObj.menuId = "ordersByLabsLink";
        setActiveItem(sidebarItems,"ordersByLabsLink");
        updateContent(reportObj);
        $('#ordersByLabsModalWindow').modal('hide');
    }
});

// ordersByLabsModalWindow button buttonOrdersByLabsToExcel handler 
$('#ordersByLabsModalWindow').on('click','#buttonOrdersByLabsToExcel', function(){
    //console.log("buttonOrdersByLabsToExcel");
    
    var frmOrdersByLabs = CreateFormOrdersByLabsObject();
    frmOrdersByLabs.getFormData();

    frmOrdersByLabs.validate();
    if(!frmOrdersByLabs.isValid)
    {
        $('#messageOrdersByLabsModal').html(frmOrdersByLabs.message);
        $('#' + frmOrdersByLabs.invalidField).focus();
        return;
    }
    else
    {
        $('#messageOrdersByLabsModal').html(frmOrdersByLabs.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateOrdersByLabs').val();
        reportObj.endDate = $('#EndDateOrdersByLabs').val();
        reportObj.labId = $('#LabIdOrdersByLabs').val();
        reportObj.reportTypeId = $('#ReportTypeIdOrdersByLabs').val();
        reportObj.menuId = "ordersByLabsLink";
        setActiveItem(sidebarItems,"ordersByLabsLink");
        exportToExcel(reportObj);
        $('#ordersByLabsModalWindow').modal('hide');
    }
});

/// FormOrdersByLabs Object
function CreateFormOrdersByLabsObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateOrdersByLabs = $('#StartDateOrdersByLabs').val();
        frm.EndDateOrdersByLabs = $('#EndDateOrdersByLabs').val();
        frm.LabIdOrdersByLabs = $('#LabIdOrdersByLabs').val();
        frm.ReportTypeIdOrdersByLabs = $('#ReportTypeIdOrdersByLabs').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        //StartDateOrdersByLabs
        if(frm.StartDateOrdersByLabs == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateOrdersByLabs';
            frm.isValid = false;
            return;       
        }
        //EndDateOrdersByLabs
        else if(frm.EndDateOrdersByLabs == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateOrdersByLabs';
            frm.isValid = false;
            return;  
        }
        //ReportTypeIdOrdersByLabs
        else if(frm.ReportTypeIdOrdersByLabs == 0)
        {
            frm.message = 'Выберите тип отчета.';
            frm.invalidField ='ReportTypeIdOrdersByLabs';
            frm.isValid = false;
            return;
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    }
    
    return frm;
}

// ordersByUsersModalWindow button OK handler 
$('#ordersByUsersModalWindow').on('click','#buttonOKOrdersByUsers', function(){
    //console.log("buttonOKOrdersByUsers");
    
    var frmOrdersByUsers = CreateFormOrdersByUsersObject();
    frmOrdersByUsers.getFormData();

    frmOrdersByUsers.validate();
    if(!frmOrdersByUsers.isValid)
    {
        $('#messageOrdersByUsersModal').html(frmOrdersByUsers.message);
        $('#' + frmOrdersByUsers.invalidField).focus();
        return;
    }
    else
    {
        $('#messageOrdersByUsersModal').html(frmOrdersByUsers.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateOrdersByUsers').val();
        reportObj.endDate = $('#EndDateOrdersByUsers').val();
        reportObj.userId = $('#UserIdOrdersByUsers').val();
        reportObj.reportTypeId = $('#ReportTypeIdOrdersByUsers').val();
        reportObj.menuId = "ordersByUsersLink";
        setActiveItem(sidebarItems,"ordersByUsersLink");
        updateContent(reportObj);
        $('#ordersByUsersModalWindow').modal('hide');
    }
});

// ordersByUsersModalWindow button buttonOrdersByUsersToExcel handler 
$('#ordersByUsersModalWindow').on('click','#buttonOrdersByUsersToExcel', function(){
    //console.log("buttonOrdersByUsersToExcel");
    
    var frmOrdersByUsers = CreateFormOrdersByUsersObject();
    frmOrdersByUsers.getFormData();

    frmOrdersByUsers.validate();
    if(!frmOrdersByUsers.isValid)
    {
        $('#messageOrdersByUsersModal').html(frmOrdersByUsers.message);
        $('#' + frmOrdersByUsers.invalidField).focus();
        return;
    }
    else
    {
        $('#messageOrdersByUsersModal').html(frmOrdersByUsers.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateOrdersByUsers').val();
        reportObj.endDate = $('#EndDateOrdersByUsers').val();
        reportObj.userId = $('#UserIdOrdersByUsers').val();
        reportObj.reportTypeId = $('#ReportTypeIdOrdersByUsers').val();
        reportObj.menuId = "ordersByUsersLink";
        setActiveItem(sidebarItems,"ordersByUsersLink");
        exportToExcel(reportObj);
        $('#ordersByUsersModalWindow').modal('hide');
    }
});

/// FormOrdersByUsers Object
function CreateFormOrdersByUsersObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateOrdersByUsers = $('#StartDateOrdersByUsers').val();
        frm.EndDateOrdersByUsers = $('#EndDateOrdersByUsers').val();
        frm.UserIdOrdersByUsers = $('#UserIdOrdersByUsers').val();
        frm.ReportTypeIdOrdersByUsers = $('#ReportTypeIdOrdersByUsers').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        //StartDateOrdersByUsers
        if(frm.StartDateOrdersByUsers == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateOrdersByUsers';
            frm.isValid = false;
            return;       
        }
        //EndDateOrdersByUsers
        else if(frm.EndDateOrdersByUsers == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateOrdersByUsers';
            frm.isValid = false;
            return;  
        }
        //ReportTypeIdOrdersByUsers
        else if(frm.ReportTypeIdOrdersByUsers == 0)
        {
            frm.message = 'Выберите тип отчета.';
            frm.invalidField ='ReportTypeIdOrdersByUsers';
            frm.isValid = false;
            return;
        }
        else
        {
            frm.message = 'Заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            return;
        }
    }
    
    return frm;
}
