<form>
    <div class="form-group">
        <label for="exampleInputEmail1">Nom</label>
        <input class="form-control" type="text" name="username" value="<?= $_SESSION['name']; ?>">
    </div>

    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= $_SESSION['email']; ?>">
    </div>

    <div class="form-group">
        <label for="password_1">Mot de passe actuel</label>
        <input type="password" class="form-control" id="password_1">
    </div>

    <div class="form-group">
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" class="form-control" id="new_password">
    </div>

    <div class="form-group">
        <label for="created_at">Compte créé le </label>
        <input class="form-control" type="text" id="created_at" placeholder="<?= getDateFormat($_SESSION['created_at']); ?>" readonly>
    </div>

    <button type="submit" class="btn btn-success">Mettre à jour les informations</button>
</form>