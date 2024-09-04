<?php session_start(); setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8"); ?>
<!doctype html>
<html lang="ru">
<head>
<title>MY-GIRO. Регистрация</title>
<meta charset="utf-8">
<!-- Для пропорционального изменения элементов на разных экранах-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Подключение файлов стилевого оформления-->
<link rel='stylesheet' href='css/style.css'>
<link rel="stylesheet" href="css/modal.css">
<link rel='stylesheet' href='css/responsive.css'>
<!-- Подключение файлов шрифтов-->
<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.css">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap" rel="stylesheet">
<!-- Подключение файла фавикон-->
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/modal.js"></script>
<script src="js/imask.js"></script>
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
{echo '<a href="engine/cabinet.php"><i class="fa fa-user" aria-hidden="true" title="Личный кабинет"></i><font color="#fff" size="-1"> '. $_SESSION['name_user'].'</font> </a>';
}
else
{echo '<a href="#" data-toggle="modal_auth"><i class="fa fa-user " aria-hidden="true" title="Вход"></i><font color="#fff" size="-1"> Войти</font></a>';
 }	
	?>
	</li>
	<li><a href="cart.php"><i class="fa fa-shopping-basket " aria-hidden="true" title="Корзина" ></i></a> </li>
</ul>
</nav>
</div>
</div>
<!-- end блок "top"-->

<div  class="container mt-100">
<div class="reg">
<p align="center"><font size="+3">Регистрация</font></p>
<br><input id="sn" name="sn"  placeholder=" Ваша фамилия " type="text" >
<br><input id="nm" name="nm"  placeholder=" Ваше имя " type="text"  >
<br><input  id="tel" name="tel" placeholder=" Телефон " type="text" >
<br><input id="email" name="email"  placeholder=" Email (логин) " type="email" >
<br><input  id="password" name="password"   placeholder=" Пароль " type="password" >
<script>
	  /*Формирование маски ввода телефона */
	  let element = document.getElementById('tel');
      new IMask(element, {
        mask: '+7(000)000-00-00',
      });
</script>
<p align="center"><input type="checkbox" id="agr" style="display:inline;"> Я согласен(на) на обработку персональных данных</p>
<script>
$('#agr').click(function(){
	if ($(this).is(':checked')){
		$('#but_reg').removeAttr('disabled');
		$('#but_reg').css('background-color', '#FF7400'); 
		
	} else {
		$('#but_reg').attr('disabled', 'disabled'); 
		$('#but_reg').css('background-color', '#c0c0c0'); 
	}
});
</script>
<p><button class="header-button" type="submit"  id="but_reg" onClick="getR()"  disabled="disabled" style="background-color:#c0c0c0" title="Подтвердите согласие на обработку персональных данных"> Сохранить </button>
<div id="message"></div>
<a href="#" data-toggle="modal_auth"> Войти в личный кабинет </a>
</p>
</div>
<script>
/* Ajax*/
function getR(){
var reg =/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
var mail=document.getElementById('email').value;
document.querySelector('#message').innerHTML = "";

if (document.querySelector('#sn').value=="" || document.querySelector('#nm').value=="" || document.querySelector('#tel').value=="" || document.querySelector('#email').value=="" || document.querySelector('#password').value=="")	
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
	document.querySelector('#message').innerHTML = "<img src='images/loader.gif'>Идет процесс регистрации";

 	var sn = $('#sn').val();
    var nm = $('#nm').val();
	var tel = $('#tel').val();
 	var email = $('#email').val();
    var password = $('#password').val();
	var result="";
	
    $.ajax({
	    type: "POST",
        url: "engine/registr_user.php",
        data: {fsn:sn,fnm:nm,ftel:tel,femail:email,fpassword:password}
    }).done(function(result)
        {
            $("#message").html( result );
        });
			}
		}
	}
}
const modal_auth = new ItcModal();
  // при клике на странице
document.addEventListener('click', (e) => {
  // создаём модальное окно для авторизации
const btn_auth = e.target.closest('[data-toggle="modal_auth"]');
    if (btn_auth) {
      modal_auth.setTitle('');
      modal_auth.setBody("<p align='center' ><b>Вход в личный кабинет</b><br><br><input type='email' id='eml' placeholder='Введите e-mail' style='width:70%'><br><input type='password' id='psw' placeholder='Введите пароль' style='width:70%'><br><button class='header-button mt-25' id='clb' onClick='getAth()'>Войти</button><div class='text-center' id='mes_auth'> </div><div class='parent'><div><a href='registr.html'>Регистрация</a></div><div align='right'><a href='registr.html'>Забыли пароль?</a></div></div></p>");
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

</script>
<script src="js/jquery.min.js"> </script>
<script src="js/main.js"> </script>
</body>
</html>