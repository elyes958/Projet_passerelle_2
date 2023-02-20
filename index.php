<?php
    require('controller/usersController.php'); // ont appel le controlleur dans l'index qui va lié la view et le model

    try{

        if(isset($_GET['page'])) {

            if($_GET['page'] == 'inscription') {
                registerUsers();
            }
            elseif ($_GET['page'] == 'connexion') {
                loginVerification();
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