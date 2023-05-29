<?php
$URI = $_SERVER['REQUEST_URI'];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// get current path
$path = substr($URI, strpos($URI, '/') + 1);
?>

<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= App\Config::TITLE ?></title>

    <!-- use this to apply dynamic urls easier -->
    <base href="<?= App\Config::BASE ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= App\Config::IMG ?>/favicon.ico"/>

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= App\Config::CSS ?>/style.css">
</head>
<body>
<!-- Closing tags located in the footer.php file -->