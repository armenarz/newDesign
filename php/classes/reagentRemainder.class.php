<?php
class RemainderOfReagent //класс считающий количество остатка реагента на складе
{
	private $link;
	private $date;
	private $sklad_begin_date;
	private $reagid;
	private $sum_prixod;
	private $sum_vibros;
	private $sum_callibr;
	private $sum_control;
	private $sum_dilution;
	private $count_dilution_order;
	private $count_sklad;
	private $remainder;
	private $rasxod;
	private $expiration_date;
	private $reagent_Desc_Eng;
	private $reagent_Desc_Rus;
	public $reagent_expr1;
	public $reagent_expr2;
    public $reagent_expr3;
	private $ar_reag1 = array(601,603,607,605,621,615,609,611,7, 285, 530, 932, 239, 888, 378, 401, 402, 968, 411, 239, 794,   205, 206,  207,  208,  214,  220,  474); 
	private $ar_reag2 = array(760,762,764,766,768,770,772,774,453, 473, 532, 343, 283, 968, 380, 398, 399, 888, 377, 283, 222, 998, 1000, 1002, 1004, 1006, 1012, 1008);
	private $sum_prixod_dnja;
	private $lastInputProducerId;
	private $lastInputProducer;
	private $lastInputCatalogueNumberId;
	private $lastInputCatalogueNumber;

	function __construct($link, $reagid, $date)
	{
		$this->link = $link;
		$this->reagid = $reagid;
		$this->date = $date;
		$this->SetReagentExpr1();
		$this->SetReagentExpr2();
		$this->SetReagentExpr3();
		$this->SetBeginDate();
		$this->SetSumPrixod();
		$this->SetSumVibros();
		$this->SetSumCallibr();
		$this->SetSumControl();
		$this->SetSumDilution();
		$this->SetCountDilutionOrder();
		$this->SetCountSklad();
		$this->SetRasxod();
		$this->SetRemainder();
		$this->SetExpirationDate();
		$this->SetReagentDescEng();
		$this->SetReagentDescRus();
		$this->SetSumPrixodDnja();
		$this->SetLastInputProducerId();
		$this->SetLastInputProducer();
		$this->SetLastInputCatalogueNumberId();
		$this->SetLastInputCatalogueNumber();
	}
	
	function GetSumPrixodDnja()
	{
		return $this->sum_prixod_dnja;
	}
	protected function SetSumPrixodDnja()
	{
		$sql = "SELECT 
					SUM(prixod_count) AS sum_prixod 
				FROM prixod
				WHERE ".$this->reagent_expr1." AND DATE(prixod_date)='".$this->date."'";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->sum_prixod_dnja=$row["sum_prixod"];
		}
		else $this->sum_prixod_dnja=0;
	}
	
	function SetReagentExpr1()
	{
		for($i=0;$i<count($this->ar_reag1);$i++)
		{
		   if($this->reagid==$this->ar_reag1[$i])
		   {
		   $this->reagent_expr1='(reagid='.$this->reagid.' or reagid='.$this->ar_reag2[$i].')';
		   return;
		   }
		}
		
		if($this->reagid==878)
		{
			$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=880 or reagid=882)';
		   return;
		}		
		
		if($this->reagid==94)
		{
		$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=441 or reagid=461)';
		   return;
		}
		
		if($this->reagid==227)
		{
		$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=442 or reagid=463)';
		   return;
		}
		
		if($this->reagid==108)
		{
		$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=443 or reagid=465)';
		   return;
		}
		if($this->reagid==343)
		{
		$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=864)';
		   return;
		}
		if($this->reagid==250)
		{
			$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=373 or reagid=866)';
		   return;
		}	
		if($this->reagid==295)
		{
		$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=940)';
		   return;
		}

        if($this->reagid==237)
		{
		$this->reagent_expr1='(reagid='.$this->reagid.' or reagid=790 or reagid=832 or reagid=868)';
		   return;
		}
		
		$this->reagent_expr1='reagid='.$this->reagid;
		
	}
	function SetReagentExpr2()
	{
		for($i=0;$i<count($this->ar_reag1);$i++)
		{
		   if($this->reagid==$this->ar_reag1[$i])
		   {
		   $this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid='.$this->ar_reag2[$i].')';
		   return;
		   }
		}

		if($this->reagid==878)
		{
		$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=880 or reagentid=882)';
		   return;
		}
		
		if($this->reagid==94)
		{
		$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=441 or reagentid=461)';
		   return;
		}
		
		if($this->reagid==227)
		{
		$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=442 or reagentid=463)';
		   return;
		}
		
		if($this->reagid==108)
		{
		$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=443 or reagentid=465)';
		   return;
		}
		if($this->reagid==343)
		{
			$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=864)';
		   	return;
		}
		if($this->reagid==250)
		{
			$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=373 or reagentid=866)';
		   	return;
		}
		if($this->reagid==295)
		{
			$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=940)';
		   	return;
		}

        if($this->reagid==237)
		{
			$this->reagent_expr2='(reagentid='.$this->reagid.' or reagentid=790 or reagentid=832 or reagentid=868)';
		   	return;
		}
		
		$this->reagent_expr2='reagentid='.$this->reagid;
	}
	function SetReagentExpr3()
	{
		for($i=0;$i<count($this->ar_reag1);$i++)
		{
		   if($this->reagid==$this->ar_reag1[$i])
		   {
		   $this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid='.
		   $this->ar_reag2[$i].')';
		   return;
		   }
		}

		if($this->reagid==878)
		{
		$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=880 or
		orderresult.reagentid=882)';
		   return;
		}
		
		if($this->reagid==94)
		{
		$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=441 or
		orderresult.reagentid=461)';
		   return;
		}
		
		if($this->reagid==227)
		{
		$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=442 or
		orderresult.reagentid=463)';
		   return;
		}
		
		if($this->reagid==108)
		{
		$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=443 or
		orderresult.reagentid=465)';
		   return;
		}
		if($this->reagid==343)
		{
			$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=864)';
		   	return;
		}
		if($this->reagid==250)
		{
			$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=373 or orderresult.reagentid=866)';
		   	return;
		}
		if($this->reagid==295)
		{
			$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=940)';
		   	return;
		}

        if($this->reagid==237)
		{
			$this->reagent_expr3='(orderresult.reagentid='.$this->reagid.' or orderresult.reagentid=790 or orderresult.reagentid=832 or orderresult.reagentid=868)';
		   	return;
		}
		
		$this->reagent_expr3='orderresult.reagentid='.$this->reagid;
	}
	function GetBeginDate()
	{
		return $this->sklad_begin_date;
	}
	protected function SetBeginDate()
	{
		$sql = "SELECT 
					sklad_beg_date 
				FROM sklad_begin
				WHERE sklad_beg_date<'".$this->date."'
				GROUP BY sklad_beg_date
				ORDER BY sklad_beg_date DESC LIMIT 1";
				$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->sklad_begin_date = $row["sklad_beg_date"];
		}
	}
	function GetSumPrixod()
	{
		return $this->sum_prixod;
	}
	protected function SetSumPrixod()
	{
		$sql = "SELECT 
					SUM(prixod_count) AS sum_prixod 
				FROM prixod
				WHERE ".$this->reagent_expr1." AND prixod_date>='".$this->sklad_begin_date."' AND prixod_date<=CONCAT( ('".$this->date." ' + interval 1 day),'00:00:00' )";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->sum_prixod=$row["sum_prixod"];
		}
		else $this->sum_prixod=0;	
	}
	function GetSumVibros()
	{
		return $this->sum_vibros;
	}
	protected function SetSumVibros()
	{
		$sql = "SELECT 
					SUM(vibros_count) AS sum_vibros 
				FROM vibros
				WHERE ".$this->reagent_expr1." AND vibros_date>='".$this->sklad_begin_date."' AND vibros_date<=CONCAT( ('".$this->date." ' + interval 1 day),'00:00:00' )";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->sum_vibros=$row["sum_vibros"];
		}
		else $this->sum_vibros=0;
	}
	function GetSumCallibr()
	{
		return $this->sum_callibr;
	}
	protected function SetSumCallibr()
	{
		$sql = "SELECT 
					SUM(callibr_count) AS sum_callibr 
				FROM callibration
				WHERE ".$this->reagent_expr2." AND dttime>='".$this->sklad_begin_date."' AND dttime<=CONCAT( ('".$this->date." ' + interval 1 day),'00:00:00' )";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->sum_callibr=$row["sum_callibr"];
		}
		else $this->sum_callibr=0;
	}
	function GetSumControl()
	{
		return $this->sum_control;
	}
	protected function SetSumControl()
	{
		$sql = "SELECT 
					SUM(control_count) AS sum_control 
				FROM control
				WHERE ".$this->reagent_expr2." AND dttime>='".$this->sklad_begin_date."' AND dttime<=CONCAT( ('".$this->date." ' + interval 1 day),'00:00:00' )";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->sum_control=$row["sum_control"];
		}
		else $this->sum_control=0;
	}
	function GetSumDilution()
	{
		return $this->sum_dilution;
	}
	protected function SetSumDilution()
	{
		$sql = "SELECT 
					SUM(dil_count) AS sum_dilution 
				FROM dilution
				WHERE ".$this->reagent_expr2." AND dttime>='".$this->sklad_begin_date."' AND dttime<=CONCAT( ('".$this->date." ' + interval 1 day),'00:00:00' )";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->sum_dilution = $row["sum_dilution"];
		}
		else $this->sum_dilution = 0;
	}
	function GetCountDilutionOrder()
	{
		return $this->count_dilution_order;
	}
	protected function SetCountDilutionOrder()
	{
		$sql ="	SELECT 
					COUNT( * ) AS count_dilution_order 
				FROM (
					SELECT 
						orders.OrderId 
					FROM orders
					INNER JOIN orderresult ON orders.OrderId = orderresult.OrderId
					WHERE ".$this->reagent_expr3." AND orders.OrderDate >= '".$this->sklad_begin_date."' AND orders.OrderDate <= CONCAT( ('".$this->date."' + INTERVAL 1 DAY), '00:00:00' )
					 ) AS T";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->count_dilution_order=$row["count_dilution_order"];
			
			$sql2 = "SELECT 
						COUNT(ReagentOrderId) AS cnt 
					FROM orderresult
			        INNER JOIN orders ON orderresult.OrderId = orders.OrderId
			        WHERE ReagentId = '$reagid' AND srochno = '1' AND OrderDate <= CONCAT( ('".$this->date."' + INTERVAL 1 DAY), '00:00:00' )";
			$result2 = mysqli_query($this->link, $sql2);
			if($result2)
			{
				$row2 = mysqli_fetch_array($result2); 
				$cnt1 = $row["cnt"];
			}
			$cnt = ($cnt1 * 2) / 3;
			$this->count_dilution_order = $this->count_dilution_order - $cnt;
		}
		else $this->count_dilution_order=0;
		
	}
	function GetCountSklad()
	{
		return $this->count_sklad;
	}
	protected function SetCountSklad()
	{
		$sql = "SELECT 
					count 
				FROM sklad_begin
				WHERE ".$this->reagent_expr2." AND sklad_beg_date='".$this->sklad_begin_date."'";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->count_sklad = $row["count"];
		}
		else $this->count_sklad = 0;		
	}
	function GetRasxod()
	{
		return $this->rasxod;
	}
	protected function SetRasxod()
	{
		 $this->rasxod = $this->sum_callibr + $this->sum_control + $this->sum_dilution + $this->count_dilution_order;
	}
	function CorrectRasxod($i)
	{
		$this->rasxod += $i;
		$this->SetRemainder();
	}
	function GetRemainder()
	{
		return $this->remainder;
	}
	protected function SetRemainder()
	{
		$this->remainder = $this->count_sklad + $this->sum_prixod - $this->sum_vibros - $this->rasxod;
	}
	function GetExpirationDate()
	{
		return $this->expiration_date;
	}
	protected function SetExpirationDate()
	{
		$sql = "SELECT 
					srok_godnosti 
				FROM prixod
				WHERE ".$this->reagent_expr1."
				ORDER BY prixod_date
				DESC Limit 0,1";
		
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->expiration_date = $row["srok_godnosti"];
		}
		else $this->expiration_date = "0000-00-00";
	}
	function GetReagentDescEng()
	{
		return $this->reagent_Desc_Eng;
	}
	protected function SetReagentDescEng()
	{
		$sql ="	SELECT 
					ReagentDesc 
				FROM reagent
				WHERE ReagentId=".$this->reagid;
		
		$result = mysqli_query($this->link,$sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->reagent_Desc_Eng = $row["ReagentDesc"];
		}
		else $this->reagent_Desc_Eng = "";
	}	
	function GetReagentDescRus()
	{
		return $this->reagent_Desc_Rus;
	}
	protected function SetReagentDescRus()
	{
		$sql ="	SELECT 
					ReagentDescRus 
				FROM reagent
				WHERE ReagentId=".$this->reagid;
		
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result); 
			$this->reagent_Desc_Rus = $row["ReagentDescRus"];
		}
		else $this->reagent_Desc_Rus = "";
	}
	protected function SetLastInputProducerId()
	{	
		$sql = "SELECT 
					producerId 
				FROM prixod 
				WHERE reagid=".$this->reagid." 
				ORDER BY prixod_date DESC 
				LIMIT 1 ";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result);
			$this->lastInputProducerId = $row["producerId"];
			if($this->lastInputProducerId == null)$this->lastInputProducerId = -1;
		}
	}
	function GetLastInputProducerId()
	{
		return $this->lastInputProducerId;
	}
	protected function SetLastInputProducer()
	{		
		$sql = "SELECT 
					producerName 
				FROM producers 
				WHERE id=".$this->GetLastInputProducerId();
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result);
			$this->lastInputProducer = $row["producerName"];
		}
	}

	function GetLastInputProducer()
	{
		return $this->lastInputProducer;
	}
	protected function SetLastInputCatalogueNumberId()
	{
		$sql = "SELECT 
					catalogueNumberId 
				FROM prixod 
				WHERE reagid=".$this->reagid." 
				ORDER BY prixod_date DESC 
				LIMIT 1 ";
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result);
			$this->lastInputCatalogueNumberId = $row["catalogueNumberId"];
			if($this->lastInputCatalogueNumberId == null)$this->lastInputCatalogueNumberId = -1;
		}
	}
	function GetLastInputCatalogueNumberId()
	{
		return $this->lastInputCatalogueNumberId;
	}
	protected function SetLastInputCatalogueNumber()
	{
		$sql = "SELECT 
					catalogueNumber 
				FROM catalogue_number 
				WHERE id=".$this->GetLastInputCatalogueNumberId();
		$result = mysqli_query($this->link, $sql);
		if($result)
		{
			$row = mysqli_fetch_array($result);
			$this->lastInputCatalogueNumber = $row["catalogueNumber"];
		}
	}
	function GetLastInputCatalogueNumber()
	{
		return $this->lastInputCatalogueNumber;
	}
}
?>