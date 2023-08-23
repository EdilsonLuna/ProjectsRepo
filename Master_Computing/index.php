<?php
session_start();
$con = mysqli_connect ('localhost','root','','mc_database');
if(!$con){
    echo 'hubo un problema con la conexión a la base de datos';
}

if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
    $query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
    $search = mysqli_query ($con,$query);
    $result = mysqli_fetch_array($search,MYSQLI_ASSOC);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/normalize.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Master Computing</title>
</head>
<body>
    
    <nav>
        <div class="main-nav">
            <a href="index.php"><img src="IMG/logo.png" alt="" class="main-logo"></a>
            <div class="menu-container"> 
                <span class="material-symbols-outlined">menu</span>
                <ul class="main-ul">
                    <?php if(isset($_SESSION['user_id'])) { ?>
                        <li><?= $result['user_name']?></li>
                        <li><a href="#">Mis compras</a></li>
                        <li><a href="HTML/my_car.php">Carrito</a></li>
                        <li><a href="HTML/products.php">Vender</a></li>
                        <li><a href="HTML/myproducts.php">Mis productos</a></li>
                        <li><a href="PHP/logout.php"><span class="material-symbols-outlined">power_settings_new</span></a></li>
                    <?php  } else { ?>
                        <li><a href="HTML/create_account.php">Crea tu cuenta</li>
                        <li><a href="HTML/Login.php">Inicia sesión</a></li>
                    <?php } ?>    

                </ul>
            </div> 
        </div>
    </nav>

    <section class="main-body">
        <div class="main-section-div">
            <?php
                $products_consult = "SELECT * FROM `products`";
                $petition = mysqli_query($con,$products_consult);
                while($petition_result = mysqli_fetch_array($petition,MYSQLI_ASSOC))
                {  
                    $product_id = $petition_result['product_id'];
                    $see_more = 'HTML/see_more.php?id='.$product_id;  
                ?>
                    <div class="card headline" style="width:18rem;">
                        <div class="card-img-container">
                            <img src="<?=$petition_result['product_img']?>" class="card-img-top img-main">
                        </div>
                        <div div class="card-body">
                            <h5 class="card-title"><?= $petition_result['product_name']?></h5>
                            <h5 class="card-title"> $<?= $petition_result['product_price']?> </h5>
                            <div class="text-container">
                                <p class="card-text"><?= $petition_result['product_desc'] ?></p>
                            </div>
                            <a href="<?= $see_more ?>" class="btn btn-primary">Ver más</a>
                        </div>    
                    </div>
            <?php } ?>
        </div>
    </section>

<script src="https://unpkg.com/scrollreveal"></script>
<script src="scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>