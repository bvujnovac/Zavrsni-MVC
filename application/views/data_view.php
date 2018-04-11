<?php
/**
 * Created by PhpStorm.
 * User: beni
 * Date: 07.04.18.
 * Time: 11:51
 */
header('Content-Type: text/javascript');

$temp = json_encode($temperature);
$lig = json_encode($light);
$mois = json_encode($moist);
$phval = json_encode($phvalue);
?>
var temperature = JSON.parse('<?php echo $temp ?>');
var light = JSON.parse('<?php echo $lig ?>');
var moist = JSON.parse('<?php echo $mois ?>');
var phvalue = JSON.parse('<?php echo $phval ?>');