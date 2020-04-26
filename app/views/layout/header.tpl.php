<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>oMoney <?= isset($pageName) ? '| ' . $pageName : ''; ?></title>

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
        <div class="alert alert-danger text-center">oMoney est actuellement en pleine rénovation, merci de ne pas faire de transactions durant cette periode !</div>
    </header>

    <main class="wrapper">
        <!-- Sidebar Holder -->
        <?php require __DIR__ . '/../partials/nav.tpl.php'; ?>

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

                    <?php 
                        // Si visiteur
                        if(!$connectedUser) :
                    ?>
                    <p class="text-danger"> <i class="fa fa-exclamation-circle"></i> Vous devez être connecté pour visualiser vos dépenses.</p>
                    <?php endif; ?>

                    <p class="nav_page">
                        <a href="<?= $router->generate('main-home'); ?>">
                            <i class="fa fa-home"></i>
                        </a> 
                        / 
                        <?= isset($pageName) ? $pageName : ''; ?>
                    </p>

                </div>
            </nav>