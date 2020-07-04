export function updateContent(reportObj)
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
    else if(menuId == "doctorSelectedLink")
    {
        var reportTypeId = reportObj.reportTypeId;
        var startDate = reportObj.startDate;
        var endDate = reportObj.endDate;

        var urlString = "";
        if(reportTypeId == 1)
        {
            urlString = "../reports/getDoctorSelectedConsolidatedReport.php";
        }
        else if(reportTypeId == 2)
        {
            urlString = "../reports/getDoctorSelectedDetailedReport.php";
        }
    }
    else if(menuId == "SARSLink")
    {
        urlString = "../reports/getSARSReport.php";
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
            if((menuId == "reagentExpensesLink" || menuId == "doctorsLink") && reportTypeId == 2 || menuId == "debtsLink" || menuId == "repaidDebtsLink" || menuId == "doctor13Link" || menuId == "doctorSelectedLink")
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
                setSelectsChangeEvents();
                
                setOptionsHtmlLab(reportDate);
                setOptionsHtmlLab1();
                setOptionsHtmlLabs();
            }
        }
    });
}

function setOptionsHtmlLab(reportDate)
{
    //console.log(reportDate);
    setOptionsHtmlRepaidDebtsLab(reportDate);
    setOptionsHtmlRefundsLab(reportDate);
    setOptionsHtmlDebtsLab(reportDate);
    setOptionsHtmlCashPaymentsLab(reportDate);
    setOptionsHtmlPaymentsLab(reportDate);
    setOptionsHtmlPartnerDebtsLab(reportDate);
    setOptionsHtmlTerminalPaymentsLab(reportDate);
    setOptionsHtmlSalesLab(reportDate);
    setOptionsHtmlInstrumentsLab(reportDate);
    setOptionsHtmlHomeVisitsLab(reportDate);
    setOptionsHtmlUrgentCallsLab(reportDate);
    setOptionsHtmlCashHandoversLab(reportDate);
    setOptionsHtmlChecksLab(reportDate);
    setOptionsHtmlCheckRefundsLab(reportDate);
}

function setOptionsHtmlRepaidDebtsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlRepaidDebtsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderRepaidDebtsLab").html(msg);
            $("#selectOrderRepaidDebtsLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlRefundsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlRefundsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderRefundsLab").html(msg);
            $("#selectOrderRefundsLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlDebtsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlDebtsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderDebtsLab").html(msg);
            $("#selectOrderDebtsLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlCashPaymentsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlCashPaymentsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderCashPaymentsLab").html(msg);
            $("#selectOrderCashPaymentsLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlPaymentsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlPaymentsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderPaymentsLab").html(msg);
            $("#selectOrderPaymentsLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlPartnerDebtsLab(reportDate)
{
    var partner = null;
        
    var urlString = "../reports/getPartner.php";

    $.ajaxSetup({
        type: "POST",
        url: urlString,
        cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val())
    });
    
    $.ajax({
        success:function(partner_result)
        {
            partner = Array.from(JSON.parse(partner_result));

            var partner_count = partner.length;

            for(var i = 0; i < partner_count; i++)
            {
                var currentPartner = partner[i];
                setOptionsHtmlCurrentPartner(currentPartner);                
            }

            function setOptionsHtmlCurrentPartner(currentPartner)
            {
                let urlString = "../reports/getOptionsHtmlPartnerDebtsLab.php";

                $.ajaxSetup({
                    type: "POST",
                    url: urlString,
                    cache: false,
                    async: true,
                    data: dataString = ("uu=" + $("input[name='uu']").val()).
                    concat("&").concat("num=" + $("input[name='num']").val()).
                    concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
                    concat("&").concat("partner=" + currentPartner).
                    concat("&").concat("reportDate=" + reportDate)
                });

                $.ajax({
                    success:function(result)
                    {
                        $('[id="selectOrderLabDebts_' + currentPartner + '"]').html(result);
                        $('[id="selectOrderLabDebts_' + currentPartner + '"]').prop("disabled", false);
                    }
                })
            }
        }
    });
    
}

function setOptionsHtmlTerminalPaymentsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlTerminalPaymentsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderTerminalLab").html(msg);
            $("#selectOrderTerminalLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlSalesLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlSalesLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
            cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderSalesLab").html(msg);
            $("#selectOrderSalesLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlInstrumentsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlInstrumentsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
        cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderInstrumensLab").html(msg);
            $("#selectOrderInstrumensLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlHomeVisitsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlHomeVisitsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
        cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderHomeVisitsLab").html(msg);
            $("#selectOrderHomeVisitsLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlUrgentCallsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlUrgentCallsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
        cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderUrgentCallsLab").html(msg);
            $("#selectOrderUrgentCallsLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlCashHandoversLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlCashHandoversLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
        cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderCashHandoversLab").html(msg);
            $("#selectOrderCashHandoversLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlChecksLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlChecksLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
        cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderChecksLab").html(msg);
            $("#selectOrderChecksLab").prop("disabled", false);
        }
    });
}

function setOptionsHtmlCheckRefundsLab(reportDate)
{
    var urlString = "../reports/getOptionsHtmlCheckRefundsLab.php";
    
    $.ajaxSetup({
        type: "POST",
        url: urlString,
        cache:false,
        data: dataString = ("uu=" + $("input[name='uu']").val()).
        concat("&").concat("num=" + $("input[name='num']").val()).
        concat("&").concat("num_pac=" + $("input[name='num_pac']").val()).
        concat("&").concat("reportDate=" + reportDate)
    });
    //console.log(dataString);
    $.ajax({
        success:function(msg){
            $("#selectOrderCheckRefunds").html(msg);
            $("#selectOrderCheckRefunds").prop("disabled", false);
        }
    });
}

function setOptionsHtmlLab1()
{

}

function setOptionsHtmlLabs()
{

}

function setSelectsChangeEvents()
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