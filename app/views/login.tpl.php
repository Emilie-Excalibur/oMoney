<div class="container">
  <div class="card card-login mx-auto mt-5">
    <div class="card-header">Se connecter</div>
    <div class="card-body">

      <form method="post" action="">
        <div class="form-group">
          <label for="exampleInputEmail1">Nom</label>
          <input class="form-control" type="text" name="username">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Mot de passe</label>
          <input class="form-control" type="password" name="password">
        </div>

        <div class="form-group">
          <div class="form-check">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox"> Se souvenir de moi</label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block" name="login_user">Se connecter</button>

      </form>
      <div class="text-center">
        <a class="d-block small mt-3" href="<?= $viewVars['BaseUri'] ?>/register">Pas encore inscrit ? Créer un compte</a>
        <!-- <a class="d-block small" href="forgot-password.php">Forgot Password?</a>-->
      </div>
    </div>
  </div>
</div>