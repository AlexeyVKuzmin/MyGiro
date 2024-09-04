<?php session_start(); 
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
include "db.php";
$id_product = $_POST['fidprod'];
$pic = $_POST['fpic'];
$fld = $_POST['ffld'];

if (!empty($pic)){
$filepath = "../images/".$fld."/".$pic;
unlink($filepath);
}

$del="DELETE FROM mg_product WHERE id_product='$id_product'";

mysql_query($del);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=index.php'>Товар удалён из каталога";

?>
