<?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

<?php if(isset($success)) : ?>

    <div class="alert alert-success" role="alert">
       <?= $success ?>
    </div>

<?php endif; ?>

<form method="post" id="update" action="">
    <div class="form-group">
        <label for="name">Nom</label>
        <input 
        class="form-control" 
        type="text"
        id="name"
        name="name" 
        value="<?= isset($user) ? $user->getName() : $_SESSION['connectedUser']->getName(); ?>"
        >
    </div>

    <div class="form-group">
        <label for="email">Adresse email</label>
        <input 
        type="email" 
        class="form-control email" 
        id="email" 
        aria-describedby="emailHelp" 
        name="email"
        value="<?= isset($user) ? $user->getEmail() : $_SESSION['connectedUser']->getEmail(); ?>"
        >
        <small id="emailhelp" class="form-text small-form">Les accents et les caractères spéciaux ! # $ % & ' * + / = ? ^ ` { | } ~ ne sont pas autorisés.</small>
    </div>

    <div class="form-group">
        <label for="created_at">Compte créé le </label>
        <input class="form-control" type="text" id="created_at" value="<?= !empty($creationDate) ? $creationDate : ''; ?>" readonly>
    </div>

    <div id="errors"></div>

    <button type="submit" class="btn btn-success">Mettre à jour les informations</button>
</form>

<script src="assets/js/profil.js"></script>