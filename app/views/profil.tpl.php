<?php 
$email = $_SESSION['email'];

$sql ="SELECT created_at FROM users WHERE email='$email'";
$pdo = Database::getPDO();
$pdoStatement = $pdo->query($sql);
$userDateAccount = $pdoStatement->fetch(PDO::FETCH_ASSOC);
?>

<form method="post" id="update" action="">
    <div class="form-group">
        <label for="actual_name">Nom</label>
        <input class="form-control" type="text" name="actual_name" value="<?= $_SESSION['name']; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="new_email">Adresse email</label>
        <input type="new_email" class="form-control new_email" id="new_email" aria-describedby="emailHelp" value="<?= $_SESSION['email']; ?>" name="new_email">
        <small id="emailhelp" class="form-text small-form">Les accents et les caractères spéciaux ! # $ % & ' * + / = ? ^ ` { | } ~ ne sont pas autorisés.</small>
    </div>

    <div class="form-group">
        <label for="created_at">Compte créé le </label>
        <input class="form-control" type="text" id="created_at" placeholder="<?= getDateFormat($userDateAccount['created_at']); ?>" readonly>
    </div>

    <div id="errors"></div>

    <button type="submit" class="btn btn-success" name="update">Mettre à jour les informations</button>
</form>

<script src="assets/js/profil.js"></script>

