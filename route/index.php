<?php

/* Получаем URL в переменную $result */
$result = $_SERVER['REQUEST_URI'];

/* проверяем, что бы в URL не было ничего, кроме символов алфавита (a-zA-Z), цифр (0-9), а также . / - _ # в противном случае - выдать ошибку 404 */
if (preg_match ('/([^a-zA-Z0-9\.\/\-\_\#])/', $result)) {
	header('HTTP/1.0 404 Not Found');
	echo 'Недопустимые символы в URL';
	exit;
}

/* отбрасываем из ЧПУ всё лишнее, оставляя только имя виртуального html-файла.*/
$array_url = preg_split ('/(\/|\..*$)/', $result,-1, PREG_SPLIT_NO_EMPTY);

if (!$array_url) {
    include $_SERVER['DOCUMENT_ROOT'].'/templates/index.php';
}
else {
    include $_SERVER['DOCUMENT_ROOT'].'/templates/' . $array_url[0] . '.php';
}