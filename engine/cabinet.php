<?php session_start();header('Content-Type: text/html; charset= utf-8');
if ($_SESSION['login']=="")
	{
	echo "Необходимо авторизироваться! <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../index.php#main'>";
	}
if (isset($_GET['exit']))
	{
	session_destroy();
	unset ($_SESSION['login']);
	header('location:../index.php');
	}
	
	echo '<li><a href="?exit" class="active"><i class="fa fa-user fa-sm" aria-hidden="true" title="Выход"></i></li><font color="#fff" size="-1">'. $_SESSION['name_user'].'</font> </a>';
?>
<!doctype html>
<html lang="ru">
<head>
<title>MY-GIRO. Личный кабинет</title>
<meta charset="utf-8">
<!-- Для пропорционального изменения элементов на разных экранах-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Подключение файлов стилевого оформления-->
<link rel='stylesheet' href='../css/style.css'>
<link rel="stylesheet" href="../css/modal.css">
<link rel='stylesheet' href='../css/responsive.css'>
<!-- Подключение файлов шрифтов-->
<link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.css">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap" rel="stylesheet">
<!-- Подключение файла фавикон-->
<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/modal.js"></script>
<script src="../js/imask.js"></script>
</head>
<body>
<!-- Блок "top"-->
<div class="top" >
<div class="containertop">
<!-- Логотип и телефон-->
<img src="../images/logo.png"  id="logo" alt="logo"><span class="phone">
<i class="fa fa-phone green phn" aria-hidden="true"></i> 8-800-100-7724
</span>
<!-- Значок "гамбургер" для мобильных устройств и маленьких планшетов-->
         <label for="toggle-1" class="toggle-menu"><i class="toggle-icon"></i></label>
         <input type="checkbox" id="toggle-1">
<!-- Главное меню, классы необходимы для подсвечивания активных пунктов меню при прокрутке-->
<nav>

<ul  id="selmenu">
	<li ><a href="../index.php#main" class="hdr ">Главная</a></li>
	<li ><a href="../index.php#about" class="abt">О нас</a></li>
	<li ><a href="../index.php#delivery" class="dlv" >Условия доставки</a></li>
    <li ><a href="../index.php#catalog" class="cat">Каталог</a></li>
	<li ><a href="../index.php#contact" class="cont">Контакты</a></li>
	<li>
	<?php
if (isset($_SESSION['login']) AND $_SESSION['login']<>"")
{echo '<a href="?exit" class="active"><i class="fa fa-user" aria-hidden="true" title="Выход"></i><font color="#fff" size="-1"> '. $_SESSION['name_user'].'</font></a>';
}

	?>
	</li>
	<li><a href="../cart.php" ><i class="fa fa-shopping-basket " aria-hidden="true" title="Корзина" ></i></a> </li>
</ul>
</nav>
</div>
</div>
<!-- end блок "top"-->

<div  class="container mt-75 mb-50">
<h2> Личный кабинет </h2>
<div class="parent1">
<div class="div1"><?php
include "db.php"; /* подключение базы данных */ 
 /*данные из таблицы mg_user*/
$lk="SELECT id_user, name_user, surname_user, date_reg, aes_decrypt(phone_user,'123456') AS phone,aes_decrypt(mail_user,'123456') AS mail FROM mg_user WHERE id_user='".$_SESSION['id_user']."'";
$lk_ex=mysql_query($lk);
$lk_p=mysql_fetch_array($lk_ex);

$date_time_Obj = date_create($lk_p['date_reg']);/*для преобразования формата даты*/

echo "<b>".$lk_p['surname_user']." ".$lk_p['name_user']. "</b>
<br>  ".$lk_p['phone']."<br>".$lk_p['mail']. "
<br> Дата регистрации ".date_format($date_time_Obj,'d.m.Y');

echo"<p><a href='#' data-toggle='modal' data-nameus=".$lk_p['name_user']." data-surnameus=".$lk_p['surname_user']." > Редактировать личные данные</a></p>
<p><a href='#' data-toggle='modal_del' data-iduser=".$lk_p['id_user']." data-nus=".$lk_p['name_user']." data-surus=".$lk_p['surname_user']."> Удалить аккаунт </a></p>";?>
</div>
<div class="div2"><?php

$ch="Select * from mg_order WHERE id_user='".$_SESSION['id_user']."'";
$ch_ex=mysql_query($ch);
$ch_num=mysql_num_rows($ch_ex);/*определяем количество записей в таблице mg_order*/
if($ch_num==0)
{
	echo "<b>Вы не сделали ни одного заказа</b><div class='mt-50'><a href='../index.php#catalog'> Перейти в каталог</a></div>";
}
else {
	echo"<b>МОИ ЗАКАЗЫ</b><br><a href='../index.php#catalog'> Перейти в каталог товаров</a>";
	/*Выбираем номер заказа и дату заказа */
		$ord="Select DISTINCT num_order, date_order  from mg_order WHERE id_user='".$_SESSION['id_user']."'";
	$ord_ex=mysql_query($ord);
	echo "<table cellpadding='5' cellspacing='5' >";
	while($ord_p=mysql_fetch_array($ord_ex))
	{$date_time_Obj = date_create($ord_p['date_order']);/*для преобразования даты*/
	echo "<tr bgcolor='#d0d0d0'><td colspan='5'><font color='blue'><b>Заказ № ".$ord_p['num_order']." от ".date_format($date_time_Obj,'d.m.Y')."</b></font></td></tr><tr>";
		
      $mod_ord="Select model,pic_model,category, quantity from mg_order,mg_product WHERE mg_order.id_product=mg_product.id_product AND num_order='".$ord_p['num_order']."' AND id_user='".$_SESSION['id_user']."'";
	  $mod_ex=mysql_query($mod_ord);
while($mod_p=mysql_fetch_array($mod_ex))
	{if ($mod_p['category']=="gyro_scooter")
		{
		$ht="Гироскутер"; $fd="gyro_scooter";
		}
	elseif ($mod_p['category']=="electric_scooter")
		{
		$ht="Самокат"; $fd="electric_scooter";
		}
	elseif ($mod_p['category']=="segway")
		{
	$ht="Сигвей"; $fd="segway";
		}
		 echo "<td valign='center'><img src='../images/".$fd."/".$mod_p['pic_model']."' width='75vw'> ".$ht." ".$mod_p['model'].", ".$mod_p['quantity']." шт.</td>";
	}
echo "</tr>";	  
	  
    }
}
?>
</table>
</div>
</div>
</div>

<script>
  // создаём модальное окно для изменения персональных данных
   document.addEventListener('click', (e) => {
   const modal = new ItcModal();
   const btn = e.target.closest('[data-toggle="modal"]');
    if (btn) {
      modal.setTitle("<b>"+btn.dataset.nameus+" "+btn.dataset.surnameus+"</b>");
	  modal.setBody("<p align='center' ><b>Изменение личных данных</b><br><br><input type='text' id='tel' placeholder='+7 (___) ___ ____' style='width:70%'><br><input type='email' id='email' placeholder='Ваш e-mail' style='width:70%'><br><button class='header-button mt-25' onClick='getR()'>Сохранить</button></p><div class='text-center' id='message'> </div>");
	  /*Формирование маски ввода телефона */
	  let elem = document.getElementById('tel');
      new IMask(elem, {
        mask: '+7(000)000-00-00',
      });
      modal.show();
	  }
	  /*создаём окно для подтверждения удаления аккаунта*/
const modal_del = new ItcModal();
   const btn_del = e.target.closest('[data-toggle="modal_del"]');
    if (btn_del) {
      modal_del.setTitle("<b>"+btn_del.dataset.nus+" "+btn_del.dataset.surus+"</b><input type='hidden' id='userid' value="+btn_del.dataset.iduser+">");
	  modal_del.setBody("<p align='center' >Вы действительно хотите удалить свой аккаунт?<br><button class='header-button mt-25' onClick='getD()'>Удалить</button></p><div class='text-center' id='mes_del'> </div>");
      modal_del.show();
	  }
});

 function getR(){
var reg =/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var mail=document.getElementById('email').value;
document.querySelector('#message').innerHTML = "";

if (document.querySelector('#tel').value=="" || document.querySelector('#email').value=="")	
	{
document.querySelector('#message').innerHTML = "<p class='red'><b>Заполните поля!</b></p>";
	}
else{
	if (document.getElementById('tel').value.length<16)
		{document.querySelector('#message').innerHTML = "<p class='red'><b>Введите корректный номер телефона!</b></p>";
		}
	else
		{
		if(reg.test(mail) == false)
			{document.querySelector('#message').innerHTML = "<p class='red'><b>Введите корректный  e-mail!</b></p>";
			}
		else{
	document.querySelector('#message').innerHTML = "<img src='../images/loader.gif'>Идет процесс изменения данных";
/*передача параметров в файл change_user.php по технологии Ajax*/
	var tel = $('#tel').val();
 	var email = $('#email').val();
	var result="";
    $.ajax({
	    type: "POST",
        url: "change_user.php",
        data: {ftel:tel,femail:email}
    }).done(function(result)
        {
            $("#message").html( result );
        });
			}
		}
	}
}

 function getD(){
	var iduser = $('#userid').val();
 	var result="";
    $.ajax({
	    type: "POST",
        url: "del_user.php",
        data: {fiduser:iduser}
    }).done(function(result)
        {
            $("#mes_del").html( result );
        });
}

</script>
<script src="../js/jquery.min.js"> </script>
<script src="../js/main.js"> </script>
</body>
</html>