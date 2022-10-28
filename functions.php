<?php

function testInput($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    $data= strtolower($data);
    return $data;
}
