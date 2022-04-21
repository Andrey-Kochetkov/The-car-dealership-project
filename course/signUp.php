<?php
session_start();
require_once 'topNav.php';
require_once 'database.php';


if (isset($_SESSION['authed']) && $_SESSION['authed'] === true)
    header('Location: index.php');

if (isset($_POST) && isset($_POST['login']) && isset($_POST['password'])) {
    $db = new database();
    $result = $db->addUser($_POST['login'], $_POST['password']);

    if ($result === 'OK'){
        $user = $db->getUser($_POST['login']);

        $_SESSION['authed'] = true;
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['role'] = $user['role'];
    }

    die($result);

}


?>

<!doctype html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Автосалон</title>

    <script src="//code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        .login-form {
            width: 300px;
            height: 150px;
            margin: 0 auto;
            margin-top: 25vh;
            display: flex;
            flex-flow: column nowrap;
        }

        .login-form button {
            width: 175px;
            align-self: center;
        }
    </style>
    <script>
        $(document).ready(() => {
            $('#sign_in_button').click(function () {
                if ($('#username').val().trim().length === 0) {
                    toastr.error('Пустое поле имя пользователя', 'Ошибка');
                    return;
                }
                if ($('#password').val().length === 0) {
                    toastr.error('Пустое поле пароля', 'Ошибка');
                    return;
                }
                if ($('#password-retype').val().length === 0) {
                    toastr.error('Пустое поле повтора пароля', 'Ошибка');
                    return;
                }
                if ($('#password-retype').val() !== $('#password').val()) {
                    toastr.error('Пароли не сошлись', 'Ошибка');
                    return;
                }
                $.post(
                    "signUp.php",
                    {
                        login: $('#username').val(),
                        password: $('#password').val()
                    },
                    (data) => {
                        if (data === 'User exists')
                            toastr.error('Такой логин уже существует', 'Ошибка');
                        else
                            window.location.replace('index.php');
                    }
                );

            })
        })
    </script>
</head>

<body>
<?PHP get_top_nav(); ?>
<div class="login-form">
    <div class="form-group">
        <input type="text" class="form-control" id="username" placeholder="Имя пользователя">
    </div>
    <div class="form-group">
        <input type="password" id="password" class="form-control" placeholder="Пароль">
    </div>
    <div class="form-group">
        <input type="password" id="password-retype" class="form-control" placeholder="Повторите пароль">
    </div>
    <button id="sign_in_button" class="btn btn-primary">Отправить</button>
</div>
</body>
</html>
