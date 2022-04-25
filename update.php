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

    $updated_data = [
        'name' => $Validate->name($_POST['name']),
        'email'=>  $Validate->email($_POST['email']),
        'role'=>  $Validate->role($_POST['role']),
        'sex'=>  $Validate->sex($_POST['sex']),
        'status'=>  $Validate->status($_POST['status'])
    ];

    if (!empty($_POST['password'])){
            $updated_data['password'] = $Validate->checkEmptyPass($_POST['password']);
    }
    if (!empty($_FILES['avatar']['name'])){
        $updated_data['avatar'] = $Validate->avatar($_FILES['avatar']);
    }

    $_SESSION['form'] = array_merge($_SESSION['form'], $updated_data);

    if (SessionHelper::hasErrors()){
        if (!empty($updated_data['avatar']))
            unlink($params['avatars_path'].$updated_data['avatar']);
        header("Location: /edit.php?id=".(int)$_POST['id']);
        exit;
    }



    $sql = 'UPDATE users SET ';
    foreach ($updated_data as $key => $val){
        $sql .= $key.' =:'.$key.', ';
    }
    $sql = substr($sql,0,-2) .' WHERE id = '.(int)$_POST['id'];


    $statement = $pdo->prepare($sql);

    if ($statement->execute($updated_data)){
        SessionHelper::addSuccess("Новый пользователь ".$updated_data['name']. "успешно отредактирован");
        if (!empty($updated_data['avatar']) )
            unlink($params['avatars_path'].$_SESSION['form']['old_avatar']);
        unset($_SESSION['form']);
        header("Location: /show.php?id=".(int)$_POST['id'] );
    } else {
        if (!empty($updated_data['avatar']))
            unlink($params['avatars_path'].$updated_data['avatar']);
        SessionHelper::addError("Не удалось отредактировать пользователя");
        header("Location: /edit.php?id=".(int)$_POST['id']);
        exit;
    }



