<?php setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");

function clean($value = "") {/*функция для очистки данных от HTML и PHP тегов*/
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

include "db.php";

$email = $_POST['femail'];
$password = $_POST['fpassword'];

$email = clean($email);
$password = clean($password);

$password=md5($password);	

$query ="SELECT id_user, aes_decrypt( mail_user, '123456' ) AS mail FROM mg_user WHERE aes_decrypt( mail_user, '123456' )='$email'";
		$rez= mysql_query($query);
		$roz = mysql_fetch_array($rez);
		if ($roz['mail']==$email)/*сравниваем введённый email c хранимым в БД*/
		{/*если такой e-mail есть, то сохраняем новый пароль*/
			$ins="IUPDATE mg_user SET password_user='$password' WHERE  aes_decrypt( mail_user, '123456' )='$email'";	
				mysql_query($ins);
			echo "<font color='blue'><b>Пароль изменён</b> </font><META HTTP-EQUIV='Refresh' CONTENT='1;  URL=../new_psw.php'>";
		}
		else
		{
		echo "<font color='red'><b>Такой E-mail не зарегистрирован </b></font> <br>
		<a href='../registr.php'> Регистрация </a>";
		}
?>