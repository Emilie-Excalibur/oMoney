<form method="GET" action="">
    <div class="mb-2 d-flex align-items-center">
        <label class="mr-sm-2" for="filter">Trier par</label>
        <div class="col-auto my-1">
            <select class="custom-select mr-sm-2" id="filter" name="filter">
                <option value="all">Tout afficher</option>
                <option value="date">Le plus récent</option>
                <option value="today">Aujourd'hui</option>
                <option value="yesterday">Hier</option>
                <option value="week">Cette semaine</option>
                <option value="month">Ce mois</option>
                <option value="title">Ordre alphabétique</option>
                <option value="sum">Somme dépensée</option>
            </select>
        </div>
        <button type="submit" class="btn btn-info">Valider</button>
    </div>
</form>

<table class="table table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Intitulé</th>
            <th scope="col">Somme dépensée</th>
            <th scope="col">Virement</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Si le résultat des requêtes SQL contient des entrées, donc s'il n'est pas false
        if($filterTransactions != false) {
            // Récupère les clés du tableau
            //  -filterSum
            //  -filterList
            extract($filterTransactions);
        }

        // Si aucun tri n'a été demandé
        // Ou si aucune transaction n'a été effectué -> Le résultat des requêtes SQL est false
        // Ou si le tri 'Afficher Tout' a été demandé
        if(empty($_GET['filter']) || $filterTransactions === false || $_GET['filter'] === 'all') :
            // Si La liste des transactions de l'utilisateur connecté n'est pas vide
            if ($transactionList != null) : 
                // Affiche toutes les transactions
                foreach ($transactionList as $transactionId => $transaction) :
                    require __DIR__ . '/../partials/filterTable.tpl.php';
      
                 endforeach; 
             endif; 
         endif; 

            // Si un tri a été demandé ET si le résultat de la requête SQL n'est pas vide
            if(!empty($_GET['filter']) && !empty($filterList)) : 
        ?>
            <?php 
                // Affiche chaque résultat obtenu
                foreach ($filterList as $transactionId => $transaction) : 
                require __DIR__ . '/../partials/filterTable.tpl.php';
            ?>

            <?php endforeach; ?>
        <?php endif;?>

            <tr class="table-danger">
                <td colspan="3">Somme totale dépensée</td>
                <td>
                    <?php 
                        if(!empty($filterSum)) {
                            echo $filterSum[0]['sumExpenses'] .' €';
                        } else if($transactionSum['sumExpenses'] != null) {
                                echo $transactionSum['sumExpenses'] . ' €';
                        } else {
                            echo '0.00 €';
                        }
                    ?> 
                </td>
                <td></td>
            </tr>
            <tr class="table-success">
                <td colspan="3">Somme totale gagnée</td>
                <td></td>
                <td>
                    <?php
                        if(!empty($filterSum)) {
                            echo $filterSum[0]['sumIncome'] .' €';
                        } else if($transactionSum['sumIncome'] != null) {
                                echo $transactionSum['sumIncome'] . ' €';
                        } else {
                            echo '0.00 €';
                        }
                    ?> 
                </td>
            </tr>

            <tr class="table-info">
                <td colspan="5">Solde du compte :
                <span class="font-weight-bold">
                    <?= $userTransaction != false ?
                        $userTransaction->getBalance() - $transactionSum['sumExpenses'] + $transactionSum['sumIncome'] . ' €' : '0.00 €'; 
                    ?>
                </span>
                </td>
            </tr>
    </tbody>
</table>