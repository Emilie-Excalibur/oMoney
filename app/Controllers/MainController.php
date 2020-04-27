<?php

namespace App\Controllers;
use App\Models\Account;


class MainController extends CoreController
{
    /**
     * Affiche la page d'accueil
     */
    public function home()
    {
        $pageName = 'Accueil';
        if(!empty($_SESSION['connectedUser'])) {
            $email = $_SESSION['connectedUser']->getEmail();

            // Récupère la date voulue
            $todayObject = new \DateTime('Today');

            // Récupère la date choisie au format Y-m-d
            $today = $todayObject->format('Y-m-d');

            // Récupère la somme de toutes les dépenses réalisées entre les dates précisées en argument
            $todayExpenses = Account::findExpensesByDate($today, $today, $email);
    
            $yesterdayObject = new \DateTime('yesterday');
            $yesterday = $yesterdayObject->format('Y-m-d');
            $yesterdayExpenses = Account::findExpensesByDate($yesterday, $yesterday, $email);
    
            $lastWeekObject = new \DateTime('-1 week today');
            $lastWeek = $lastWeekObject->format('Y-m-d');
            $lastWeekExpenses = Account::findExpensesByDate($lastWeek, $today, $email);
    
            $firstDayOfMonthObject = new \DateTime('first day of this month');
            $firstDayOfMonth = $firstDayOfMonthObject->format('Y-m-d');
            $monthExpenses = Account::findExpensesByDate($firstDayOfMonth, $today, $email);
        } else {
            $todayExpenses = null;
            $yesterdayExpenses = null;
            $lastWeekExpenses = null;
            $monthExpenses = null;
        }

        $this->show('main/home', [
            'pageName' => $pageName,
            'todayExpenses' => $todayExpenses,
            'yesterdayExpenses' => $yesterdayExpenses,
            'lastWeekExpenses' => $lastWeekExpenses,
            'monthExpenses' => $monthExpenses
        ]);
    }

}
