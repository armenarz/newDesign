<?php
function ConcatWithBrackets($firstString, $secondString, $contractionSize = 20)
{
    $tempFirstString = "";
    if(mb_strlen($firstString,'UTF-8') > $contractionSize) $tempFirstString = mb_substr($firstString, 0, $contractionSize,'UTF-8')."&hellip;";
    else $tempFirstString = $firstString;
    
    $tempSecondString = "";
    if(mb_strlen($secondString,'UTF-8') > $contractionSize) $tempSecondString = mb_substr($secondString, 0, $contractionSize,'UTF-8')."&hellip;";
    else $tempSecondString = $secondString;
    
    return $tempFirstString." [ ".$tempSecondString." ]";
}
?>