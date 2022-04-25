<?php
    $pdo = require_once __DIR__ . '/config/dp.php';
    $params = require_once __DIR__ . '/config/params.php';

    $sql = "SELECT * FROM users WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([(int)$_GET['id']]);

?>

<!DOCTYPE html>
<html lang="en">
<?= require_once __DIR__ . '/header_html.php' ?>
    <body class="mod-bg-1 mod-nav-link ">
        <main id="js-page-content" role="main" class="page-content">

            <div class="col-md-8">
                <?php
                    include_once 'SessionHelper.php';
                    SessionHelper::showSession();

                    if (empty($_SESSION['form'])){
                       $_SESSION['form']
                            = $user
                            = $statement->fetch();
                        $_SESSION['form']['old_avatar'] = $user['old_avatar'] = $user['avatar'];
                        unset($_SESSION['form']['avatar']);
                    }
                ?>

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
                                Изменение данных пользователя
                            </h5>
                            <div class="frame-wrap">
                                <form method="post" action="update.php" name="update_form" enctype="multipart/form-data">
                                    <input type="hidden" id="user_id" class="form-control" name="id" value="<?=$_GET['id'] ?>">

                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Логин</label>
                                        <input type="text" id="simpleinput" class="form-control" name="name" value="<?=$_SESSION['form']['name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-email-2">Email</label>
                                        <input type="email" id="example-email-2" name="email" class="form-control" placeholder="Email" value="<?=$_SESSION['form']['email'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-password">Password</label>
                                        <input type="password" id="example-password" class="form-control" value="" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-select">Роль</label>
                                        <select class="form-control" id="example-select" name="role">

                                            <?php
                                            foreach ($params['roles'] as $role_val=>$role_descr):
                                                ?>
                                                <option value="<?=$role_val ?>"  <?=( $_SESSION['form']['role'] == $role_val ? 'selected' : '')?> ><?=$role_descr ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-select2">Пол</label>
                                        <select class="form-control" id="example-select2" name="sex">
                                            <option value="1" <?=( $_SESSION['form']['sex'] != 2 ? 'selected' : '')?> >Муж</option>
                                            <option value="2" <?=( $_SESSION['form']['sex'] == 2 ? 'selected' : '')?> >Жен</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="status">Активен  <br/>
                                            <input type="hidden" name="checkbox" value="0">
                                            <input type="checkbox" value="1" id="status" name="status" <?=( empty($_SESSION['form']['status'])  ? '' : 'checked="checked')?>">
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        include_once 'UserDecorator.php';
                                        $UserDecorator = new UserDecorator($params);
                                           echo $UserDecorator->avatar([
                                                   'avatar'=> $_SESSION['form']['old_avatar'],
                                                   'sex'   => $_SESSION['form']['sex'],
                                                   'status' => $_SESSION['form']['status']
                                           ]);
                                        ?>" <br/>
                                        <label class="form-label" for="example-fileinput">Аватар</label>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="avatar">
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning">Изменить</button>
                                        <a href="/index.php" class="btn btn-primary">Отмена</a>
                                    </div>
                                </form>
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
