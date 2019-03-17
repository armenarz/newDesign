///===================================================================
///==== Login, Password & Captcha sending JS code
///===================================================================
$(function() 
{
	$(".login").click(function() 
	{
    	/// validate
        var login = $("#inputLogin").val();
  		if (login == "") 
  		{
            $("#iii").click();
			$("#inputLogin").focus();
			$("#response").html("Input Login.");
        	return false;
      	}
    	var password = $("#inputPassword").val();
  		if (password == "") 
  		{
            $("#iii").click();
			$("#inputPassword").focus();
			$("#response").html("Input Password.");
  	    	return false;
      	}
    	var code = $("#code").val();
  		if (code == "") 
  		{
            $("#iii").click();
			$("#code").focus();
			$("#response").html("Input Code.");
  	    	return false;
      	}

		/// process
        $.ajaxSetup({
            type: "POST",
            url: "../../test/files/php/verify.php",
            cache: false,
			data: dataString = $('form').serialize(),
			success: funcSuccess,
			error: funcError
        });
		$.ajax();
  		return false;      
    });
});

function funcSuccess(res)
{
	//alert(res);
	var phpFilePath = res.substring(0,"php_file_path".length);
	//alert(phpFilePath);
	if(phpFilePath == "php_file_path")
	{
		phpFilePath = res.substring("php_file_path".length + 1, res.length);
		//alert(phpFilePath);
		$("form[name=form-login]").attr("action","../test/files/php/" + phpFilePath);
		$("form[name=form-login]").attr("method","post");
		$("form[name=form-login]").submit();
	}
	else if(res == "code_error")
	{
		$("#response").html("The code is incorrect.");
		
		$("#inputLogin").val("");
		$("#inputPassword").val("");
		$("#code").val("");
		$("#iii").click();
		$("#inputLogin").focus();
	}
	else if(res == "login_or_password_error")
	{
		$("#response").html("The login and/or password are incorrect.");
		
		$("#inputLogin").val("");
		$("#inputPassword").val("");
		$("#code").val("");
		$("#iii").click();
		$("#inputLogin").focus();
	}
	else if(res == "profile_not_configured")
	{
		$("#response").html("Your profile not configured. Ask administrator.");

		$("#inputLogin").val("");
		$("#inputPassword").val("");
		$("#code").val("");
		$("#iii").click();
		$("#inputLogin").focus();
	}
	else
	{
		$("#response").html(res);

		$("#inputLogin").val("");
		$("#inputPassword").val("");
		$("#code").val("");
		$("#iii").click();
		$("#inputLogin").focus();
	}
            
}

function funcError(XMLHttpRequest, textStatus, errorThrown)
{
	//alert("funcError");
	$("#response").html("Status: " + textStatus + ", " + "Error: " + errorThrown);
}