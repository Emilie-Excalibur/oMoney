<?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

<form method="post" action="" id="form-retrait">

    <div class="form-group">
        <label for="balance">Solde du compte</label>
        <input 
        class="form-control balance" 
        type="number" 
        name="balance" 
        id="balance" 
        step="0.01" 
        value="<?= isset($userExpenses) ? $userExpenses->getBalance() : ''; ?>"
        >
    </div>

    <div class="form-group">
        <label for="date">Date</label>
        <input class="form-control" type="date" name="date" id="date">
    </div>

    <div class="form-group">
        <label for="title">Intitulé</label>
        <input 
        class="form-control" 
        type="text" 
        name="title" 
        id="title"
        value="<?= isset($account) ? $account->getTitle() : ''; ?>"
        >
    </div>

    <div class="form-group">
        <label for="sum">Somme dépensée</label>
        <input 
        class="form-control" 
        type="number" 
        name="sum" 
        id="sum" 
        min="0" 
        step="0.01" 
        value="<?= isset($account) ? $account->getSum() : ''; ?>"
        required
        >
    </div>

    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

<script src="assets/js/retrait.js"></script>