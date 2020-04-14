<form method="post">
    <div class="form-group">
        <label for="actual_name">Nom</label>
        <input class="form-control" type="text" name="actual_name" value="<?= $_SESSION['name']; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="new_email">Adresse email</label>
        <input type="new_email" class="form-control" id="new_email" aria-describedby="emailHelp" value="<?= $_SESSION['email']; ?>" name="new_email">
    </div>
 
    <div class="form-group">
        <label for="created_at">Compte créé le </label>
        <input class="form-control" type="text" id="created_at" placeholder="<?= getDateFormat($_SESSION['created_at']); ?>" readonly>
    </div>

    <button type="submit" class="btn btn-success" name="update">Mettre à jour les informations</button>
</form>