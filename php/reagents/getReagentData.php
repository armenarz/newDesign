<?php
require_once "../connect.php";
require_once "../authorization.php";
require_once "../fillNonBreak.php";

//sleep(3);
$msg = "";
$filter = "";
//getting methodId
if(isset($_POST["methodId"]))
{
	$methodId = $_POST["methodId"];
	$sql = "SELECT * FROM method WHERE MethodId='".$methodId."'";
	$result = mysqli_query($link,$sql);

	if($result)
	{
		$row = mysqli_fetch_array($result);
		$method = $row["Method"];
	}
}
else
{
	$msg = "Код метода отсутствует";
	echo $msg;
	return;
}
//getting groupId
if(isset($_POST["groupId"]))
{
	$groupId = $_POST["groupId"];
}
else
{
	$msg = "Код группы отсутствует.";
	echo $msg;
	return;
}
//getting generalSelectionId
if(isset($_POST["generalSelectionId"]))
{
	$generalSelectionId = $_POST["generalSelectionId"];
}
else
{
	$msg = "Код общей выборки отсутствует.";
	echo $msg;
	return;
}

//getting visibilityId
if(isset($_POST["visibilityId"]))
{
	$visibilityId = $_POST["visibilityId"];
}
else
{
	$msg = "Код видимости отсутствует";
	echo $msg;
	return;
}
//getting reagentId
if(isset($_POST["reagentId"]))
{
	$reagentId = $_POST["reagentId"];
}
else
{
	$msg = "Код реагента отсутствует.";
	echo $msg;
	return;
}

$filter = "";
//new if
if($methodId != 0 || $groupId != 0)
{
	if($methodId == 0 && $groupId == 0 && $visibilityId == 0)
	{
		$filter = "";
	}
	elseif($methodId == 0 && $groupId == 0 && $visibilityId != 0)
	{
		$filter = "";
	}
	elseif($methodId == 0 && $groupId != 0 && $visibilityId == 0)
	{
		$filter = " GroupId='".$groupId."'";
	}
	elseif($methodId == 0 && $groupId !=0 && $visibilityId != 0)
	{
		$filter = " GroupId='".$groupId."' AND visibility='".$visibilityId."'";
	}
	elseif($methodId != 0 && $groupId == 0 && $visibilityId == 0)
	{
		$filter = " Method='".$method."'";
	}
	elseif($methodId != 0 && $groupId == 0 && $visibilityId != 0)
	{
		$filter = " Method='".$method."' AND visibility='".$visibilityId."'";
	}
	elseif($methodId != 0 && $groupId != 0 && $visibilityId == 0)
	{
		$filter = " Method='".$method."' AND GroupId='".$groupId."'";
	}
	elseif($methodId != 0 && $groupId != 0 && $visibilityId != 0)
	{
		$filter = " Method='".$method."' AND GroupId='".$groupId."' AND visibility='".$visibilityId."'";
	}
}
else if($reagentId != 0)
{
	$filter = " ReagentId='".$reagentId."'";
	$sql = "SELECT * FROM reagent WHERE ".$filter;
	$result = mysqli_query($link,$sql);
	
	if($result)
	{
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$msg.= '
		<table class="table table-bordered table-hover table-fluid">
			<thead>
				<th scope="col">Параметр</th>
				<th scope="col">Значение</th>
			</thead>
			<tbody>
		';
		
		foreach($row as $key => $value)
		{
			$msg.='<tr>';
			$msg.='<td><strong>'.$key.'</strong></td>';
			$msg.='<td>';
			if($key == "Norm_male")
			{
				$msg.='<textarea id="textAreaNorm_male" readonly>'.$value.'</textarea>';
			}
			elseif($key == "Norm_female")
			{
				$msg.='<textarea id="textAreaNorm_female" readonly>'.$value.'</textarea>';
			}
			else
			{
				$msg.= $value;
			}
			$msg.='</td>';
			$msg.='</tr>';
		}	
		$msg.= '</tbody>';
		$msg.= '</table>';
		echo $msg;
		return;
	}
}
else if($generalSelectionId != 0)
{
	//Все реагенты
	if($generalSelectionId == 1)
	{
		$filter = "1";
	}
	//Все видимые реагенты
	elseif($generalSelectionId == 2)
	{
		$filter = " visibility='1'";
	}
	//Все скрытые реагенты
	elseif($generalSelectionId == 3)
	{
		$filter = " visibility='2'";
	}
	//Все активные реагенты
	elseif($generalSelectionId == 4)
	{
		$filter = " activ='activ'";
	}
	//Все не активные реагенты
	elseif($generalSelectionId == 5)
	{
		$filter = " activ='not activ'";
	}
	//Все используемые реагенты
	elseif($generalSelectionId == 6)
	{
		$filter = " GroupId<>'19'";
	}
	//Все неиспользуемые реагенты
	elseif($generalSelectionId == 7)
	{
		$filter = " GroupId='19'";
	}
}

$msg.= '
<table class="table table-bordered table-hover table-responsive">
	<thead>
		<th scope="col"></th>
		<th scope="col">#</th>
		<!-- Mashinid -->
		<th scope="col">Код анализатора</th>
		<!-- ReagentId -->
		<th scope="col">Код реагента</th>
		<!-- Loinc -->
		<th scope="col">Loinc</th>
		<!-- ReagentDesc -->
		<th scope="col">Описание</th>
		<!-- ReagentDescRus -->
		<th scope="col">Описание на русском</th>
		<!-- ReagentDescArm -->
		<th scope="col">Описание на армянском</th>
		<!-- GroupDesc -->
		<th scope="col">Группа</th>
		<!-- AnalysisPrice -->
		<th scope="col">AnalysisPrice</th>
		<!-- Method -->
		<th scope="col">Метод</th>
		<!-- Norm_male -->
		<th scope="col">Norm_male</th>
		<!-- norm_male_top -->
		<th scope="col">norm_male_top</th>
		<!-- norm_male_bottom -->
		<th scope="col">norm_male_bottom</th>
		<!-- Norm_female -->
		<th scope="col">Norm_female</th>
		<!-- norm_female_top -->
		<th scope="col">norm_female_top</th>
		<!-- norm_female_bottom -->
		<th scope="col">norm_female_bottom</th>
		<!-- ed_ismer -->
		<th scope="col">Единица измерения</th>
		<!-- Норма мужчин -->
		<th scope="col">Норма мужчин</th>
		<!-- Норма женщин -->
		<th scope="col">Норма женщин</th>
		<!-- Dilution -->
		<th scope="col">Dilution</th>
		<!-- UnitPrice -->
		<th scope="col">UnitPrice</th>
		<!-- ProducerId -->
		<th scope="col">ProducerId</th>
		<!-- ReagentEquivalent -->
		<th scope="col">ReagentEquivalent</th>
		<!-- Material -->
		<th scope="col">Material</th>
		<!-- Probirka -->
		<th scope="col">Probirka</th>
		<!-- Probirka2 -->
		<th scope="col">Probirka2</th>
		<!-- Probirka3 -->
		<th scope="col">Probirka3</th>
		<!-- Activ -->
		<th scope="col">Activ</th>
		<!-- Title -->
		<th scope="col">Title</th>
		<!-- До Title -->
		<th scope="col">До&nbsp;Title</th>
		<!-- После Title -->
		<th scope="col">После&nbsp;Title</th>
		<!-- Method2 -->
		<th scope="col">Method2</th>
		<!-- Пробирки заказа -->
		<th scope="col">Пробирки заказа</th>
		<!-- Готовность -->
		<th scope="col">Готовность</th>
		<!-- Срок готовности -->
		<th scope="col">Срок&nbsp;готовности</th>
		<!-- Готовность3 -->
		<th scope="col">Готовность3</th>
		<!-- Visibility -->
		<th scope="col">Видимость</th>
	</thead>
	<tbody>
';

$sql = "
SELECT *,
CASE 
	WHEN visibility=1 THEN 'Видимый'
	WHEN visibility=2 THEN 'Скрытый'
END 
AS vis
FROM reagent 
WHERE ".$filter." ORDER BY ReagentId";
$result = mysqli_query($link,$sql);
if($result)
{
	$i = 0;
	while($row = mysqli_fetch_array($result))
	{
		$i++;

		$msg.= '
		<tr>
			<td><input type="radio" name="radioReagent" value="'.$row["ReagentId"].'" aria-label="Выберите реагент"></td>
			<td scope="row"><strong>'.$i.'</strong></td>
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
		// $msg.='	
		// 	<td>'.$row["GroupId"].'</td>
		// ';
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
			<td>'.$row["Material"].'</td>
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
		// $msg.='
		// 	<td>'.$row["Method2"].'</td>
		// 	';
		// $msg.='
		// 	<td>'.$row["probirka_z"].'</td>
		// 	';
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
			<td>'.$row["vis"].'</td>
		</tr>
		';
	}
	if($i == 0)
	{
		$msg = '
		<div class="alert alert-primary d-print-none content" role="alert">
			По данной выборке ничего не найдено.
		</div>
		';
		echo $msg;
		return;
	}
}
else
{
	$msg ='
	<div class="alert alert-primary d-print-none" role="alert">
		Сделайте выборку с помощью фильтров методов и групп, общей выборки или же выберите конкретный реагент с помощью фильтра реагентов.
	</div>
	';
	echo $msg;
	return;
}

$msg.='
	</tbody>
</table>
';
echo $msg;
?>