export function setReagentExpensesMWData()
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
    
    //
    $("#SelectReagentGroupSARSReagentExpenses").click(function(){
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
            var reagentGroup = [1142,1166];
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
    
	let uu = document.tempData.user_id.value;
	
	console.log(uu);	
	let sars_el = document.getElementById("div_sars");
	
	if(sars_el) {
		if(uu != '12' && uu != '13') {
			sars_el.style.visibility = "hidden";
		}
	}
	
	if(document.getElementById("SelectReagentGroupReagentExpenses")) {
		if( document.tempData.user_id.value =="764" ){
			$("#SelectReagentGroupReagentExpenses").prop("disabled",true);
			
		}
	}
	
	if(document.getElementById("SelectReagentGroupSARSReagentExpenses")) {
		if( document.tempData.user_id.value =="764" ){
			$("#SelectReagentGroupSARSReagentExpenses").prop("disabled",true);
			
		}
	}
	
	if(document.getElementById("DoctorIdReagentExpenses")) {
		if( document.tempData.user_id.value =="764" ){
			$("#DoctorIdReagentExpenses").prop("disabled",true);
			
		}
	}
	
	if(document.getElementById("WorkplaceIdReagentExpenses")) {
		if( document.tempData.user_id.value =="764" ){
			$("#WorkplaceIdReagentExpenses").prop("disabled",true);
			
		}
	}
	
	if(document.getElementById("SalesIdReagentExpenses")) {
		if( document.tempData.user_id.value =="764" ){
			$("#SalesIdReagentExpenses").prop("disabled",true);
			
		}
	}
	
	if(document.getElementById("UserIdReagentExpenses")) {
		if( document.tempData.user_id.value =="764" ){
			$("#UserIdReagentExpenses").prop("disabled",true);
			
		}
	}
	
	if(document.getElementById("SARS-CoV-2BezCheckReagentExpenses")) {
		if( document.tempData.user_id.value =="764" ){
			$("#SARS-CoV-2BezCheckReagentExpenses").prop("disabled",true);
			
		}
	}
	
	if( document.tempData.user_id.value =="764" ) { 
		if(document.getElementById("ReagentIdReagentExpenses")) {
			//document.getElementById("ReagentIdReagentExpenses").focus();
			$("#ReagentIdReagentExpenses").val('1142');
			$('#ReagentIdReagentExpenses option[value!="1142"]').remove();			
			
			$("#ReagentIdReagentExpenses").prop("disabled",true);
		}
	}
}

export function setSearchDoctorData() 
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

    $("#DoctorIdReagentExpenses, #DoctorIdDoctors, #DoctorIdSARS").catcomplete({
        delay: 0,
        source: data
    });
}

export function setSearchReagentData() 
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

export function setReagentRemaindersMWData()
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

export function setDoctorsMWData()
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

export function setDebtsMWData()
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

export function setRepaidDebtsMWData()
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

export function setDailyMWData()
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

export function setOrdersByLabsMWData()
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

export function setOrdersByUsersMWData()
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

export function setDoctor13MWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getDoctor13MWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDoctor13MWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetDoctor13MWData(result)
{
    //console.log(result);
    $("#contentDoctor13Modal").html(result);
}

export function setDoctorSelectedMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../reports/getDoctorSelectedMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDoctorSelectedMWData,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetDoctorSelectedMWData(result)
{
    //console.log(result);
    $("#contentDoctorSelectedModal").html(result);
}

export function setSARSMWData()
{
        /// ajax setup
        $.ajaxSetup({
            type: "POST",
            url: "../reports/getSARSMWData.php",
            cache: false,
            data: dataString = $("form[name='tempData']").serialize(),
            success: funcSuccessSetSARSMWData,
            error: funcError
        });
        ///process
        $.ajax();
}

function funcSuccessSetSARSMWData(result)
{
    //console.log(result);
    $("#contentSARSModal").html(result);
    setSearchDoctorData();
    $("#DoctorIdSARS").focus(function() 
    {
        $(this).select();
        //console.log("focus");
    });
    $("#DoctorIdSARS").prop("disabled",false);
    $("#StartDateSARS").datepicker({ dateFormat: "yy-mm-dd" });
    $("#EndDateSARS").datepicker({ dateFormat: "yy-mm-dd" });
}

export function funcError(XMLHttpRequest, textStatus, errorThrown)
{
    $("#content").html("Status: " + textStatus + ", " + "Error: " + errorThrown);
}