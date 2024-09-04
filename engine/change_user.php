<?php session_start(); setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");

function clean($value = "") {/*функция для очистки данных от HTML и PHP тегов*/
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

include "db.php";

$tel = $_POST['ftel'];
$email = $_POST['femail'];

$email = clean($email);

			$upd="Update mg_user SET phone_user=aes_encrypt('$tel','123456'),mail_user=aes_encrypt('$email','123456') WHERE id_user='".$_SESSION['id_user']."'";

				mysql_query($upd);
			echo "<font color='blue'><b>Ваши данные изменены</b></font><META HTTP-EQUIV='Refresh' CONTENT='1;  URL=cabinet.php'>";

?>