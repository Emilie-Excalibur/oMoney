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
                    <?php 
                    if ($userTransaction != false) {

                        // calcule le solde actuel
                        $currentBalance = $userTransaction->getBalance() - $transactionSum['sumExpenses'] + $transactionSum['sumIncome'];

                        // Formate le nombre pour n'avoir que 2 chiffres après la virgule, les milliers sont séparés par des espaces
                        $formatBalance = number_format($currentBalance, 2, ',', ' ');
                        echo $formatBalance . ' €';
                    } else {
                        echo '0.00 €';
                    }
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
                // Si aucune transaction n'a été effectuée
                if(empty($expensesByDate)) {
                    // N'affiche pas la date
                    echo '';
                } else {
                    // Sinon, pour chaque transaction effectuée par l'utilisateur 
                    foreach ($expensesByDate as $transaction) {
                        // Si la valeur de la date de dépense à l'index courant est null
                        // Passe à l'itération suivante
                        if($transaction->getDate() == null) {
                            continue;
                        } else {
                            // Sinon stocke la valeur (=date) dans $firstExpenses
                            // Et formate la date
                            $firstExpenses = date('d/m/Y', strtotime($transaction->getDate()));
                            // Stop la boucle
                            break;
                        }
                    }

                    // Si une date a bien été récupérée 
                    if(!empty($firstExpenses)) {
                        // Affiche la date
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
                        // Si le solde n'est pas null, c'est-à-dire si l'utilisateur a entré des dépenses en premier
                        if($userTransaction->getBalance() != null) {
                            // Calcule et affiche le % des dépenses par rapport au solde du compte
                            echo ($transactionSum['sumExpenses'] / $userTransaction->getBalance()) * 100;
                        } else {
                            // Sinon, si le solde est null, cela veut dire que l'utilisateur a entré un virement en premier
                            // calcule donc le % des dépenses par rapport au viremenent effectué
                            echo ($transactionSum['sumExpenses'] / $userTransaction->getTransferAmount()) *100;
                        }
                    } else {
                        echo "0";
                    }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" 
                    font-size="
                    <?= 
                        // Si la somme des dépenses est inférieur à 1000000.00, la font-size sera de 5
                        // Sinon, si la somme est supérieure, la font-size sera de 3
                        $transactionSum['sumExpenses'] < '1000000.00' ? "5" : "3";
                    ?>">
                        <?php 
                        // Si utilisateur connecté ET si des dépenses ont été ajoutées
                        if($connectedUser && $transactionSum['sumExpenses'] != null) {
                        // Affiche la somme de toutes les dépenses de l'utilisateur
                            echo number_format($transactionSum['sumExpenses'], 2, ',', ' ');
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
                            if($userTransaction->getBalance() != null) {
                                echo ($todayExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                            } else {
                                echo($todayExpenses['dateExpenses'] / $userTransaction->getTransferAmount()) * 100;
                            }
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="<?= !isset($todayExpenses['dateExpenses']) || $todayExpenses['dateExpenses'] < '1000000.00' ? "5" : "3"?>">
                        <?php 
                            if($connectedUser && $todayExpenses['dateExpenses'] != null) {
                                echo number_format($todayExpenses['dateExpenses'], 2, ',', ' ');
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
                            if($userTransaction->getBalance() != null) {
                                echo ($yesterdayExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                            } else {
                                echo ($yesterdayExpenses['dateExpenses'] / $userTransaction->getTransferAmount()) * 100;
                            }
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="<?= !isset($yesterdayExpenses['dateExpenses']) || $yesterdayExpenses['dateExpenses'] < '1000000.00' ? "5" : "3"; ?>">
                            <?php 
                                if($connectedUser && $yesterdayExpenses['dateExpenses'] != null) {
                                    echo number_format($yesterdayExpenses['dateExpenses'], 2, ',', ' ');
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
                            if($userTransaction->getBalance() != null) {
                                echo ($lastWeekExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                            } else {
                                echo ($lastWeekExpenses['dateExpenses'] / $userTransaction->getTransferAmount()) * 100;
                            }
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="<?= !isset($lastWeekExpenses['dateExpenses']) || $lastWeekExpenses['dateExpenses'] < '1000000.00' ? "5" : "3"; ?>">
                            <?php 
                                if($connectedUser && $lastWeekExpenses['dateExpenses'] != null) {
                                    echo number_format($lastWeekExpenses['dateExpenses'], 2, ',', ' ');
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
                          if($userTransaction->getBalance() != null) {
                              echo ($monthExpenses['dateExpenses'] / $userTransaction->getBalance()) * 100;
                          } else {
                            echo ($monthExpenses['dateExpenses'] / $userTransaction->getTransferAmount()) * 100;
                          }
                    } else {
                        echo "0";
                    }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="<?= $monthExpenses['dateExpenses'] < '1000000.00' ? "5" : "3"?>">
                        <?php 
                            if($connectedUser && $monthExpenses['dateExpenses'] != null) {
                                echo number_format($monthExpenses['dateExpenses'], 2, ',',' ');
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

