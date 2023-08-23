<?php
$con = mysqli_connect('localhost','root','','mc_database'); //connection with the database in localhost
if(!$con){
    die("No se pudo conectar".mysqli_connect_error()); //if a issue exists, show a message with the error
}

if(!empty($_POST['user_name']) && !empty($_POST['user_ape']) && !empty($_POST['user']) && !empty($_POST['user_tel']) && !empty($_POST['user_mail']) && !empty($_POST['user_pass'])) //verifying that no form input is empty
{
    $user_name = $_POST['user_name'];
    $user_ape = $_POST['user_ape'];
    $user = $_POST['user'];
    $user_tel = $_POST['user_tel'];
    $user_mail = $_POST['user_mail'];
    $user_pass = $_POST['user_pass'];
    
    $search = "SELECT * FROM `users` WHERE `user_tel` = '$user_tel'";
    $query_search = mysqli_query($con,$search); //verifying if already exists other user with the same nickname
    $search_array = mysqli_num_rows($query_search);

    if($search_array ==1){
        $_SESSION['warning'] = 'Una cuenta ya se encuentra registrada con éste número de teléfono';
    }else{
        $query = "INSERT INTO `users` (`user_nickname`,`user_name`,`user_ape`,`user_email`,`user_tel`,`user_password`) VALUES ('$user','$user_name','$user_ape','$user_mail','$user_tel','$user_pass')";

        $rs = mysqli_query($con,$query);
        
        
        if($rs){
            $_SESSION['warning'] = 'El usuario ha sido creado exitosamente';
        }else{
            $_SESSION['uwarning'] = 'Ha ocurrido un error en la creación del usuario. Intente el registro de nuevo más tarde';
        }
        
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/create_account.css">
    <link rel="stylesheet" href="../CSS/normalize.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">



    <title>Crea tu cuenta - Master Computing</title>
</head>
<body>
    
<nav>
        <div class="main-nav">
            <a href="../index.php"><img src="../IMG/logo.png" alt="" class="main-logo"></a>
            <h1>CREA TU CUENTA</h1>
        </div>
    </nav>

<section class="main-form">
    
        <?php if(isset($_SESSION['warning'])){ ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?=$_SESSION['warning']?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php  } ?> 
    
    <div class="box">    
        <form action="Create_account.php" method="post">
            <div class="inputBox">
            <input type="text" required placeholder="Nombres" name="user_name">
            </div>
            <div class="inputBox">
                <input type="text" required placeholder="Apellidos" name="user_ape">
            </div>
            <div class="inputBox">
                <input type="text" required placeholder="Nombre de usuario" name="user">
            </div>
            <div class="inputBox">
                <input type="email" required placeholder="e-mail" name="user_mail">
            </div>
            <div class="inputBox">
                <input type="text" required placeholder="Número de teléfono" name="user_tel">
            </div>
            <div class="inputBox">
                <input type="password" required placeholder="Crea tu contraseña" name="user_pass">
            </div>
            <button type="submit">Registrarme</button>
            <a href="Login.php" class="login">¿Ya tienes una cuenta?</a> 
        </form>
    </div>

    
        
    
    
    
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
