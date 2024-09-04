<?php  setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
include "db.php";
$id_product=$_POST['fid_product'];
$model = $_POST['fmodel'];
$price = $_POST['fprice'];
$color = $_POST['fcolor'];
$des = $_POST['fdes'];

$upd="UPDATE mg_product SET model='$model', price='$price',color='$color', descr_model='$des' WHERE id_product='$id_product'";

mysql_query($upd);
	echo "<font color='blue'><b>Данные отредактированы</b></font><META HTTP-EQUIV='Refresh' CONTENT='0; URL=edit_product_page.php?id_product=".$id_product."'>";

?>
