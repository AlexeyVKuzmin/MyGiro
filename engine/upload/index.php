<?php header('Content-Type: text/html; charset= utf-8'); ?>
<!DOCTYPE html>
<html>
<head>
<title>MY-GIRO.Загрузка изображений</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.png">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery.form.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('#submitButton').click(function () {
    	    $('#uploadForm').ajaxForm({
    	        target: '#outputImage',
    	        url: 'uploadFile.php',
    	        beforeSubmit: function () {
    	        	  $("#outputImage").hide();
    	        	   if($("#uploadImage").val() == "") {
    	        		   $("#outputImage").show();
    	        		   $("#outputImage").html("<div class='error'>Выберите файл для загрузки</div>");
                    return false; 
                }
    	            $("#progressDivId").css("display", "block");
    	            var percentValue = '0%';

    	            $('#progressBar').width(percentValue);
    	            $('#percent').html(percentValue);
    	        },
    	        uploadProgress: function (event, position, total, percentComplete) {

    	            var percentValue = percentComplete + '%';
    	            $("#progressBar").animate({
    	                width: '' + percentValue + ''
    	            }, {
    	                duration: 5000,
    	                easing: "linear",
    	                step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
    	                    $("#percent").text(percentText + "%");
                        if(percentText == "100") {
                        	   $("#outputImage").show();
                        }
    	                }
    	            });
    	        },
    	        error: function (response, status, e) {
    	            alert('Невозможно загрузить файл.');
    	        },
    	        
    	        complete: function (xhr) {
    	            if (xhr.responseText && xhr.responseText != "error")
    	            {
    	            	  $("#outputImage").html(xhr.responseText);
    	            }
    	            else{  
    	               	$("#outputImage").show();
        	            	$("#outputImage").html("<div class='error'>Возникли проблемы с загрузкой.</div>");
        	            	$("#progressBar").stop();
    	            }
    	        }
    	    });
    });
});
</script>

</head>
<body>
<div class="pos">
<div class="reds">ВНИМАНИЕ! Подготовьте для загрузки изображение размером 280X280 пикселей.</div>
<?php
$id_product=$_GET['id_prod'];
$model=$_GET['model'];
$cat=$_GET['cat'];
if (!empty($id_product)){
echo "<h2 class='bricks'>".$_GET['model']."</h2>";
}

 ?>
    <div class="form-container">
        <form action="uploadFile.php" id="uploadForm" name="frmupload"
            method="post" enctype="multipart/form-data">
			<?php 
			if (!empty($id_product))
		{echo "<input type='hidden' name='id_product' value='".$id_product."'>
		<input type='hidden' name='cat' value='".$cat."'>";
		echo  '<input type="file" id="uploadImage" name="uploadImage" /> 
			<input id="submitButton" type="submit" name="btnSubmit1" value="Загрузить изображение" />';
		}
			?>
        </form>
        <div class='progress' id="progressDivId">
            <div class='progress-bar' id='progressBar'></div>
            <div class='percent' id='percent'>0%</div>
        </div>
        <div style="height: 10px;"></div>
        <div id='outputImage'></div>
 <?php    echo "<br><a href='../edit_product_page.php?id_product=".$id_product."'> Вернуться к редактированию товара</a>&nbsp;&nbsp;&nbsp;<a href='../index.php'> Вернуться в каталог </a></p>";?>
    </div>
</div>
</body>
</html>