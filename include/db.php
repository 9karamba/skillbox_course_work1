<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

function connectionDB()
{
    // подключаемся к серверу
    $link = mysqli_connect(HOST, DB_USER, DB_PASSWORD, DB)
        or die("Ошибка: " . mysqli_error($link));

    return $link;
}

function getResultDB($link, $query)
{
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if ($result) {
        return $result;
    } else {
        die('Ошибка: $result=' . $result);
    }
}
