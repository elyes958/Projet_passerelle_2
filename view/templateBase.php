<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="public/design/default.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-dark bg-dark navbar-expand ">
        <div class="container">

            <div class="navbar-brand fw-bold">
                Blog
            </div>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <!-- lien de la page accueil a faire ! -->
                    <li class="nav-item">
                        <a href="index.php?page=accueil" class="nav-link active fst-italic">Accueil</a>   
                    </li>
                    
                    <li class="nav-item">
                        <a href="index.php?page=inscription" class="nav-link active fst-italic">Inscription</a>
                    </li>

                    <li class="nav-item">
                        <a href="index.php?page=connexion" class="nav-link active fst-italic">Connexion</a>
                    </li>

                    <li class="nav-item">
                        <a href="index.php?page=admin_connexion" class="nav-link active fst-italic">Admin</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <?= $content ?>

    <footer class="text-center text-white bg-dark p-1 fst-italic fixed-bottom">© Edouard et Elyès @2023</footer>

</body>

</html>