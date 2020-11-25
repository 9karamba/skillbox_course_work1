<?php

function connectionDB(){
    $host = 'localhost'; // адрес сервера 
    $database = 'skillbox'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = ""; // пароль
    
    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link));
    
    return $link;
}

function getResultDB($link, $query){
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    if($result) {
        return $result;
    }
    else{
        die('Ошибка $result=' . $result);
    }
}