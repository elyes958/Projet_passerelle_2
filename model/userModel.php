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

    // Début de la partie connexion

    function loginUser($email, $password) {
        // Lancement de la session
        session_start();

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
    
?>