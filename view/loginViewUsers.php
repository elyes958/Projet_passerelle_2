<?php if (!isset($_SESSION)) {
    session_start();
}
?>

<?php
$title = "connexion";

ob_start();
?>



<?php if(isset($_SESSION['connect'])) { ?>
    <h1 class="text-center mt-2 mb-2 fw-bold">Bonjour !</h1>
    <?php 
    if(isset($_GET['success'])) { ?>
        <p class="text-center fst-italic">Vous etes maintenant connecté !</p>
    <?php
    } ?>
    <p class="text-center fst-italic mt-3">Vous pouvez accéder à nos articles !</p>
    <div class="d-flex justify-content-center">
    <a href="index.php?page=accueil" class="text-decoration-none fw-bold text-dark me-3">Accueil</a>
    <a href="index.php?action=logout" class="text-decoration-none fw-bold text-dark">Déconnexion</a>
</div>
<?php } else { ?>
    <h1 class="text-center mt-2">S'identifier</h1>
    <form method="post" action="index.php?page=connexion">
        <div class="container">
        <p>
            <label for="email" class="form-label fst-italic">Email</label>
            <input type="email" name="email" placeholder="Entrez votre adresse email" required class="form-control-plaintext"/>
        </p>

        <p>
            <label for="password" class="form-label fst-italic">Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" required class="form-control"/>
        </p>
        
        <button type="submit" class="btn btn-primary fw-bold">S'identifier</button>
        </div>
       
    </form>
    <div class="container">
    <p >Première visite sur notre blog ? <a href="index.php?page=inscription" class="text-decoration-none fw-bold text-dark">Inscrivez-vous</a>.</p>
    </div>
    
    <?php } ?>





<?php
$content = ob_get_clean();

require('templateBase.php');
?>