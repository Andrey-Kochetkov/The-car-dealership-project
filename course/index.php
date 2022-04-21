<?php
session_start();
require_once 'topNav.php';

if (!isset($_SESSION['authed']) || $_SESSION['authed'] !== true)
    header('Location: login.php');

require_once 'database.php';

$db = new database();

?>

<!doctype html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Автосалон</title>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        .cars {
            display: flex;
            flex-flow: row wrap;
            width: auto;
            height: auto;
            margin-top: 50px;
        }

        .car {
            width: 300px;
            height: 325px;
            border: black solid 1px;
            margin: 15px;
        }
        .car p{
            margin-left: 10px;
        }
        .car a {
            color: red;
            text-decoration: none;
            float: right;
            margin-right: 5px;
        }

        .car a:hover{
            text-decoration: underline;

        }

        .car img {
            width: 300px;
            height: 150px;
        }
    </style>
</head>

<body>
<?PHP get_top_nav(); ?>
<div class="cars">
    <?PHP
        $cars = $db->getCars();
        foreach ($cars as $car){
            echo "<div class='car'>";
            echo "<img src='data:image/jpeg;base64," . $car['image'] . '\'>';
            echo '<p> Брэнд: ' . $car['brand'] . '</p>';
            echo '<p> Модель: ' . $car['model'] . '</p>';
            echo '<p> Пробег: ' . $car['mileage'] . ' КМ</p>';
            echo '<p> Цена: ' . $car['price'] . ' ₽</p>';
            if ($_SESSION['role'] === 'moderator')
                echo '<a class="remover" href="removeCar.php?id=' . $car['id'] . '">Удалить</a>';
            echo "</div>";
        }
    ?>
</div>
</body>
</html>
