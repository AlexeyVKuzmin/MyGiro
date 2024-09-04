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

<div  class="container mt-75 mb-50">
<h2>Каталог товаров</h2>
<?php
$w=$_GET['w'];
if ($w==1) {$catalog="gyro_scooter";}
if ($w==2) {$catalog="electric_scooter";}
if ($w==3) {$catalog="segway";}
echo "<div  class='mt-10 text-center'><a href='#' data-toggle='modal'><img src='../images/plus.png' alt='Добавить' title='Добавить'> Добавить товар</a></div><hr>";
?>
<div id="BtnContainer">
  <button class="btn act" onclick="filterSelection('all')"> Все товары</button>
<?php 
include "db.php";
/* выбор категорий товаров из таблицы mg_product*/
$cat="SELECT DISTINCT category FROM mg_product ORDER BY category";
$cat_ex=mysql_query($cat);
while($cat_pr=mysql_fetch_array($cat_ex))
{if ($cat_pr['category']=="gyro_scooter") {
	$category="Гироскутеры";
	}
elseif ($cat_pr['category']=="electric_scooter"){
	$category="Самокаты";
}
elseif ($cat_pr['category']=="segway"){
	$category="Сигвеи";
}
/* кнопки выбора категорий "Гироскутеры", "Самокаты", "Сигвеи" */
echo '<button class="btn" onclick="filterSelection(\''.$cat_pr['category'].'\')">'.$category.'</button>';	
}
?>
</div>

<!-- Сетка для изображений -->
<div class="row" >
<?php
$prod="SELECT * FROM mg_product ORDER BY category";
$prod_ex=mysql_query($prod);
while($prod_pr=mysql_fetch_array($prod_ex))
{
	if ($prod_pr['category']=="gyro_scooter") {
	$ctr="Гироскутер"; $fld="gyro_scooter";
	}
elseif ($prod_pr['category']=="electric_scooter"){
	$ctr="Самокат"; $fld="electric_scooter";
}
elseif ($prod_pr['category']=="segway"){
	$ctr="Сигвей"; $fld="segway";
}
if ($prod_pr['hit']=="1") {$star="<span class='red'>&#9734; Хит продаж</span>";}else {$star='';}
if ($prod_pr['pic_model']=="") {$pic='';}else {$pic='<img src="../images/'.$fld.'/'.$prod_pr['pic_model'].'"  alt="'.$prod_pr['model'].'" class="imsm" height="100vh">';}
echo '<div class="column '.$prod_pr['category'].'">
	<div class="content" style="border:1px dashed grey">
	
	<a href="upload/index.php?id_prod='.$prod_pr['id_product'].'&model='.$prod_pr['model'].'&cat='.$prod_pr['category'].'"><img src="../images/download.png">Загрузить картинку</a>
	
	<div class="pic">'.$pic.'</div>
	  <h4>'.$ctr.' '.$prod_pr['model'].'<br>'.$prod_pr['color'].' '.$star.'</h4>
	  <p><b>'.number_format($prod_pr['price'],0,'',' ').' &#8381;</b></p>
      <p class="sm">'.$prod_pr['descr_model'].'</p>
	  
		<a href="#" data-toggle="modal_del" data-idprod="'.$prod_pr['id_product'].'" data-prod="'.$prod_pr['model'].'" data-cat="'.$ctr.'" data-pict="'.$prod_pr['pic_model'].'" data-fld="'.$prod_pr['category'].'"><img src="../images/delete.png">Удалить</a>
		
		<a href="edit_product_page.php?id_product='.$prod_pr['id_product'].'" ><img src="../images/edit.png">Редактировать</a><br>
		
		
	</div>
</div>';
}
?>
<div class="clear"></div>
<!-- END GRID -->
</div>

<script>
  // создаём модальное окно для добавления товара
   document.addEventListener('click', (e) => {
   const modal = new ItcModal();
   const btn = e.target.closest('[data-toggle="modal"]');
    if (btn) {
      modal.setTitle("<b>Новый товар</b>");
	  modal.setBody("<div style='margin-left:30px'><select id='categ'><option value='gyro_scooter' />Гироскутер</option><option value='electric_scooter'/>Самокат</option> <option value='segway'> Сигвей</option><br>Модель<br><input type='text' id='model'  style='width:90%'><br>Цвет <br><input type='text' id='color'  style='width:90%'><br>Цена, руб<br><input type='text' id='price'  style='width:90%'><br>Описание товара<br><textarea style='width:90%' id='des'></textarea><button class='header-button mt-25' type='submit' onClick='getR()'>Сохранить</button></div><div class='text-center' id='message'> </div>");
modal.show();
	  }
	
	  
	  /*создаём окно для подтверждения удаления товара*/
const modal_del = new ItcModal();
   const btn_del = e.target.closest('[data-toggle="modal_del"]');
    if (btn_del) {
		var kartinka;
	if (btn_del.dataset.pict==''){kartinka='<img src="../images/product.jpg">';}
	else {kartinka='<img src="../images/'+btn_del.dataset.fld+'/'+btn_del.dataset.pict+'">';}
      modal_del.setTitle("<b>Удаление товара</b><input type='hidden' id='idprod' value='"+btn_del.dataset.idprod+"'><input type='hidden' id='pict' value='"+btn_del.dataset.pict+"'><input type='hidden' id='fld' value='"+btn_del.dataset.fld+"'>");
	  modal_del.setBody("<p align='center' >Вы действительно хотите удалить<br><b>"+btn_del.dataset.cat+" "+btn_del.dataset.prod+"</b>?<br>'"+kartinka+"'<br><button class='header-button mt-25' onClick='getD()'>Удалить</button></p><div class='text-center' id='mes_del'> </div>");
      modal_del.show();
	  }
});

function getR(){/*добавление нового товара*/
document.querySelector('#message').innerHTML = "";

if (document.querySelector('#model').value=="")	
	{
document.querySelector('#message').innerHTML = "<p class='red'><b>Введите название модели!</b></p>";
	}
else{
	document.querySelector('#message').innerHTML = "<img src='../images/loader.gif'>Идет процесс сохранения нового товара";

 	var model = $('#model').val();
    var categ = $('#categ').val();
	var price = $('#price').val();
    var color = $('#color').val();
	var des = $('#des').val();
	var result="";
	
    $.ajax({
	    type: "POST",
        url: "new_product.php",
        data: {fmodel:model,fcateg:categ,fprice:price,fcolor:color,fdes:des}
    }).done(function(result)
        {
            $("#message").html( result );
        });
			}
}

  function getD(){/*удаление товара*/
	var idprod = $('#idprod').val();
	var pic = $('#pict').val();
	var fld = $('#fld').val();
 	var result="";
    $.ajax({
	    type: "POST",
        url: "del_product.php",
        data: {fidprod:idprod,fpic:pic,ffld:fld}
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