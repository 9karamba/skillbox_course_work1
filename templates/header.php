<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/include/menu.php';

    $menu = getMenu();
    $uri = $_SERVER['REQUEST_URI'];

    if( isset( $_GET["action"]) &&  $_GET["action"] == 'out') {
        logout();
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Fashion</title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="/templates/img/intro/coats-2018.jpg" as="image">
  <link rel="preload" href="/templates/fonts/opensans-400-normal.woff2" as="font">
  <link rel="preload" href="/templates/fonts/roboto-400-normal.woff2" as="font">
  <link rel="preload" href="/templates/fonts/roboto-700-normal.woff2" as="font">

  <link rel="icon" href="/templates/img/favicon.png">
  <link rel="stylesheet" href="/templates/css/style.min.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="/templates/js/scripts.js" defer=""></script>
</head>
<body>
<header class="page-header">
  <a class="page-header__logo" href="/">
    <img src="/templates/img/logo.svg" alt="Fashion">
  </a>
  <nav class="page-header__menu">
    <ul class="main-menu main-menu--header">
        <?php
            foreach ($menu as $item) { ?>
                <li>
                    <a class="main-menu__item <?= strripos($uri, $item['href']) === false ? '' : 'active' ?>" href="<?= $item['href'] ?>">
                        <?= $item['name'] ?>
                    </a>
                </li>
        <?php } ?>
    </ul>
  </nav>
</header>
