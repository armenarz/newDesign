<?php
require_once "../connect.php";
require_once "../authorization.php";

if(isset($_POST["reagent_id"])) $reagent_id = $_POST["reagent_id"];
$sql = "SELECT * FROM reagent WHERE ReagentId='".$reagent_id."'";
$result = mysqli_query($link,$sql);
if($result)
{
    $row = mysqli_fetch_array($result);
    $ReagentDesc = $row["ReagentDesc"];
    $ReagentDescRus = $row["ReagentDescRus"];
    $ReagentDescArm = $row["ReagentDescArm"];
}
//<!-- BEGIN HTML Markup -->
$msg =  '';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="ReagentIdDelete">ReagentId</label>';
$msg .=                 '<input type="text" id="ReagentIdDelete" class="form-control" placeholder="ReagentId" name="ReagentIdDelete" readonly value="'.$reagent_id.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="ReagentDescDelete">ReagentDesc</label>';
$msg .=             '<input type="text" id="ReagentDescDelete" class="form-control" placeholder="ReagentDesc" name="ReagentDescDelete" readonly value="'.$ReagentDesc.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="ReagentDescRusDelete">ReagentDescRus</label>';
$msg .=             '<input type="text" id="ReagentDescRusDelete" class="form-control" placeholder="ReagentDescRus" name="ReagentDescRusDelete" readonly value="'.$ReagentDescRus.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';
$msg .= '<div class="row">';
$msg .=     '<div class="col">';
$msg .=         '<div class="form-group d-print-none">';
$msg .=             '<label for="ReagentDescArmDelete">ReagentDescArm</label>';
$msg .=             '<input type="text" id="ReagentDescArmDelete" class="form-control" placeholder="ReagentDescArm" name="ReagentDescArmDelete" readonly value="'.$ReagentDescArm.'">';
$msg .=         '</div>';
$msg .=     '</div>';
$msg .= '</div>';

echo $msg;
//<!-- END Tabs HTML Markup -->
?>
