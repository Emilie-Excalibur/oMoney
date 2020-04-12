<form action="post">

    <div class="form-group">
        <label for="balance">Solde du compte</label>
        <input class="form-control" type="number" name="balance" id="balance" min="0">
    </div>

    <div class="form-group">
        <label for="date">Date</label>
        <input class="form-control" type="date" name="date" id="date">
    </div>

    <div class="form-group">
        <label for="title">Intitulé</label>
        <input class="form-control" type="text" name="title" id="title">
    </div>

    <div class="form-group">
        <label for="title">Somme dépensée</label>
        <input class="form-control" type="number" name="title" id="title" min="0" required>
    </div>

    <button type="submit" class="btn btn-primary" name="add_expenses">Ajouter</button>
</form>