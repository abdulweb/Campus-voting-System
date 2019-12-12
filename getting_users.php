<?php
/**
 * Created by PhpStorm.
 * User: Ummu Abdullaah
 * Date: 10/18/2017
 * Time: 3:52 PM
 */
require 'admin/inc/connect.inc.php';
$out = '';
$sql = "Select * from aspirant";
$res = mysqli_query($cn, $sql);
$n = mysqli_num_rows($res);
if ($n<0) {
	$out = "item not fetech";
}
else{

while($row = mysqli_fetch_assoc($res)){
   $out .= '<li>'. $row['full_name'] '</li>';
}
echo $out;
}