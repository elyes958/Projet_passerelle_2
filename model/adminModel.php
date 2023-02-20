<?php 
require('vendor/dbConnexion.php');

// Récupération de tous les articles
function getArticles() {
    $pdo = getDb();
    $query = "SELECT * FROM articles";
    $stmt = $pdo->query($query);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $articles;
}

// Récupération d'un article par son ID
function getArticleById($id) {
    $pdo = getDb();
    $query = "SELECT * FROM articles WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    return $article;
}

// Ajout d'un article
function addArticle($title, $content) {
    $pdo = getDb();
    $query = "INSERT INTO articles (title, content) VALUES (:title, :content)";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->execute();
}

// Mise à jour d'un article
function updateArticle($id, $title, $content) {
    $pdo = getDb();
    $query = "UPDATE articles SET title = :title, content = :content WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->execute();
}

// Suppression d'un article
function deleteArticle($id) {
    $pdo = getDb();
    $query = "DELETE FROM articles WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
?>


?>