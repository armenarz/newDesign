<?php
function Shorten($sourceString, $shorteningSize = 40)
{
    $resultString = "";
    if(mb_strlen($sourceString,'UTF-8') > $shorteningSize) $resultString = mb_substr($sourceString, 0, $shorteningSize,'UTF-8')."&hellip;";
    else $resultString = $sourceString;
    
    return $resultString;
}
?>