<?php
session_start();

if(isset($_SESSION['user_id'])){
    $con = mysqli_connect ('localhost','root','','mc_database');
    if(!$con){
        echo 'hubo un problema con la conexión a la base de datos';
    }else{
        $edit = false;
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
        $search = mysqli_query ($con,$query);
        $result = mysqli_fetch_array($search,MYSQLI_ASSOC);
        $placeholder_product_title = 'Titulo del producto';
        $placeholder_product_info = 'Ej: Samsung S22 Ultra...';
        $placeholder_product_type = 'Ej: Celular, Ropa, Accesorios';
        $placeholder_product_price = '';
        $placeholder_product_units = 'Ej: 1,2,3...';
        $route_form = '../PHP/sell_product.php';
        $button_text = 'VENDER';

        if(isset($_GET['product'])){
            if($_GET['product']=='edit'){
                $edit = true;
                $id_product = $_GET['id'];
                $search_product = "SELECT * FROM `products` WHERE `product_id` = $id_product";
                $product_query = mysqli_query($con,$search_product);
                $product_info = mysqli_fetch_array($product_query,MYSQLI_ASSOC);
                $_SESSION['warning_message'] = 'Recuerda llenar todo el formulario para poder editar el producto';
                $placeholder_product_title = $product_info['product_name'];
                $placeholder_product_info = $product_info['product_desc'];
                $placeholder_product_type = $product_info['product_type'];
                $placeholder_product_price = $product_info['product_price'];
                $placeholder_product_units = $product_info['product_cant'];
                $route_form = '../PHP/sell_product.php?edit_publication=edit&id='.$product_info['product_id'];
                $button_text = 'EDITAR PUBLICACION';
            }
        }
    }
}else{
    header("Location:Login.php");
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
    <link rel="stylesheet" href="../CSS/products.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Anunciar</title>
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
                    <?php  } ?>  
                </ul>
            </div>
        </div>
    </nav>
    <?php if(isset($_SESSION['warning_message'])){ ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?=$_SESSION['warning_message']?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php  } unset($_SESSION['warning_message']); ?>
    <?php if(isset($_SESSION['succesfull_message'])){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?=$_SESSION['succesfull_message']?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php  } unset($_SESSION['succesfull_message']); ?>  
<div class="form-container">
    <form action="<?= $route_form ?>" method="post" class="main-form-products" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">¿Que quieres vender?</label>
            <input class="form-control" type="text" placeholder="<?=$placeholder_product_title?>" aria-label="default input example" name="product_title" required>
          </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Descríbenos tu producto</label><br>     
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="<?=$placeholder_product_info?>" name="product_desc" required></textarea>

        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">¿Que tipo de producto estás vendiendo?</label><br>     
            <input class="form-control" type="text" placeholder="<?=$placeholder_product_type?>" aria-label="default input example" name="product_type" required>
        </div>   
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">¿Cuánto va a costar?</label><br>     
            <div class="input-group mb-3">
                <span class="input-group-text">$</span>
                <span class="input-group-text">0.00</span>
                <input type="text" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" name="product_price" placeholder="<?=$placeholder_product_price?>" required>
            </div>
        </div> 
        <div class="mb-3">
            <label for="formFile" class="form-label">Sube una foto de tu producto</label>
            <input class="form-control" type="file" id="formFile" name="product_image" required>
          </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">¿De cuántas unidades dispones?</label><br>
            <input type="number" name="product_units" id="" placeholder="<?=$placeholder_product_units?>" required>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">¿Todo listo?</label><br>
            <button type="submit" class="submit"><?= $button_text?></button>     
        </div>
        
    </form>
</div>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>