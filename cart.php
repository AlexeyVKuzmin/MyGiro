<?php session_start();
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");
?>
<!doctype html>
<html lang="ru">
<head>
<title>MY-GIRO. Корзина товаров</title>
<meta charset="utf-8">
<!-- Для пропорционального изменения элементов на разных экранах-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Подключение файлов стилевого оформления-->
<link rel='stylesheet' href='css/style.css'>
<link rel='stylesheet' href='css/responsive.css'>
<link rel="stylesheet" href="css/modal.css">
<!-- Подключение файлов шрифтов-->
<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.css">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap" rel="stylesheet">
<!-- Подключение файла фавикон-->
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="js/jquery.min.js"></script>
</head>
<body>
<!-- Блок "top"-->
<div class="top" >
<div class="containertop">
<!-- Логотип и телефон-->
<img src="images/logo.png"  id="logo" alt="logo"><span class="phone">
<i class="fa fa-phone green phn" aria-hidden="true"></i> 8-800-100-7724
</span>
<!-- Значок "гамбургер" для мобильных устройств и маленьких планшетов-->
         <label for="toggle-1" class="toggle-menu"><i class="toggle-icon"></i></label>
         <input type="checkbox" id="toggle-1">
<!-- Главное меню, классы необходимы для подсвечивания активных пунктов меню при прокрутке-->
<nav>

<ul  id="selmenu">
	<li ><a href="index.php#main" class="hdr ">Главная</a></li>
	<li ><a href="index.php#about" class="abt">О нас</a></li>
	<li ><a href="index.php#delivery" class="dlv" >Условия доставки</a></li>
    <li ><a href="index.php#catalog" class="cat">Каталог</a></li>
	<li ><a href="index.php#contact" class="cont">Контакты</a></li>
	<li>
	<?php
if (isset($_SESSION['login']) AND $_SESSION['login']<>"")
{echo '<a href="engine/cabinet.php"><i class="fa fa-user" aria-hidden="true" title="Вход"></i><font color="#fff" size="-1"> '. $_SESSION['name_user'].'</font> </a>';
}
else
{echo '<a href="#" data-toggle="modal_auth"><i class="fa fa-user " aria-hidden="true" title="Вход"></i></a>';
 }	
	?>
	</li>
	<li><a href="#" class="active"><i class="fa fa-shopping-basket " aria-hidden="true" title="Корзина" ></i></a> 
	</li>
</ul>
</nav>
</div>
</div>
<!-- end блок "top"-->

<div  class="container mt-100">
<h2>Корзина</h2>
<?php 
include "engine/db.php"; /* подключение базы данных */ 
$idses=session_id();
$i=0;
$bsk="SELECT * FROM mg_cart WHERE id_ses='$idses'";

$bsk_ex=mysql_query($bsk);
$bsk_num=mysql_num_rows($bsk_ex);
if ($bsk_num==0){
	echo "<b>КОРЗИНА ПУСТА</b><div class='mt-50'><a href='index.php#catalog'> Перейти в каталог</a></div>";
	
}
else {
	echo "<a href='#' data-toggle='modal_del_cart'> Очистить корзину </a>&nbsp;&nbsp;&nbsp;<a href='index.php#catalog'> Продолжить покупки </a><br>";
	$bskt="SELECT id_basket, model, price, quantity,pic_model,category, price*quantity AS total FROM mg_cart,mg_product WHERE mg_product.id_product=mg_cart.id_product AND id_ses='$idses'";

$bskt_ex=mysql_query($bskt);
echo "<table cellpadding='5px' cellspacing='10px'>";
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
	$i++;	
	echo "<tr><td><input type='hidden' value='".$bskt_pr['id_basket']."' id='id_basket'>".$i.". </td>
	<td> <img src='images/".$fld."/".$bskt_pr['pic_model']."' height='100vh'></td><td>".$ctr." ".$bskt_pr['model']."<br>".number_format($bskt_pr['price'],0,'',' ')." &#8381;</td>
	<td>".$bskt_pr['quantity']." шт. </td>
	<td class='red'><b>".number_format($bskt_pr['total'],0,'',' ')." &#8381;</b></td>
	
	<td align='right'><a href='#' data-toggle='modal_save' data-quant='".$bskt_pr['quantity']."' data-idbsk='".$bskt_pr['id_basket']."'  data-tit='".$ctr." ".$bskt_pr['model']."' data-cont='images/".$fld."/".$bskt_pr['pic_model']."'><i class='fa fa-edit fa-lg ' aria-hidden='true' title='Редактировать' ></i></a></td>
	
	<td><a href='#'  data-toggle='modal' data-idbas='".$bskt_pr['id_basket']."'  data-title='".$ctr." ".$bskt_pr['model']."' data-content='images/".$fld."/".$bskt_pr['pic_model']."'><i class='fa fa-trash-o fa-lg ' aria-hidden='true' title='Удалить' ></i></a>
	<div id='msg'></div></td></tr>";
	}
$sum_total="SELECT  price, quantity, SUM(price*quantity) AS total_sum FROM mg_cart,mg_product WHERE mg_product.id_product=mg_cart.id_product AND id_ses='$idses'";
$sum_total_ex=mysql_query($sum_total);
$sum_total_pr=mysql_fetch_array($sum_total_ex);
echo "<tr><td colspan='5' align='right'><b>ИТОГО ".number_format($sum_total_pr['total_sum'],0,'',' ')." &#8381</b>
</td><td colspan='2' align='center'>";

if (empty($_SESSION['login']))/*Если логин не введён */
	{echo "<a href='#' data-toggle='modal_auth' class='header-button'>Перейти к оформлению</a>";
	}
else
	{
	echo "<a href='engine/order.php' class='header-button'>Перейти к оформлению</a>";
	}	
echo "</td></tr></table>";
}
?>
</div>
<script src="js/modal.js"></script>
<script src="js/imask.js"></script>
<script>
  // создаём модальное окно для подтверждения удаления товара
  const modal = new ItcModal();
  // при клике на странице
  document.addEventListener('click', (e) => {
  const btn = e.target.closest('[data-toggle="modal"]');
    if (btn) {
      modal.setTitle('<input type="hidden" id="id_bskt" value="'+btn.dataset.idbas+'">');
      modal.setBody('<center>Вы действительно хотите удалить <br><b>'+btn.dataset.title+'</b><br> из корзины?<br><img src="'+btn.dataset.content+'"  ><br><button class="header-button" type="submit" onClick="delB()">Удалить</button><div id="msg_del"></div></center>');
      modal.show();
}

  /* создаём модальное окно для изменения количества товара в корзине*/
const modal_save = new ItcModal();
const btn_save = e.target.closest('[data-toggle="modal_save"]');
    if (btn_save) {
      modal_save.setTitle('<input type="hidden" id="id_bsk" value="'+btn_save.dataset.idbsk+'">');
      modal_save.setBody('<center>Изменение количества товара<br><b>'+btn_save.dataset.tit+'</b><br><div class="number"><button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown();this.nextElementSibling.onchange();"> &mdash; </button>	<input type="number" min="1" value="'+btn_save.dataset.quant+'"  id="inum"><button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp();this.previousElementSibling.onchange();"> &#10010; </button></div><br><img src="'+btn_save.dataset.cont+'" ><br><button class="header-button" type="submit" onClick="plusQ()">Сохранить</button><div id="msg_save"></div></center>');
      modal_save.show();
}

  // создаём модальное окно для очистки корзины
  const modal_del_cart = new ItcModal();
  const btn_del_cart = e.target.closest('[data-toggle="modal_del_cart"]');
    if (btn_del_cart) {
      modal_del_cart.setTitle('');
      modal_del_cart.setBody('<center><div class="mt-50">Вы действительно хотите удалить все товары из корзины?</div><div class="mt-50"><button class="header-button" type="submit" onClick="delCart()">Удалить</button></div><div id="msg_del_cart"></center>');
      modal_del_cart.show();
}

  
  // создаём модальное окно для авторизации
  const modal_auth = new ItcModal();
  const btn_auth = e.target.closest('[data-toggle="modal_auth"]');
    if (btn_auth) {
      modal_auth.setTitle('');
      modal_auth.setBody("<p align='center' ><b>Вход в личный кабинет</b><br><br><input type='email' id='eml' placeholder='Введите e-mail' style='width:70%'><br><input type='password' id='psw' placeholder='Введите пароль' style='width:70%'><br><button class='header-button mt-25' id='clb' onClick='getAth()'>Войти</button><div class='text-center' id='mes_auth'> </div><div class='parent'><div><a href='registr.php'>Регистрация</a></div><div align='right'><a href='registr.html'>Забыли пароль?</a></div></div></p>");
      modal_auth.show();
}
});

function getAth(){/*авторизация */
var reg =/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var mail=document.getElementById('eml').value;
document.querySelector('#mes_auth').innerHTML = "";

if (document.querySelector('#eml').value=="" || document.querySelector('#psw').value=="")	
	{
document.querySelector('#mes_auth').innerHTML = "<p class='red'><b>Заполните поля!</b></p>";
	}
	else
		{
		if(reg.test(mail) == false)
			{document.querySelector('#mes_auth').innerHTML = "<p class='red'><b>Введите корректный  e-mail!</b></p>";
			}
		else{
	document.querySelector('#mes_auth').innerHTML = "<img src='images/loader.gif'>Идет процесс авторизации";
/*передача параметров в файл-обработчик*/	
	var eml=$('#eml').val();
	var psw=$('#psw').val();
	var result='';
	    $.ajax({
	    type: 'POST',
        url: 'engine/author_user.php',
       data: {feml:eml,fpsw:psw}
    }).done(function(result)
        {
            $('#mes_auth').html(result);
        });
}
}
}

function plusQ(){/*изменение количества товара в корзине */
	var quantity = $('#inum').val();
	var id_basket=$('#id_bsk').val();
	var result='';
	    $.ajax({
	    type: 'POST',
        url: 'engine/add_quantity_product.php',
        data: {fid_basket:id_basket,fquantity:quantity}
    }).done(function(result)
        {
            $('#msg_save').html(result);
        });
}

function delB(){/*удаление товара из корзины*/
	var id_basket=$('#id_bskt').val();
	var result='';
	    $.ajax({
	    type: 'POST',
        url: 'engine/del_product_cart.php',
        data: {fid_basket:id_basket}
    }).done(function(result)
        {
            $('#msg_del').html(result);
        });
}

function delCart(){/*удаление товара из корзины*/
	var result='';
	    $.ajax({
	    type: 'POST',
        url: 'engine/del_cart.php'
    }).done(function(result)
        {
            $('#msg_del_cart').html(result);
        });
}
</script>
<script src="js/jquery.min.js"> </script>
<script src="js/main.js"> </script>
</body>
</html>