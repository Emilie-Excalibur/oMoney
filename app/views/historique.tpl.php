<?php
// Si visiteur
if (!isset($_SESSION['success'])) :
require __DIR__. '/../inc/filter.tpl.php';
?>
            <tr>
                <td scope="col">1</td>
                <td scope="col">-</td>
                <td scope="col">-</td>
                <td scope="col">-</td>
                <td scope="col">-</td>
            </tr>
            <tr class="table-danger">
                <td colspan="3">Somme totale dépensée</td>
                <td>0 €</td>
                <td></td>
            </tr>
            <tr class="table-success">
                <td colspan="3">Somme totale gagnée</td>
                <td></td>
                <td>0 €</td>
            </tr>

            <tr class="table-info">
                <td colspan="5">Solde du compte : 0 €</td>
            </tr>            
        </tbody>
    </table>

<?php 
else: 
    // Si utilisateur
    // Récupère les infos du compte de l'utilisateur connecté
    $accountInfo = getAccountInfo();

    // Récupère la somme de toutes les dépenses dans la BDD
    $sum = sumExpenses();

    // Récupère la somme de tous les virements dans la BDD
    $sumTransfer = sumTransfer();

require __DIR__ . '/../inc/filter.tpl.php'; 

$email = $_SESSION['email'];
$pdo = Database::getPDO();


// Si un tri a été demandé
// Lis et exécute les requêtes
if(!empty($_GET['filter'])) {
    require __DIR__ . '/../utils/requests.php';
    $pdoStatement = $pdo->query($sql);
    $filteredList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
}

require __DIR__ . '/../inc/table.tpl.php'; 
endif;
?>
