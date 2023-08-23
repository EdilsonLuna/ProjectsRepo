<?php
session_start();
$con = mysqli_connect ('localhost','root','','mc_database');
if(!$con){
    echo 'hubo un problema con la conexión a la base de datos';
}

$id_see_more_product = $_GET['id'];

if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
    $query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
    $search = mysqli_query ($con,$query);
    $result = mysqli_fetch_array($search,MYSQLI_ASSOC);
}

$product_query = "SELECT * FROM `products` WHERE product_id = $id_see_more_product";
$product_query_search = mysqli_query($con,$product_query);
$product_info = mysqli_fetch_array($product_query_search,MYSQLI_ASSOC);
$add_car_link = "../PHP/carrito.php?id=".$product_info['product_id'];

$product_query_owner = "SELECT `user_nickname` FROM `users` INNER JOIN `products` WHERE users.user_id = products.fk_user_name AND products.product_id = '$id_see_more_product'";
$product_own_search = mysqli_query($con,$product_query_owner);
$product_own_name = mysqli_fetch_array($product_own_search,MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/normalize.css">
    <link rel="stylesheet" href="../CSS/see_more.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />


    <title>Master Computing</title>
</head>
<body>

    <nav>
        <div class="main-nav">
            <a href="../index.php"><img src="../IMG/logo.png" alt="" class="main-logo"></a>
            <div class="menu-container">
                <span class="material-symbols-outlined">menu</span>
                <ul class="main-ul">
                    <?php if(isset($_SESSION['user_id'])) { ?>
                        <li><?= $result['user_name']?></li>
                        <li><a href="#">Mis compras</a></li>
                        <li><a href="#">Carrito</a></li>
                        <li><a href="products.php">Vender</a></li>
                        <li><a href="myproducts.php">Mis productos</a></li>
                        <li><a href="../PHP/logout.php"><span class="material-symbols-outlined">power_settings_new</span></a></li>
                    <?php  } else { ?>
                        <li><a href="create_account.php">Crea tu cuenta</li>
                        <li><a href="Login.php">Inicia sesión</a></li>
                    <?php } ?>    
                </ul>
            </div>
            
        </div>
    </nav>

    <section class="main-body-seemore">
        <div class="info-image"><img src="<?='../'.$product_info['product_img']?>" alt="" class="img-seemore"></div>
        <div class="info-price">
            <h3 class="product_title"><?= $product_info['product_name']?></h3>
            <h1 class="product_price">$<?= $product_info['product_price']?></h1>
            <p>Stock disponible: <?= $product_info['product_cant']?> unidades</p>
            <a href="#"class="buy btn">Comprar ahora</a>
            <a href="<?= $add_car_link ?>"class="addcar btn">Agregar al carrito</a>
            <p>Vendido por <?=$product_own_name['user_nickname']?> </p>
        </div>
        <div class="info-desc">
            <h3>Descripción:</h3>
            <p><?=$product_info['product_desc']?></p>
        </div>
    </section>
    
</body>
</html>