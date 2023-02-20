<?php 
    $title = "inscription";

    ob_start();
?>

<h1>S'inscrire</h1>

<form method="post" action="index.php?page=inscription">
    <input type="email" name="email" placeholder="Votre adresse email" required />
    <input type="password" name="password" placeholder="Mot de passe" required />
    <input type="password" name="password_two" placeholder="Retapez votre mot de passe" required />
    <button type="submit">S'inscrire</button>
</form>

<p >Déjà Inscrit ? <a href="index.php?page=connexion">Connectez-vous</a>.</p>

<?php 
    $content = ob_get_clean();

    require('templateBase.php');
?>