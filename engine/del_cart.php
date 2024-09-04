<?php session_start(); 
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
include "db.php";

$del="DELETE FROM mg_cart";
mysql_query($del);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../cart.php'>Все товары удалены из корзины";

?>
