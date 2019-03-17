<?php
require_once('connect.php');

//Calibration SELECT `Calibration` FROM `reagent` WHERE `Calibration`='&nbsp;'
$sql = "UPDATE reagent SET Calibration='' WHERE Calibration='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "Calibration is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//Control SELECT `Control` FROM `reagent` WHERE `Control`='&nbsp;'
$sql = "UPDATE reagent SET Control='' WHERE Control='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "Control is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//ed_ismer SELECT `ed_ismer` FROM `reagent` WHERE `ed_ismer`='&nbsp;'
$sql = "UPDATE reagent SET ed_ismer='' WHERE ed_ismer='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "ed_ismer is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//probirka SELECT `probirka` FROM `reagent` WHERE `probirka`='&nbsp;'
$sql = "UPDATE reagent SET probirka='' WHERE probirka='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "probirka is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//gotovnost SELECT `gotovnost` FROM `reagent` WHERE `gotovnost`='&nbsp;'
$sql = "UPDATE reagent SET gotovnost='' WHERE gotovnost='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "gotovnost is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//srok_gotovnosti SELECT `srok_gotovnosti` FROM `reagent` WHERE `srok_gotovnosti`='&nbsp;'
$sql = "UPDATE reagent SET srok_gotovnosti='' WHERE srok_gotovnosti='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "srok_gotovnosti is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//gotovnostN SELECT `gotovnostN` FROM `reagent` WHERE `gotovnostN`='&nbsp;'
$sql = "UPDATE reagent SET gotovnostN='' WHERE gotovnostN='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "gotovnostN is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//probirka2 SELECT `probirka2` FROM `reagent` WHERE `probirka2`='&nbsp;'
$sql = "UPDATE reagent SET probirka2='' WHERE probirka2='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "probirka2 is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}

//probirka3 SELECT `probirka3` FROM `reagent` WHERE `probirka3`='&nbsp;'
$sql = "UPDATE reagent SET probirka3='' WHERE probirka3='&nbsp;'";
$result = mysqli_query($link,$sql);
if($result)
{
    echo "probirka3 is updated, affected ".mysqli_affected_rows($link)." rows<br/>";
}
?>