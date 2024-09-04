<?php session_start();header('Content-Type: text/html; charset= utf-8');
 if ($_SESSION['login']=="")
	{
	echo "Необходимо авторизироваться! <META HTTP-EQUIV='Refresh' CONTENT='0; URL=../index.php#main'>";
	}
$idses=session_id();
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
<title>MY-GIRO. Оформление заказа</title>
<meta charset="utf-8">
<!-- Для пропорционального изменения элементов на разных экранах-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Подключение файлов стилевого оформления-->
<link rel='stylesheet' href='../css/style.css'>
<link rel='stylesheet' href='../css/responsive.css'>
<!-- Подключение файлов шрифтов-->
<link rel="stylesheet" href="../fonts/font-awesome/css/font-awesome.css">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap" rel="stylesheet">
<!-- Подключение файла фавикон-->
<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="js/jquery.min.js"></script>
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
{echo '<a href="cabinet.php" class="active"><i class="fa fa-user" aria-hidden="true" title="Личный кабинет"></i> <font color="#fff" size="-1"> '. $_SESSION['name_user'].'</font></a>';
}
else
{echo '<a href="#" data-toggle="modal_auth"><i class="fa fa-user " aria-hidden="true" title="Вход"></i>Войти</a>';
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
<h2>Оформление заказа</h2>
<?php
include "db.php";	
$bskt="SELECT id_basket, model, price, quantity,pic_model,category, price*quantity AS total FROM mg_cart,mg_product WHERE mg_product.id_product=mg_cart.id_product AND id_ses='$idses'";
$bskt_ex=mysql_query($bskt);
$num_bskt=mysql_num_rows($bskt_ex);
if ($num_bskt==0)
	{
	echo "В корзине нет товаров <br><a href='../index.php#catalog'> Перейти в каталог </a>";
	}
else
	{?>
<div class="parent">
<div>
<h3>Способ получения</h3>
<!-- вкладки -->
  <div class="tabs">
   <div class="tab">
    <input type="radio" id="tab1" name="tab-group" checked>
    <label for="tab1" class="tab-title">Самовывоз</label> 
    <section class="tab-content">
	<p><i class="fa fa-map-marker brick fa-lg" aria-hidden="true"></i> г. Ижевск, ул. Пушкинская, 268 
	<i class="fa fa-phone brick fa-lg" aria-hidden="true"></i> 8-800-100-7724</p>
	<p>
	<a href="https://yandex.ru/maps/?um=constructor%3Acf0568cd3e8b1439bd0cdabcfcdffe16e91e805a1a62552d33c46fbadfde2c1f&amp;source=constructorStatic" target="_blank"><img src="https://api-maps.yandex.ru/services/constructor/1.0/static/?um=constructor%3Acf0568cd3e8b1439bd0cdabcfcdffe16e91e805a1a62552d33c46fbadfde2c1f&amp;width=600&amp;height=350&amp;lang=ru_RU" alt="" style="border: 0;" /></a>
	</p>
	</section>
   </div> 
   <div class="tab">
    <input type="radio" id="tab2" name="tab-group">
    <label for="tab2" class="tab-title">Курьерская служба</label> 
    <section class="tab-content">
	Адрес доставки<br>
	<textarea id="dlv" class="dlv" ></textarea>
	<br>Доставка курьерской службой осуществляется в течение <b>5 дней</b> с даты заказа. 
	</section>
   </div>
   
  </div>
<!-- end вкладки -->
</div>


<?
echo "<div><h3>Ваш заказ</h3><table cellpadding='5px' cellspacing='10px'>";
	while($bskt_pr=mysql_fetch_array($bskt_ex)){
				if ($bskt_pr['category']=="gyro_scooter") {
	$ctr="Гироскутер"; $fld="gyro_scooter";
	}
elseif ($bskt_pr['category']=="electric_scooter"){
	$ctr="Самокат"; $fld="electric_scooter";
}
elseif ($bskt_pr['category']=="segway"){
	$ctr="Сигвей"; $fld="segway";
}	
	echo "<tr><td><input type='hidden' value='".$bskt_pr['id_basket']."' id='id_basket'>
	<img src='../images/".$fld."/".$bskt_pr['pic_model']."' height='100vh'></td><td>".$ctr." ".$bskt_pr['model']."<br>".number_format($bskt_pr['price'],0,'',' ')." &#8381;</td>
	<td>".$bskt_pr['quantity']." шт. </td>
	<td class='red'><b>".number_format($bskt_pr['total'],0,'',' ')." &#8381;</b></td>
</tr>";
	}
$sum_total="SELECT  price, quantity, SUM(price*quantity) AS total_sum FROM mg_cart,mg_product WHERE mg_product.id_product=mg_cart.id_product AND id_ses='$idses'";
$sum_total_ex=mysql_query($sum_total);
$sum_total_pr=mysql_fetch_array($sum_total_ex);
echo "<tr><td colspan='5' align='right'><b>ИТОГО ".number_format($sum_total_pr['total_sum'],0,'',' ')." &#8381</b></td>";
echo "</tr></table>";
?>
Оплата заказа производится в магазине при самовывозе или курьеру при доставке на указанный адрес. Рассчитаться можно наличными, или банковской картой, или через приложение на смартфоне.
<p align="right"><button class="header-button" type="submit" onClick="getOrd()">Оформить заказ</button></p>
<div id="mes_ord"></div>
</div>
</div>
	<?php } ?>
</div>
<script> 
 function getOrd(){/*оформление заказа */
	var dlv=$('#dlv').val();
	var result='';
	    $.ajax({
	    type: 'POST',
        url: 'add_order.php',
       data: {fdlv:dlv}
    }).done(function(result)
        {
            $('#mes_ord').html(result);
        });
}

/*}*/
</script>
<script src="../js/jquery.min.js"> </script>
</body>
</html>