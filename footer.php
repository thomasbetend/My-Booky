<footer class="py-3 my-4 footer mt-auto py-3">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item"><a href="index.php" class="nav-link px-2 text-muted">Accueil</a></li>
        <?php if(!isset($_SESSION['login'])){ ?>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Connexion</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="signout.php" class="nav-link px-2 text-muted">Déconnexion</a></li>
        <?php } ?>
    </ul>
    <p class="text-center text-muted"> BookyMe</p>
</footer>