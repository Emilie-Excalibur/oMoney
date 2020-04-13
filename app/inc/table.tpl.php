<?php
    // Si aucun tri n'a été demandé
    if (empty($_GET['filter'])) :
        // Affiche les données dans l'ordre où elles ont été enregistrées par l'utilisateur
        foreach ($accountInfo as $transactionId => $transactionInfo) :
?>
        <tr>
            <th scope="row"><?= $transactionId + 1 ?></th>
            <td><?= getDateFormat($transactionInfo['date']); ?></td>
            <td><?= $transactionInfo['title']; ?></td>
            <td><?= $transactionInfo['sum']; ?> €</td>

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
        </tr>

        <tr class="table-info">
            <td colspan="4">Solde du compte : <?= calculBalance(); ?> €</td>
        </tr>
    </tbody>
</table>