<?php

function getMenu()
{
    include_once $_SERVER['DOCUMENT_ROOT'].'/include/global_func.php';
    $role = getRole();
    $menu = [];

    if ($role == 'user') {
        $menu = [
            [
                'name' => 'Главная',
                'href' => '/'
            ],
            [
                'name' => 'Новинки',
                'href' => '/'
            ],
            [
                'name' => 'Sale',
                'href' => '/'
            ],
            [
                'name' => 'Доставка',
                'href' => '/delivery'
            ]
        ];
    } else {
        if ($role == 'admin') {
            $menu = [
                [
                    'name' => 'Товары',
                    'href' => '/admin/products'
                ]
            ];
        }
        $menu = array_merge($menu, [
            [
                'name' => 'Заказы',
                'href' => '/admin/orders'
            ],
            [
                'name' => 'Выйти',
                'href' => '/?action=out'
            ]
        ]);
    }
    return $menu;
}
