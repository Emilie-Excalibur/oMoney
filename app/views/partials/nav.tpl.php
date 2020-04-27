<nav id="sidebar">
            <div class="sidebar-header">
                <h2>Mieux gérer son argent</h2>
            </div>

            <ul class="list-unstyled components">
                <ul class="list-unstyled CTAs">

                <?php 
                        // Si visiteur
                        if(!$connectedUser) : 
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
                        if($connectedUser) : 

                    ?>
                        <div class="user_picture" style="background-color:<?= isset($color) ? $color : '' ?>;">
                        <p class="user_letter"><?= isset($firstLetter) ? $firstLetter : ''; ?></p>
                    </div>
                    <p class="text-center"><?=  $connectedUser ? $_SESSION['connectedUser']->getName() : ''; ?></p>

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

                    <li class="<?= $viewName === 'user/password' ? 'active' : ''; ?>">
                        <a href="<?= $router->generate('user-password'); ?>">Changer le mot de passe</a>
                    </li>

                    <li>
                        <a href="<?= $router->generate('user-logout'); ?>">Déconnexion</a>
                    </li>

                <?php endif; ?>

                <li class="<?= $viewName === 'comments/comments' ? 'active' : ''; ?> comments">
                    <a href="<?= $router->generate('comments-comments');?>">Commentaires</a>
                </li>                

            </ul>

        </nav>