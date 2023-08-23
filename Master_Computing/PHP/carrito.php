<?php
session_start();
$con = mysqli_connect('localhost','root','','mc_database');
if(!$con){
    $_SESSION['warning_message'] ="Ha ocurrido un error en la conexión a la base de datos";
}else{
    if(isset($_SESSION['user_id'])){
        $id = $_GET['id'];
        $user = $_SESSION['user_id'];
        $query = "INSERT INTO `shopping_car` (`fk_id_product`,`fk_id_user`) VALUES ('$id','$user')";
        $insert = mysqli_query($con, $query);
        if($insert){
            header("Location: ../HTML/my_car.php");
        }
    }else{
        header("Location: ../HTML/Login.php");
    }
}



?>
