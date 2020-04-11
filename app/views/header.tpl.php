<?php session_start(); ?>

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
        <a class="navbar-brand" href="index.php">
            <h1>oMoney</h1>
        </a>
    </header>

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Mieux gérer son argent</h3>
            </div>

            <ul class="list-unstyled components">
                <ul class="list-unstyled CTAs">
                    <li>
                        <a href="">Se connecter</a>
                    </li>
                    <li>
                        <a href="">Créer un compte</a>
                    </li>
                </ul>

                <li>
                    <a href="index.php">Accueil</a>
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