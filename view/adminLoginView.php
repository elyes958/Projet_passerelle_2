<?php if (!isset($_SESSION)) {
    session_start();
} ?>

<?php 
    $title = "admin_connexion";

    ob_start();
?>

<?php if(isset($_SESSION['adminConnect'])) { ?>
    <h1 class="text-center m-3">Bonjour !</h1>
        <div class="container text-center">
        <p class="fst-italic">Vous etes maintenant connecté en tant qu'administrateur !</p>
        <a href="index.php?page=vue_admin" class="text-decoration-none text-dark fw-bold ">Accéder à la page administrateur</a>
        <a href="index.php?action=logout" class="text-decoration-none text-dark fw-bold ">Déconnexion</a>
    </div>
<?php } else { ?>
    <h1 class="text-center mt-3">S'identifier en tant qu'admin</h1>
    <form method="post" action="index.php?page=admin_connexion">
        <div class="container">
        <p>
            <label for="email" class="form-label fst-italic">Email</label>
            <input type="email" name="email" placeholder="Votre adresse email" required class="form-control-plaintext"/>
        </p>

        <p>
            <label for="password" class="form-label fst-italic">Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" required class="form-control"/>
        </p>
        
        <button type="submit" class="btn btn-primary fw-bold">S'identifier</button>
        </div>
        
    </form>
    <?php } ?>


<?php 
    $content = ob_get_clean();

    require('templateBase.php');
?>