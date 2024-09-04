<?php
$link = mysql_connect('localhost', 'mygiro', '123456')
or die("Невозможно подключение к серверу, попробуйте позже: " . mysql_error());
mysql_select_db('mygiro', $link) or die ('Невозможно соединение с базой данных, попробуйте позже : ' . mysql_error());

?>
