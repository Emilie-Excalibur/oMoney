<?php
// Si un tri a été demandé
// Et si ce tri est date / titre /sum
// Récupète toutes les informations liées aux transactions
if(!empty($_GET['filter']) && $_GET['filter'] === 'all'){
    $sql="SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email';
    ";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'date') {
    $sql = "SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ORDER BY account.date DESC, account.date_transfer DESC;
    ";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'title') {
    $sql = "SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ORDER BY account.title ASC, account.title_transfer ASC;
    ";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'sum') {
    $sql = "SELECT *
    FROM account
    INNER JOIN users
    ON account.user_id = users.id
    WHERE users.email = '$email'
    ORDER BY account.sum ASC;
    ";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'today') {
    $today= convertDate();

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE (account.`date` BETWEEN '$today' AND '$today'
    OR account.date_transfer BETWEEN '$today' AND '$today')
    AND users.email = '$email';";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'yesterday') {
    $yesterday = convertDate(24*60*60);

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE (account.`date` BETWEEN '$yesterday' AND '$yesterday'
    OR account.date_transfer BETWEEN '$yesterday' AND '$yesterday')
    AND users.email = '$email';";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'week') {
    $today= convertDate();
    $lastWeek = convertDate(7*24*60*60);

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE (account.`date` BETWEEN '$lastWeek' AND '$today'
    OR account.date_transfer BETWEEN '$lastWeek' AND '$today')
    AND users.email = '$email';";
} else if(!empty($_GET['filter']) && $_GET['filter'] === 'month') {
    $today= convertDate();
    $lastMonth = convertDate(4*7*24*60*60);

    $sql = "SELECT *
    FROM account 
    INNER JOIN users
    ON account.user_id = users.id
    WHERE (account.`date` BETWEEN '$lastMonth' AND '$today'
    OR account.date_transfer BETWEEN '$lastMonth' AND '$today')
    AND users.email = '$email';";
}