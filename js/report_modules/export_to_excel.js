export function exportToExcel(reportObj)
{
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

        var labId = reportObj.labId;
        appendHiddenElement(form, "labId", labId);

        var filial = reportObj.filial;
        appendHiddenElement(form, "filial", filial);

        var doubleCheck = reportObj.doubleCheck;
        appendHiddenElement(form, "doubleCheck", doubleCheck);
		
		var SARSCheck = reportObj.SARSCheck;
        appendHiddenElement(form, "SARSCheck", SARSCheck);
		
		let BezSARSCheck = reportObj.BezSARSCheck;
        appendHiddenElement(form, "BezSARSCheck", BezSARSCheck);

        //var urlString = "";
        if(reportTypeId == 1)
        {
            //urlString = "../reports/exportReagentExpensesConsolidated.php";
			///alert(SARSCheck); porcel notebook -ov
			if(SARSCheck === false) {
				console.log(1);
				document.tempData.action = "../reports/exportReagentExpensesConsolidated.php";
			}
			else {
				console.log(2);
				document.tempData.action = "../reports/exportReagentSars.php";
			}
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
        removeHiddenElement(form, "labId");
        removeHiddenElement(form, "filial");
        removeHiddenElement(form, "doubleCheck");
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

        var doubleCheck = reportObj.doubleCheck;
        appendHiddenElement(form, "doubleCheck", doubleCheck);

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
        removeHiddenElement(form, "doubleCheck");
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
    else if(menuId == "doctor13Link")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);
        
        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        if(reportTypeId == 1)
        {
            document.tempData.action = "../reports/exportDoctor13Consolidated.php";
        }
        else if(reportTypeId == 2)
        {
            document.tempData.action = "../reports/exportDoctor13Detailed.php";
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
    }
    else if(menuId == "doctorSelectedLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);
        
        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        if(reportTypeId == 1)
        {
            document.tempData.action = "../reports/exportDoctorSelectedConsolidated.php";
        }
        else if(reportTypeId == 2)
        {
            document.tempData.action = "../reports/exportDoctorSelectedDetailed.php";
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
    }
    else if(menuId == "SARSLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        let startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        let startTime = reportObj.startTime;
        appendHiddenElement(form, "startTime", startTime);

        let endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);

        let endTime = reportObj.endTime;
        appendHiddenElement(form, "endTime", endTime);

        let doctorId = reportObj.doctorId;
        appendHiddenElement(form, "doctorId", doctorId);
		
		let BezSARSCheck = reportObj.BezSARSCheck;
        appendHiddenElement(form, "BezSARSCheck", BezSARSCheck);

        let onlyArmenian = reportObj.onlyArmenian;
        appendHiddenElement(form, "onlyArmenian", onlyArmenian);
        console.log("onlyArmenian="+onlyArmenian);
        document.tempData.action = "../reports/exportSARS.php";
        document.tempData.target = '_blank';
        document.tempData.method = 'POST';
        document.tempData.submit();
        document.tempData.action = '';
        document.tempData.target = '';
        
        removeHiddenElement(form, "menuId", menuId);
        removeHiddenElement(form, "startDate", startDate);
        removeHiddenElement(form, "startTime", startTime);
        removeHiddenElement(form, "endDate", endDate);
        removeHiddenElement(form, "endTime", endTime);
        removeHiddenElement(form, "doctorId", doctorId);
		removeHiddenElement(form, "BezSARSCheck", BezSARSCheck);
        removeHiddenElement(form, "onlyArmenian", onlyArmenian);
    }
	else if(menuId == "driversLink")
    {
        appendHiddenElement(form, "menuId", menuId);

        var reportTypeId = reportObj.reportTypeId;
        appendHiddenElement(form, "reportTypeId", reportTypeId);

        var startDate = reportObj.startDate;
        appendHiddenElement(form, "startDate", startDate);

        var endDate = reportObj.endDate;
        appendHiddenElement(form, "endDate", endDate);
        
        var driverId = reportObj.driverId;
        appendHiddenElement(form, "driverId", driverId);

        //var urlString = "";
        if(reportTypeId == 1)
        {
            //urlString = "../reports/exportOrdersByUsersConsolidated.php";
            document.tempData.action = "../reports/exportDriversConsolidated.php";
        }
        else if(reportTypeId == 2)
        {
            //urlString = "../reports/exportOrdersByUsersDetailed.php";
            document.tempData.action = "../reports/exportDriversDetailed.php";
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
        removeHiddenElement(form, "driverId");
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