<?php

session_start();

if(empty($_SESSION['login'])){

    header('location: index.php');

} else {

$_SESSION['cart']['quantity'][$_GET['id']]=0;
$_SESSION['cart']['price'][$_GET['id']]=0;

header('location: cart.php');
exit();

}