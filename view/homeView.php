<?php 
$title = "accueil";
ob_start();
?>

<div class="container">
<?php
if (count($articles) > 0) {
    foreach ($articles as $article) {
        ?>
        <h2 class='text-center mt-5 mb-3 fw-bold'><?php echo $article['title']; ?></h2>
        <div class='row row-cols-1 col-12 g-4'>
            <div class='col'>
                <div class='card h-100'>
                    <img src='public/assets/images/<?php echo $article['images']; ?>' class='card-img-top w-100' alt='img'>
                    <div class='card-body'>
                        <p class='card-text w-100 lead'><?php echo $article['content']; ?></p>
                    </div>
                    <div class='card-footer'>
                        <p class="fst-italic">Laisser un commentaire !</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Afficher les commentaires pour cet article -->
        <?php
        $comments = allComments($article['id']);
        if (count($comments) > 0) {
            ?>
            <h4 class="fw-bold mt-3">Commentaires :</h4>
            <ul>
                <?php
                foreach ($comments as $comment) {
                    ?>
                    <li>
                        <p><?php echo $comment['content']; ?></p>
                        <p>Par : <?php echo $comment['author']; ?></p>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        } else {
            ?>
            <p class="fst-italic mt-2">Pas encore de commentaires</p>
            <?php
        }
        ?>

        <!-- Formulaire d'ajout de commentaire pour cet article -->
        <?php
        if (isset($_SESSION['connect'])) {
            ?>
            <form method='post' action='index.php?page=accueil'>
                <input type='hidden' name='article_id' value=<?=$article['id']?>>
                <p><label for='auteur' class="form-label fst-italic">Auteur</label>
                <input type='text' name='auteur' id='auteur' class="form-control"></p>
                <p><label for='commentaires' class="form-label fst-italic">Commentaires</label>
                <textarea name='commentaires' id='commentaires' cols='30' rows='10' class="form-control"></textarea></p>
                <p><input type='submit' value='Ajouter un commentaire' class="btn btn-primary"></p>
            </form>
            <?php
        } else {
            ?>
            <p class="fst-italic mb-5">Connectez-vous pour laisser un commentaire.</p>
            <?php
        }

        // Séparateur entre les articles
        echo "<hr>";
    }
}
?>
</div>

<?php 
$content = ob_get_clean();

require('templateBase.php');
?> 
