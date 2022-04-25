<?php
/*
        CREATE TABLE `users` (
            `id` INT(10) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
            `email` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
            `password` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
            `role` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
            `avatar` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
            `sex` TINYINT(3) NULL DEFAULT '1',
            `status` TINYINT(3) NULL DEFAULT '1',
            PRIMARY KEY (`id`) USING BTREE
        )
        COLLATE='utf8mb4_unicode_ci'
        ENGINE=InnoDB
        ;
*/

    $host = '127.0.0.1';//'localhost'
    $db   = 'diploma_db';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    return new PDO($dsn, $user, $pass, $opt);