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

$name = $_POST['fnm'];
$lastname = $_POST['fsn'];
$tel = $_POST['ftel'];
$email = $_POST['femail'];
$password = $_POST['fpassword'];
$date_reg=date("Y-m-d");

$name = clean($name);
$lastname = clean($lastname);
$middlename = clean($middlename);
$email = clean($email);
$password = clean($password);

$password=md5($password);	

$query ="SELECT id_user, aes_decrypt( mail_user, '123456' ) AS mail FROM mg_user WHERE aes_decrypt( mail_user, '123456' )='$email'";
		$rez= mysql_query($query);
		$roz = mysql_fetch_array($rez);
		if ($roz['mail']!=$email)/*сравниваем введённый email c хранимым в БД*/
		{/*если такого e-mail нет, то регистрируем пользователя*/
			$ins="INSERT INTO mg_user VALUES('', '$name','$lastname',aes_encrypt('$tel','123456'),aes_encrypt('$email','123456'),'$password', '$date_reg','0')";	
				mysql_query($ins);
			echo "<font color='blue'><b>Вы успешно зарегистрированы.</b> </font><META HTTP-EQUIV='Refresh' CONTENT='1;  URL=../registr.php'>";
		}
		else
		{
		echo "<font color='red'><b>E-mail уже зарегистрирован </b></font>";
		}
?>