<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>oMoney</title>

    <!-- Bootstrap core CSS-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts-->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- CSS-->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Header-->
    <header class="bg-dark text-white border-bottom border-white">
        <a class="navbar-brand" href="<?= $viewVars['BaseUri'] ?>/">
            <h1>oMoney</h1>
        </a>
    </header>

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h2>Mieux gérer son argent</h2>
            </div>

            <ul class="list-unstyled components">
                <ul class="list-unstyled CTAs">
                    <li>
                        <a href="<?= $viewVars['BaseUri'] ?>/connexion">Se connecter</a>
                    </li>
                    <li>
                        <a href="<?= $viewVars['BaseUri'] ?>/inscription">Créer un compte</a>
                    </li>
                </ul>

                <li>
                    <a href="<?= $viewVars['BaseUri'] ?>/">Accueil</a>
                </li>

                <li>
                    <a href="#Submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Gestion des dépenses</a>
                    <ul class="collapse list-unstyled" id="Submenu">
                        <li class="list-collapse">
                            <a href="#">Ajouter un retrait d'argent</a>
                        </li>
                        <li class="list-collapse">
                            <a href="#">Ajouter un virement</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Historique</a>
                </li>
                <li>
                    <a href="#">Profil</a>
                </li>
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
                </div>
            </nav>        