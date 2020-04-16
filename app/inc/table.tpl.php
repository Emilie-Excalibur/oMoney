<?php
    // Si aucun tri n'a été demandé
    if (empty($_GET['filter'])) :
        // Affiche les données dans l'ordre où elles ont été enregistrées par l'utilisateur
        foreach ($accountInfo as $transactionId => $transactionInfo) :
?>
        <tr>
            <th scope="row"><?= $transactionId + 1 ?></th>
            <td><?php 
            if($transactionInfo['date'] != null) {
                echo getDateFormat($transactionInfo['date']);
            }
            if($transactionInfo['date_transfer'] != null) {
                echo getDateFormat($transactionInfo['date_transfer']);
            }
             ?></td>
            <td><?php           
                if($transactionInfo['title'] != null) {
                    echo $transactionInfo['title'];
                }
                if($transactionInfo['title_transfer'] != null) {
                    echo $transactionInfo['title_transfer'];
                } 
            ?></td>
            <td><?php 
                if($transactionInfo['sum'] != null) {
                    echo $transactionInfo['sum'];
                } else {
                    echo '0.00';
                }
             ?> €</td>
            <td><?php 
                if($transactionInfo['transfer_amount'] != null) {
                    echo $transactionInfo['transfer_amount'];
                } else {
                    echo '0.00';
                }
             ?> €</td>

        </tr>
<?php
        endforeach;
    endif;

    // Si un tri a été demandé
    if (!empty($_GET['filter'])) :
        // Affiche les données dans l'ordre demandé
        foreach ($filteredList as $listIndex => $listInfo) :
?>

        <tr>
            <th scope="row"><?= $listIndex + 1 ?></th>
            <td><?php 
            if($listInfo['date'] != null) {
                echo getDateFormat($listInfo['date']);
            }
            if($listInfo['date_transfer'] != null) {
                echo getDateFormat($listInfo['date_transfer']);
            }
             ?></td>
            <td><?php           
                if($listInfo['title'] != null) {
                    echo $listInfo['title'];
                }
                if($listInfo['title_transfer'] != null) {
                    echo $listInfo['title_transfer'];
                } 
            ?></td>
            <td><?php 
                if($listInfo['sum'] != null) {
                    echo $listInfo['sum'];
                } else {
                    echo '0.00';
                }
             ?>  €</td>
            <td><?php 
                if($listInfo['transfer_amount'] != null) {
                    echo $listInfo['transfer_amount'];
                } else {
                    echo '0.00';
                }
             ?>  €</td>
        </tr>
<?php 
        endforeach;
    endif; 

    // Si un tri a été demandé
    if(!empty($_GET['filter'])) :
        // Lis et execute les requêtes selon le tri
        $pdoStatement = $pdo->query($sqlSum);
        $sumFiltered = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    // Affiche les sommes totales dépensées / gagnées selon le tri        
?>

        <tr class="table-danger">
            <td colspan="3">Somme totale dépensée</td>
            <td><?php
            if(isset($sumFiltered[0]['sumExpenses'])) {
                echo $sumFiltered[0]['sumExpenses'];
            } else if($sumFiltered[0]['sumExpenses'] == null) {
                echo '0.00';
            }
            ?> €</td>
            <td></td>
        </tr>

        <tr class="table-success">
            <td colspan="3">Somme totale gagnée</td>
            <td></td>
            <td><?php
            if(isset($sumFiltered[0]['sumTransfer'])) {
                echo $sumFiltered[0]['sumTransfer'];
            } else if($sumFiltered[0]['sumTransfer'] == null){
                echo '0.00';
            }
            ?> €</td>
        </tr>
<?php 
    // Si aucun tri n'a été demandé
    // Affiche la somme de toutes les dépenses/virements
    else : 

?>

    <tr class="table-danger">
            <td colspan="3">Somme totale dépensée</td>
            <td><?php 
                if($sum['sumExpenses'] != null) {
                    echo $sum['sumExpenses'];
                } else {
                    echo '0.00';
                }
             ?> €</td>
            <td></td>
        </tr>

        <tr class="table-success">
            <td colspan="3">Somme totale gagnée</td>
            <td></td>
            <td><?php 
                if($sumTransfer['sumTransfer'] != null) {
                    echo $sumTransfer['sumTransfer'];
                } else {
                    echo '0.00';
                }
             ?> €</td>
        </tr>

<?php endif; ?>

        <tr class="table-info">
            <td colspan="5">Solde du compte : <span class="font-weight-bold"><?= calculBalance(); ?> €</span></td>
        </tr>
    </tbody>
</table>