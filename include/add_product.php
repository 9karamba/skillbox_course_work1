<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';

if(isset( $_POST["add-product"] )){
    if ( empty( $_POST["product-name"] ) || empty( $_POST["product-price"] ) || !isset( $_FILES["product-photo"] ) || empty( $_FILES["product-photo"]["name"] ) ) {
        $error = "Данные о товаре и фотография обязательны для заполнения.";
    }
    else{
        $name = htmlspecialchars($_POST["product-name"]);
        $price = intval( htmlspecialchars($_POST["product-price"]) );
        $new = intval( isset($_POST["new"]) );
        $sale = intval( isset($_POST["sale"]) );
        $file = $_FILES["product-photo"];

        if(mb_strlen($name) > 255){
            $error = "Название товара слишком длинное.";
        }
        elseif($price <= 0){
            $error = "Цена должна быть числом и должна быть больше 0.";
        }
        else{
            $uploaddir = '/uploads/';

            if(!is_dir($_SERVER['DOCUMENT_ROOT'] . $uploaddir)){
                mkdir($_SERVER['DOCUMENT_ROOT'] . $uploaddir, 0777);
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $path = $_SERVER['DOCUMENT_ROOT'] . $uploaddir . basename($file['name']);

            if(!move_uploaded_file( $file['tmp_name'], $path)){
                $error = 'Ошибка загрузки фото.';
            }
            finfo_close($finfo);

            if(!isset($error)){
                $link = connectionDB();
                $query ="INSERT INTO products (name, price, new, sale, photo) VALUES ('{$name}', '{$price}', '{$new}', '{$sale}', '{$path}');";

                $result = getResultDB($link, $query);
                if($result){
                    $product_id = mysqli_insert_id($link);
                    $categories = [];

                    foreach ($_POST["category"] as $category_id){
                        $categories[]= "('{$product_id}','{$category_id}')";
                    }

                    $request = join(',', $categories);
                    if(!empty($categories)){
                        $query ="INSERT INTO product_categories (product_id, category_id) VALUES {$request};";
                        $result = getResultDB($link, $query);
                    }
                }
                else{
                    $error = 'Не удалось добавить товар.';
                }
            }
        }
    }
}