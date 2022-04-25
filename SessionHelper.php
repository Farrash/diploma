<?php
session_start();

class SessionHelper
{
    public static function addSuccess(string $message){
        $_SESSION['success'][] = $message;
    }

    public static function addError(string $message){
        $_SESSION['error'][] = $message;
    }

    public static function showSession(){
        if(!empty($_SESSION['error'])){
            $error_message = '';
            foreach ($_SESSION['error'] as $one_error){
                $error_message .= $one_error.'<br/>';
            }
            echo '<div class="alert alert-danger fade show in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$error_message.'</div>';
            unset($_SESSION['error']);
        }
        if(!empty($_SESSION['success'])){
            $success_message = '';
            foreach ($_SESSION['success'] as $one_success){
                $success_message .= $one_success.'<br/>';
            }
            echo '<div class="alert alert-success fade show in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$success_message.'</div>';
            unset($_SESSION['success']);
        }
    }

    public static function hasErrors(){
        return !empty($_SESSION['error']);
    }
}