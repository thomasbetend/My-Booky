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

function testInput($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    $data= strtolower($data);
    return $data;
}
