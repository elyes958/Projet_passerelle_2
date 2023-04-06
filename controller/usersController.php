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
        // echo "Please enter your email and password.";
        require('view/loginViewUsers.php');
    }
    // Fin de la partie connexion

    // Début de la partie connexion en tant qu'administrateur
    function adminVerification() {
        if(!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $adminResult = adminLogin($email, $password);

            if($adminResult['success']) {
                header('location: index.php?page=admin_connexion&success=1');
                exit();
            } else {
                header('location: index.php?page=admin_connexion&error=1&message=' . $adminResult['message']);
                exit();
            }
        }
        require('view/adminLoginView.php');
    }

    // Début de la partie déconnexion
    function logout() {
        // Désactiver la session
        session_start();
        session_unset();
        session_destroy();

        // Rediriger vers la page d'accueil
        header('Location: index.php?page=connexion');  // me redirige vers la page de connexion en tant qu'utilisateur meme si je me deco en tant qu'admin
        exit();
    }

// Fin de la partie déconnexion

// Début de la partie ajouter/modifier/supprimer
function actionData() {
    // Traitement des actions des boutons
    if (isset($_POST['add'])) {
        $fileName = null;
        if (isset($_FILES['images']) && $_FILES['images']['error'] === 0) {
            if ($_FILES['images']['size'] <= 3000000) {
                $informationImage = pathinfo($_FILES['images']['name']);
                $extensionImage = $informationImage['extension'];
                $extensionsArray = ['png', 'gif', 'jpg', 'jpeg'];
                if (in_array($extensionImage, $extensionsArray)) {
                    $fileName = time() . rand() . rand() . '.' . $extensionImage;
                    move_uploaded_file($_FILES['images']['tmp_name'], 'public/assets/images/'.$fileName);
                } else {
                    echo 'Le fichier doit être une image de type png, gif, jpg ou jpeg.';
                }
            } else {
                echo 'Le fichier est trop volumineux (3 Mo maximum)';
            }
        }
        addArticle($_POST['title'], $_POST['content'], $fileName);
    } elseif (isset($_POST['update'])) {
        $newimage = null;
        if (isset($_FILES['images']) && $_FILES['images']['error'] === 0) {
            if ($_FILES['images']['size'] <= 3000000) {
                $informationImage = pathinfo($_FILES['images']['name']);
                $extensionImage = $informationImage['extension'];
                $extensionsArray = ['png', 'gif', 'jpg', 'jpeg'];
                if (in_array($extensionImage, $extensionsArray)) {
                    $newimage = time() . rand() . rand() . '.' . $extensionImage;
                    move_uploaded_file($_FILES['images']['tmp_name'], 'public/assets/images/'.$newimage);
                } else {
                    echo 'Le fichier doit être une image de type png, gif, jpg ou jpeg.';
                }
            } else {
                echo 'Le fichier est trop volumineux (3 Mo maximum)';
            }
        }
        updateArticle($_POST['id'], $_POST['title'], $_POST['content'], $newimage ? $newimage : $_POST['old_images']);
    } elseif (isset($_POST['delete'])) {
        deleteArticle($_POST['id']);
    }

    // Récupération des articles
    $articles = getArticles();

    // Chargement de la vue
    require_once 'view/adminView.php';
}

// Début de la partie ajout d'un commentaire sour les articles
function commentsController() {
    if(isset($_POST['commentaires']) && isset($_POST['auteur']) && isset($_POST['article_id'])) {

        if (!isset($_SESSION['connect'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: index.php?page=connexion');
            exit();
        }


        $commentaires = htmlspecialchars($_POST['commentaires']);
        $auteur       = htmlspecialchars($_POST['auteur']);
        $article_id   = htmlspecialchars($_POST['article_id']);
        
        $result = addComments($article_id, $auteur, $commentaires);

        if ($result) {
            // Rediriger vers la page d'accueil
            header('Location: index.php?page=accueil');
            exit();
        } else {
            // Gérer l'erreur
            echo "Une erreur est survenue lors de l'ajout du commentaire";
        }
    }

    // Afficher tous les articles
    $articles = getArticles();

    // Afficher tous les commentaires
    $commentsByArticle = array();
    foreach ($articles as $article) {
        $commentsByArticle[$article['id']] = allComments($article['id']);
    }

    // Afficher la vue
    require('view/homeView.php');
}


?>

    
    

