<?php

    $pdo = require_once __DIR__ . '/config/dp.php';
    $params = require_once __DIR__ . '/config/params.php';
    include_once 'SessionHelper.php';

    $id_to_delete = (int)$_GET['id'];

    if ($user = is_such_user($id_to_delete, $pdo)){
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        if ($stmt->execute(['id'=>$id_to_delete])){
            if (!empty($user['avatar']))
                unlink($params['avatars_path'].$user['avatar']);
            SessionHelper::addSuccess("Удаление пользователя прошло успешно.");
        }
    } else {
        SessionHelper::addError("Пользователя с таким id не существует. Удаление невозможно.");
    }

    header("Location: /index.php");
    exit;

     function is_such_user($id,$pdo){
        $stmt = $pdo->prepare("SELECT id, avatar FROM users WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        $return = $stmt->fetchAll();
        return $return[0] ;
    }