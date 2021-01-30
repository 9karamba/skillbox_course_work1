<?php

include $_SERVER['DOCUMENT_ROOT'].'/include/db.php';

ini_set ("session.use_trans_sid", true);
session_start();

function login()
{
    if (isset($_SESSION['id'])) {
        $link = connectionDB();
        $id = intval($_SESSION['id']);
        $query = "SELECT * FROM users WHERE id='{$id}'";

        $result = getResultDB($link, $query);
        if ($result) {
            return true;
        }

        return false;
    }
}

function logout()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    unset($_SESSION['id']);
    header("Location: /");
}

function getRole()
{
    if (login()) {
        $user_id = intval($_SESSION['id']);
        $link = connectionDB();
        $query ="SELECT role_id FROM user_roles WHERE user_id='{$user_id}'";

        $result = getResultDB($link, $query);
        $roles = mysqli_fetch_all( $result );

        if (!empty($roles)) {
            $name = 'user';

            foreach ($roles as $role) {
                $query ="SELECT name FROM roles WHERE id='{$role[0]}'";
                $result = getResultDB($link, $query);

                $name = mysqli_fetch_row( $result )[0];

                if ($name == 'admin') {
                    return $name;
                }
            }
            return $name;
        }
    }
    return 'user';
}

function getCategories()
{
    $link = connectionDB();
    $query ="SELECT * FROM categories ";

    $result = getResultDB($link, $query);
    return mysqli_fetch_all( $result, MYSQLI_ASSOC );
}

function getProducts()
{
    $link = connectionDB();
    $query = "SELECT * FROM ";
    $table = "products ";
    $args = [];
    $num = 6;
    $page     = $_GET['page'] ?? 1;
    $category = isset($_GET['category']) ? $link->real_escape_string(strip_tags($_GET['category'])) : '';
    $new      = $_GET['new'] ?? '';
    $sale     = $_GET['sale'] ?? '';
    $minPrice = isset($_GET['min-price']) ? intval($_GET['min-price']) : '';
    $maxPrice = isset($_GET['max-price']) ? intval($_GET['max-price']) : '';
    $sort     = isset($_GET['sort']) ? $link->real_escape_string(strip_tags($_GET['sort'])) : '';
    $order    = isset($_GET['order']) ? $link->real_escape_string(strip_tags($_GET['order'])) : 'asc';

    if (!empty($new)) {
        $args[] = "products.new = 1";
    }
    if (!empty($sale)) {
        $args[] = "products.sale = 1";
    }
    if (!empty($minPrice) && !empty($maxPrice)) {
        $args[] = "products.price > {$minPrice}";
        $args[] = "products.price < {$maxPrice} ";
    }

    if (!empty($category)) {
        $table = "product_categories
        LEFT JOIN products ON products.id = product_categories.product_id
        WHERE product_categories.category_id = '$category' ";
        if (count($args) > 0 ) {
            $table .= "AND ";
        }
    } elseif (count($args) > 0 ) {
        $table .= "WHERE ";
    }

    $table .= join(' AND ', $args);
    $result = getResultDB($link,"SELECT COUNT(*) FROM " . $table);
    $posts = mysqli_fetch_row($result);

    $total = intval(($posts[0] - 1) / $num) + 1;
    $page = intval($page);

    if (empty($page) or $page < 0) $page = 1;
    if ($page > $total) $page = $total;

    $start = $page * $num - $num;

    if (!empty($sort)) {
        $table .= " ORDER BY {$sort} {$order} ";
    }

    $result = getResultDB($link,$query . $table . " LIMIT {$start}, {$num}");

    return [
        'obj' => mysqli_fetch_all($result, MYSQLI_ASSOC),
        'count' => $posts[0],
        'pagination' => [
            'current' => $page,
            'total'   => $total
        ]
    ];
}

function getProductsCategories($id)
{
    $link = connectionDB();
    $id = intval($id);
    $query ="SELECT categories.name FROM categories
        LEFT JOIN product_categories ON categories.id = product_categories.category_id
        WHERE product_categories.product_id='$id'";

    $result = getResultDB($link, $query);
    if ($result) {
        $categories = mysqli_fetch_all( $result );

        return array_reduce($categories, function ($carry, $item){
            $carry .= empty($carry) ? $item[0] : ', ' . $item[0];
            return $carry;
        });
    }
    return '';
}

function getUrl($type, $num)
{
    $uri = '';

    if (isset($_SERVER['QUERY_STRING'])) {
        parse_str($_SERVER['QUERY_STRING'], $vars);
        $uri = '?' . http_build_query(array_diff_key($vars,array($type=>"")));
    }

    if (preg_match ('/(\?)/', $uri) && stripos($uri, $type) === false) {
        $uri .= '&' . $type . '=' . $num;
    } elseif (preg_match ('/(\?)/', $uri)) {
        $uri = preg_replace("/(".$type."=[0-9]+)/i", "".$type."=".$num, $uri);
    } else {
        $uri .= '?' . $type . '=' . $num;
    }
    return $uri;
}

function getDelivery()
{
    $link = connectionDB();
    $query ="SELECT * FROM delivery";

    $result = getResultDB($link, $query);
    return mysqli_fetch_all( $result, MYSQLI_ASSOC );
}

function getPayment()
{
    $link = connectionDB();
    $query ="SELECT * FROM payment";

    $result = getResultDB($link, $query);
    return mysqli_fetch_all( $result, MYSQLI_ASSOC );
}

function getOrders()
{
    $link = connectionDB();
    $query ="SELECT orders.id, 
                    orders.price, 
                    orders.comment, 
                    orders.status, 
                    users.name AS user_name, 
                    users.phone, 
                    users.address, 
                    delivery.name AS delivery_name, 
                    payment.name AS payment_name FROM orders
        LEFT JOIN users ON orders.user_id = users.id
        LEFT JOIN delivery ON orders.delivery_id = delivery.id
        LEFT JOIN payment ON orders.payment_id = payment.id
        ORDER BY orders.status, orders.id DESC";

    $result = getResultDB($link, $query);
    return mysqli_fetch_all( $result, MYSQLI_ASSOC );
}
