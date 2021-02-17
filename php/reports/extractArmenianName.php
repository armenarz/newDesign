<?php 
//header('Content-Type: text/html; charset=utf-8');
//$str = "Tudorica- Cristinel Տուդորիկա- Քրիստինել Tudorica- Cristinel";
//$str = "Tudorica- Cristinel Տուդորիկա- Քրիստինել Тудорика- Кристинел";
//$str = "Tudorica- Cristinel ";
//$str = "---- Տուդորիկա- Քրիստինել";
//echo $str."<br>";
//echo "extarctArmenianName(str)=".extarctArmenianName($str)."<br>";


function extarctArmenianName($name)
{
    // replacing 3 whitespaces with one
    $name = str_replace("   "," ", $name);
    
    // replacing 2 whitespaces with one
    $name = str_replace("  "," ", $name);
    
    // cleaning whitespaces around the dashes
    $name = str_replace(" -" , "-" , $name);

    $name = str_replace("- " , "-" , $name);

    // separating by whitespace
    $temp = explode(" ",$name);
   
    $name_am = "";
    $name_en = "";
    $name_ru = "";
   
    for($i = 0; $i < count($temp); $i++)
    {
        $temp[$i] = trim($temp[$i]);
        // if text is armenian
        if(preg_match('/[Ա-Ֆա-ֆ]/u', $temp[$i]))
        {
            $name_am .= $temp[$i]." ";
        }
        // if text is english
        if(preg_match('/[A-Za-z]/u', $temp[$i]))
        {
            $name_en .= $temp[$i]." ";
        }
        // if text is russian
        if(preg_match('/[А-Яа-яЁё]/u', $temp[$i]))
        {
            $name_ru .= $temp[$i]." ";
        }
    }

    $name_am = trim($name_am);
    $name_en = trim($name_en);
    $name_ru = trim($name_ru);
    if($name_am != "")
    {
        $name = $name_am;
    }
    elseif($name_en != "")
    {
        $name = $name_en;
    }
    else
    {
        $name = $name_ru;
    }
    
    return $name;
}

?>