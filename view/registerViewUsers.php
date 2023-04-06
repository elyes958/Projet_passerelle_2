<?php 
    $title = "inscription";

    ob_start();
?>

<h1 class="text-center mt-3">S'inscrire</h1>

<form method="post" action="index.php?page=inscription" class="mb-3">
    <div class="container">
    <p>
        <label for="email" class="form-label fst-italic">Email</label>
        <input type="email" name="email" placeholder="Entrez votre adresse email" required class="form-control-plaintext" />
    </p>

    <p>
        <label for="password" class="form-label fst-italic">Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe" required class="form-control" />
    </p>
    
    <p>
        <label for="password_two" class="form-label fst-italic">Retapez votre mot de passe</label>
        <input type="password" name="password_two" placeholder="Retapez votre mot de passe" required class="form-control" />
    </p>
    <button type="submit" class="btn btn-primary fw-bold">S'inscrire</button>
    </div>
</form>

<div class="container">
    <p >Déjà Inscrit ? <a href="index.php?page=connexion" class="text-decoration-none text-dark fw-bold">Connectez-vous</a>.</p>
</div>


<?php 
    $content = ob_get_clean();

    require('templateBase.php');
?>