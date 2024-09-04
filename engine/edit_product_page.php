<?php session_start(); 
setlocale(LC_ALL, 'ru_RU.utf8'); /*для корректной кодировки кириллицы*/
Header("Content-Type: text/html;charset=UTF-8");?>
<!doctype html>
<html lang="ru">
<head>
<title>MY-GIRO. Панель управления</title>
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
</ul>
</nav>
</div>
</div>
<!-- end блок "top"-->
<div  class="container mt-100 mb-50">
<div class="page_edit">
<h2>Редактирование товара</h2>
<a href="index.php">Вернуться в каталог</a><br>
<?
include "db.php";
$id_product=$_GET['id_product'];
$tov="SELECT * FROM mg_product WHERE id_product='$id_product'";
$tov_ex=mysql_query($tov);
$tov_p=mysql_fetch_array($tov_ex);

if ($tov_p['pic_model']=="")
{$pic="product.jpg";}
else
{$pic=$tov_p['category']."/".$tov_p['pic_model'];
}
echo "<br><a href='upload/index.php?id_prod=".$tov_p['id_product']."&cat=".$tov_p['category']."&model=".$tov_p['model']."'><img src='../images/download.png'>Загрузить картинку</a><br>

<img src='../images/".$pic."' height='100vh'><br>
<input type='hidden' value='".$tov_p['id_product']."' id='id_product' name='id_product'>
<b>Модель</b><br>
<input type='text' value='".$tov_p['model']."' style='width:50%' id='model_pr' name='model_pr'><br>
<b>Цвет</b> 
<br><input type='text'   value='".$tov_p['color']."' style='width:50%' id='col' name='col'><br>
<b>Цена, руб</b>
<br><input type='text'  value='".$tov_p['price']."' style='width:50%' id='pr' name='pr'><br>
<b>Описание товара</b>
<br><textarea  style='width:50%' id='dscr' name='dscr' rows=5 >".$tov_p['descr_model']."</textarea><br>";
?>

<button class='header-button mt-25' type='submit' onClick='getSave()' >Сохранить</button><div class='text-center' id='mes_edit'> </div>
</div>
</div>
<script>
function getSave(){/*редактирование товара*/
	var id_product = $('#id_product').val();
 	var model = $('#model_pr').val();
	var price = $('#pr').val();
    var color = $('#col').val();
	var des = $('#dscr').val();
	var result="";
	
    $.ajax({
	    type: "POST",
        url: "edit_product.php",
        data: {fid_product:id_product,fmodel:model,fprice:price,fcolor:color,fdes:des}
    }).done(function(result)
        {
            $("#mes_edit").html( result );
        });
}
</script>

<script src="../js/jquery.min.js"> </script>
<script src="../js/main.js"> </script>
</body>
</html>