<?php

session_start();

if(empty($_SESSION['id'])=){
    echo "vous n'avez pas les droits pour supprimer";
}

else{
    header('location: book-modif');
}