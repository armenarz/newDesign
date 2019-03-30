<?php
header("Content-Type: application/xls");
require_once "../connect.php";
require_once "../authorization.php";
require_once "../concatWithBrackets.php";

$msg = "";
$filter = "";
$utf8_bom = chr(239).chr(187).chr(191);

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
//when selectReagent is selected
/* if($reagentId != 0)
{
	$filter = " ReagentId='".$reagentId."'";
	$sql = "SELECT * FROM reagent WHERE ".$filter;
	$result = mysqli_query($link,$sql);
	
	if($result)
	{	
		$row = mysqli_fetch_array($result,MYSQL_ASSOC);
	
		$msg = '
		<table class="table" border="1">
			<caption><h2>Справка о реагенте #'.$reagentId.'</h2></caption>
			<thead>
				<th scope="col">Параметр</th>
				<th scope="col">Значение</th>
			</thead>
		<tbody>
		';
		
		foreach($row as $key => $value)
		{
			$msg.='<tr>';
			$msg.='<td>'.$key.'</td>';
			$msg.='<td>'.$value.'</td>';
			$msg.='</tr>';
		}	
		$msg.= '</tbody>';
        $msg.= '</table>';

		header("Content-Disposition: attachement; filename=reagent_".$reagentId.".xls");
		echo $utf8_bom.$msg;
		return;
	}
} */

$msg.= '
<table class="table" border="1">
	<caption>
		<h2>Список реагентов</h2>
		<h3>
';

//when selectMethod and/or selectGroup are/is selected
if($groupId != 0)
{
	$sql = "SELECT GroupDesc, GroupDescRus FROM reagentgroup WHERE GroupId='".$groupId."'";
	$result = mysqli_query($link,$sql);
	$groupDesc = "";
	$groupDescRus = "";

	if($result)
	{	
		$row = mysqli_fetch_array($result);
		$groupDesc = $row["GroupDesc"];
		$groupDescRus = $row["GroupDescRus"];
	}

	$groupDesc.= ConcatWithBrackets($groupDesc,$groupDescRus);
}

$visibility = "";

if($visibilityId == 0)
{
	$visibility = 'Все';
}
elseif($visibilityId == 1)
{
	$visibility = 'Видимые';
}
elseif($visibilityId == 2)
{
	$visibility = 'Скрытые';
}

$filter = "";

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
	$msg .= "Групп: ".$groupDesc.", Видимость: ".$visibility;
}
elseif($methodId == 0 && $groupId !=0 && $visibilityId != 0)
{
	$filter = " GroupId='".$groupId."' AND visibility='".$visibilityId."'";
	$msg .= "Групп: ".$groupDesc.", Видимость: ".$visibility;
}
elseif($methodId != 0 && $groupId == 0 && $visibilityId == 0)
{
	$filter = " Method='".$method."'";
	$msg .= "Метод: ".$method.", Видимость: ".$visibility;
}
elseif($methodId != 0 && $groupId == 0 && $visibilityId != 0)
{
	$filter = " Method='".$method."' AND visibility='".$visibilityId."'";
	$msg .= "Метод: ".$method.", Видимость: ".$visibility;
}
elseif($methodId != 0 && $groupId != 0 && $visibilityId == 0)
{
	$filter = " Method='".$method."' AND GroupId='".$groupId."'";
	$msg .= "Метод: ".$method.", Группа: ".$groupDesc.", Видимость: ".$visibility;
}
elseif($methodId != 0 && $groupId != 0 && $visibilityId != 0)
{
	$filter = " Method='".$method."' AND GroupId='".$groupId."' AND visibility='".$visibilityId."'";
	$msg .= "Метод: ".$method.", Группа: ".$groupDesc.", Видимость: ".$visibility;
}

//when generalSelection is selected
//Все реагенты
if($generalSelectionId == 1)
{
	$filter = "1";
	$msg .= "Все реагенты";
}
//Все видимые реагенты
elseif($generalSelectionId == 2)
{
	$filter = " visibility='1'";
	$msg .= "Все видимые реагенты";
}
//Все скрытые реагенты
elseif($generalSelectionId == 3)
{
	$filter = " visibility='2'";
	$msg .= "Все скрытые реагенты";
}
//Все активные реагенты
elseif($generalSelectionId == 4)
{
	$filter = " activ='activ'";
	$msg .= "Все активные реагенты";
}
//Все не активные реагенты
elseif($generalSelectionId == 5)
{
	$filter = " activ='not activ'";
	$msg .= "Все не активные реагенты";
}
//Все используемые реагенты
elseif($generalSelectionId == 6)
{
	$filter = " GroupId<>'19'";
	$msg .= "Все используемые реагенты";
}
//Все неиспользуемые реагенты
elseif($generalSelectionId == 7)
{
	$filter = " GroupId='19'";
	$msg .= "Все неиспользуемые реагенты";
}

$msg.= '
		</h3>
	</caption>
	<thead>
		<th scope="col">#</th>
		<!--ReagentId-->
		<th scope="col">Код реагента</th>
		<!--Loinc-->
		<th scope="col">Loinc</th>
		<!--ReagentDesc-->
		<th scope="col">Описание</th>
		<!--ReagentDescRus-->
		<th scope="col">Описание на русском</th>
		<!--ReagentDescArm-->
		<th scope="col">Описание на армянском</th>
		<!--UnitPrice-->
		<th scope="col">UnitPrice</th>
		<!--ed_ismer-->
		<th scope="col">Единица измерения</th>
		<!--AnalysisPrice-->
		<th scope="col">AnalysisPrice</th>
		<!--Method-->
		<th scope="col">Method</th>
		<!--Norm_male-->
		<th scope="col">Norm_male</th>
		<!--norm_male_top-->
		<th scope="col">norm_male_top</th>
		<!--norm_male_bottom-->
		<th scope="col">norm_male_bottom</th>
		<!--Norm_female-->
		<th scope="col">Norm_female</th>
		<!--norm_female_top-->
		<th scope="col">norm_female_top</th>
		<!--norm_female_bottom-->
		<th scope="col">norm_female_bottom</th>
		<!--Calibration-->
		<th scope="col">Calibration</th>
		<!--Control-->
		<th scope="col">Control</th>
		<!--dilution-->
		<th scope="col">dilution</th>
		<!--GroupId-->
		<th scope="col">Код группы</th>
		<!--ProducerId-->
		<th scope="col">Код производителя</th>
		<!--ReagentEquivalent-->
		<th scope="col">ReagentEquivalent</th>
		<!--Material-->
		<th scope="col">Материал</th>
		<!--num-->
		<th scope="col">num</th>
		<!--activ-->
		<th scope="col">Активность</th>
		<!--ed_ismer-->
		<th scope="col">Единица измерения</th>
		<!--Mashinid-->
		<th scope="col">Код анализатора</th>
		<!--probirka-->
		<th scope="col">Пробирка</th>
		<!--Title-->
		<th scope="col">Title</th>
		<!--do12-->
		<th scope="col">do12</th>
		<!--posle12-->
		<th scope="col">posle12</th>
		<!--Method2-->
		<th scope="col">Method2</th>
		<!--Method2id-->
		<th scope="col">Method2id</th>
		<!--probirka_z-->
		<th scope="col">Пробирки заказа</th>
		<!--gotovnost-->
		<th scope="col">Готовность</th>
		<!--srok_gotovnosti-->
		<th scope="col">Срок готовности</th>
		<!--gotovnostN-->
		<th scope="col">gotovnostN</th>
		<!--probirka2-->
		<th scope="col">probirka2</th>
		<!--probirka3-->
		<th scope="col">probirka3</th>
		<!--visibility-->
		<th scope="col">Код видимости</th>
	</thead>
	<tbody>
';

$sql = "SELECT * FROM reagent WHERE ".$filter;
$result = mysqli_query($link,$sql);
if($result)
{
	$i = 0;
	while($row = mysqli_fetch_array($result))
	{
		$i++;

		$msg.= 	'
		<tr>
			<th scope="row">'.$i.'</th>
			<td>'.$row["ReagentId"].'</td>
			<td>'.$row["Loinc"].'</td>
			<td>'.$row["ReagentDesc"].'</td>
			<td>'.$row["ReagentDescRus"].'</td>
			<td>'.$row["ReagentDescArm"].'</td>
			<td>'.$row["UnitPrice"].'</td>
			<td>'.$row["ed_ismer"].'</td>
			<td>'.$row["AnalysisPrice"].'</td>
			<td>'.$row["Method"].'</td>
			<td>'.$row["Norm_male"].'</td>
			<td>'.$row["norm_male_top"].'</td>
			<td>'.$row["norm_male_bottom"].'</td>
			<td>'.$row["Norm_female"].'</td>
			<td>'.$row["norm_female_top"].'</td>
			<td>'.$row["norm_female_bottom"].'</td>
			<td>'.$row["Calibration"].'</td>
			<td>'.$row["Control"].'</td>
			<td>'.$row["dilution"].'</td>
			<td>'.$row["GroupId"].'</td>
			<td>'.$row["ProducerId"].'</td>
			<td>'.$row["ReagentEquivalent"].'</td>
			<td>'.$row["Material"].'</td>
			<td>'.$row["num"].'</td>
			<td>'.$row["activ"].'</td>
			<td>'.$row["ed_ismer"].'</td>
			<td>'.$row["Mashinid"].'</td>
			<td>'.$row["probirka"].'</td>
			<td>'.$row["Title"].'</td>
			<td>'.$row["do12"].'</td>
			<td>'.$row["posle12"].'</td>
			<td>'.$row["Method2"].'</td>
			<td>'.$row["Method2id"].'</td>
			<td>'.$row["probirka_z"].'</td>
			<td>'.$row["gotovnost"].'</td>
			<td>'.$row["srok_gotovnosti"].'</td>
			<td>'.$row["gotovnostN"].'</td>
			<td>'.$row["probirka2"].'</td>
			<td>'.$row["probirka3"].'</td>
			<td>'.$row["visibility"].'</td>
		</tr>
		';
	}
	if($i == 0)
	{
		$msg = '
			<tr>
				<td>По данной выборке ничего не найдено.</td>
			</tr>
		';
		header("Content-Disposition: attachement; filename=reagent_group_".$groupId.".xls");
		echo $utf8_bom.$msg;
		return;
	}
}
else
{
	$msg ='
		<tr>
			<td>Сделайте выборку с помощью фильтров групп и методов или же выберите конкретный реагент с помощью фильтра реагентов.</td>
		</tr>
	';
	echo $msg;
	return;
}

$msg.='
	</tbody>
</table>
';
header("Content-Disposition: attachement; filename=reagents.xls");
echo $utf8_bom.$msg;
?>