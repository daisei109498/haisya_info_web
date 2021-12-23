<?php
header("Content-type: text/html; charset=utf-8");
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$jusyo = $_POST['jusyo'];

	$fname = "log_address.txt";//generates random name

	$file = fopen("/HTTPRoot/haisya/haisya_info/".$fname, 'a');//creates new file
	$csv = $jusyo.','.$lat.','.$lng;
	fwrite($file, $csv."\r\n");
	fclose($file);
?>