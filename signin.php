<?php 

if($_POST){

    $errorMessage = '';
    
    if(!empty($_POST['user_password']) && !empty($_POST['user_lastname']) && $_POST['user_firstname']){

        function testInput($data){
            $data= trim($data);
            $data= stripslashes($data);
            $data= htmlspecialchars($data);
            return $data;
        }
    
        $lastname = testInput($_POST['user_lastname']);
        $email = testInput($_POST['user_email']);
        $firstname = testInput($_POST['user_firstname']);
        $passUser = $_POST['user_password'];

        $pdo = new \PDO('mysql:host=localhost;dbname=the_library_factory','root','');
        $query = 'SELECT * FROM user';
        $statement = $pdo->query($query);
        $users = $statement->fetchAll();

        foreach ($users as $user) {
            if (($user['lastname'] == $lastname) && ($user['firstname'] == $firstname) && (password_verify($passUser, $user['pass_user']))) {

                session_start();
    
                $_SESSION['login'] = $firstname . ' ' . $lastname;
                header('location: index.php');
                exit();
    
            } else {
                $errorMessage = 'Renseignements incorrects';
            }
        }


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
    <title>Signin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('nav-bar.php'); ?>

    <div class="container w-50">
        <div class="mt-5"></div>
            <h3>Identifiez-vous</h3>
            <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="mt-3">
                <div class="form-group mb-2">
                    <label for="user_firstname">Prénom</label>
                    <input type="text" id="firstname" name="user_firstname" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="user_lastname">Nom</label>
                    <input type="text" id="lastname" name="user_lastname" class="form-control">
                </div>
                <div class="form-group mb-2">
                    <label for="user_email">Email</label>
                    <input type="text" id="email" name="user_email" class="form-control">
                    <p><?php if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {echo "Email incorrect, veuillez recommencer.";} ?></p>
                </div>
                <div class="form-group mb-2 mt-2">
                    <label for="user_password">Mot de passe</label>
                    <input type="password" id="password" name="user_password" class="form-control">
                    <p>Le mot de passe doit contenir 8 caractères minimum, 1 majuscule, 1 minuscule et 1 chiffre</p>
                    <p><?php if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/" ,$passUser)) {echo "Le mot de passe doit contenir  incorrect, veuillez recommencer.";} ?></p>
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