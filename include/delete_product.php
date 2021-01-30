<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';

if (getRole() != 'admin') {
    return http_response_code(403);
}

if (isset($_POST['id'])) {
    $id = intval( $_POST["id"] );

    $link = connectionDB();
    $query ="DELETE FROM products WHERE id = '$id'";
    $result = getResultDB($link, $query);
    if ($result) {
        return http_response_code(200);
    } else {
        return http_response_code(404);
    }
}