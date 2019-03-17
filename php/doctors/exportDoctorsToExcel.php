<?php
header("Content-Type: application/xls");
require_once "../connect.php";
require_once "../authorization.php";
require_once "../concatWithBrackets.php";

$msg = "";
$filter = "";
$utf8_bom = chr(239).chr(187).chr(191);

//getting doctorId
if(isset($_POST["doctorId"]))
{
	$doctorId = $_POST["doctorId"];
}
else
{
	$msg = "Код доктора отсутствует.";
	echo $msg;
	return;
}
//getting salesId
if(isset($_POST["salesId"]))
{
	$salesId = $_POST["salesId"];
	$sql = "SELECT salesName FROM sales WHERE salesId='".$salesId."'";
	$result = mysqli_query($link,$sql);
	if($result)
	{	
		$row = mysqli_fetch_array($result);
		$sales = $row["salesName"];
	}
}
else
{
	$msg = "Код sales отсутствует.";
	echo $msg;
	return;
}
//getting workplaceId
if(isset($_POST["workplaceId"]))
{
	$workplaceId = $_POST["workplaceId"];
	$sql = "SELECT WorkPlaceDesc FROM cworkplace WHERE WorkPlaceId='".$workplaceId."'";
	$result = mysqli_query($link,$sql);
	if($result)
	{	
		$row = mysqli_fetch_array($result);
		$workplace = $row["WorkPlaceDesc"];
	}
}
else
{
	$msg = "Код места работы отсутствует";
	echo $msg;
	return;
}
//getting speciality
if(isset($_POST["specialityId"]))
{
	$specialityId = $_POST["specialityId"];
	$sql = "SELECT Method FROM profession WHERE MethodId='".$specialityId."'";
	$result = mysqli_query($link,$sql);
	if($result)
	{	
		$row = mysqli_fetch_array($result);
		$speciality = $row["Method"];
	}

}
else
{
	$msg = "Код специальности отсутствует";
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

//when doctor is searched by searchDoctor
if($doctorId != 0)
{
	$filter = " DoctorId='".$doctorId."'";
	$sql = "SELECT * FROM doctor WHERE ".$filter;
	$result = mysqli_query($link,$sql);
	
	if($result)
	{	
		$row = mysqli_fetch_array($result,MYSQL_ASSOC);
	
		$msg = '
		<table class="table" border="1">
			<caption><h2>Справка о докторе #'.$doctorId.'</h2></caption>
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

		header("Content-Disposition: attachement; filename=doctor_".$doctorId.".xls");
		echo $utf8_bom.$msg;
		return;
	}
}

//when selectSale and/or selectWorkplace and/or selectSpeciality are/is selected
$msg.= '
<table class="table" border="1">
	<caption>
		<h2>Список докторов</h2>
		<h3>
';

$filter = "";

if($salesId == 0 && $workplaceId == 0 && $specialityId == 0)
{
	$filter = "";
}
elseif($salesId == 0 && $workplaceId == 0 && $specialityId != 0)
{
	$filter = " profession='".$speciality."'";
	$msg .= "Специальность: ".$speciality;
}
elseif($salesId == 0 && $workplaceId != 0 && $specialityId == 0)
{
	$filter = " doctor.WorkPlaceId='".$workplaceId."'";
	$msg .= "Местo работы: ".$workplace;
}
elseif($salesId == 0 && $workplaceId !=0 && $specialityId != 0)
{
	$filter = " doctor.WorkPlaceId='".$workplaceId."' AND profession='".$speciality."'";
	$msg .= "Местo работы: ".$workplace.", Специальность: ".$speciality;
}
elseif($salesId != 0 && $workplaceId == 0 && $specialityId == 0)
{
	$filter = " sales_id='".$salesId."'";
	$msg .= "Sales: ".$sales;
}
elseif($salesId != 0 && $workplaceId == 0 && $specialityId != 0)
{
	$filter = " sales_id='".$salesId."' AND profession='".$speciality."'";
	$msg .= "Sales: ".$sales.", Специальность: ".$speciality;
}
elseif($salesId != 0 && $workplaceId != 0 && $specialityId == 0)
{
	$filter = " sales_id='".$salesId."' AND doctor.WorkPlaceId='".$workplaceId."'";
	$msg .= "Sales: ".$sales.", Местo работы: ".$workplace;
}
elseif($salesId != 0 && $workplaceId != 0 && $specialityId != 0)
{
	$filter = " sales_id='".$salesId."' AND doctor.WorkPlaceId='".$workplaceId."' AND profession='".$speciality."'";
	$msg .= "Sales: ".$sales.", Местo работы: ".$workplace.", Специальность: ".$speciality;
}

//when generalSelection is selected
//Все доктора
if($generalSelectionId == 1)
{
	$filter = " 1";
	$msg .= "Все доктора";
}
//Все активные доктора
elseif($generalSelectionId == 2)
{
	$filter = " active='1'";
	$msg .= "Все активные доктора";
}
//Все не активные доктора
elseif($generalSelectionId == 3)
{
	$filter = " active='0'";
	$msg .= "Все не активные доктора";
}


$msg.= '
		</h3>
	</caption>
	<thead>
		<th scope="col">#</th>
		<!--DoctorId-->
		<th scope="col">Код доктора</th>
		<!--FirstName-->
		<th scope="col">FirstName</th>
		<!--LastName-->
		<th scope="col">LastName</th>
		<!--MidName-->
		<th scope="col">MidName</th>
		<!--personality_type-->
		<th scope="col">Тип личности</th>
		<!--loyalty-->
		<th scope="col">Лояльность</th>
		<!--BirthDate-->
		<th scope="col">BirthDate</th>
		<!--Discount-->
		<th scope="col">Discount</th>
		<!--Phone1-->
		<th scope="col">Phone1</th>
		<!--Phone2-->
		<th scope="col">Phone2</th>
		<!--Phone3-->
		<th scope="col">Mail</th>
		<!--WorkPlaceDesc-->
		<th scope="col">WorkPlaceDesc</th>
		<!--Comment-->
		<th scope="col">Login</th>
		<!--wp-->
		<th scope="col">Password</th>
		<!--sales-->
		<th scope="col">sales</th>
		<!--profession-->
		<th scope="col">Специальность</th>
		<!--active-->
		<th scope="col">active</th>
	</thead>
	<tbody>
';

$sql = "
SELECT * FROM doctor 
LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId 
LEFT JOIN sales ON doctor.sales_id = sales.salesId 
WHERE ".$filter;
//var_dump($sql);
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
			<td>'.$row["DoctorId"].'</td>
			<td>'.$row["FirstName"].'</td>
			<td>'.$row["LastName"].'</td>
			<td>'.$row["MidName"].'</td>
			<td>'.$row["personality_type"].'</td>
			<td>'.$row["loyalty"].'</td>
			<td>'.$row["BirthDate"].'</td>
			<td>'.$row["Discount"].'</td>
			<td>'.$row["Phone1"].'</td>
			<td>'.$row["Phone2"].'</td>
			<td>'.$row["Phone3"].'</td>
			<td>'.$row["WorkPlaceDesc"].'</td>
			<td>'.$row["Comment"].'</td>
			<td>'.$row["wp"].'</td>
			<td>'.$row["salesName"].'</td>
			<td>'.$row["profession"].'</td>
			<td>
		';
		if($row["active"] == 1) $msg.='active';
		else if($row["active"] == 0) $msg.='not active';
		$msg.= '
			</td>
		</tr>
		';
	}
	if($i == 0)
	{
		$msg .= '
			<tr>
				<td>По данной выборке ничего не найдено.</td>
			</tr>
		';
		header("Content-Disposition: attachement; filename=doctors.xls");
		echo $utf8_bom.$msg;
		return;
	}
}
else
{
	$msg .='
		<tr>
			<td>Сделайте выборку с помощью фильтров sales, мест работы и специальности или же выберите конкретного доктора с помощью поиска докторов.</td>
		</tr>
	';
	echo $msg;
	return;
}

$msg.='
	</tbody>
</table>
';
header("Content-Disposition: attachement; filename=doctors.xls");
echo $utf8_bom.$msg;
?>