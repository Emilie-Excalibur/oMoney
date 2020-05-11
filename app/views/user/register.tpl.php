<div class="container">

<?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>
<div id="errors"></div>

        <div class="card card-register mx-auto mt-5">
            <div class="card-header">Créer un compte</div>
            <div class="card-body">

                <form method="post" action="" id="register-form" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="username">Nom</label>
                                   <input 
                                   class="form-control username" 
                                   id="username" 
                                   type="text" 
                                   name="username" 
                                   placeholder="Votre nom"
                                   value="<?= isset($user) ? $user->getName() : ''; ?>"
                                   >
                                   <small id="nameHelp" class="form-text small-form">Le nom doit contenir 3 caractères minimum</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                        class="form-control email" 
                        id="email" 
                        type="email" 
                        aria-describedby="emailHelp" 
                        placeholder="Votre email"
                        name="email" 
                        value="<?= isset($user) ? $user->getEmail() : ''; ?>"
                        >
                        <small id="emailhelp" class="form-text small-form">Les accents et les caractères spéciaux ! # $ % & ' * + / = ? ^ ` { | } ~ ne sont pas autorisés.</small>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="password_1">Mot de passe</label>

                                <input 
                                class="form-control password_1" id="password_1" 
                                type="password" 
                                name="password_1"
                                placeholder="Votre mot de passe"
                                >
                                <small id="password_1" class="form-text small-form">Le mot de passe doit contenir 3 caractères minimum</small>
                            </div>

                            <div class="col-md-6">
                                <label for="password_2">Confirmer le mot de passe</label>

                                <input class="form-control password_2" id="passsword_2" type="password" name="password_2" placeholder="Confirmer votre mot de passe">
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-info btn-block">S'inscrire</button>

                </form>

                <div class="text-center">
                    <a class="d-block small mt-3" href="<?= $router->generate('user-login');?>">Déja inscrit ? Se connecter</a>
                </div>
            </div>
        </div>
    </div>

<script src="assets/js/register.js"></script>
