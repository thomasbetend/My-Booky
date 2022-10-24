<?php

function creationCart () {
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart']=array();
        $_SESSION['cart']['quantity_product']=array();
        $_SESSION['cart']['price_product']=array();
    }

    return true;
}