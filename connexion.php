<?php

define ('ENV', 'prod');

$db = 'mysql:host=localhost; dbname=the_library_factory';
$userDB = 'root';
$passDB = '';

try {
    $pdo = new PDO($db, $userDB, $passDB);
} 
catch (PDOException $pe){
    if(ENV === 'test'){
        echo $pe->getMessage();
    } else {
        header('error.php');
    }
}