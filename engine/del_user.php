<?php session_start(); 
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
include "db.php";
$id_user = $_POST['fiduser'];

$del1="DELETE FROM mg_user WHERE id_user='$id_user'";
mysql_query($del1);
$del2="DELETE FROM mg_order WHERE id_user='$id_user'";
mysql_query($del2);
$del3="DELETE FROM mg_return WHERE id_user='$id_user'";
mysql_query($del3);
session_destroy();
unset ($_SESSION['login']);
	
	echo "<font color='blue'><b>Ваш аккаунт удалён</b> </font><META HTTP-EQUIV='Refresh' CONTENT='1;  URL=../index.php'>";


?>
