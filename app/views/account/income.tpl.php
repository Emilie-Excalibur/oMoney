<form method="post" action="">
    <div class="form-group">
        <label for="date">Date</label>
        <input class="form-control" type="date" name="date" id="date">
    </div>
    <div class="form-group">
        <label for="title">Intitulé</label>
        <input class="form-control" type="text" name="title" id="title">
    </div>
    <div class="form-group">
        <label for="transfer_amount">Montant du virement</label>
        <input class="form-control" type="number" name="transfer_amount" id="transfer_amount" min="0" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary" name="add_transfer">Ajouter</button>
</form>