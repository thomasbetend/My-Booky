<footer class="py-3 my-4 footer mt-auto py-3">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <?php if(!empty($_SESSION['login'])){ ?>
            <li class="nav-item"><a href="index.php" class="nav-link px-2 text-muted">Accueil</a></li>
            <li class="nav-item"><a href="signout.php" class="nav-link px-2 text-muted">Déconnexion</a></li>
    </ul>
    <p class="text-center text-muted"> MyBooky</p>
    <?php } ?>
</footer>