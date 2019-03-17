<?php
///Fill Unicode(UTF-8) String With Non Break Space
function FillNonBreak($source,$maxSymbols,$direction = 0)
{
	$len = mb_strlen($source,'UTF-8');
	$delta = $maxSymbols - $len;
	$temp = "";
	for($i = 0; $i < $delta; $i++)
	{
		$temp.="&nbsp;";
	}
	if($direction == 0)
	{
		$temp.= $source;
	}
	else if($direction == 1)
	{
		$temp = $source.$temp;
	}
	return $temp;
}
?>