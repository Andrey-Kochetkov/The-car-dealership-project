<?php
session_start();

if ($_SESSION['role'] !== 'moderator')
    die('Not enough permission');

if (!isset($_GET['id']))
    die('id empty');

require_once 'database.php';

$db = new database();
$db->removeCar($_GET['id']);

header('Location: index.php');
