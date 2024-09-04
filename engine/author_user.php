<?php session_start();
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
if (isset($_SESSION['login']) AND $_SESSION['login']<>"")
{echo "<META HTTP-EQUIV='Refresh' CONTENT='1;  URL=engine/cabinet.php'>";}
else
{	
include "db.php";
$password = $_POST['fpsw'];
$email = $_POST['feml'];
$password = md5($password);/*MD5 шифрование*/

$ws="SELECT password_user,id_user,name_user, surname_user,group_user, aes_decrypt( mail_user, '123456' ) AS mail FROM mg_user WHERE aes_decrypt( mail_user, '123456' )='$email'";
$ws_ex= mysql_query($ws);
$ws_p = mysql_fetch_array($ws_ex);
if ($ws_p['mail']<>$email)
{
echo  "<div class='red' ><b>Email не зарегистрирован </b></div>";
}
else{
	if ($ws_p['password_user']<>$password )
	{
			echo  "<div class='red' ><b>Пароль неверный</b></div>";
	}				
	else
	{
			/*Сохраняем переменные сессии*/
			 $_SESSION['login'] = $ws_p['mail'];
			 $_SESSION['id_user'] = $ws_p['id_user'];
			 $_SESSION['name_user'] = $ws_p['name_user'];
			 $_SESSION['surname_user'] = $ws_p['surname_user'];	
			 $_SESSION['group_user'] = $ws_p['group_user'];

			echo " <font color='blue'><b>Добро пожаловать в магазин MY-GIRO,<br>".$_SESSION['name_user']." ".$_SESSION['surname_user'].", ".$_SESSION['login']."!</b></font> <META HTTP-EQUIV='Refresh' CONTENT='1'>";
		}
	}
}

?>