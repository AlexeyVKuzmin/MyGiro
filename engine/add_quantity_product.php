<?php session_start(); 
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
include "db.php";
$id_basket = $_POST['fid_basket'];
$quantity = $_POST['fquantity'];

$upd="UPDATE mg_cart SET quantity='$quantity' WHERE id_basket='$id_basket'";
mysql_query($upd);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../cart.php'>Количество товара изменено";

?>
