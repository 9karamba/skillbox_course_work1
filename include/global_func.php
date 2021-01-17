<?php

include $_SERVER['DOCUMENT_ROOT'].'/include/db.php';

ini_set ("session.use_trans_sid", true);
session_start();

function login()
{
    if (isset($_SESSION['id'])) {
        if(isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
            return true;
        }
        else {
            $link = connectionDB();
            $query ="SELECT * FROM users WHERE id LIKE '{$_SESSION['id']}'";

            $result = getResultDB($link, $query);
            $user = mysqli_fetch_row( $result );

            setcookie('email', $user[1], time() + 3600 * 24 * 30, '/');
            setcookie('password', $user[2], time() + 3600 * 24 * 30, '/');

            return true;
        }
    }
    else {
        if(isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
            $link = connectionDB();
            $query ="SELECT * FROM users WHERE email LIKE '{$_COOKIE['email']}'";

            $result = getResultDB($link, $query);
            $user = mysqli_fetch_row( $result );

            if($_COOKIE['password'] == $user[2]){
                $_SESSION['id'] = $user[0];
                return true;
            }
            else {
                setcookie('email', '', time() + 3600 * 24 * 30, '/');
                setcookie('password', '', time() + 3600 * 24 * 30, '/');
                return false;
            }
        }
        else {
            return false;
        }
    }
}

function logout()
{
    if (!isset($_SESSION)){
        session_start();
    }

    unset($_SESSION['id']);
    setcookie('email', '', time() + 3600 * 24 * 30, '/');
    setcookie('password', '', time() + 3600 * 24 * 30, '/');

    header("Location: /");
}

function getRole()
{
    if(login()){
        $user_id = $_SESSION['id'];
        $link = connectionDB();
        $query ="SELECT role_id FROM user_roles WHERE user_id LIKE '{$user_id}'";

        $result = getResultDB($link, $query);
        $roles = mysqli_fetch_all( $result );

        if(!empty($roles)) {
            $name = 'user';

            foreach ($roles as $role) {
                $query ="SELECT name FROM roles WHERE id LIKE '{$role[0]}'";
                $result = getResultDB($link, $query);

                $name = mysqli_fetch_row( $result )[0];

                if($name == 'admin') {
                    return $name;
                }
            }
            return $name;
        }
    }
    return 'user';
}

function getCategories(){
    $link = connectionDB();
    $query ="SELECT * FROM categories";

    $result = getResultDB($link, $query);
    return mysqli_fetch_all( $result, MYSQLI_ASSOC );
}

function getProducts(){
    $link = connectionDB();
    $num = 5;
    $page = $_GET['page'] ?? 1;

    $result = getResultDB($link,"SELECT COUNT(*) FROM products");
    $posts = mysqli_fetch_row($result);

    $total = intval(($posts[0] - 1) / $num) + 1;
    $page = intval($page);

    if(empty($page) or $page < 0) $page = 1;
    if($page > $total) $page = $total;

    $start = $page * $num - $num;
    $result = getResultDB($link,"SELECT * FROM products LIMIT {$start}, {$num}");

    return [
        'obj' => mysqli_fetch_all($result, MYSQLI_ASSOC),
        'pagination' => [
            'current' => $page,
            'total'   => $total
        ]
    ];
}

function getProductsCategories($id){
    $link = connectionDB();
    $query ="SELECT categories.name FROM categories
        LEFT JOIN product_categories ON categories.id = product_categories.category_id
        WHERE product_categories.product_id LIKE '$id'";

    $result = getResultDB($link, $query);
    if($result){
        $categories = mysqli_fetch_all( $result );

        return array_reduce($categories, function ($carry, $item){
            $carry .= empty($carry) ? $item[0] : ', ' . $item[0];
            return $carry;
        });
    }
    return '';
}