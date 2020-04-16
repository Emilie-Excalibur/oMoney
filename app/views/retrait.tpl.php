<?php 
    if (isset($_SESSION['success'])) {
        $accountInfo = getAccountInfo();
        $sum = sumExpenses();
        $sumTransfer = sumTransfer();
        $balance= getBalance();   
    }
?>
<form method="post" id="form-retrait">

    <div class="form-group">
        <label for="balance">Solde du compte</label>
        <input class="form-control balance" type="number" name="balance" id="balance" step="0.01" value="<?= isset($_SESSION['success']) ? $balance['balance'] - $sum['sumExpenses'] + $sumTransfer['sumTransfer'] : '0'; ?>">
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

<script src="assets/js/retrait.js"></script>