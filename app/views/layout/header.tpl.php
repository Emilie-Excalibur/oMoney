
<?php 
//dump($connectedUser); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>oMoney | <?= isset($pageName) ? $pageName : ''; ?></title>

    <!-- Bootstrap core CSS-->
    <link href="<?= $baseUri; ?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts-->
    <link href="<?= $baseUri; ?>/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- CSS-->
    <link href="<?= $baseUri; ?>/assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Header-->
    <header class="bg-dark text-white border-bottom border-white">
        <a class="navbar-brand mx-3" href="<?= $router->generate('main-home'); ?>">
            <h1>oMoney</h1>
        </a>
    </header>

    <main class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h2>Mieux gérer son argent</h2>
            </div>

            <ul class="list-unstyled components">
                <ul class="list-unstyled CTAs">

                <?php 
                        // Si visiteur
                        if($connectedUser === null) : 
                    ?>
                        <li>
                            <a href="<?= $router->generate('user-login'); ?>">Se connecter</a>
                        </li>
                        <li>
                            <a href="<?= $router->generate('user-register'); ?>">Créer un compte</a>
                        </li>
                    <?php endif; ?>

                    <?php 
                    // Si utilisateur connecté
                        if($connectedUser != null) : 

                    ?>
                        <div class="user_picture" style="background-color:green;">
                        <p class="user_letter">E</p>
                    </div>
                    <p class="text-center"><?=  isset($connectedUser) ? $connectedUser->getName() : ''; ?></p>

                    <?php endif; ?>
                </ul>

                <li class="<?= $viewName === 'main/home' ? 'active' : ''; ?>">
                    <a href="<?= $router->generate('main-home') ?>">Accueil</a>
                </li>

                <li>
                    <a href="#Submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Gestion des dépenses</a>
                    <ul class="collapse list-unstyled" id="Submenu">
                        <li class="list-collapse">
                            <a href="<?= $router->generate('account-expenses'); ?>">Ajouter un retrait d'argent</a>
                        </li>
                        <li class="list-collapse">
                            <a href="<?= $router->generate('account-income'); ?>">Ajouter un virement</a>
                        </li>
                    </ul>
                </li>
                <li class="<?= $viewName === 'account/history' ? 'active' : ''; ?>">
                    <a href="<?= $router->generate('account-history'); ?>">Historique</a>
                </li>

                <?php 
                    if($connectedUser != null) :
                ?>

                    <li class="<?= $viewName === 'user/profil' ? 'active' : ''; ?>">
                        <a href="<?= $router->generate('user-profil'); ?>">Profil</a>
                    </li>

                    <li class="<?= $viewName === 'password' ? 'active' : ''; ?>">
                        <a href="">Changer le mot de passe</a>
                    </li>

                    <li>
                        <a href="<?= $router->generate('user-logout'); ?>">Déconnexion</a>
                    </li>

                <?php endif; ?>

            </ul>

        </nav>

        <!-- Page Content Holder -->
        <div id="content">

            <!-- Sidebar Button -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <p>Vous devez être connecté pour visualiser vos dépenses.</p>

                </div>
            </nav>