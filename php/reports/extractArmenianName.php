<?php
function extarctArmenianName($name)
{
    // check if source string includes "-"character
    if(strpos($name,"-"))
    {
        // cleaning whitespace next to "-" character
        $temp = explode("-",$name);
        if(count($temp)>0)
        {
            $name = "";
            for($tempIndex = 0; $tempIndex < count($temp); $tempIndex++)
            {
                if($tempIndex > 0)
                {
                    $name .= trim($temp[$tempIndex]);
                }
                else
                {
                    $name .= "-".trim($temp[$tempIndex]);
                }
            }
        }
    }
    // separating by whitespace
    $temp = explode(" ",$name);
    if(count($temp) == 3)
    {
        return $temp[0];
    }
    elseif(count($temp) == 6)
    {
        return $temp[0]." ".$temp[1];
    }
    else
    {
        return $name;
    }
}

?>