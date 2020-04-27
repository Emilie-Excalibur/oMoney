<?php
namespace App\Controllers;
use App\Models\Account;
use App\Models\User;


class AccountController extends CoreController {
    /**
     * Affiche la page de l'historique des transactions
     *
     * @return void
     */
    public function history()
    {
        $pageName = 'Historique';
        if(!empty($_SESSION['connectedUser'])) {
            $filterTransactions = Account::findByFilter($_SESSION['connectedUser']->getEmail());   
        } else {
            $filterTransactions = false;
        }

        $this->show('account/history', [
            'pageName' => $pageName,
            'filterTransactions' => $filterTransactions
        ]);
    }

    /**
     * Affiche la page du formulaire d'ajout de dépenses
     *
     * @return void
     */
    public function expenses() {
        $pageName = 'Ajouter des dépenses';
        $this->show('account/expenses', [
            'pageName' => $pageName
            ]);
    }

    /**
     * Affiche la page du formulaire d'ajout d'argent
     *
     * @return void
     */
    public function income() {
        $pageName = 'Ajouter un virement';
        $this->show('account/income', ['pageName' => $pageName]);
    }

    /**
     * Ajoute les dépenses de l'utilisateur connecté dans la BDD
     * Méthode HTTP : POST
     *
     * @return void
     */
    public function addExpenses() {
        // Lors de l'envoi des données du formulaire
        // Vérifie qu'il s'agit bien d'un utilisateur connecté
        $this->checkAuthorization();

        // Récupère les valeurs des champs
        $balance = filter_input(INPUT_POST, 'balance', FILTER_SANITIZE_NUMBER_FLOAT, 
        FILTER_FLAG_ALLOW_FRACTION);
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $title = trim(filter_input(INPUT_POST, 'title',  FILTER_SANITIZE_STRING));
        $sum = filter_input(INPUT_POST, 'sum',  FILTER_SANITIZE_NUMBER_FLOAT, 
        FILTER_FLAG_ALLOW_FRACTION);

        // Crée un nouvel objet DateTime pour récupérer la date du jour
        $todayObject = new \DateTime('Today');
        // Formate la date sous forme Année-Mois-Jour
        $today = $todayObject->format('Y-m-d');

        $errorList = [];

        if(empty($balance)) {
            $errorList[] = 'Merci de renseigner le solde de votre compte';
        }

        // Dans la BDD, les virements sont stockés sous la forme de décimaux (10,2)
        // La limite autorisée est donc de 12 chiffres maximum dont 2 après la virgule
        if($balance > 9999999999.99) {
            $errorList[] = 'Le montant de la dépense dépasse la limite autorisée';
        }
        if(empty($date)) {
            $errorList[] = 'Merci de renseigner une date';
        }
        if($date > $today) {
            $errorList[] = 'La date entrée est postérieure à la date du jour: ' . date('d/m/Y', strtotime($today));
        } 
        if(empty($title)) {
            $errorList[] = 'L\'intitulé est invalide';
        }
        if(strlen($title) > 200) {
            $errorList[] = 'L\'intitulé est trop long';
        }
        if(empty($sum)) {
            $errorList[] = 'Merci de renseigner un montant';
        }
        if($sum > $balance) {
            $errorList[] = 'Vous n\'avez pas assez d\'argent sur votre compte pour réaliser cette dépense';
        }
        if($sum > 9999999999.99) {
            $errorList[] = 'Le montant du virement dépasse la somme autorisée';
        }

        // Si pas d'erreurs
        if(empty($errorList)) {
            // Recherche l'utilisateur connecté 
            $email = $_SESSION['connectedUser']->getEmail();
            $user = User::findByMail($email);

            // si aucune correspondance dans la BDD
            if($user == false) {
                $errorList[] = 'Vous n\'avez pas les droits pour ajouter des dépenses !';
            } else {
                // Sinon, crée une nouvelle instance Account
                $account = new Account();

                // Ajoute les données du formulaire à l'instance Account
                $account->setUserId($user->getId());
                $account->setBalance($balance);
                $account->setDate($date);
                $account->setTitle($title);
                $account->setSum($sum);

                // Insert les données dans la BDD
                $executed = $account->insertExpenses();

                // Si tout s'est bien passé
                if($executed) {
                    // Redirige l'utilisateur sur la page historique
                    $this->redirect('account-history');
                } else {
                    // Sinon, ajoute une erreur
                    $errorList[] = 'L\'ajout de la dépense a échoué, merci de recommencer.';
                }
            }
        }

        // S'il y a eu des erreurs
        if(!empty($errorList)) {
            $account = new Account();
            $account->setTitle(filter_input(INPUT_POST, 'title',  FILTER_SANITIZE_STRING));
            $account->setSum(INPUT_POST, 'sum', FILTER_SANITIZE_NUMBER_FLOAT, 
            FILTER_FLAG_ALLOW_FRACTION);
            $account->setDate(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
            $pageName = 'Informations incorrectes';

            $this->show('account/expenses', [
                'pageName' => $pageName,
                'errorList' => $errorList,
                'account' => $account
            ]);
        }
    }

    /**
     * Ajoute dans la BDD les données du formulaire des virements de l'utilisateur connecté
     * Méthode HTTP : POST
     *
     * @return void
     */
    public function addIncome() {
        $this->checkAuthorization();

        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $title = trim(filter_input(INPUT_POST, 'title',  FILTER_SANITIZE_STRING));
        $transfer_amount = filter_input(INPUT_POST, 'transfer_amount',  FILTER_SANITIZE_NUMBER_FLOAT, 
        FILTER_FLAG_ALLOW_FRACTION);

        $todayObject = new \DateTime('Today');
        $today = $todayObject->format('Y-m-d');

        $errorList = [];

        if(empty($date)) {
            $errorList[] = 'Merci de renseigner une date';
        }
        if($date > $today) {
            $errorList[] = 'La date entrée est postérieure à la date du jour: ' . date('d/m/Y', strtotime($today));
        } 
        if(empty($title)) {
            $errorList[] = 'L\'intitulé est invalide';
        }
        if(strlen($title) > 200) {
            $errorList[] = 'L\'intitulé est trop long';
        }
        if(empty($transfer_amount)) {
            $errorList[] = 'Merci de renseigner un montant';
        }
        // Dans la BDD, les virements sont stockés sous la forme de décimaux (10,2)
        // La limite autorisée est donc de 12 chiffres maximum dont 2 après la virgule
        if($transfer_amount > 9999999999.99) {
            $errorList[] = 'Le montant du virement dépasse la limite autorisée';
        }

        // Si pas d'erreurs
        if(empty($errorList)) {
            // Recherche l'utilisateur connecté 
            $email = $_SESSION['connectedUser']->getEmail();
            $user = User::findByMail($email);

            // si aucune correspondance dans la BDD
            if($user == false) {
                $errorList[] = 'Vous n\'avez pas les droits pour ajouter des dépenses !';
            } else {
                // Sinon, crée une nouvelle instance Account
                $account = new Account();

                // Ajoute les données du formulaire à l'instance Account
                $account->setUserId($user->getId());
                $account->setDateTransfer($date);
                $account->setTitleTransfer($title);
                $account->setTransferAmount($transfer_amount);

                // Insert les données dans la BDD
                $executed = $account->insertIncome();

                // Si tout s'est bien passé
                if($executed) {
                    // Redirige l'utilisateur sur la page historique
                    $this->redirect('account-history');
                } else {
                    // Sinon, ajoute une erreur
                    $errorList[] = 'L\'ajout de la dépense a échoué, merci de recommencer.';
                }
            }
        }

        // S'il y a eu des erreurs
        if(!empty($errorList)) {
            $account = new Account();
            $account->setTitleTransfer(filter_input(INPUT_POST, 'title',  FILTER_SANITIZE_STRING));
            $account->setDateTransfer(filter_input(INPUT_POST, 'date',  FILTER_SANITIZE_STRING));
            $account->setTransferAmount(INPUT_POST, 'transfer_amount',  FILTER_SANITIZE_NUMBER_FLOAT, 
            FILTER_FLAG_ALLOW_FRACTION);
            $pageName = 'Informations incorrectes';

            $this->show('account/income', [
                'pageName' => $pageName,
                'errorList' => $errorList,
                'account' => $account
            ]);
        }
    }
}