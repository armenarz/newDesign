<?php header('Content-Type: text/html; charset=UTF-8');
require_once('connect.php');
$cryptinstall="../crypt/cryptographp.fct.php";
require_once $cryptinstall;

if (isset($_POST['code']) && !chk_crypt($_POST['code'])) 
{
	echo "code_error";
} 
else 
{
	//echo 'The captcha checking succeeded:<br/>';
	
	if (isset($_POST['login']) && isset($_POST['password']))
	{
    	$login = mysql_real_escape_string($_POST['login']);
		$password = mysql_real_escape_string($_POST['password']);

		$sql  = "SELECT id, log, passw, userGroup, startMenuId FROM us22 ";
		$sql .= "WHERE log='".$login."' AND passw='".$password."'";
		$res = mysql_query($sql);
		if($res)
		{
			if (mysql_num_rows($res) == 1) 
			{
				$row = mysql_fetch_array($res);
				if($row['startMenuId']==0)
				{
					echo "profile_not_configured";
				}
				else
				{
					$sql_phpFilePath = "SELECT id, userId, menuId, phpFilePath, parentMenuId, sortOrder FROM user_menus WHERE id='".$row['startMenuId']."'";
					$res_phpFilePath = mysql_query($sql_phpFilePath);
					if($res_phpFilePath)
					{
						$row_phpFilePath = mysql_fetch_array($res_phpFilePath);
						echo "php_file_path_".$row_phpFilePath['phpFilePath'];
					}
				}
			}
			else
			{
				echo "login_or_password_error";
			}
		}
		else
		{
			echo "mysql_error ".mysql_error();
		}
	}
  }
?>