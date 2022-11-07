<?php

function testInput($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    $data= strtolower($data);
    return $data;
}

function testBookName($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= strtolower($data);
    return $data;
}

function testInputNotLowerCase($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    return $data;
}
