<?php 

if($_POST){
    $errorMessage = '';

    
    if(!empty($_POST['user_firstname']) && !empty($_POST['user_lastname'])){

        function testInput($data){
            $data= trim($data);
            $data= stripslashes($data);
            $data= htmlspecialchars($data);
            return $data;
        }
    
        $lastname = testInput($_POST["user_lastname"]);
        $firstname = testInput($_POST["user_firstname"]);

        session_start();

        $_SESSION['login'] = $firstname . ' ' . $lastname;
        header('location: index.php');
        exit();
    } else {
        $errorMessage = 'Remplissez tous les champs';
    }
} 
        

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php 

include_once('nav-bar.php');

?>


<div class="container w-50">
    <form method="post" class="mt-3">
        <div class="form-group mb-2">
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" name="user_firstname" class="form-control" value="<?php if(isset($_POST['user_firstname'])) echo $_POST['user_firstname']?>">
        </div>
        <div class="form-group mb-2">
            <label for="lastname">Nom</label>
            <input type="text" id="lastname" name="user_lastname" class="form-control" value="<?php if(isset($_POST['user_lastname'])) echo $_POST['user_lastname']?>">
        </div>
        <div>
            <?php if (!empty($errorMessage)) echo $errorMessage ;?>
        </div>
        <div>
            <button type="submit" class="btn btn-primary mt-2">login</button>
        </div>
    </form>
</div>

</body>
</html>