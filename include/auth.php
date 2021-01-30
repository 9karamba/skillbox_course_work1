<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';

if (login()) {
    header("Location: /admin/orders");
    exit;
} elseif( isset( $_POST["login"] )) {
    if ( !isset( $_POST["email"] ) || !isset( $_POST["password"] ) ) {
        $error = "Заполните все поля.";
    } else {
        $link = connectionDB();

        $email = $link->real_escape_string(strip_tags($_POST['email']));
        $user_password = $link->real_escape_string(strip_tags($_POST['password']));
        $query ="SELECT * FROM users WHERE email LIKE '$email'";
        $result = getResultDB($link, $query);

        $user = mysqli_fetch_row( $result );
        $id = $user[0];
        $password = $user[2];

        mysqli_free_result($result);
        mysqli_close($link);

        if ($password != null && password_verify($user_password, $password)) {
            $_SESSION['id'] = $id;
            header("Location: /admin/orders");
            exit;
        } else {
            $error = "Неправильная почта или пароль.";
        }
    }
}
