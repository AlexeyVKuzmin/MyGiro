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
<body onLoad="Mw()">		
<div class="container mb-100">	

<?php
echo "<div  class='mt-10 text-center'><a href='#' data-toggle='modal' data-target='#exampleModal'><img src='../images/plus.png' alt='Добавить' title='Добавить'> Добавить товар</a></div><hr>";
$i=0;
$mam="SELECT * FROM mg_product";
$mam_ex=mysql_query($mam);
$num_str=mysql_num_rows($mam_ex);
if (empty($num_str))
{echo "<div  class='text-center mt-120'><b>Каталог товаров ещё не заполнен</b></div>";}
else {
echo "<div  class='mt-10'>";
while ($mam_p=mysql_fetch_array($mam_ex)){
if (empty($mam_p['pic_model']))
{$a="<br><a href='upload/index.php?id_vw=".$mam_p['id_product']."&view=".$mam_p['model']."&id_class=7'><img src='../images/download.png'> Загрузить изображение</a><br>"; $b="";}
else
{							
$a="<br><a href='upload/index.php?id_vw=".$mam_p['id_product']."&view=".$mam_p['model']."&pic=".$mam_p['pic_model']."&id_class=7'><img src='../images/download.png'> Загрузить изображение </a><br>";
$b="<img src='../images/gyro_scooter/".$mam_p['pic_model']."'  width='100px' align='left' class='mr-10'>";}
$i++;	
echo "<div  class='mt-10'><br>".$i.". ".$z.$mam_p['model'].", ".$mam_p['price'].", ".$mam_p['phone_res']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<!--Редактирование -->
<a href='#' class='btnR' data-toggle='modal' data-target='#editModal' data-res='".$mam_p['name_res']."' data-addr='".$mam_p['addr_res']."' data-phone='".$mam_p['phone_res']."' data-ds='".$mam_p['desc_res']."' data-site='".$mam_p['site_res']."' data-idres='".$mam_p['id_res']."'><img src='../images/edit.png' alt='Редактировать' title='Редактировать'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<!--Удаление -->
<a href='#' class='btn' data-toggle='modal' data-target='#delModal' data-imgrs='".$mam_p['pic_res']."' data-rs='".$mam_p['name_res']."' data-idrs='".$mam_p['id_res']."'><img src='../images/delete.png' alt='Удалить' title='Удалить'></a>";

echo "<p class='sm'>".$a.$b.$mam_p['desc_res']."</p>
</div>
<div class='clear'></div>
<hr>";			
}
}
?>
</div>
</div>
<!-- modal -->
<script>
$(function() {/*Передача параметров в модальное окно для удаления записи*/
  $(".btn").click(
    function() {
	var rs = $(this).attr('data-rs');
    var idrs = $(this).attr('data-idrs');
	var imgrs= $(this).attr('data-imgrs');
	if	(imgrs==""){/*если картинка не загружена*/
		$("#imgrs").append('');
	}
	else{
		$("#imgrs").append('<img src="../assets/img/reserves/'+imgrs+'" style="height:150px">');
	}
      $("#rs").append('<b>' + rs+ '?</b>');
      $("#idrs").attr('value', idrs);
	  $("#imgrss").attr('value', imgrs);
       })
$(".close").click(/*при закрытии модального окна все элементы, в которые переданы параметры, очищаются*/
    function() {
	$("#rs").html('');
	$("#idrs").html('');
    $("#imgrs").html(''); 
       })
});
</script>
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="ti-close" aria-hidden="true"></span>
            </button>
            <div class="modal-dialog" role="document">
                <div class="modal-content pt-50 pb-50">
                    <div class="m-auto">
					<h2>УДАЛЕНИЕ ЗАПОВЕДНИКА</h2>
					<div class="mt-10 text-center">
					Вы действительно хотите удалить 
					<div id="rs" ></div>
					<div id="imgrs" ></div>
					<input type="hidden" id="idrs">
					<input type="hidden" id="imgrss">
					</div>
				<div class="mt-10 text-right">
					<button class="btn-style" type="submit" onClick="delRes()">Удалить</button>
				</div>
<!-- Сообщение об удалении -->					
<div id="mesd"></div>					
            </div>
        </div>
    </div>
</div>

<script>
/*Передача параметров удаления в файл-обработчик */
function delRes(){
	 var idrs= $('#idrs').val();
	 var imgrss=$('#imgrss').val();
	 var result="";
    $.ajax({
	    type: "POST",
        url: "deletereserve.php",
        data: {fidrs:idrs,fimgrss:imgrss}
    }).done(function( result )
        {
            $("#mesd").html( result );
        });
}
</script>
<script>
$(function() {/*Передача параметров в модальное окно для редактирования записи*/
  $(".btnR").click(
    function() {
	var idres = $(this).attr('data-idres');
	var nameres = $(this).attr('data-res');
	var addrres = $(this).attr('data-addr');
	var phoneres = $(this).attr('data-phone');
	var descres = $(this).attr('data-ds');
	var siteres = $(this).attr('data-site');
	$("#idres").attr('value',idres);
	$("#nameres").attr('value',nameres);
    $("#addrres").attr('value',addrres);
	$("#phoneres").attr('value',phoneres);
	$("#siteres").attr('value',siteres);
	$('#descres').val(''+descres+'');/*передача данных в textarea*/
       })
$(".close").click(/*при закрытии модального окна все элементы, в которые переданы параметры, очищаются*/
    function() {
	$("#idres").html('');
	$("#nameres").html('');
       })
});
</script>
<!-- modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="ti-close" aria-hidden="true"></span>
            </button>
            <div class="modal-dialog" role="document">
                <div class="modal-content pt-50 pb-50">
                    <div class="m-auto">
						<h2>РЕДАКТИРОВАНИЕ ЗАПОВЕДНИКА</h2>
					<input type="hidden"  id="idres" >			
					<div class="mt-10">
					<input type="text"  id="nameres" >
					</div>
					<div class="mt-10">
					<input type="text"  id="addrres" >
					</div>
					<div class="mt-10">
					<input type="text"  id="phoneres" >
					</div>
					<div class="mt-10">
					<input type="text"  id="siteres" >
					</div>
					<div class="mt-10 sm">
					Tег новой строки &lt;br /&gt; формируется <b>автоматически</b> при нажатии клавиши <b>ENTER</b>
					<textarea id="descres"> </textarea>
					</div>
					<div class="mt-10 text-right">
						<button class="btn-style" type="submit" onClick="editRes()">Сохранить</button>
					</div>	
<div id="mesedt"></div>			
                </div>
            </div>
        </div>
</div>
<script>
/*Передача полей для редактирования записи в файл-обработчик */
function editRes(){
	 var idres= $('#idres').val();
	 var nameres= $('#nameres').val();
	 var addrres = $('#addrres').val();
	 var phoneres = $('#phoneres').val();
	 var siteres = $('#siteres').val();
	 var descres = $('#descres').val();
	 var result="";
    $.ajax({
	    type: "POST",
        url: "editreserve.php",
        data: {fidres:idres,fnameres:nameres,faddrres:addrres,fphoneres:phoneres,fsiteres:siteres,fdescres:descres}
    }).done(function( result )
        {
            $("#mesedt").html( result );
        });
}
</script>



<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="ti-close" aria-hidden="true"></span>
            </button>
            <div class="modal-dialog" role="document">
                <div class="modal-content pt-50 pb-50">
                    <div class="m-auto">
					<h2>ДОБАВЛЕНИЕ ЗАПОВЕДНИКА</h2>
					<div class="mt-10">
					<input type="text" placeholder=" Название &#9733 " id="name_res" >
					</div>
					<div class="mt-10">
					<input type="text" placeholder=" Адрес &#9733 "  id="addr_res">
					</div>
					<div class="mt-10">
					<input type="text" placeholder=" Телефон "  id="phone_res">
					</div>
					<div class="mt-10">
					<input type="text" placeholder=" URL сайта "  id="site_res">
					</div>
					<div class="mt-10">
					Описание заповедника &#9733
					<textarea id="desc_res" > </textarea>
					<script>CKEDITOR.replace('desc_res',{enterMode: CKEDITOR.ENTER_BR, shiftEnterMode: CKEDITOR.ENTER_P })</script>
					</div>
					<div class="mt-10 text-right">
						<button class="btn-style" type="submit" onClick="getadd()">Добавить</button>
					</div>	
<div id="mes"></div>					
                </div>
            </div>
        </div>
		<script>
/*Передача полей новой записи в файл-обработчик */
function getadd(){
	 var name_res= $('#name_res').val();
	 var addr_res = $('#addr_res').val();
	 var phone_res = $('#phone_res').val();
	 var site_res = $('#site_res').val();
	 var desc_res = $('#desc_res').val();
	 var result="";
    $.ajax({
	    type: "POST",
        url: "addreserve.php",
        data: {fname_res:name_res,faddr_res:addr_res,fphone_res:phone_res,fsite_res:site_res,fdesc_res:desc_res}
    }).done(function( result )
        {
            $("#mes").html( result );
        });
}
</script>
        <script src="../assets/js/vendor/jquery-1.12.0.min.js"></script>
        <script src="../assets/js/popper.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.counterup.min.js"></script>
		<script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/waypoints.min.js"></script>
        <script src="../assets/js/elevetezoom.js"></script>
        <script src="../assets/js/ajax-mail.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/main.js"></script>
    </body>
</html>
