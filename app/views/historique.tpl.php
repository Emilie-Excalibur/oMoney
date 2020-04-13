<?php
// Si visiteur
if (!isset($_SESSION['success'])) :
?>
    <p class="text-danger">Vous devez être connecté pour visualiser vos dépenses.</p>

<?php 
else: 
    // Si utilisateur
    // Récupère les infos du compte de l'utilisateur connecté
    $accountInfo = getAccountInfo();

    // Somme de toutes les dépenses de l'utilisateur
    $sum = sumExpenses();

    // Récupère le solde du compte de l'utilisateur
    $balance= getBalance();

?>

<table class="table table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Intitué</th>
            <th scope="col">Somme dépensée</th>
        </tr>
    </thead>
    <tbody>
        
            <?php 
                foreach ($accountInfo as $transactionId => $transactionInfo) :
            ?>
            <tr>
            <th scope="row"><?= $transactionId+1 ?></th>
            <td><?= getDateFormat('fr', $transactionInfo['date']); ?></td>
            <td><?= $transactionInfo['title']; ?></td>
            <td><?= $transactionInfo['sum']; ?> €</td>

        </tr>
                <?php endforeach; ?>

        <tr class="table-danger">
            <td colspan="3">Somme totale dépensée</td>
            <td><?= $sum['sumExpenses']; ?> €</td>
        </tr>

        <tr class="table-info">
            <td colspan="4">Solde du compte : <?= $balance['balance'] - $sum['sumExpenses']; ?> €</td>
        </tr>
    </tbody>
</table>

<?php endif; ?>