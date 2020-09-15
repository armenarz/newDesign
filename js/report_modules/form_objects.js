/// FormReagentExpenses Object
export function CreateFormReagentExpensesObject()
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
        frm.LabIdReagentExpenses = $('#LabIdReagentExpenses').val();
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

/// FormReagentRemainders Object
export function CreateFormReagentRemaindersObject()
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

/// FormDoctors Object
export function CreateFormDoctorsObject()
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

/// FormDebts Object
export function CreateFormDebtsObject()
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

/// FormRepaidDebts Object
export function CreateFormRepaidDebtsObject()
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

/// FormDaily Object
export function CreateFormDailyObject()
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

/// FormOrdersByLabs Object
export function CreateFormOrdersByLabsObject()
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

/// FormOrdersByUsers Object
export function CreateFormOrdersByUsersObject()
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

/// FormDoctor13 Object
export function CreateFormDoctor13Object()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateDoctor13 = $('#StartDateDoctor13').val();
        frm.EndDateDoctor13 = $('#EndDateDoctor13').val();
        frm.ReportTypeIdDoctor13 = $('#ReportTypeIdDoctor13').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //StartDateDoctor13
        if(frm.StartDateDoctor13 == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateDoctor13';
            frm.isValid = false;
            return;       
        }
        //EndDateDoctor13
        else if(frm.EndDateDoctor13 == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateDoctor13';
            frm.isValid = false;
            return;       
        }
        //ReportTypeIdDoctor13
        else if(frm.ReportTypeIdDoctor13 == 0)
        {
            frm.message = 'Выберите тип отчета.';
            frm.invalidField ='ReportTypeIdDoctor13';
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

/// FormDoctorSelected Object
export function CreateFormDoctorSelectedObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateDoctorSelected = $('#StartDateDoctorSelected').val();
        frm.EndDateDoctorSelected = $('#EndDateDoctorSelected').val();
        frm.ReportTypeIdDoctorSelected = $('#ReportTypeIdDoctorSelected').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //StartDateDoctorSelected
        if(frm.StartDateDoctorSelected == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateDoctorSelected';
            frm.isValid = false;
            return;       
        }
        //EndDateDoctorSelected
        else if(frm.EndDateDoctorSelected == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateDoctorSelected';
            frm.isValid = false;
            return;       
        }
        //ReportTypeIdDoctorSelected
        else if(frm.ReportTypeIdDoctorSelected == 0)
        {
            frm.message = 'Выберите тип отчета.';
            frm.invalidField ='ReportTypeIdDoctorSelected';
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

/// FormSARS Object
export function CreateFormSARSObject()
{
    var frm = {};

    ///general properties ======================================
    frm.message = "Заполните нужными значениями поля формы.";
    frm.isValid = true;
    frm.invalidField = null;

    frm.getFormData = function()
    {
        frm.StartDateSARS = $('#StartDateSARS').val();
        frm.EndDateSARS = $('#EndDateSARS').val();
    }

    frm.validate = function()
    {
        frm.message = 'Заполните нужными значениями поля формы.';
        frm.isValid = true;
        frm.invalidField = null;

        //StartDateSARS
        if(frm.StartDateSARS == 0)
        {
            frm.message = 'Выберите начальную дату отчета.';
            frm.invalidField ='StartDateSARS';
            frm.isValid = false;
            return;       
        }
        //EndDateSARS
        else if(frm.EndDateSARS == 0)
        {
            frm.message = 'Выберите конечную дату отчета.';
            frm.invalidField ='EndDateSARS';
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