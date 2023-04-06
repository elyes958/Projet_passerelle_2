<?php if (!isset($_SESSION)) {
    session_start();
} ?>

<?php

$title = "vue_admin";

ob_start();
?>

<?php 
if (!isset($_SESSION['adminConnect'])) {
    header('Location:index.php?page=admin_connexion');
}
if (count($articles) > 0) { ?>
        <h2 class='text-center mt-3 fw-bold'>Liste des articles</h2>
        <div class='row row-cols-1 row-cols-md-2 g-4'>
 <?php   foreach ($articles as $article) {
?>
        <div class='col'>
            <div class='card h-100'>
                <img src='public/assets/images/<?php echo $article['images']; ?>' class='card-img-top img-fluid rounded' alt='img'>
                <div class='card-body'>
                    <h5 class='card-title'><?php echo $article['title']; ?></h5>
                    <p class='card-text lead'><?php echo $article['content']; ?></p>
                    <p class='fst-italic'>Laisser un commentaire !</p>
                </div>
                <div class='card-footer'>
                    <form method='post' action='' enctype='multipart/form-data'>
                        <input type='hidden' name='id' value='<?php echo $article['id']; ?>'>
                        <label class='form-label fst-italic'>Titre:</label><br>
                        <input class='form-control' type='text' name='title' value='<?php echo $article['title']; ?>'><br>
                        <label class='form-label fst-italic'>Contenu:</label><br>
                        <textarea class='form-control' name='content'><?php echo $article['content']; ?> </textarea><br>
                        <label class='form-label fst-italic'>Images:</label><br>
                        <input type='hidden' name='old_images' value='<?php echo $article['images']; ?>'>
                        <img src='public/assets/images/<?php echo $article['images']; ?>' class='card-img-top w-50' alt='img'><br>
                        <input type='file' name='images' class='btn mt-1 form-control'><br>
                        <input type='submit' name='update' value='Modifier' class='btn btn-primary mt-1 form-control'>
                        <input type='submit' name='delete' value='Supprimer' class='btn btn-danger mt-1 form-control'>
                    </form>
                </div>
            </div>
        </div>
<?php 
    } // fin du foreach
    echo "</div>";
} else {
    echo "<p>Aucun article trouvé.</p>";
}
?>





<div class="row">
  <div class="col-md-6 mx-auto">
    <h2 class="text-center fw-bold">Ajouter un article</h2>
    <form method='post' action='' enctype="multipart/form-data">
      <label class="form-label fst-italic">Titre:</label><br>
      <input  class='form-control' type='text' name='title'><br>
      <label class="form-label fst-italic">Description:</label><br>
      <textarea class='form-control' name='content'></textarea><br>
      <label class='form-label fst-italic' for="images">Fichier</label><br>
      <input type="file" name="images" class="btn form-control"><br>
      <input type='submit' name='add' value='Ajouter' class="btn btn-success mt-1 mb-5 form-control ">
    </form>
  </div>
</div>







<?php
$content = ob_get_clean();

require('templateBase.php');
?>