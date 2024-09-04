<?php session_start(); 
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
include "db.php";
$id_product = $_POST['id_product'];
$id_ses=$_POST['ids'];

$ins="INSERT INTO mg_cart VALUES ('', '$id_ses', '$id_product',  '1')";
mysql_query($ins);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../cart.php'>";

?>
