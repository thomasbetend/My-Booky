<?php

session_start();

if(empty($_SESSION)){

    header('location: index.php');

} else {

include_once('functions.php');

$id= testInput($_GET['id']);

$_SESSION['cart']['quantity'][$id]=0;
$_SESSION['cart']['price'][$id]=0;

header('location: cart.php');
exit();

}