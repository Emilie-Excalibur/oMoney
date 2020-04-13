<?php 
    $accountInfo = getAccountInfo();
    $sum = sumExpenses();
    $balance= getBalance();    
?>
<form method="post">

    <div class="form-group">
        <label for="balance">Solde du compte</label>
        <input class="form-control" type="number" name="balance" id="balance" min="0" step="0.01" value="<?= $balance['balance'] - $sum['sumExpenses']; ?>">
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
        <label for="sum">Somme dépensée</label>
        <input class="form-control" type="number" name="sum" id="sum" min="0" step="0.01" required>
    </div>

    <button type="submit" class="btn btn-primary" name="add_expenses">Ajouter</button>
</form>