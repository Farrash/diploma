<?php
    $pdo = require_once __DIR__ . '/config/dp.php';
    $params = require_once __DIR__ . '/config/params.php';

    $sql = "SELECT id, name, email, password, role, avatar, sex, status FROM users WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([(int)$_GET['id']]);
    $user = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<?= require_once __DIR__ . '/header_html.php' ?>

<body class="mod-bg-1 mod-nav-link ">
    <main id="js-page-content" role="main" class="page-content">
        <div class="col-md-9">
            <?php
                    include_once 'SessionHelper.php';
                    SessionHelper::showSession(); ?>

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Задание
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <h5 class="frame-heading">
                            Обычная таблица
                        </h5>
                        <div class="frame-wrap">
                            <div class="form-group">
                                <a href="/index.php" class="btn btn-success"><< Вернуться к списку</a>
                            </div>
                            <table class="table m-0" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Фото</th>
                                        <th>Логин</th>
                                        <th>Email</th>
                                        <th>Доступ</th>
                                        <th>Пол</th>
                                        <th>Активен</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                include_once 'UserDecorator.php';
                                $UserDecorator = new UserDecorator($params);

                                ?>
                                    <tr>
                                        <th scope="row">#</th>
                                        <td><?=$UserDecorator->avatar($user) ?></td>
                                        <td><?=$user['name'] ?></td>
                                        <td><?=$user['email'] ?></td>
                                        <td><?=$UserDecorator->role($user) ?></td>
                                        <td><?=$UserDecorator->sex($user)  ?></td>
                                        <td><?=$UserDecorator->status($user) ?></td>
                                        <td>
                                            <a href="edit.php?id=<?=$user['id'] ?>" class="btn btn-warning fa fa-pen" data-toggle="tooltip" data-original-title="Изменить"></a>
                                            <a href="delete.php?id=<?=$user['id'] ?>" class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-original-title="Удалить"></a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>
        // default list filter
        initApp.listFilter($('#js_default_list'), $('#js_default_list_filter'));
        // custom response message
        initApp.listFilter($('#js-list-msg'), $('#js-list-msg-filter'));
    </script>
</body>
</html>
