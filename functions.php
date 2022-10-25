<?php

function creationCart () {
    if(!isset($_SESSION['login'])){
        $_SESSION['cart']=array();
        $_SESSION['cart']['book']=array();
        $_SESSION['cart']['quantity']=array();
        $_SESSION['cart']['price']=array();
    }

    return true;
}

function addToCart( $id, $qty, $price) {
    if (isset ($_SESSION['login'])){
        $_SESSION['cart']['book'][$id] = $id;
        $_SESSION['cart']['quantity'][$id] += $qty;
        $_SESSION['cart']['price'][$id] = $price;
    }
    return $qty;
}

function testInput($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    $data= strtolower($data);
    return $data;
}
