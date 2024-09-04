<?php session_start(); 
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
include "db.php";

$model = $_POST['fmodel'];
$categ = $_POST['fcateg'];
$price = $_POST['fprice'];
$color = $_POST['fcolor'];
$des = $_POST['fdes'];

$ins="INSERT INTO mg_product VALUES ('', '$model', '$color', '$price',  '$des', '','0', '', '$categ')";
mysql_query($ins);
	echo "<font color='blue'><b>Товар добавлен в каталог</b></font><META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php'>";

?>
