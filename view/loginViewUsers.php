<?php session_start(); ?>

<?php
$title = "connexion";

ob_start();
?>



<?php if(isset($_SESSION['connect'])) { ?>
    <h1>Bonjour !</h1>
    <?php 
    if(isset($_GET['success'])) {
        echo "Vous etes maintenant connecté.";
    } ?>
    <p>Vous pouvez accéder à nos artciles et nos projets !</p>
    <small><a href="index.php?action=logout">Déconnexion</a></small>
<?php } else { ?>
    <h1>S'identifier</h1>
    <form method="post" action="index.php?page=connexion">
        <input type="email" name="email" placeholder="Votre adresse email" required />
        <input type="password" name="password" placeholder="Mot de passe" required />
        <button type="submit">S'identifier</button>
        <label id="option"><input type="checkbox" name="auto" checked />Se souvenir de moi</label>
    </form>
    
    <p >Première visite sur notre blog ? <a href="index.php?page=inscription">Inscrivez-vous</a>.</p>
    <?php } ?>





<?php
$content = ob_get_clean();

require('templateBase.php');
?>