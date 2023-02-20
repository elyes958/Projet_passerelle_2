<?php 
    require('model/userModel.php'); // ont recupere le model dans le controller

    // Début de la partie inscription
    function registerUsers() {

        $error = '';
        if (!empty($_POST['email']) && !empty($_POST['password'] && !empty($_POST['password_two']))) {

            $email        = htmlspecialchars($_POST['email']);
            $password     = htmlspecialchars($_POST['password']);
            $password_two = htmlspecialchars($_POST['password_two']);
            // ont recupere nos variables qu'on sécurise aves htmlspecialchars

            if($password != $password_two) {
                $error = 'Vos mots de passe ne sont pas identiques.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Votre adresse email est invalide.';
            }

            if (!findByEmail($email)) {
                createUser($email, $password);
                header('location:index.php');
            } else {
                $error = 'cet utilisateur existe deja';
            };

        }

        require('view/registerViewUsers.php'); // ont recupere la view dans le controller
    }
    // fin de la partie inscription
    
    // Début de la partie connexion
    function loginVerification() {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
        
            
            $loginResult = loginUser($email, $password);
            
        
            if ($loginResult['success']) {
                header('location: index.php?success=1');
                exit();
            } else {
                header('location: index.php?error=1&message=' . $loginResult['message']);
                exit();
            }
        }
        echo "Please enter your email and password.";
        require('view/loginViewUsers.php');
    }
    
    // Fin de la partie connexion

    // Début de la partie déconnexion
    function logout() {
        // Désactiver la session
        session_start();
        session_unset();
        session_destroy();

        // Rediriger vers la page d'accueil
        header('Location: index.php?page=connexion');
        exit();
    }
    
    

