<!-- Fichier de connection à la BDD -->

<?php
    function getDb() {

        try {
            $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        return $bdd;
      }
?>