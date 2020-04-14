<form method="post" id="form-password">
    <div class="form-group">
        <label for="old_password">Mot de passe actuel</label>
        <input type="password" class="form-control old_password" id="old_password" name="old_password">
    </div>

    <div class="form-group">
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" class="form-control new_password" id="new_password" name="new_password">
    </div>

    <div class="form-group">
        <label for="new_password_conf">Confirmer le nouveau mot de passe</label>
        <input type="password" class="form-control new_password_conf" id="new_password_conf" name="new_password_conf">
    </div>  

    <div id="errors"></div>

    <button type="submit" class="btn btn-success update_password" name="update_password">Mettre à jour le mot de passe</button>

</form>

<script src="assets/js/changePassword.js"></script>

