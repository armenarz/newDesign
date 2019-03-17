$(function()
{
    //alert("Hi");
    $.ajaxSetup({
        type: "POST",
        url: "../handlerBuilder.php",
        cache: false,
        data: dataString = $("form[name='tempData']").serialize(),
        success: function(result){
            $( "body" ).append( "<script>" + result + "</script>" );
        },
        error: function(){}
    });
    ///process
    $.ajax();
});