<?php
//dump($userTransaction);
//dd($transactionList);
//dump($transactionSum);


?>

<div class="card text-white my-2">
    <div class="card-header bg-dark">Solde du compte</div>
    <div class="card-body bg-transparent border border-dark">
        <p class="card-text text-center font-weight-bold current-balance">

            <i class="fa fa-lg fa-money"></i> Solde actuel : 
            <?php
            // Si utilisateur connecté ET si des transactions ont été effectuées
            if($connectedUser && !empty($transactionList)) :
                // Affiche le solde
            ?>
                <span class="font-weight-bold">
                    <?= $userTransaction != false ?
                        $userTransaction->getBalance() - $transactionSum['sumExpenses'] + $transactionSum['sumIncome'] . ' €' : '0.00 €'; 
                    ?>
                </span>
            <?php endif; ?>
            <?= !$connectedUser ? '0.00 €' : ''; ?>
        </p>
    </div>
</div>

<div class="card text-white my-2">
    <div class="card-header bg-danger">
        Total des dépenses
        <?php if ($connectedUser) : ?>
            <?php
                if(empty($transactionList)) {
                    echo '';
                } else {
                    // Pour chaque transaction effectuée par l'utilisateur 
                    foreach ($transactionList as $transaction) {
                        // Si la valeur de la date de dépense à l'index courant est null
                        // Continue la boucle
                        if($transaction->getDate() == null) {
                            continue;
                        } else {
                            // Sinon stocke la valeur (=date) dans $firstExpenses
                            // Stop la boucle
                            $firstExpenses = date('d/m/Y', strtotime($transaction->getDate()));
                            break;
                        }
                    }
                    if(!empty($firstExpenses)) {
                        echo 'depuis le ' . $firstExpenses;
                    } else {
                        echo '';
                    }
                }
            ?>
        <?php endif; ?>
    </div>

    <div class="card-body bg-transparent border border-danger">
        <div class="card-text text-center">
            <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="#dc3545" stroke-width="2" stroke-dasharray="<?php 
                    if($connectedUser && $transactionSum['sumExpenses'] != null && $userTransaction != false) {
                        // Si utilisateur connecté ET si des dépenses ont été ajoutées
                        // Calcule et affiche le % des dépenses par rapport au solde du compte
                        echo ($transactionSum['sumExpenses'] / $userTransaction->getBalance()) * 100;
                    } else {
                        echo "0";
                    }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="<?= $transactionSum['sumExpenses'] < '100000.00' ? "5" : "3"?>">
                        <?php 
                        if($connectedUser && $transactionSum['sumExpenses'] != null) {
                        // Si utilisateur connecté ET si des dépenses ont été ajoutées
                        // Affiche la somme de toutes les dépenses de l'utilisateur
                            echo $transactionSum['sumExpenses'];
                        } else {
                            echo "0";
                        }; ?>€
                    </text>
                </g>
            </svg>
        </div>
    </div>
</div>

<div class="card_container d-flex flex-wrap">
    <div class="card text-white mb-2 col-md-6 p-0">
        <div class="card-header bg-success ">
            Aujourd'hui <?= date('d/m/Y', time()); ?>
        </div>
        <div class="card-body bg-transparent border border-success">
            <div class="card-text text-center">
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <circle class="circle-chart__circle" stroke="#28a745" stroke-width="2" stroke-dasharray="<?php 
                        if($connectedUser && $todayExpenses['dateExpenses'] != null && $userTransaction != false) {
                            echo ($todayExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="<?= $todayExpenses['dateExpenses'] < '100000.00' ? "5" : "3"?>">
                        <?php 
                            if($connectedUser && $todayExpenses['dateExpenses'] != null) {
                                echo $todayExpenses['dateExpenses'];
                            } else {
                                echo "0";
                            }; ?>€
                        </text>
                    </g>
                </svg>
            </div>
        </div>
    </div>

    <div class="card text-white mb-2 col-md-6 p-0">
        <div class="card-header bg-primary">Hier</div>
        <div class="card-body bg-transparent border border-primary">
            <p class="card-text text-center">
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <circle class="circle-chart__circle" stroke="#007bff" stroke-width="2" stroke-dasharray="<?php 
                    
                        if($connectedUser && $yesterdayExpenses['dateExpenses'] != null && $userTransaction != false) {
                            echo ($yesterdayExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                            <?php 
                                if($connectedUser && $yesterdayExpenses['dateExpenses'] != null) {
                                    echo $yesterdayExpenses['dateExpenses'];
                                } else {
                                    echo "0";
                                }; 
                            ?>€
                        </text>
                    </g>
                </svg>
            </p>
        </div>
    </div>

    <div class="card text-white mb-2 col-md-6 p-0">
        <div class="card-header bg-info">7 derniers jours</div>
        <div class="card-body bg-transparent border border-info">
            <p class="card-text text-center">
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <circle class="circle-chart__circle" stroke="#00acc1" stroke-width="2" stroke-dasharray="<?php 
                        if($connectedUser && $lastWeekExpenses['dateExpenses'] != null && $userTransaction != false) {
                            echo ($lastWeekExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                            <?php 
                                if($connectedUser && $lastWeekExpenses['dateExpenses'] != null) {
                                    echo $lastWeekExpenses['dateExpenses'];
                                } else {
                                    echo "0";
                                }; 
                            ?>€
                        </text>
                    </g>
                </svg>
            </p>
        </div>
    </div>

    <div class="card text-white mb-2 col-md-6 p-0">
        <div class="card-header bg-warning">Mois <?php $date=time(); echo $month=date('F', $date); ?></div>
        <div class="card-body bg-transparent border border-warning">
            <p class="card-text text-center">
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <circle class="circle-chart__circle" stroke="#ffc107" stroke-width="2" stroke-dasharray="<?php 
                      if($connectedUser && $monthExpenses['dateExpenses'] != null && $userTransaction != false) {
                        echo ($monthExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                    } else {
                        echo "0";
                    }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                        <?php 
                            if($connectedUser && $monthExpenses['dateExpenses'] != null) {
                                echo $monthExpenses['dateExpenses'];
                            } else {
                                echo "0";
                            }; 
                        ?>€
                        </text>
                    </g>
                </svg>
            </p>
        </div>
    </div>
</div>