//startup code
$(function()
{
    var filterObj = {};
    filterObj.salesId = 0;
    filterObj.workplaceId = 0;
    filterObj.specialityId = 0;
    filterObj.doctorId = 0;
    filterObj.generalSelectionId = 0;

    setSelectSaleData();
    setSelectWorkplaceData();
    setSelectSpecialityData();
    setSearchDoctorData();
    updateContent(filterObj);

    //getting selected value of select tag with id "selectSale"
    $("#selectSale").change(function(){
        filterObj.salesId = $("#selectSale").val();
        
        filterObj.doctorId = 0;
        $("#searchDoctor").val("");
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");
        updateContent(filterObj);
    });

    //getting selected value of select tag with id "selectWorkplace"
    $("#selectWorkplace").change(function(){
        filterObj.workplaceId = $("#selectWorkplace").val();
        console.log(filterObj.workplaceId);
        filterObj.doctorId = 0;
        $("#searchDoctor").val("");
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");
        updateContent(filterObj);
    });

    //getting selected value of select tag with id "selectSpeciality"
    $("#selectSpeciality").change(function(){
        filterObj.specialityId = $("#selectSpeciality").val();
        
        filterObj.doctorId = 0;
        $("#searchDoctor").val("");
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");
        updateContent(filterObj);
    });

    //getting selected value of select tag with id "generalSelectionId";
    $("#generalSelectionId").change(function(){
        //alert("generalSelectionId");
        filterObj.generalSelectionId = $("#generalSelectionId").val();
        filterObj.salesId = 0;
        $("#selectSale").val("0");
        filterObj.workplaceId = 0;
        $("#selectWorkplace").val("0");
        filterObj.reagentId = 0;
        $("#searchDoctor").val("0");
        updateContent(filterObj);
    });

    //getting searched value of input tag with id "searchDoctor"
    $("#searchButton").click(function()
    {
        var temp = $("#searchDoctor").val();
        if(temp.length == 0)
        {
            temp = 0;
        }
        filterObj.doctorId = parseInt(temp);
        $("#searchDoctor").val(filterObj.doctorId);
        if($("#searchDoctor").val()==null)
        {
            var loaderMsg = '';
            loaderMsg  = '<div class="alert alert-primary d-print-none" role="alert">';
            loaderMsg += 	'По данной выборке ничего не найдено.';
            loaderMsg += '</div>';   
            $("#content").html(loaderMsg);
            return;
        }

        filterObj.salesId = 0;
        $("#selectSale").val("0");
        filterObj.workplaceId = 0;
        $("#selectWorkplace").val("0");
        filterObj.specialityId = 0;
        $("#selectSpeciality").val("0");
        filterObj.generalSelectionId = 0;
        $("#generalSelectionId").val("0");

        updateContent(filterObj);
    });

    $("#searchDoctor").focus(function () {
        $(this).select();
    });

    $("#exportLink").click(function()
    {
        exportToExcel();
    });

    //setting content div height for scrollbar appearing
    $("#content").height($(window).height()-237);
    $(window).resize(function() 
    {
        $("#content").height($(window).height()-237);
    });
});

//functions
//setting selectSale data
function setSelectSaleData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/getSelectSaleData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetSelectSaleData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetSelectSaleData(result)
{
    $('#selectSale').html(result);
    $("#selectSale").prop("disabled",false);
}

function setSelectWorkplaceData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/getSelectWorkplaceData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetSelectWorkplaceData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetSelectWorkplaceData(result)
{
    $('#selectWorkplace').html(result);
    $("#selectWorkplace").prop("disabled",false);
}

function setSelectSpecialityData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/getSelectSpecialityData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetSelectSpecialityData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetSelectSpecialityData(result)
{
    $('#selectSpeciality').html(result);
    $("#selectSpeciality").prop("disabled",false);
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

    $("#searchDoctor").catcomplete({
        delay: 0,
        source: data
    });
    $("#searchDoctor").prop("disabled",false);
}

function updateContent(filterObj)
{
    var salesId = filterObj.salesId;
    var workplaceId = filterObj.workplaceId;
    var specialityId = filterObj.specialityId;
    var doctorId = filterObj.doctorId;
    var generalSelectionId = filterObj.generalSelectionId;

    var loaderMsg = '';
    if(salesId==0 && workplaceId==0 && specialityId==0 && doctorId==0 && generalSelectionId==0)
    {
        loaderMsg  = '<div class="alert alert-primary d-print-none" role="alert">';
        loaderMsg += 'Сделайте выборку с помощью фильтров sales, мест работы, специальности и общей выборки или же выберите конкретного доктора с помощью фильтра докторов.';
        loaderMsg += '</div>';
        $("#content").html(loaderMsg);
        $("#exportLink").hide(); 
        $("#addLink").hide();
        $("#editLink").hide();
        $("#deleteLink").hide();
        return;
    }
    else if(salesId!=0 || workplaceId!=0 || specialityId!=0 || doctorId!=0 || generalSelectionId!=0)
    {
        $("#exportLink").show(); 
        $("#addLink").show();
        $("#editLink").hide();
        $("#deleteLink").hide();
        setDoctorAMWData();
    }
       
	$.ajaxSetup({
		type: "POST",
    	url: "../doctors/getDoctorData.php",
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
            $("input[name='radioDoctor']").on("click",this,function()
            {
                $("#doctor_id").val($(this).val());
                setDoctorEMWData();
                $("#editLink").show();
                setDoctorDMWData();
                $("#deleteLink").show();
            });
        }
    });
}

//setting addModalWindow data
function setDoctorAMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/getDoctorAMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDoctorAMWData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetDoctorAMWData(result)
{
    $("#contentAddModal").html(result);
}

//setting editModalWindow data
function setDoctorEMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/getDoctorEMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDoctorEMWData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetDoctorEMWData(result)
{
    $("#contentEditModal").html(result);
}

//setting deleteModalWindow data
function setDoctorDMWData()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/getDoctorDMWData.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetDoctorDMWData,
        error: funcError
    });
    ///process
    $.ajax();
}
function funcSuccessSetDoctorDMWData(result)
{
    $("#contentDeleteModal").html(result);
}

// deleteModalWindow button OK handler
$('#deleteModalWindow').on('click','#buttonOKDelete', function(){

    ///deleteing doctor data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/deleteDoctor.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formDelete']").serialize()),
        success: function(res)
        {
            var filterObj = {};
            filterObj.salesId = $("#selectSale").val();
            filterObj.workplaceId = $("#selectWorkplace").val();
            filterObj.specialityId = $("#selectSpeciality").val();
            filterObj.doctorId = $("#searchDoctor").val();
            filterObj.generalSelectionId = $('#generalSelectionId').val();
            updateContent(filterObj);
            setSearchDoctorData();
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

//export to excel
function exportToExcel()
{
    document.tempData.action = 'exportDoctorsToExcel.php';
    document.tempData.target = '_blank';
    document.tempData.method = 'POST';
    document.tempData.submit();
    document.tempData.action = '';
    document.tempData.target = '';
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
    ///updateing doctor data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/editDoctor.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formEdit']").serialize()),
        success: function(res)
        {
            console.log(res);
            var filterObj = {};
            filterObj.salesId = $("#selectSale").val();
            filterObj.workplaceId = $("#selectWorkplace").val();
            filterObj.specialityId = $("#selectSpeciality").val();
            filterObj.doctorId = $("#searchDoctor").val();
            filterObj.generalSelectionId = $('#generalSelectionId').val();
            updateContent(filterObj);
            setSearchDoctorData();
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
    };

    frm.getFormData = function()
    {
        frm.getTab1Data();
        frm.getTab2Data();
        frm.getTab3Data();
    };

    frm.getTab1Data = function()
    {
        ///tab 1 ===================================================
        frm.doctorIdEdit = $('#DoctorIdEdit').val();
        frm.firstNameEdit = $('#FirstNameEdit').val();
        frm.lastNameEdit = $('#LastNameEdit').val();
        frm.midNameEdit = $('#MidNameEdit').val();
        frm.personality_typeEdit = $('#personality_typeEdit').val();
        frm.loyaltyEdit = $('#loyaltyEdit').val();
    }

    frm.getTab2Data = function()
    {
        ///tab 2 ===================================================
        frm.birthDateEdit = $('#BirthDateEdit').val();
        frm.discountEdit = $('#DiscountEdit').val();
        frm.phone1Edit = $('#Phone1Edit').val();
        frm.phone2Edit = $('#Phone2Edit').val();
        frm.emailEdit = $('#EmailEdit').val();
        frm.workPlaceIdEdit = $('#WorkPlaceIdEdit').val();
    }

    frm.getTab3Data = function()
    {
        ///tab 3 ===================================================
        frm.loginEdit = $('#LoginEdit').val();
        frm.passwordEdit = $('#PasswordEdit').val();
        frm.salesIdEdit = $('#SalesIdEdit').val();
        frm.specialityIdEdit = $('#SpecialityIdEdit').val();
        frm.activeIdEdit = $('#ActiveIdEdit').val();
    }

    frm.validate = function()
    {
        frm.validateTab1();
        if(frm.isValid) frm.validateTab2();
        else return;
        if(frm.isValid) frm.validateTab3();
        else return;
    };
    //Tab1
    frm.validateTab1 = function()
    {
        frm.message = 'Для редактирования данных текущего доктора заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
        
        //FirstNameEdit
        if(frm.firstNameEdit.length == 0)
        {
            frm.message = 'Введите имя доктора в поле FirstName.';
            frm.invalidField ='FirstNameEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;            
        }
        //LastNameEdit
        else if(frm.lastNameEdit.length == 0)
        {
            frm.message = 'Введите фамилия доктора в поле LastNameEdit.';
            frm.invalidField ='LastNameEdit';
            frm.isValid = false;
            frm.invalidTab = 'nav-edit-part1-tab';
            return;
        }
        else
        {
            frm.message = 'Для редактирования данных текущего доктора заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            frm.invalidTab = null;
            return;
        }
    };
    //Tab2
    frm.validateTab2 = function()
    {
        frm.message = 'Для редактирования данных текущего доктора заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
    }
    //Tab3
    frm.validateTab3 = function()
    {
        frm.message = 'Для редактирования данных текущего доктора заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
    }
    
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
    
    ///updateing doctor data
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../doctors/addDoctor.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize().concat('&').concat($("form[name='formAdd']").serialize()),
        success: function(res)
        {
            console.log(res);
            var filterObj = {};
            filterObj.salesId = $("#selectSale").val();
            filterObj.workplaceId = $("#selectWorkplace").val();
            filterObj.specialityId = $("#selectSpeciality").val();
            filterObj.doctorId = $("#searchDoctor").val();
            filterObj.generalSelectionId = $('#generalSelectionId').val();
            updateContent(filterObj);
            setSearchDoctorData();
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
    $('#DoctorIdAdd').val('');
    $('#FirstNameAdd').val('');
    $('#LastNameAdd').val('');
    $('#MidNameAdd').val('');
    $('#personality_typeAdd').val('');
    $('#loyaltyAdd').val();

    $('#BirthDateAdd').val();
    $('#DiscountAdd').val();
    $('#Phone1Add').val();
    $('#Phone2Add').val();
    $('#EmailAdd').val();
    $('#WorkPlaceIdAdd').val();

    $('#LoginAdd').val();
    $('#PasswordAdd').val();
    $('#SalesIdAdd').val();
    $('#SpecialityIdAdd').val();
    $('#ActiveIdAdd').val();
});

// addModalWindow close handler
$('#addModalWindow').on('hidden.bs.modal', function () {

});

/// FormAdd Object
function CreateFormAddObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Для добавления нового доктора заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;
    frm.invalidTab = null;
    frm.activeTab = null;

    frm.getActiveTab = function()
    {
        if($('#nav-add-part1-tab').hasClass('active')) frm.activeTab = 'nav-add-part1-tab';
        else if($('#nav-add-part2-tab').hasClass('active')) frm.activeTab = 'nav-add-part2-tab';
        else if($('#nav-add-part3-tab').hasClass('active')) frm.activeTab = 'nav-add-part3-tab';     
    };
    frm.getFormData = function()
    {
        frm.getTab1Data();
        frm.getTab2Data();
        frm.getTab3Data();
    };
    frm.getTab1Data = function()
    {
        ///tab 1 ===================================================
        frm.doctorIdAdd = $('#DoctorIdAdd').val();
        frm.firstNameAdd = $('#FirstNameAdd').val();
        frm.lastNameAdd = $('#LastNameAdd').val();
        frm.midNameAdd = $('#MidNameAdd').val();
        frm.personality_typeAdd = $('#personality_typeAdd').val();
        frm.loyaltyAdd = $('#loyaltyAdd').val();
    };
    frm.getTab2Data = function()
    {
        ///tab 2 ===================================================
        frm.birthDateAdd = $('#BirthDateAdd').val();
        frm.discountAdd = $('#DiscountAdd').val();
        frm.phone1Add = $('#Phone1Add').val();
        frm.phone2Add = $('#Phone2Add').val();
        frm.emailAdd = $('#EmailAdd').val();
        frm.workPlaceIdAdd = $('#WorkPlaceIdAdd').val();
    };
    frm.getTab3Data = function()
    {
        ///tab 3 ===================================================
        frm.loginAdd = $('#LoginAdd').val();
        frm.passwordAdd = $('#PasswordAdd').val();
        frm.salesIdAdd = $('#SalesIdAdd').val();
        frm.specialityIdAdd = $('#SpecialityIdAdd').val();
        frm.activeIdAdd = $('#ActiveIdAdd').val();
    };
    frm.validate = function()
    {
        frm.validateTab1();
        if(frm.isValid) frm.validateTab2();
        else return;
        if(frm.isValid) frm.validateTab3();
        else return;
    };
    //Tab1
    frm.validateTab1 = function()
    {
        frm.message = 'Для добавления нового доктора заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;
        
        //FirstNameAdd
        if(frm.firstNameAdd.length == 0)
        {
            frm.message = 'Введите имя доктора в поле FirstName.';
            frm.invalidField ='FirstNameAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;            
        }
        //LastNameAdd
        else if(frm.lastNameAdd.length == 0)
        {
            frm.message = 'Введите фамилия доктора в поле LastName.';
            frm.invalidField ='LastNameAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part1-tab';
            return;
        }
        else
        {
            frm.message = 'Для добавления нового доктора заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            frm.invalidTab = null;
            return;
        }
    };
    //Tab2
    frm.validateTab2 = function()
    {
        frm.message = 'Для добавления нового доктора заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //WorkPlaceIdAdd
        if(frm.workPlaceIdAdd == 0)
        {
            frm.message = 'Выберите место работы доктора.';
            frm.invalidField ='WorkPlaceIdAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part2-tab';
            return;
        }
        else
        {
            frm.message = 'Для добавления нового доктора заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            frm.invalidTab = null;
            return;
        }
    };
    //Tab3
    frm.validateTab3 = function()
    {
        frm.message = 'Для добавления нового доктора заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;
        frm.invalidTab = null;

        //SalesIdAdd
        if(frm.salesIdAdd == 0)
        {
            frm.message = 'Выберите sales доктора.';
            frm.invalidField ='SalesIdAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part3-tab';
            return;
        }
        //SpecialityIdAdd
        else if(frm.specialityIdAdd == 0)
        {
            frm.message = 'Выберите специальность доктора.';
            frm.invalidField ='SpecialityIdAdd';
            frm.isValid = false;
            frm.invalidTab = 'nav-add-part3-tab';
            return;
        }
        else
        {
            frm.message = 'Для добавления нового доктора заполните нужными значениями поля формы.';
            frm.invalidField = null;
            frm.isValid = true;
            frm.invalidTab = null;
            return;
        }
    };
    return frm;
}

function funcError(XMLHttpRequest, textStatus, errorThrown)
{
    $("#content").html("Status: " + textStatus + ", " + "Error: " + errorThrown);
}