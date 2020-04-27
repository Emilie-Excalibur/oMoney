<?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

<form method="post" action="">
    <div class="form-group">
        <label for="date">Date</label>
        <input 
        class="form-control" 
        type="date" 
        name="date" 
        id="date"
        value="<?= isset($account) ? $account->getDateTransfer() : '';?>"
        >
    </div>
    <div class="form-group">
        <label for="title">Intitulé</label>
        <input 
        class="form-control" 
        type="text" 
        name="title" 
        id="title"
        value="<?= isset($account) ? $account->getTitleTransfer() : '';?>"
        >
    </div>
    <div class="form-group">
        <label for="transfer_amount">Montant du virement</label>
        <input 
        class="form-control" 
        type="number" 
        name="transfer_amount" 
        id="transfer_amount" 
        min="0" 
        step="0.01" 
        value="<?= isset($account) ? $account->getTransferAmount() : '';?>"
        required
        >
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>