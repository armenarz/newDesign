<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";

//getting reagentId
if(isset($_POST["reagent_id"]))
{
	$reagentId = $_POST["reagent_id"];
}
else
{
	$msg = "Код реагента отсутствует.";
	echo $msg;
	return;
}

$sql = "
SELECT *,
CASE 
	WHEN visibility=1 THEN 'Видимый'
	WHEN visibility=2 THEN 'Скрытый'
END 
AS vis
FROM reagent 
WHERE ReagentId='".$reagentId."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $msg.= '
        <td><input type="radio" name="radioReagent" value="'.$row["ReagentId"].'" aria-label="Выберите реагент"/></td>
        <td scope="row"><strong></strong></td>
        <td>'.$row["Mashinid"].'</td>
        <td>'.$row["ReagentId"].'</td>
        <td>'.$row["Loinc"].'</td>
        <td>'.$row["ReagentDesc"].'</td>
        <td>'.$row["ReagentDescRus"].'</td>
        <td>'.$row["ReagentDescArm"].'</td>
    ';
    $sql_group ="
    SELECT GroupDesc FROM reagentgroup WHERE GroupId='".$row["GroupId"]."' 
    ";
    $result_group = mysqli_query($link,$sql_group);
    if($result_group)
    {
        $row_group = mysqli_fetch_array($result_group);
        $msg.='
        <td>'.$row_group["GroupDesc"].'</td>
        ';
    }

    $msg.='
        <td>'.$row["AnalysisPrice"].'</td>
        <td>'.$row["Method"].'</td>
        <td><textarea id="textarea_Norm_male" readonly>'.$row["Norm_male"].'</textarea></td>
        <td>'.$row["norm_male_top"].'</td>
        <td>'.$row["norm_male_bottom"].'</td>
        <td><textarea id="textarea_Norm_female" readonly>'.$row["Norm_female"].'</textarea></td>
        <td>'.$row["norm_female_top"].'</td>
        <td>'.$row["norm_female_bottom"].'</td>
        <td>'.$row["ed_ismer"].'</td>
        <td>'.$row["Calibration"].'</td>
        <td>'.$row["Control"].'</td>
        <td>'.$row["dilution"].'</td>
        <td>'.$row["UnitPrice"].'</td>
        <td>'.$row["ProducerId"].'</td>
        <td>'.$row["ReagentEquivalent"].'</td>
        <td>';
		$sql_material = "SELECT Material FROM material WHERE id = '".$row["material_id"]."'";
		$result_material = mysqli_query($link,$sql_material);
		if($result_material)
		{
			$row_material = mysqli_fetch_array($result_material);
			$msg.=$row_material["Material"];
		}
		
	$msg.='
		</td>
        <td>'.$row["probirka"].'</td>
        <td>'.$row["probirka2"].'</td>
        <td>'.$row["probirka3"].'</td>
        <td>'.$row["activ"].'</td>
        <td><textarea id="textarea_Title" readonly>'.$row["Title"].'</textarea></td>
        <td>'.$row["do12"].'</td>
        <td>'.$row["posle12"].'</td>
        ';
    $sql_method2="
    SELECT Method FROM method2 WHERE MethodId='".$row["Method2id"]."'
    ";
    $result_method2 = mysqli_query($link,$sql_method2);
    if($result_method2)
    {
        $row_method2 = mysqli_fetch_array($result_method2);
        $msg.='
        <td>'.$row_method2["Method"].'</td>
        ';
    }

    $probirka_z = array();
    if(json_decode($row["probirka_z"],true) == NULL)
    {
        $probirka_z = explode(',',$row["probirka_z"]);
    }
    else
    {
        $probirka_zAssoc = json_decode($row["probirka_z"],true);
        if(count($probirka_zAssoc) > 0)
        {
            foreach($probirka_zAssoc as $key => $value)
            {
                $probirka_z[] = $key;
            }
        }
    }

    $msg.='
        <td><select id="probirka_zView" class="form-control" name="probirka_zView[]" size="6" multiple disabled>
                    <option value="0"></option>
    ';
    $sql_pz = "SELECT id, prob FROM probirka_z";
    $result_pz = mysqli_query($link,$sql_pz);
    if($result_pz)
    {
        while($row_pz = mysqli_fetch_array($result_pz))
        {
            $msg .=  '<option value="'.$row_pz["id"].'"';
            if(in_array($row_pz["id"],$probirka_z)) $msg .= ' selected';
            $msg .='>'.FillNonBreak($row_pz["id"],2).'&nbsp;'.$row_pz["prob"].'</option>';
        }
    }
    $msg.= '
                        </select></td>
        <td>'.$row["gotovnost"].'</td>
        <td>'.$row["srok_gotovnosti"].'</td>
        <td>'.$row["gotovnostN"].'</td>
        <td>'.$row["gotovnost4"].'</td>
        <td>'.$row["vis"].'</td>
        <td>'.$row["sorting"].'</td>
    ';
	
}
echo $msg;
?>