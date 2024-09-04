<?php session_start();header('Content-Type: text/html; charset= utf-8'); 
$idses=session_id();/*идентификатор сессии*/
include "db.php";
$delivery_address=$_POST['fdlv'];
if($delivery_address=="")
{$delivery_address="Самовывоз из магазина";}

$ch="Select * from mg_order";
$ch_ex=mysql_query($ch);
$ch_p=mysql_num_rows($ch_ex);/*определяем количество записей в таблице mg_order*/
if($ch_p==0) /*если таблица пустая*/
{$num_order=1;} /*присваиваем номер заказа 1*/
else
{/*находим последнюю запись в таблице*/
$lastnum="SELECT num_order FROM mg_order ORDER BY num_order DESC Limit 1";
$lastnum_ex=mysql_query($lastnum);
$lastnum_p=mysql_fetch_array($lastnum_ex);
$num_order=($lastnum_p['num_order']+1);/*увеличиваем номер заказа на 1*/
}
/*выбираем товары из козины mg_cart по идентификатору текущей сессии и переносим их в таблицу mg_order*/
$mov="Insert into mg_order (id_product, quantity, id_ses )
Select id_product, quantity, id_ses From mg_cart Where id_ses='$idses'";
mysql_query($mov);

/*дата заказа - текущая дата*/
$date_order=date("Y-m-d");

$upd="Update mg_order SET num_order='$num_order', id_user='".$_SESSION['id_user']."', date_order='$date_order', delivery_address='$delivery_address' WHERE id_ses='$idses'";
mysql_query($upd);

 /*очищаем корзину*/
$del="Delete from mg_cart WHERE id_ses='$idses'";
 mysql_query($del);
  /*удаляем идентификатор сессии из таблицы mg_order, тогда пользователь сможет сделать новый заказ в текущем сеансе работы*/
$upd_order="Update mg_order SET id_ses='' WHERE id_ses='$idses'";
mysql_query($upd_order);

 /*данные из таблицы mg_user*/
$lk="SELECT id_user, name_user, surname_user, aes_decrypt(phone_user,'123456') AS phone FROM mg_user WHERE id_user='".$_SESSION['id_user']."'";
$lk_ex=mysql_query($lk);
$lk_p=mysql_fetch_array($lk_ex);

echo "<p><font color='blue'><b>Заказ оформлен</b></font>
<br>Уважаемый ".$lk_p['name_user']." ".$lk_p['surname_user']."! Наши менеджеры свяжутся с Вами по указанному при регистрации телефону ".$lk_p['phone']."</p>
<p><a href='cabinet.php'>Перейти в личный кабинет </a><br><a href='../index.php'> На главную страницу</a></p>";



?>