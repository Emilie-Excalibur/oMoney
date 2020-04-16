<div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">Créer un compte</div>
            <div class="card-body">
                <form method="post" action="" id="register-form">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">Nom</label>
                                   <input class="form-control username" id="username" type="text" name="username" value="">
                                   <small id="nameHelp" class="form-text small-form">Le nom doit contenir 3 caractères minimum</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>

                        <input class="form-control email" id="email" type="email" aria-describedby="emailHelp" name="email" value="">
                        <small id="emailhelp" class="form-text small-form">Les accents et les caractères spéciaux ! # $ % & ' * + / = ? ^ ` { | } ~ ne sont pas autorisés.</small>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="password_1">Mot de passe</label>

                                <input class="form-control password_1" id="password_1" type="password" name="password_1">
                                <small id="passwordHelpBlock" class="form-text small-form">Le mot de passe doit contenir 3 caractères minimum</small>
                            </div>

                            <div class="col-md-6">
                                <label for="password_2">Confirmer le mot de passe</label>

                                <input class="form-control password_2" id="passsword_2" type="password" name="password_2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Choisir un avatar</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="picture">
                    </div>

                    <div id="errors"></div>

                    <button class="btn btn-info btn-block" name="reg_user">S'inscrire</button>

                </form>

                <div class="text-center">
                    <a class="d-block small mt-3" href="<?= $viewVars['BaseUri']; ?>/login">Déja inscrit ? Se connecter</a>
                </div>
            </div>
        </div>
    </div>

  <script src="assets/js/register.js"></script>
