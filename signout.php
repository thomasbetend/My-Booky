<?php 

$title="MyBooky - Connexion";

require('head.php');

?> 

<?php

if(empty($_SESSION)){

    header('location: index.php');

} else {


        $_SESSION = array();
        session_destroy();
        unset($_SESSION);
        header('location: index.php');
    }?>

<?php include_once('footer.php'); ?>

</body>
</html>

