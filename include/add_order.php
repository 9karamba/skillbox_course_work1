<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';

$error = '';

if ( empty( $_POST["surname"] ) || empty( $_POST["name"] ) ||
    empty( $_POST["tel"] ) || empty( $_POST["email"] ) ||
    empty( $_POST["delivery"] ) || empty( $_POST["pay"] )) {
    $error = "Данные со звездочкой, доставка и оплата обязательны для заполнения.";
} elseif ($_POST["delivery"] != 'no' &&
    ( empty( $_POST["home"] ) || empty( $_POST["street"] ) || empty( $_POST["city"] ) || empty( $_POST["aprt"] ) )) {
    $error = "Данные доставки обязательны для заполнения.";
} elseif (empty( $_POST["product"] )) {
    $error = "Товар не выбран.";
} else {
    $user_id = null;
    $name = join(' ', [
        htmlspecialchars($_POST["surname"]),
        htmlspecialchars($_POST["name"]),
        htmlspecialchars($_POST["thirdName"])
    ]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["tel"]);
    $address = $_POST["delivery"] != 'no' ? join(',', [
        htmlspecialchars($_POST["city"]),
        htmlspecialchars($_POST["street"]),
        htmlspecialchars($_POST["home"]),
        htmlspecialchars($_POST["aprt"])
    ]) : '';
    $delivery_id = $_POST["delivery"] != 'no' ? "'" . htmlspecialchars($_POST["delivery"]) . "'" : 'NULL';
    $payment_id = intval( htmlspecialchars($_POST["pay"]) );
    $product_id = intval( htmlspecialchars($_POST["product"]) );
    $comment = htmlspecialchars($_POST["comment"]);

    $link = connectionDB();
    $query ="SELECT id FROM users WHERE email LIKE '{$email}'";
    $result = getResultDB($link, $query);

    $user_id = mysqli_fetch_row($result);
    if ($user_id) {
        $user_id = $user_id[0];
        $query = "UPDATE users SET name='{$name}', phone='{$phone}', address='{$address}' WHERE id ={$user_id}";
        $result = getResultDB($link, $query);
    } else {
        $query ="INSERT INTO users (email, name, phone, address) VALUES ('{$email}', '{$name}', '{$phone}', '{$address}');";
        $result = getResultDB($link, $query);
        if($result) {
            $user_id = mysqli_insert_id($link);
        } else{
            $error = "Ошибка пользовательских данных.";
        }
    }

    $query ="SELECT price FROM products WHERE id={$product_id}";
    $result = getResultDB($link, $query);

    $price = mysqli_fetch_row($result);
    if ($price) {
        $price = $price[0];
        if ($_POST["delivery"] != 'no') {
            $query ="SELECT price, free_price FROM delivery WHERE id={$delivery_id}";
            $result = getResultDB($link, $query);
            $item = mysqli_fetch_row($result);

            $price += $item[0];
            if ($item[1] != null && $price > $item[1]) {
                $price -= $item[0];
            }
        }
    } else {
        $error = "Продукт не найден в базе.";
    }


    if(empty($error) && $user_id != null) {
        $query = "INSERT INTO orders (user_id, delivery_id, payment_id, product_id, price, comment, status) VALUES ('{$user_id}', {$delivery_id}, '{$payment_id}', '{$product_id}', '{$price}', '{$comment}', 0);";
        $result = getResultDB($link, $query);
        if (!$result) {
            $error = "Не удалось создать заказ.";
        }
    }
}

echo $error;
