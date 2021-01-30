<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';

$error = '';

if (getRole() == 'user') {
    return http_response_code(403);
}

if (!isset($_POST['status'])) {
    $error = "Статус не может быть обработан.";
} else {
    $id = intval( $_POST["id"] );
    $status = intval( $_POST["status"] );
    $link = connectionDB();
    $query ="UPDATE orders SET status='{$status}' WHERE id={$id}";
    $result = getResultDB($link, $query);

    if (!$result) {
        $error = "Ошибка обработки статуса.";
    }
}
echo $error;
