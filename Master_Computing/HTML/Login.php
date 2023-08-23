<?php

$con = mysqli_connect('localhost','root','','mc_database');
if(!$con){
    echo 'Error conectando con la base de datos';
}

if(!empty($_POST['user']) && !empty($_POST['password'])){
    $user = $_POST['user'];
    $pass = $_POST['password'];

    $query = "SELECT * FROM `users` WHERE `user_nickname` ='$user' AND `user_password` = '$pass'";

    $search = mysqli_query($con,$query);
    $query_result = mysqli_fetch_array($search,MYSQLI_ASSOC);
    $result = mysqli_num_rows($search);

    if($result ==1){
        session_start();
        $_SESSION['user_id'] = $query_result['user_id']; //number of the user in the db
        header("Location: ../index.php");
    }else{
        $_SESSION['warning'] = 'El usuario no existe o las credenciales ingresadas no son las correctas';
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../CSS/create_account.css">
    <link rel="stylesheet" href="../CSS/normalize.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <title>Inicia Sesión - Master Computing</title>
</head>
<body>

    <nav>
        <div class="main-nav">
            <a href="../index.php"><img src="../IMG/logo.png" alt="" class="main-logo"></a>
            <h1>INICIA SESION</h1>
        </div>
    </nav>
    
    <section class="main-form">

        <div class="box">
            <form action="" class="scnd-form" method="post">
                <div class="inputBox first">
                    <input type="text" required placeholder="Usuario" name="user">
                </div>
                <div class="inputBox">
                    <input type="password" required placeholder="Contraseña" name="password">
                </div>
                <button type="submit">Iniciar Sesión</button><br><br> 
                <a href="Create_account.php" class="login">¿No tienes una cuenta?</a>
            </form>
        </div>
        
        
    </section>
    
</body>
</html>