<?php
    session_start();

    $pdo = require_once __DIR__ . '/config/dp.php';
    $test_data = require_once __DIR__ . '/config/test_data.php';
    $params = require_once __DIR__ . '/config/params.php';

    $sql = "INSERT INTO users (name, email, password, role, avatar, sex, status) VALUES (:name,:email, :password,:role,:avatar,:sex,:status)";

    $success = 0; $errors=[];

    foreach ($test_data as $item){
        $data = [
            'name'  => $item['name']  ?: 'Unnamed Guy',
            'email' => $item['email'] ?: 'random@email.loc',
            'password'=> password_hash('12345',PASSWORD_DEFAULT ),
            'role'  => array_rand($params['roles']),
            'avatar' => $item['avatar']  ?: null,
            'sex' => 1,
            'status' => 1
        ];

        $statement = $pdo->prepare($sql);

        if (
            $statement->execute($data)
        )
            $success+=1;
        else $errors[] = $data;
    }

    include_once 'SessionHelper.php';
    if ($success)
        SessionHelper::addSuccess('В таблицу "users" успешно добавлены '.$success.' тестовых пользователя');
    if (count($errors))
        SessionHelper::addError('В таблицу "users" не удалось добавить данные: '.json_encode($data));

    header("Location: /index.php");
    exit;