<div class="card text-white my-2">
    <div class="card-header bg-dark">Solde du compte</div>
    <div class="card-body bg-transparent border border-dark">
        <p class="card-text text-center font-weight-bold">

            <?php

            if (isset($_SESSION['success'])) :
                $accountInfo = getAccountInfo();
                $sum = sumExpenses();
                $balance = getBalance();
            ?>
                <i class="fa fa-lg fa-money"></i> Solde actuelle : <?= calculBalance(); ?>€

            <?php else : ?>
                <i class="fa fa-lg fa-money"></i> Solde actuelle : 0€
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="card text-white my-2">
    <div class="card-header bg-danger">
        Total des dépenses
        <?php if (isset($_SESSION['success'])) : ?>
            depuis le <?= getDateFormat('fr', $_SESSION['created_at']); ?>
        <?php endif; ?>
    </div>

    <div class="card-body bg-transparent border border-danger">
        <p class="card-text text-center">
            <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <circle class="circle-chart__circle" stroke="#dc3545" stroke-width="2" stroke-dasharray="<?php 
                    if(isset($_SESSION['success']) && $sum['sumExpenses'] != null) {
                        echo calculPercentage($sum['sumExpenses'], $balance['balance']);
                    } else {
                        echo "0";
                    }; ?>,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                <g class="circle-chart__info">
                    <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">
                        <?php 
                        if(isset($_SESSION['success']) && $sum['sumExpenses'] != null) {
                            echo $sum['sumExpenses'];
                        } else {
                            echo "0";
                        }; ?>€
                    </text>
                </g>
            </svg>
        </p>
    </div>
</div>

<div class="card_container d-flex flex-wrap">
    <div class="card text-white mb-2 col-md-6 p-0">
        <div class="card-header bg-success ">
            Aujourd'hui <?= getDateToday(); ?>
        </div>
        <div class="card-body bg-transparent border border-success">
            <p class="card-text text-center">
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <circle class="circle-chart__circle" stroke="#28a745" stroke-width="2" stroke-dasharray="0,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">0€</text>
                    </g>
                </svg>
            </p>
        </div>
    </div>

    <div class="card text-white mb-2 col-md-6 p-0">
        <div class="card-header bg-primary">Hier</div>
        <div class="card-body bg-transparent border border-primary">
            <p class="card-text text-center">
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <circle class="circle-chart__circle" stroke="#007bff" stroke-width="2" stroke-dasharray="0,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">0€</text>
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
                    <circle class="circle-chart__circle" stroke="#00acc1" stroke-width="2" stroke-dasharray="0,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">0€</text>
                    </g>
                </svg>
            </p>
        </div>
    </div>

    <div class="card text-white mb-2 col-md-6 p-0">
        <div class="card-header bg-warning">Mois</div>
        <div class="card-body bg-transparent border border-warning">
            <p class="card-text text-center">
                <svg class="circle-chart" viewbox="0 0 33.83098862 33.83098862" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
                    <circle class="circle-chart__background" stroke="#efefef" stroke-width="2" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <circle class="circle-chart__circle" stroke="#ffc107" stroke-width="2" stroke-dasharray="0,100" stroke-linecap="round" fill="none" cx="16.91549431" cy="16.91549431" r="15.91549431" />
                    <g class="circle-chart__info">
                        <text class="circle-chart__percent" x="16.91549431" y="15.5" alignment-baseline="central" text-anchor="middle" font-size="6">0€</text>
                    </g>
                </svg>
            </p>
        </div>
    </div>
</div>