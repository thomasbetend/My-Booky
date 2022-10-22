<?php 

if($_POST){

    $errorMessage = '';
    
    if(!empty($_POST['user_password']) && !empty($_POST['user_lastname'])){

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
        $query = 'INSERT * INTO user (lastname, pass_user) VALUES (:lastname, :pass_user)';
        $statement = $pdo->prepare($query);
    
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    
        $statement->execute();

        function testInput($data){
            $data= trim($data);
            $data= stripslashes($data);
            $data= htmlspecialchars($data);
            return $data;
        }
    
        $lastname = testInput($_POST['user_lastname']);
        $passUser = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

        session_start();

        $_SESSION['login'] = $lastname;
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

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50">
        <div class="mt-5"></div>
            <h3>Identifiez-vous</h3>
            <form method="post" class="mt-3">
                <div class="form-group mb-2">
                    <label for="firstname">Nom</label>
                    <input type="text" id="lastname" name="user_lastname" class="form-control">
                <div class="form-group mb-2 mt-2">
                    <label for="lastname">Mot de passe</label>
                    <input type="password" id="password" name="user_password" class="form-control">
                </div>
                <div>
                    <?php if (!empty($errorMessage)) echo $errorMessage ;?>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-2">Signin</button>
                </div>
            </form>
            <p class="mt-4 text-secondary"><a href="signup.php">Pas encore inscrit ? Créez un compte.</a></p>
        </div>
    </div>

</body>
</html>