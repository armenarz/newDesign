<?php
$msg = '
<!-- Old site compatability variables -->
<input type="hidden" name="uu" value="'.$uu.'"/>
<input type="hidden" name="num" value="'.$num.'"/>
<input type="hidden" name="num_pac" value="'.$num_pac.'"/>

<!-- New variables -->
<input type="hidden" id="user_id" name="user_id" value="'.$userId.'"/>
<input type="hidden" id="current_doc" name="current_doc" value="'.$_SERVER['PHP_SELF'].'"/>
<input type="hidden" id="reagent_id" name="reagent_id"/>
<input type="hidden" id="doctor_id" name="doctor_id"/>
<input type="hidden" id="preorder_id" name="preorder_id"/>';

echo $msg;
?>