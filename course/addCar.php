<?php
session_start();

require_once 'topNav.php';

if ($_SESSION['role'] !== 'moderator')
    die('Not enough permission');


if (isset($_POST) &&
    isset($_POST['brand']) &&
    isset($_POST['model']) &&
    isset($_POST['mileage']) &&
    isset($_POST['price']) &&
    !empty($_FILES) &&
    $_FILES['image']['error'] == 0
)
{
    $destiation_dir = dirname(__FILE__) .'/'.$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $destiation_dir );

    $image = base64_encode(file_get_contents($destiation_dir));
    unlink($destiation_dir);

    require_once 'database.php';
    $db = new database();

    $db->addCar($_POST['brand'], $_POST['model'], $_POST['mileage'], $_POST['price'], $image);
    header('Location: index.php');
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
</head>

<body>
<?PHP get_top_nav(); ?>
<form action="./addCar.php" method="post" enctype="multipart/form-data" class="login-form">
    <div class="form-group">
        <input type="text" name="brand" class="form-control" placeholder="Брэнд">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="model" placeholder="Модель">
    </div>
    <div class="form-group">
        <input type="number" class="form-control" name="mileage" placeholder="Пробег (км)">
    </div>
    <div class="form-group">
        <input type="number" class="form-control" name="price" placeholder="Цена (руб)">
    </div>
    <div class="form-group">
        <input type="file" name="image" class="form-control">
    </div>
    <input type="submit" class="btn btn-primary" value="Отправить"/>
</form>
</body>
</html>

