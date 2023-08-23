<?php
session_start();
$con = mysqli_connect ('localhost','root','','mc_database');
if(!$con){
    echo 'hubo un problema con la conexión a la base de datos';
}else{
    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
        $search = mysqli_query ($con,$query);
        $result = mysqli_fetch_array($search,MYSQLI_ASSOC);
    
        $products = "SELECT * FROM `products` WHERE `fk_user_name` = '$id'";
        $products_query = mysqli_query($con,$products);
        
    
    }else{
        header("Location: Login.php");
    }
    
}



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
    <link rel="stylesheet" href="../CSS/myproducts.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />


    <title>Document</title>
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
                        <li><a href="my_car.php">Carrito</a></li>
                        <li><a href="products.php">Vender</a></li>
                        <li><a href="myproducts.php">Mis productos</a></li>
                        <li><a href="../PHP/logout.php"><span class="material-symbols-outlined">power_settings_new</span></a></li>
                    <?php  } else { ?>
                        <li><a href="HTML/create_account.php">Crea tu cuenta</li>
                        <li><a href="HTML/Login.php">Inicia sesión</a></li>
                    <?php } ?>    
                </ul>
            </div>
            
        </div>
    </nav>

    <section class="body-content">
        <div class="products-container">
            <h4>Mis publicaciones</h4>
            <div class="main-orders">
                <table class="table table-bordered table-myproducts">
                    <?php while($row = mysqli_fetch_array($products_query, MYSQLI_ASSOC))
                        {
                            $img_route = "../".$row['product_img'];
                            $route_delete = "../PHP/delete_product.php?id=".$row['product_id'];
                            $route_edit = "products.php?product=edit&id=".$row['product_id'];
                    ?>
                        <tr class="table-tr">
                            <td>
                                <div class="product-info-container">
                                    <img src="<?= $img_route?>" alt="" width="120" height="90"/>
                                    <div class="product-info-container-title">
                                        <h6><?=$row['product_type'];?></h6>
                                        <h3><?=$row['product_name'];?></h3>
                                        <h6>Unidades: <?=$row['product_cant'];?></h6>
                                    </div>
                                    <div class="">
                                        <h5>$<?=$row['product_price'];?></h5>
                                    </div>
                                    <div class="options">
                                        <a href="<?=$route_delete?>"><span class="material-symbols-outlined">delete</span></a>
                                        <a href=<?= $route_edit ?>><span class="material-symbols-outlined">border_color</span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    
</section>

</body>
</html>