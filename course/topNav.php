<?php


function get_top_nav()
{
    $output = '<div class="topnav">
        <a class="active" href="index.php">Главная</a>';
    if ($_SESSION['role'] === 'moderator')
        $output .= '<a href="addCar.php">Добавить автомобиль</a>';

    if ($_SESSION['authed'] != true)
        $output .= '<a href="login.php" style="float:right;">Вход</a><a href="signUp.php" style="float:right;">Регистрация</a>';
    else {

        $output .= '<a href="close_session.php" style="float:right;">Выход</a>';
//        if ($_SESSION['admin'])
//            $output .= "<a style=\"float:right; color: red;\" href=\"panel.php\">You're poweruser!</a>";
        $output .= "<a style=\"float:right;\">{$_SESSION['login']}</a>";
    }
    $output .= '</div>';
    echo $output;
}

?>
