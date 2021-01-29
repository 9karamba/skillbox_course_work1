<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';

$uploaddir = '/uploads/';

if (getRole() != 'admin') {
    return http_response_code(403);
}

if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $uploaddir)) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $uploaddir, 0777);
}

if (isset( $_POST["add-product"] )) {
    if ( empty( $_POST["product-name"] ) || empty( $_POST["product-price"] ) ) {
        $error = "Данные о товаре обязательны для заполнения.";
    } else{
        $id = isset($_POST["product-id"]) ? intval( htmlspecialchars($_POST["product-id"]) ) : false;
        $name = htmlspecialchars($_POST["product-name"]);
        $price = intval( htmlspecialchars($_POST["product-price"]) );
        $new = intval( isset($_POST["new"]) );
        $sale = intval( isset($_POST["sale"]) );
        $file = $_FILES["product-photo"];

        if (mb_strlen($name) > 255) {
            $error = "Название товара слишком длинное.";
        } elseif ($price <= 0) {
            $error = "Цена должна быть числом и должна быть больше 0.";
        } elseif (empty( $_FILES["product-photo"]["name"] ) && !is_numeric($id) ||
            is_numeric($id) && empty( $_POST["product-image"] ) && empty( $_FILES["product-photo"]["name"] )){
            $error = "Фотография не должна быть пустой.";
        } elseif (is_numeric($id)) {
            if (empty( $_FILES["product-photo"]["name"] )){
                $path = $uploaddir . basename(htmlspecialchars($_POST["product-image"]));
            } else {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $path = $uploaddir . basename($file['name']);

                if (!move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path))
                {
                    $error = 'Ошибка загрузки фото.';
                }
                finfo_close($finfo);
            }
            $link = connectionDB();
            $query = "UPDATE products SET name='{$name}', price='{$price}', new='{$new}', sale='{$sale}', photo='{$path}' WHERE id='{$id}'";
            $result = getResultDB($link, $query);
            if ($result) {
                $categories = [];

                foreach ($_POST["category"] as $category_id) {
                    $categories[]= "('{$id}','{$category_id}')";
                }

                $query ="DELETE FROM product_categories WHERE product_id = '$id'";
                $result = getResultDB($link, $query);

                if (!empty($categories)) {
                    $request = join(',', $categories);
                    $query ="INSERT INTO product_categories (product_id, category_id) VALUES {$request};";
                    $result = getResultDB($link, $query);
                }
            } else {
                $error = 'Не удалось обновить товар.';
            }
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $path = $uploaddir . basename($file['name']);

            if (!move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path)) {
                $error = 'Ошибка загрузки фото.';
            }
            finfo_close($finfo);

            if (!isset($error)) {
                $link = connectionDB();
                $query ="INSERT INTO products SET name='{$name}', price='{$price}', new='{$new}', sale='{$sale}', photo='{$path}';";

                $result = getResultDB($link, $query);
                if ($result) {
                    $product_id = mysqli_insert_id($link);
                    $categories = [];

                    foreach ($_POST["category"] as $category_id) {
                        $categories[]= "('{$product_id}','{$category_id}')";
                    }

                    if (!empty($categories)) {
                        $request = join(',', $categories);
                        $query ="INSERT INTO product_categories (product_id, category_id) VALUES {$request};";
                        $result = getResultDB($link, $query);
                    }
                } else {
                    $error = 'Не удалось добавить товар.';
                }
            }
        }
    }
}

if (isset( $_GET["product-id"] )) {
    $id = intval( htmlspecialchars($_GET["product-id"]) );

    $link = connectionDB();
    $query ="SELECT * FROM products
        LEFT JOIN product_categories ON products.id = product_categories.product_id
        WHERE products.id = '$id'";
    $result = getResultDB($link, $query);

    $product = mysqli_fetch_all( $result, MYSQLI_ASSOC );
    if ($product) {
        foreach ($product as $item){
            $product_categories[] = $item["category_id"];
        }
    }
}