import { updateContent } from "./report_modules/update_content.js";
import { exportToExcel } from "./report_modules/export_to_excel.js";
import 
{ 
    setReagentExpensesMWData, 
/*     setSearchDoctorData,
    setSearchReagentData, */
    setReagentRemaindersMWData,
    setDoctorsMWData,
    setDebtsMWData,
    setRepaidDebtsMWData,
    setDailyMWData,
    setOrdersByLabsMWData,
    setOrdersByUsersMWData,
    setDoctor13MWData,
    setDoctorSelectedMWData,
    setSARSMWData
} from "./report_modules/set_user_interfaces_data.js";

import 
{ 
    CreateFormReagentExpensesObject,
    CreateFormReagentRemaindersObject,
    CreateFormDoctorsObject,
    CreateFormDebtsObject,
    CreateFormRepaidDebtsObject,
    CreateFormDailyObject,
    CreateFormOrdersByLabsObject,
    CreateFormOrdersByUsersObject,
    CreateFormDoctor13Object,
    CreateFormDoctorSelectedObject,
    CreateFormSARSObject 
} from "./report_modules/form_objects.js";

//startup code
$(function()
{
    //console.log("startup code");

    var reportObj = {};
    reportObj.menuId = 0;

    //console.log(reportObj);

    setSidebarItems();		
    setReagentExpensesMWData();
    setReagentRemaindersMWData();
    setDoctorsMWData();
    setDebtsMWData();
    setRepaidDebtsMWData();
    setDailyMWData();
    setOrdersByLabsMWData();
    setOrdersByUsersMWData();
    setDoctor13MWData();
    setDoctorSelectedMWData();
    setSARSMWData();
    updateContent(reportObj);

    //printing content"
    $("#printLink").click(function()
    {
        window.print();
        //$("#editLink").click();
    });

    //correcting content area height
    $("#content").height($(window).height()-242);//237
    $(window).resize(function() 
    {
        $("#content").height($(window).height()-242);//237
    });
});

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
        reportObj.labId = $('#LabIdReagentExpenses').val();
        reportObj.doubleCheck = $('#DoubleCheckReagentExpenses').is(":checked");
        reportObj.menuId = "reagentExpensesLink";
        setActiveItem(sidebarItems,"reagentExpensesLink");
        console.log("reportObj.labId=" + reportObj.labId);
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
        reportObj.labId = $('#LabIdReagentExpenses').val();
        reportObj.doubleCheck = $('#DoubleCheckReagentExpenses').is(":checked");
		reportObj.SARSCheck = $('#SARS-CoV-2CheckReagentExpenses').is(":checked");
        reportObj.menuId = "reagentExpensesLink";
        setActiveItem(sidebarItems,"reagentExpensesLink");
        exportToExcel(reportObj);
        $('#reagentExpensesModalWindow').modal('hide');
    }
});

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
        reportObj.doubleCheck = $('#DoubleCheckDoctors').is(":checked");
        reportObj.menuId = "doctorsLink";
        setActiveItem(sidebarItems,"doctorsLink");
        updateContent(reportObj);
        $('#doctorsModalWindow').modal('hide');
    }
});

// doctorsModalWindow button buttonDoctorsToExcel handler
$('#doctorsModalWindow').on('click','#buttonDoctorsToExcel', function(){
    //console.log("buttonDoctorsToExcel");
    
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
        reportObj.doubleCheck = $('#DoubleCheckDoctors').is(":checked");
        reportObj.menuId = "doctorsLink";
        setActiveItem(sidebarItems,"doctorsLink");
        exportToExcel(reportObj);
        $('#doctorsModalWindow').modal('hide');
    }
});

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

// doctor13ModalWindow button OK handler
$('#doctor13ModalWindow').on('click','#buttonOKDoctor13', function(){
    //console.log("buttonOKDoctor13");
    
    var frmDoctor13 = CreateFormDoctor13Object();
    frmDoctor13.getFormData();

    frmDoctor13.validate();
    if(!frmDoctor13.isValid)
    {
        $('#messageDoctor13Modal').html(frmDoctor13.message);
        $('#' + frmDoctor13.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDoctor13Modal').html(frmDoctor13.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateDoctor13').val();
        reportObj.endDate = $('#EndDateDoctor13').val();
        reportObj.reportTypeId = $('#ReportTypeIdDoctor13').val();
        reportObj.menuId = "doctor13Link";
        setActiveItem(sidebarItems,"doctor13Link");
        updateContent(reportObj);
        $('#doctor13ModalWindow').modal('hide');
    }
});

// doctor13ModalWindow button buttonDoctor13ToExcel handler
$('#doctor13ModalWindow').on('click','#buttonDoctor13ToExcel', function(){
    
    var frmDoctor13 = CreateFormDoctor13Object();
    frmDoctor13.getFormData();

    frmDoctor13.validate();
    if(!frmDoctor13.isValid)
    {
        $('#messageDoctor13Modal').html(frmDoctor13.message);
        $('#' + frmDoctor13.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDoctor13Modal').html(frmDoctor13.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateDoctor13').val();
        reportObj.endDate = $('#EndDateDoctor13').val();
        reportObj.reportTypeId = $('#ReportTypeIdDoctor13').val();
        reportObj.menuId = "doctor13Link";
        setActiveItem(sidebarItems,"doctor13Link");
        exportToExcel(reportObj);
        $('#doctor13ModalWindow').modal('hide');
    }
});

// doctorSelectedModalWindow button OK handler
$('#doctorSelectedModalWindow').on('click','#buttonOKDoctorSelected', function(){
    //console.log("buttonOKDoctorSelected");
    
    var frmDoctorSelected = CreateFormDoctorSelectedObject();
    frmDoctorSelected.getFormData();

    frmDoctorSelected.validate();
    if(!frmDoctorSelected.isValid)
    {
        $('#messageDoctorSelectedModal').html(frmDoctorSelected.message);
        $('#' + frmDoctorSelected.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDoctorSelectedModal').html(frmDoctorSelected.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateDoctorSelected').val();
        reportObj.endDate = $('#EndDateDoctorSelected').val();
        reportObj.reportTypeId = $('#ReportTypeIdDoctorSelected').val();
        reportObj.menuId = "doctorSelectedLink";
        setActiveItem(sidebarItems,"doctorSelectedLink");
        updateContent(reportObj);
        $('#doctorSelectedModalWindow').modal('hide');
    }
});

// doctorSelectedModalWindow button buttonDoctorSelectedToExcel handler
$('#doctorSelectedModalWindow').on('click','#buttonDoctorSelectedToExcel', function(){
    
    var frmDoctorSelected = CreateFormDoctorSelectedObject();
    frmDoctorSelected.getFormData();

    frmDoctorSelected.validate();
    if(!frmDoctorSelected.isValid)
    {
        $('#messageDoctorSelectedModal').html(frmDoctorSelected.message);
        $('#' + frmDoctorSelected.invalidField).focus();
        return;
    }
    else
    {
        $('#messageDoctorSelectedModal').html(frmDoctorSelected.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateDoctorSelected').val();
        reportObj.endDate = $('#EndDateDoctorSelected').val();
        reportObj.reportTypeId = $('#ReportTypeIdDoctorSelected').val();
        reportObj.menuId = "doctorSelectedLink";
        setActiveItem(sidebarItems,"doctorSelectedLink");
        exportToExcel(reportObj);
        $('#doctorSelectedModalWindow').modal('hide');
    }
});

// SARSModalWindow button OK handler
$('#SARSModalWindow').on('click','#buttonOKSARS', function(){
    //console.log("buttonOKSARS");
    
    var frmSARS = CreateFormSARSObject();
    frmSARS.getFormData();

    frmSARS.validate();
    if(!frmSARS.isValid)
    {
        $('#messageSARSModal').html(frmSARS.message);
        $('#' + frmSARS.invalidField).focus();
        return;
    }
    else
    {
        $('#messageSARSModal').html(frmSARS.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateSARS').val();

        let startHoure = $('#StartHourSARS').val();
        if(startHoure < 10)
        {
            startHoure = "0" + startHoure.toString();
        }
        else
        {
            startHoure = startHoure.toString();
        }
        
        let startMinute = $('#StartMinuteSARS').val();
        if(startMinute < 10)
        {
            startMinute = "0" + startMinute.toString();
        }
        else
        {
            startMinute = startMinute.toString();
        }

        let startSecond = $('#StartSecondSARS').val();
        if(startSecond < 10)
        {
            startSecond = "0" + startSecond.toString();
        }
        else
        {
            startSecond = startSecond.toString();
        }
        
        reportObj.startTime = startHoure + ":" + startMinute + ":" + startSecond;

        reportObj.endDate = $('#EndDateSARS').val();

        let endHoure = $('#EndHourSARS').val();
        if(endHoure < 10)
        {
            endHoure = "0" + endHoure.toString();
        }
        else
        {
            endHoure = endHoure.toString();
        }

        let endMinute = $('#EndMinuteSARS').val();
        if(endMinute < 10)
        {
            endMinute = "0" + endMinute.toString();
        }
        else
        {
            endMinute = endMinute.toString();
        }

        let endSecond = $('#EndSecondSARS').val();
        if(endSecond < 10)
        {
            endSecond = "0" + endSecond.toString();
        }
        else
        {
            endSecond = endSecond.toString();
        }

        reportObj.endTime = endHoure + ":" + endMinute + ":" + endSecond;
        
        var tempDoctorId = $('#DoctorIdSARS').val();
        if(tempDoctorId.length == 0 || tempDoctorId == null)
        {
            tempDoctorId = 0;
        }
        else
        {
            tempDoctorId = parseInt(tempDoctorId);
        }
        reportObj.doctorId = tempDoctorId;
        reportObj.menuId = "SARSLink";

        setActiveItem(sidebarItems,"SARSLink");
        updateContent(reportObj);
        $('#SARSModalWindow').modal('hide');
    }
});

// SARSModalWindow button buttonSARSToExcel handler
$('#SARSModalWindow').on('click','#buttonSARSToExcel', function(){
    
    var frmSARS = CreateFormSARSObject();
    frmSARS.getFormData();

    frmSARS.validate();
    if(!frmSARS.isValid)
    {
        $('#messageSARSModal').html(frmSARS.message);
        $('#' + frmSARS.invalidField).focus();
        return;
    }
    else
    {
        $('#messageSARSModal').html(frmSARS.message);

        var reportObj = {};
        reportObj.startDate = $('#StartDateSARS').val();

        let startHoure = $('#StartHourSARS').val();
        if(startHoure < 10)
        {
            startHoure = "0" + startHoure.toString();
        }
        else
        {
            startHoure = startHoure.toString();
        }
        
        let startMinute = $('#StartMinuteSARS').val();
        if(startMinute < 10)
        {
            startMinute = "0" + startMinute.toString();
        }
        else
        {
            startMinute = startMinute.toString();
        }

        let startSecond = $('#StartSecondSARS').val();
        if(startSecond < 10)
        {
            startSecond = "0" + startSecond.toString();
        }
        else
        {
            startSecond = startSecond.toString();
        }
        
        reportObj.startTime = startHoure + ":" + startMinute + ":" + startSecond;

        reportObj.endDate = $('#EndDateSARS').val();

        let endHoure = $('#EndHourSARS').val();
        if(endHoure < 10)
        {
            endHoure = "0" + endHoure.toString();
        }
        else
        {
            endHoure = endHoure.toString();
        }

        let endMinute = $('#EndMinuteSARS').val();
        if(endMinute < 10)
        {
            endMinute = "0" + endMinute.toString();
        }
        else
        {
            endMinute = endMinute.toString();
        }

        let endSecond = $('#EndSecondSARS').val();
        if(endSecond < 10)
        {
            endSecond = "0" + endSecond.toString();
        }
        else
        {
            endSecond = endSecond.toString();
        }

        reportObj.endTime = endHoure + ":" + endMinute + ":" + endSecond;
        
        var tempDoctorId = $('#DoctorIdSARS').val();
        if(tempDoctorId.length == 0 || tempDoctorId == null)
        {
            tempDoctorId = 0;
        }
        else
        {
            tempDoctorId = parseInt(tempDoctorId);
        }
        reportObj.doctorId = tempDoctorId;
        reportObj.menuId = "SARSLink";

        setActiveItem(sidebarItems,"SARSLink");
        exportToExcel(reportObj);
        $('#SARSModalWindow').modal('hide');
    }
});