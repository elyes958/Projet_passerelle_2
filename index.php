<?php
    session_start();
    require('controller/usersController.php'); // ont appel le controlleur dans l'index qui va lié la view et le model

    try{

        if(isset($_GET['page'])) {

            if($_GET['page'] == 'inscription') {
                registerUsers();
            }
            elseif ($_GET['page'] == 'connexion') {
                loginVerification();
            }
            elseif ($_GET['page'] == 'vue_admin') {
                actionData();
            }
            elseif ($_GET['page'] == 'admin_connexion') {
                adminVerification();
            }
            elseif ($_GET['page'] == 'accueil') {
                commentsController();
            }
            else{
                throw new Exception("Cette page n'existe pas ou a été supprimée.");
            }

        }
        elseif (isset($_GET['action']) && $_GET['action'] == 'logout') {
            logout();
        }
        else{
            loginVerification();
        }

    }
    catch(Exception $e) {
        $error = $e->getMessage();
        require('view/errorView.php'); // ont appel cet view si il y'a une erreur
    }
?>