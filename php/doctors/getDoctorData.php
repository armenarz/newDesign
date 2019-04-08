<?php
require_once "../connect.php";
require_once "../authorization.php";

$msg = "";
$filter = "";
//getting salesId
if(isset($_POST["salesId"]))
{
	$salesId = $_POST["salesId"];
}
else
{
	$msg = "Код salesId отсутствует";
	echo $msg;
	return;
}
//getting workplaceId
if(isset($_POST["workplaceId"]))
{
	$workplaceId = $_POST["workplaceId"];
}
else
{
	$msg = "Код места работы отсутствует.";
	echo $msg;
	return;
}
$speciality = "";
//getting specialityId
if(isset($_POST["specialityId"]))
{
	$specialityId = $_POST["specialityId"];
	$sql = "SELECT MethodId, Method FROM profession WHERE MethodId='".$specialityId."'";
	$result = mysqli_query($link,$sql);

	if($result)
	{
		$row = mysqli_fetch_array($result);
		$speciality = $row["Method"];
	}
}
else
{
	$msg = "Код специальности отсутствует.";
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

//getting doctorId
if(isset($_POST["doctorId"]))
{
	$doctorId = $_POST["doctorId"];
}
else
{
	$msg = "Код доктора отсутствует";
	echo $msg;
	return;
}

$filter = "";

if($salesId != 0 || $workplaceId != 0 || $specialityId != 0)
{
	if($salesId == 0 && $workplaceId == 0 && $specialityId == 0)
	{
		$filter = "";
	}
	elseif($salesId == 0 && $workplaceId == 0 && $specialityId != 0)
	{
		$filter = " profession='".$speciality."'";
	}
	elseif($salesId == 0 && $workplaceId != 0 && $specialityId == 0)
	{
		$filter = " doctor.WorkPlaceId='".$workplaceId."'";
	}
	elseif($salesId == 0 && $workplaceId !=0 && $specialityId != 0)
	{
		$filter = " doctor.WorkPlaceId='".$workplaceId."' AND profession='".$speciality."'";
	}
	elseif($salesId != 0 && $workplaceId == 0 && $specialityId == 0)
	{
		$filter = " sales_id='".$salesId."'";
	}
	elseif($salesId != 0 && $workplaceId == 0 && $specialityId != 0)
	{
		$filter = " sales_id='".$salesId."' AND profession='".$speciality."'";
	}
	elseif($salesId != 0 && $workplaceId != 0 && $specialityId == 0)
	{
		$filter = " sales_id='".$salesId."' AND doctor.WorkPlaceId='".$workplaceId."'";
	}
	elseif($salesId != 0 && $workplaceId != 0 && $specialityId != 0)
	{
		$filter = " sales_id='".$salesId."' AND doctor.WorkPlaceId='".$workplaceId."' AND profession='".$speciality."'";
	}
}
/* else if($doctorId != 0)
{
	$filter = " DoctorId='".$doctorId."'";
	$sql = "SELECT * FROM doctor WHERE ".$filter;
	$result = mysqli_query($link,$sql);
	
	if(result)
	{
		$row = mysqli_fetch_array($result,MYSQL_ASSOC);
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
			$msg.='
			<tr>
				<td><strong>'.$key.'</strong></td>
				<td>'.$value.'</td>
			</tr>
			';
		}	
		$msg.= '
			</tbody>
		</table>';
		echo $msg;
		return;
	}
} */
else if($generalSelectionId != 0)
{
	//Все докторы
	if($generalSelectionId == 1)
	{
		$filter = "1";
	}
	//Все активные докторы
	elseif($generalSelectionId == 2)
	{
		$filter = " active='1'";
	}
	//Все неактивные докторы
	elseif($generalSelectionId == 3)
	{
		$filter = " active='0'";
	}
}

$msg.= '
<table class="table table-bordered table-hover table-responsive">
	<thead>
		<th scope="col"></th>
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
		<th scope="col">BirthDate&nbsp;&nbsp;</th>
		<!--Discount-->
		<th scope="col">Discount</th>
		<!--Phone1-->
		<th scope="col">Phone1</th>
		<!--Phone2-->
		<th scope="col">Phone2</th>
		<!--Phone3-->
		<th scope="col">Mail</th>
		<!--WorkPlaceDesc-->
		<th scope="col">WorkPlaceDesc&nbsp;&nbsp;&nbsp;</th>
		<!--Comment-->
		<th scope="col">Login</th>
		<!--wp-->
		<th scope="col">Password</th>
		<!--sales-->
		<th scope="col">sales</th>
		<!--Специальность-->
		<th scope="col">Специальность</th>
		<!--active-->
		<th scope="col">active</th>
	</thead>
	<tbody>
';

//$sql = "SELECT * FROM doctor WHERE ".$filter;
$sql = "
SELECT * FROM doctor 
LEFT JOIN cworkplace ON doctor.WorkPlaceId = cworkplace.WorkPlaceId 
LEFT JOIN sales ON doctor.sales_id = sales.salesId 
WHERE ".$filter;

$result = mysqli_query($link,$sql);
if($result)
{
	$i = 0;
	while($row = mysqli_fetch_array($result))
	{
		$i++;

		$msg.= '
		<tr id="r_'.$row["DoctorId"].'">
			<td><input type="radio" name="radioDoctor" value="'.$row["DoctorId"].'" aria-label="Выберите доктора"></td>
			<td scope="row"><strong>'.$i.'</strong></td>
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
		Сделайте выборку с помощью фильтров Sales, Мест работы и Специальности, общей выборки или же выберите конкретный доктор с помощью фильтра докторов.
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