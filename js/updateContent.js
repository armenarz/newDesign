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
    else if(menuId == "doctor13Link")
    {
        var reportTypeId = reportObj.reportTypeId;
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;


        var urlString = "";
        if(reportTypeId == 1)
        {
            urlString = "../reports/getDoctor13ConsolidatedReport.php";
        }
        else if(reportTypeId == 2)
        {
            urlString = "../reports/getDoctor13DetailedReport.php";
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

export default updateContent;