<?php
    require('vendor/dbConnexion.php');
    // ont inclu le fichier de connexion à la bdd.

    // Début de la partie inscription
    function getUsers() {
        $bdd = getDb(); //getDb = la fct de connexion à la bdd, inclu plus haut
        $requete = $bdd->query('SELECT * FROM users');
        return $requete;
    }

    function findByEmail($email) {
        $bdd = getDb();
        $requete = $bdd->prepare('SELECT email FROM users WHERE email = ?');
        $requete->execute([$email]);
        

        $user = $requete->fetch(PDO::FETCH_OBJ);
        return $user;
        
    }

    function createUser($email,$password) {
        $bdd = getDb();

        $password = "ba1" . sha1($password . "321") . "90";

        $secret = sha1($email) . time();
        $secret = sha1($secret) . time();

        $requete = $bdd->prepare('INSERT INTO users(email, password, secret) VALUES(?, ?, ?)');
        $response = $requete->execute([$email, $password, $secret]);
        return $response;
    }
    // fin de la partie inscription

    // Début de la partie connexion en tant qu'utilisateur

    function loginUser($email, $password) {
        // Lancement de la session
        // session_start();

        // Connexion à la base de données
        $bdd = getDb();
    
        // Vérifier si l'adresse email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array('success' => false, 'message' => 'Votre adresse email est invalide.');
        }
    
        // Chiffrer le mot de passe
        $password = "ba1" . sha1($password . "321") . "90";
    
        // Vérifier si l'email existe dans la base de données
        $req = $bdd->prepare('SELECT COUNT(*) as numberEmail FROM users WHERE email = ?');
        $req->execute([$email]);
        $emailVerification = $req->fetch(PDO::FETCH_ASSOC);
    
        if ($emailVerification['numberEmail'] != 1) {
            return array('success' => false, 'message' => 'Impossible de vous authentifier correctement.');
        }
    
        // Récupérer l'utilisateur correspondant à l'email
        $req = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute([$email]);
        $user = $req->fetch(PDO::FETCH_ASSOC);
    
        // Vérifier si le mot de passe est correct
        if ($password == $user['password']) {
            $_SESSION['connect'] = 1;
            $_SESSION['email'] = $user['email'];
    
            // if (isset($_POST['auto'])) {
            //     setcookie('auth', $user['secret'], time() + 365 * 24 * 3600, '/', null, false, true);
            // }
    
            return array('success' => true, 'message' => 'Connexion réussie.');
        } else {
            return array('success' => false, 'message' => 'Impossible de vous authentifier correctement(partie connexion final).');
        }
    }
    // Fin de la partie connexion en tant qu'utilisateur


    // Connexion en tant qu'administrateur
    function adminLogin($email, $password) {
        // Lancement de la session
        // session_start();

        // Connexion à la base de données
        $bdd = getDb();

        // Vérifier si l'adresse email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return array('success' => false, 'message' => 'Votre adresse email est invalide.');
        }

        // Chiffrer le mot de passe
        // $password = "ba1" . sha1($password . "321") . "90";

        // Vérifier si l'email existe dans la base de données
        $req = $bdd->prepare('SELECT COUNT(*) as numberEmail FROM admin WHERE email = ?');
        $req->execute([$email]);
        $emailVerification = $req->fetch(PDO::FETCH_ASSOC);

        if ($emailVerification['numberEmail'] != 1) {
            return array('success' => false, 'message' => 'Impossible de vous authentifier correctement.');
        }

        // Récupérer l'utilisateur correspondant à l'email
        $req = $bdd->prepare('SELECT * FROM admin WHERE email = ?');
        $req->execute([$email]);
        $admin = $req->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le mot de passe est correct
        if ($password == $admin['password']) {
            $_SESSION['adminConnect'] = 1;
            $_SESSION['email'] = $admin['email'];
            return array('success' => true, 'message' => 'Connexion réussie.');
        } else {
            return array('success' => false, 'message' => 'Impossible de vous authentifier correctement(partie connexion final).');
        }

    }



// Récupération de tous les articles
function getArticles() {
    $bdd = getDb();
    $query = "SELECT * FROM articles";
    $stmt = $bdd->query($query);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $articles;
}

// Récupération d'un article par son ID
function getArticleById($id) {
    $bdd = getDb();
    $query = "SELECT * FROM articles WHERE id = :id";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    return $article;
}

// Ajout d'un article
function addArticle($title, $content, $images) {
    $bdd = getDb();
    $query = "INSERT INTO articles (title, content, images) VALUES (:title, :content, :images)";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->bindValue(':images', $images, PDO::PARAM_STR);
    $stmt->execute();
}

// Mise à jour d'un article
function updateArticle($id, $title, $content, $images) {
    $bdd = getDb();
    $query = "UPDATE articles SET title = :title, content = :content, images = :images WHERE id = :id";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->bindValue(':images', $images, PDO::PARAM_STR);
    $stmt->execute();
}

// Suppression d'un article
function deleteArticle($id) {
    $bdd = getDb();
    $query = "DELETE FROM articles WHERE id = :id";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}



// Ajout d'un commentaires
function addComments($article_id, $author, $content) {
    $bdd = getDb();
    $user_id = $_SESSION['connect']; // récupérer l'identifiant de l'utilisateur connecté
    $requete = $bdd->prepare("INSERT INTO comments(article_id, user_id, author, content) VALUES (:article_id, :user_id, :author, :content)");
    $result = $requete->execute([
        'article_id' => $article_id,
        'user_id' => $user_id, // ajouter l'identifiant de l'utilisateur à la requête
        'author' => $author,
        'content' => $content
    ]);

    return $result;
}


// Afficher tous les commentaires
function allComments($article_id) {
    $bdd = getDb();
    $query = "SELECT * FROM comments WHERE article_id = ?";
    $stmt = $bdd->prepare($query);
    $stmt->execute([$article_id]);
    $allComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $allComments;
}

    
?>