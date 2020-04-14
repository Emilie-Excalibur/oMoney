<?php
// Si visiteur
if (!isset($_SESSION['success'])) :
require __DIR__. '/../inc/filter.tpl.php';
?>
            <tr>
                <th scope="col">1</th>
                <th scope="col">-</th>
                <th scope="col">-</th>
                <th scope="col">-</th>
            </tr>
            <tr class="table-danger">
                <td colspan="3">Somme totale dépensée</td>
                <td>0 €</td>
            </tr>

            <tr class="table-info">
                <td colspan="4">Solde du compte : 0 €</td>
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
// Et si ce tri est date / titre /sum
if(!empty($_GET['filter']) && $_GET['filter'] === 'date') {
    // Ecriture de la requête selon le tri demandé
    $sql = "SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ORDER BY account.date DESC
    ";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'title') {
    $sql = "SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ORDER BY account.title ASC
    ";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'sum') {
    $sql = "SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ORDER BY account.sum ASC
    ";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'today') {
    $today= convertDate();

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE account.`date` BETWEEN '$today' AND '$today'
    AND users.email = '$email';";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'yesterday') {
    $yesterday = convertDate(24*60*60);

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE account.`date` BETWEEN '$yesterday' AND '$yesterday'
    AND users.email = '$email';";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'week') {
    $today= convertDate();
    $lastWeek = convertDate(7*24*60*60);

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE account.`date` BETWEEN '$lastWeek' AND '$today'
    AND users.email = '$email';";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'week') {
    $today= convertDate();
    $lastMonth = convertDate(4*7*24*60*60);

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE account.`date` BETWEEN '$lastMonth' AND '$today'
    AND users.email = '$email';";
}


// Si un tri a été demandé
// Execution de la requête
if(!empty($_GET['filter'])) {
    $pdoStatement = $pdo->query($sql);
    $filteredList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
}

require __DIR__ . '/../inc/table.tpl.php'; 
endif;
?>
