<?php
$arUrlRewrite=array (
//  0 =>
//  array (
//    'CONDITION' => '#^/services/#',
//    'RULE' => '',
//    'ID' => 'bitrix:catalog',
//    'PATH' => '/services/index.php',
//    'SORT' => 100,
//  ),
//  1 =>
//  array (
//    'CONDITION' => '#^/products/#',
//    'RULE' => '',
//    'ID' => 'bitrix:catalog',
//    'PATH' => '/products/index.php',
//    'SORT' => 100,
//  ),
//  2 =>
//  array (
//    'CONDITION' => '#^/news/#',
//    'RULE' => '',
//    'ID' => 'bitrix:news',
//    'PATH' => '/news/index.php',
//    'SORT' => 100,
//  ),
    [
        'CONDITION' => '/bitrix/',
        'RULE' => '',
        'ID' => '',
        'PATH' => '/bitrix/index.php',
        'SORT' => 100,
    ],
    [
        'CONDITION' => '/',
        'RULE' => '',
        'ID' => '',
        'PATH' => '/index.php',
        'SORT' => 102,
    ],
);
