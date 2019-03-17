<?php
require_once("connect.php");
if(isset($_POST['user_id']))
{
    $userId = $_POST['user_id'];
    $doc_path = Array();
    $doc_path = explode('/',$_POST['current_doc']);
    $current_doc = $doc_path[count($doc_path)-1];
    $handlersStr = "";
    $sql = "SELECT id, userId, menuId, phpFilePath, parentMenuId, sortOrder FROM user_menus ";
    $sql.= "WHERE userId=".$userId." AND menuId<>1 AND id NOT IN (SELECT DISTINCT parentMenuId FROM user_menus WHERE userId=".$userId." AND parentMenuId<>0)";
    $result = mysqli_query($link,$sql);
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $handlerName = $row['phpFilePath'];
            $tempArray = explode('.',$handlerName);
            $handlerName = $tempArray[0];

            $handlersStr .= "document.getElementById('userMenu_".$row['id']."').onclick=";
            $handlersStr .= "function()"."\n";
            $handlersStr .= "{"."\n";
            $handlersStr .= "\t";
            
            if($row['phpFilePath']!==$current_doc)
            {
                $handlersStr .= "document.tempData.action='../../".$row['phpFilePath']."';"."\n\t";
            }
            //$handlersStr .= "alert('".$row['phpFilePath']."');";
            //$handlersStr .= "console.dir(document);"."\n";
            $handlersStr .= "document.tempData.submit();"."\n";
            $handlersStr .= "}"."\n";
        }
    }
    echo $handlersStr;
   
    mysqli_close($link);
}
?>