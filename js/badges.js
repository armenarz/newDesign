setRawPreordersCount();

function setRawPreordersCount()
{
    /// ajax setup
    $.ajaxSetup({
        type: "POST",
        url: "../preorders/getRawPreordersCount.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: funcSuccessSetRawPreordersCount,
        error: funcError
    });
    ///process
    $.ajax();
}

function funcSuccessSetRawPreordersCount(result)
{
    $("#rawPreordersCount").html(result);
}

function funcError(XMLHttpRequest, textStatus, errorThrown)
{
    $("#content").html("Status: " + textStatus + ", " + "Error: " + errorThrown);
}