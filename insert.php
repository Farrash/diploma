<?php
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /index.php");
        exit;
    }

    $pdo = require_once __DIR__ . '/config/dp.php';
    $params = require_once __DIR__ . '/config/params.php';
    include_once 'SessionHelper.php';
    include_once 'Validate.php';

    $Validate = new Validate($pdo,$params);

    $sql = "INSERT INTO users (name, email, password, role, avatar, sex, status) VALUES (:name,:email, :password,:role,:avatar, :sex,:status)";


    $name       = $Validate->name($_POST['name']);
    $email      = $Validate->email($_POST['email']);
    $password   = $Validate->checkEmptyPass($_POST['password']);
    $role       = $Validate->role($_POST['role']);
    $avatar     = $Validate->avatar($_FILES['avatar']);
    $sex        = $Validate->sex($_POST['sex']);
    $status     = $Validate->status($_POST['status']);

    $_SESSION['form'] = $data = [
        'name'  => $name,
        'email' => $email,
        'password'=> $password,
        'role'  => $role,
        'avatar' => $avatar,
        'sex' => $sex,
        'status' => $status
    ];

    if (SessionHelper::hasErrors()){
        unlink($params['avatars_path'].$avatar);
        header("Location: /create.php");
        exit;
    }


    $statement = $pdo->prepare($sql);

    if ($statement->execute($data)){
        SessionHelper::addSuccess("Новый пользователь $name успешно добавлен");
        unset($_SESSION['form']);
        header("Location: /show.php?id=".$pdo->lastInsertId() );
    } else {
        unlink($params['avatars_path'].$avatar);
        SessionHelper::addError("Не удалось добавить нового пользователя");
        header("Location: /create.php");
        exit;
    }




