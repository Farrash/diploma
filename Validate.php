<?php
include_once 'SessionHelper.php';

class Validate
{
    private $pdo;
    private $params;

    public function __construct(PDO $pdo, array $params)
    {
        $this->pdo = $pdo;
        $this->params = $params;
    }

    public function name(string $str, $id = null){
        $name = preg_replace('%[^A-Za-zА-Яа-я0-9-_ ]%', '', $str);
        if (empty(trim($str))){
            SessionHelper::addError("Недопустимые символы в пользовательстком логине или он пустой.");
        }
        if ($this->isnot_unique_name($name,$id))    {
            SessionHelper::addError("$name уже существует в базе данных.");
        }
        return $name;
    }

    public function email(string $email, $id = null){
        $email = htmlspecialchars($email);
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)){
            SessionHelper::addError("Невалидный email");
        }
        if ($this->isnot_unique_email($email,$id))    {
            SessionHelper::addError("$email уже существует в базе данных.");
        }
        return $email;
    }

    public function checkEmptyPass(string $str){
        if (empty($str)){
            SessionHelper::addError("Пароль не может быть пустым");
        }
        return password_hash($str, PASSWORD_DEFAULT);
    }



    public function role(string $str){
        if (!in_array($str, array_keys($this->params['roles']))){
            SessionHelper::addError("Недопустимая роль, не надо ломать html-формы");
        }
        return $str;
    }

    public function sex( $str){
        return  (!empty($str) && $str == $this->params['sex']['FEMALE']) ? $this->params['sex']['FEMALE']  : $this->params['sex']['MALE'];
    }

    public function status($str){
        return (int)(!empty($str));
    }

    public function avatar($uploaded_file){
        if (empty($uploaded_file['name'])) return null;

        if (
            empty($uploaded_file['error']) && !empty($uploaded_file['tmp_name']) && is_uploaded_file($uploaded_file['tmp_name'])
        ) {
            $new_filename = uniqid().'.'.self::get_file_extension($uploaded_file['name']);
            move_uploaded_file($uploaded_file['tmp_name'],  $this->params['avatars_path'].$new_filename);
            return $new_filename;
        } else {
            SessionHelper::addError("Не удалось загрузить файл, код ошибки: ".$uploaded_file['error']);
            return null;
        }
    }





    private function isnot_unique_name($name,$id){
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE name = :name and id != :id");
        $stmt->execute(['name'=>$name, 'id'=>$id]);
        return $stmt->fetchColumn();
    }

    private function isnot_unique_email($email,$id){
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email and id != :id");
        $stmt->execute(['email'=>$email, 'id'=>$id]);
        return $stmt->fetchColumn();
    }

    public static function get_file_extension($file_path) {
        $basename = basename($file_path);
        if ( strrpos($basename, '.')!==false ) {
            $file_extension = substr($basename, strrpos($basename, '.') + 1);
        } else {
            $file_extension = false;
        }
        return $file_extension;
    }
}