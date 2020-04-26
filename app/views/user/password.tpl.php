<?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

<?php if(isset($success)) : ?>

<div class="alert alert-success" role="alert">
   <?= $success ?>
</div>

<?php endif; ?>

<form method="POST" id="form-password">
    <div class="form-group">
        <label for="old_password">Mot de passe actuel</label>
        <input 
        type="password" 
        class="form-control old_password" i
        d="old_password" 
        name="old_password"
        >
    </div>
    <div class="form-group">
        <label for="new_password">Nouveau mot de passe</label>
        <input 
        type="password" 
        class="form-control new_password" 
        id="new_password" 
        name="new_password"
        >
        <small id="passwordHelpBlock" class="form-text text-muted">Le mot de passe doit contenir 3 caractères minimum</small>
    </div>
    <div class="form-group">
        <label for="new_password_conf">Confirmer le nouveau mot de passe</label>
        <input 
        type="password" 
        class="form-control new_password_conf" 
        id="new_password_conf" 
        name="new_password_conf"
        >
    </div>  
    <div id="errors"></div>
    <button type="submit" class="btn btn-success update_password">Mettre à jour le mot de passe</button>
</form>
<script src="assets/js/changePassword.js"></script>
