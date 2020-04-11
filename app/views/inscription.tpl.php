<div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">Créer un compte</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleInputName">Nom</label>

                                <input class="form-control" id="exampleInputName" type="text" name="username" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>

                        <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" name="email" value="">
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Mot de passe</label>

                                <input class="form-control" id="exampleInputPassword1" type="password" name="password_1">
                            </div>

                            <div class="col-md-6">
                                <label for="exampleInputPassword1">Confirmer le mot de passe</label>

                                <input class="form-control" id="exampleInputPassword2" type="password" name="password_2">
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-info btn-block" name="reg_user">S'inscrire</button>

                </form>

                <div class="text-center">
                    <a class="d-block small mt-3" href="<?= $viewVars['BaseUri']?>/connexion">Déja inscrit ? Se connecter</a>
                    <!--- <a class="d-block small" href="forgot-password.html">Forgot Password?</a>-->
                </div>
            </div>
        </div>
    </div>
