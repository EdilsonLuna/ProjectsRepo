<?php
session_start();
$con = mysqli_connect('localhost','root','','mc_database');
if(!$con){
    echo 'No se pudo conectar a la base de datos';
}

$image = '';
if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];

    if(isset($_POST['product_title'])&&isset($_POST['product_desc'])&&isset($_POST['product_type'])&&isset($_POST['product_price'])&& isset($_POST['product_units'])&&isset($_FILES['product_image'])){
        
        $product_title = $_POST['product_title'];
        $product_desc = $_POST['product_desc'];
        $product_type = $_POST['product_type'];
        $product_price = intval($_POST['product_price']);
        $product_units = intval($_POST['product_units']);
        $product_img = $_FILES['product_image'];

        $product_img_name = $product_img["name"];
        $product_img_type = $product_img['type'];
        $ruta_provisional = $product_img['tmp_name'];
        $size = $product_img["size"];
        $carpeta = '../IMG/products_img/';

        if($product_img_type !='image/jpg' && $product_img_type !='image/JPG' && $product_img_type !='image/jpeg' && $product_img_type !='image/png'){
            $_SESSION['warning_message'] = 'El archivo subido no es de formato imagen';
        }else if($size > 20*1024*1024){
            $_SESSION['warning_message'] = 'El tamaño del archivo es más grande del admitido (Debe pesar menos de 10MB)';
        }else{
            $src = $carpeta.$product_img_name;
            move_uploaded_file($ruta_provisional,$src);
            $image = "IMG/products_img/".$product_img_name;
        }

        if(isset($_GET['edit_publication']) & isset($_GET['id'])){
            $product_id = $_GET['id'];
            $query = "UPDATE `products` SET product_name = '$product_title', product_desc = '$product_desc', product_type = '$product_type', product_price = $product_price, product_img = '$image', product_cant = '$product_units' WHERE product_id = '$product_id'";
        }else{
            $query = "INSERT INTO `products` (`product_name`,`product_desc`,`product_type`,`product_price`,`product_img`,`product_cant`,`fk_user_name`) VALUES ('$product_title','$product_desc','$product_type',$product_price,'$image','$product_units','$id')";
        }
         
        $consult = mysqli_query($con,$query);

        
        if($consult){
            $_SESSION['succesfull_message'] = '¡GENIAL! Tu producto ya está a la venta :)';
            header("Location: ../HTML/products.php");
        }else{  
            $_SESSION['warning_message'] = 'Ha ocurrido un error en la publicación de tu producto. Inténtalo más tarde';
            header("Location:../HTML/products.php");
        }
        
    }else{
        header("Location:../HTML/products.php");
        $_SESSION['warning_message'] = 'El formulario no está completo. Llénalo antes de publicar tu anuncio';
    }      
}else{
    header("Location: ../HTML/Login.php");
}












?>