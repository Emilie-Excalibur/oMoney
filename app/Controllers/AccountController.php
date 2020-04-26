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
        $this->show('account/history', [
            'pageName' => $pageName
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

        $balance = filter_input(INPUT_POST, 'balance', FILTER_SANITIZE_NUMBER_FLOAT);
        $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
        $title = trim(filter_input(INPUT_POST, 'title',  FILTER_SANITIZE_STRING));
        $sum = filter_input(INPUT_POST, 'sum',  FILTER_SANITIZE_NUMBER_FLOAT);

        $errorList = [];

        if(empty($balance)) {
            $errorList[] = 'Merci de renseigner le solde de votre compte';
        }
        if(empty($date)) {
            $errorList[] = 'Merci de renseigner une date';
        }
        if($title == null) {
            $errorList[] = 'L\'intitulé est invalide';
        }
        if(empty($sum)) {
            $errorList[] = 'Merci de renseigner un montant';
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
            $account->setSum(INPUT_POST, 'sum',  FILTER_SANITIZE_NUMBER_FLOAT);

            $this->show('account/expenses', [
                'errorList' => $errorList,
                'account' => $account
            ]);
        }
    }

    public function addIncome() {
        $this->checkAuthorization();


    }
}