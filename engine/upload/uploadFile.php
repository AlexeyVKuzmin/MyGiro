<?php
include "../db.php";
$id_product=$_POST['id_product'];
$cat=$_POST['cat'];
/*загрузка в папку ../../images/program/ */
if (isset($_POST['btnSubmit1'])) {
    $uploadfile = $_FILES["uploadImage"]["tmp_name"];
if($cat=="gyro_scooter")
    {$folderPath = "../../images/gyro_scooter/";}
else if ($cat=="electric_scooter")
	{$folderPath = "../../images/electric_scooter/";}
else if ($cat=="segway")
	{$folderPath = "../../images/segway/";}


    if (! is_writable($folderPath) || ! is_dir($folderPath)) {
        echo "error";
        exit();
    }
	if (!empty($pic)) {	$filepath =$folderPath.$pic; unlink($filepath);}
	
	$img=$_FILES["uploadImage"]["name"];
    if (move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderPath . $_FILES["uploadImage"]["name"])) {


	$upd="UPDATE mg_product SET pic_model='$img' WHERE id_product='$id_product'";	

		mysql_query($upd);
        echo '<center><img src="' . $folderPath . "" . $_FILES["uploadImage"]["name"] . '"></center>';
        exit();
    }
}

?>
