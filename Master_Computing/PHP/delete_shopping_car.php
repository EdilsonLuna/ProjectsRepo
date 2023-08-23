<?php
$con = mysqli_connect('localhost','root','','mc_database');
if(!$con){
    $_SESSION['warning_message'] ="Ha ocurrido un error en la conexión a la base de datos";
    header("Location:../index.php");
}else{
    $id = $_GET['id'];
    $query = "DELETE FROM `shopping_car` WHERE `fk_id_product` = '$id'";
    $delete_product = mysqli_query($con,$query);
    if($delete_product){
        header("Location: ../HTML/my_car.php");
    }
}

?>