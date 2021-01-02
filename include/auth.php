<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';

if(login()) {
    header("Location: /admin/orders");
    exit;
}
elseif( isset( $_POST["login"] )) {
    if ( !isset( $_POST["email"] ) || !isset( $_POST["password"] ) ) {
        $error = "Заполните все поля.";
    }
    else{
        $link = connectionDB();

        $email = $link->real_escape_string($_POST['email']);
        $query ="SELECT * FROM users WHERE email LIKE '$email'";
        $result = getResultDB($link, $query);

        $user = mysqli_fetch_row( $result );
        $id = $user[0];
        $password = $user[2];

        mysqli_free_result($result);
        mysqli_close($link);

        if(password_verify($_POST['password'], $password)){
            $_SESSION['id'] = $id;
            setcookie('email', $_POST['email'], time() + 3600 * 24 * 30, '/');
            setcookie('password', $password, time() + 3600 * 24 * 30, '/');

            header("Location: /admin/orders");
            exit;
        }
        else{
            $error = "Неправильная почта или пароль.";
        }
    }
}
