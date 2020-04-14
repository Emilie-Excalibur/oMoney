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
            <td><?= $transactionInfo['transfer_amount']; ?> €</td>

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
            <td><?= getDateFormat($listInfo['date']); ?></td>
            <td><?= $listInfo['title']; ?></td>
            <td><?= $listInfo['sum']; ?> €</td>
        </tr>
<?php 
        endforeach;
    endif; 
?>

        <tr class="table-danger">
            <td colspan="3">Somme totale dépensée</td>
            <td><?= $sum['sumExpenses']; ?> €</td>
            <td></td>
        </tr>

        <tr class="table-success">
            <td colspan="3">Somme totale gagnée</td>
            <td></td>
            <td><?= $sumTransfer['sumTransfer']; ?> €</td>
        </tr>

        <tr class="table-info">
            <td colspan="5">Solde du compte : <span class="font-weight-bold"><?= calculBalance(); ?> €</span></td>
        </tr>
    </tbody>
</table>