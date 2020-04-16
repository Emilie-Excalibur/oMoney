<div class="card text-white my-2">
    <div class="card-header bg-dark">Solde du compte</div>
    <div class="card-body bg-transparent border border-dark">
        <p class="card-text text-center font-weight-bold current-balance">

            <?php
            // Si utilisateur connecté
            if (isset($_SESSION['success'])) :
                // Toutes les variables nécessaires à l'affichage de la page
                $accountInfo = getAccountInfo();
                $sum = sumExpenses();
                $balance = getBalance();

                // Récupère la date choisie au format Y-m-d
                $today= convertDate();
                $yesterday = convertDate(24*60*60);
                $lastWeek = convertDate(7*24*60*60);
                $firstDayOfMonth = new DateTime('first day of this month');
                $firstDay = $firstDayOfMonth->format('Y-m-d');

                // Récupère le total de toutes les dépenses durant la période choisie
                $todayExpenses= getExpensesByDate($today, $today);
                $yesterdayExpenses = getExpensesByDate($yesterday, $yesterday);
                $weekExpenses = getExpensesByDate($lastWeek, $today);
                $monthExpenses = getExpensesByDate($firstDay, $today);
            ?>
                <i class="fa fa-lg fa-money"></i> Solde actuel : 
                <span class="<?= calculBalance() < 0 ? 'text-danger' : 'text-success'; ?>">
                    <?= calculBalance(); ?>€
                </span>

            <?php else : ?>
                <i class="fa fa-lg fa-money"></i> Solde actuel : 0€
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="card text-white my-2">
    <div class="card-header bg-danger">
        Total des dépenses
        <?php if (isset($_SESSION['success'])) : ?>
            <?php
                if(getExpensesByDateOrder() != false) {
                    // Si des dépenses ont été ajoutéees
                    // Recherche les dépenses triées par date
                    $allExpenses = getExpensesByDateOrder();

                    // Pour chaque résultat trouvé 
                    foreach ($allExpenses as $expenses) {
                        // Si la valeur à l'index courant est null
                        // Continue la boucle
                        if($expenses['date'] == null) {
                            continue;
                        } else {
                            // Sinon stocke la valeur (=date) dans $firstExpenses
                            // Stop la boucle
                            $firstExpenses = $expenses['date'];
                            break;
                        }
                    }
                    echo 'depuis le ' . getDateFormat($firstExpenses);
                } else {
                    echo '';
                }
            ?>
        <?php endif; ?>
    </div>

    <div class="card-body bg-transparent border border-danger">
        <div class="card-text text-center">
            <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="#dc3545" stroke-width="2" stroke-dasharray="<?php 
                    if(isset($_SESSION['success']) && $sum['sumExpenses'] != null) {
                        // Si utilisateur connecté ET si des dépenses ont été ajoutées
                        // Calcule et affiche le % des dépenses par rapport au solde du compte
                        echo calculPercentage($sum['sumExpenses'], $balance['balance']);
                    } else {
                        echo "0";
                    }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                        <?php 
                        if(isset($_SESSION['success']) && $sum['sumExpenses'] != null) {
                        // Si utilisateur connecté ET si des dépenses ont été ajoutées
                        // Affiche la somme de toutes les dépenses de l'utilisateur
                            echo $sum['sumExpenses'];
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
                        if(isset($_SESSION['success']) && $todayExpenses['dateExpenses'] != null) {
                            echo calculPercentage($todayExpenses['dateExpenses'], $balance['balance']);
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                            <?php 
                            if(isset($_SESSION['success']) && $todayExpenses['dateExpenses'] != null) {
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
                        if(isset($_SESSION['success']) && $yesterdayExpenses['dateExpenses'] != null) {
                            echo calculPercentage($yesterdayExpenses['dateExpenses'], $balance['balance']);
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                            <?php 
                            if(isset($_SESSION['success']) && $yesterdayExpenses['dateExpenses'] != null) {
                                echo $yesterdayExpenses['dateExpenses'];
                            } else {
                                echo "0";
                            }; ?>€</text>
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
                        if(isset($_SESSION['success']) && $weekExpenses['dateExpenses'] != null) {
                            echo calculPercentage($weekExpenses['dateExpenses'], $balance['balance']);
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                            <?php 
                            if(isset($_SESSION['success']) && $weekExpenses['dateExpenses'] != null) {
                                echo $weekExpenses['dateExpenses'];
                            } else {
                                echo "0";
                            }; ?>€</text>
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
                        if(isset($_SESSION['success']) && $monthExpenses['dateExpenses'] != null) {
                            echo calculPercentage($monthExpenses['dateExpenses'], $balance['balance']);
                        } else {
                            echo "0";
                        }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                            <?php 
                            if(isset($_SESSION['success']) && $monthExpenses['dateExpenses'] != null) {
                                echo $monthExpenses['dateExpenses'];
                            } else {
                                echo "0";
                            }; ?>€</text>
                    </g>
                </svg>
            </p>
        </div>
    </div>
</div>