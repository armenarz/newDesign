<?php
header("Content-Type: application/xls");

require_once "../connect.php";
require_once "../authorization.php";

$utf8_bom = chr(239).chr(187).chr(191);

$msg = $utf8_bom;

if(!isset($_POST["startDate"]) || !isset($_POST["endDate"]))
{
    $msg .= "The reporting period is not defined.";
    echo $msg;
    return;
}
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];

$arr = array('Դրական/ positive/ положительный' => 'Դրական', 'Բացասական/ negative/ отрицательный' => 'Բացասական');

$msg.= '
<table class="table" border="1" id="reagentExpensesData">
	<thead>
		<tr>
			<th scope="col" class="text-left">Անուն</th>
			<th scope="col">Ազգանուն</th>
			<th scope="col" class="text-left">Ծննդյան ամսաթիվ</th>
			<th scope="col" class="text-left">ՀԾՀ</th>
			<th scope="col" class="text-left">Բարկոդ</th>
			<th scope="col" class="text-left">Ամսաթիվ</th>
			<th scope="col" class="text-left">Առաջադրանքի պատասխանի ամսաթիվ</th>
			<th scope="col" class="text-left">Թեստավորման պատասխան</th>
			<th scope="col" class="text-left">Թեստավորման ամսաթիվ</th>
			<th scope="col" class="text-left">Նմուշառման ամսաթիվ</th>
			<th scope="col" class="text-left">Կրկնակի թեստավորման տարբերություն</th>
			<th scope="col" class="text-left">Կրկնակի թեստավորում</th>
			<th scope="col" class="text-left">Ուղեգրող հաստատություն</th>
			<th scope="col" class="text-left">Գրանցման հասցե</th>
			<th scope="col" class="text-left">Բնակության հասցե</th>
			<!--Row number-->
			<th scope="col" class="text-left">Համար</th>
		</tr>
	</thead>
	<tbody>
	';
	
		$msg.= '';
		$sql = "SELECT 
					pacients.FirstName,
					pacients.LastName,
					pacients.birthday,
					pacients.dopolnitelno,
					orderresult.OrderId,
					orderresult.AnalysisResult
					FROM orderresult
					INNER JOIN orders ON orders.OrderId=orderresult.OrderId
					INNER JOIN pacients ON pacients.id=orders.pac_id
					WHERE orders.OrderDate >= '$startDate' and orders.OrderDate <= '$endDate'
						  AND orderresult.ReagentId = '1142' and orderresult.double_check = '1'						
					ORDER BY orderresult.OrderId";
		$res = mysqli_query($link,$sql);
		if($res)
		{
			while($row = mysqli_fetch_array($res))
			{
				$i++;
				$msg.= '
				<tr>
					<td class="text-left">'.$row["FirstName"].'</td>
					<td class="text-left">'.$row["LastName"].'</td>
					<td class="text-left">'.$row["birthday"].'</td>
					<td class="text-left">'.$row["dopolnitelno"].'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.$arr[$row["AnalysisResult"]].'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.'ՊՐՈՄ-ՏԷՍՏ ՍՊԸ'.'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.' '.'</td>
					<td class="text-left">'.$i.'</td>
				</tr>
				';
			}
		}
	
$msg.= '
	</tbody>
</table>
';

header("Content-Disposition: attachement; filename=ReagentExportReagentSars.xls");
echo $msg;
?>