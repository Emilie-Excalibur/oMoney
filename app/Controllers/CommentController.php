<?php

namespace App\Controllers;

use App\Controllers\CoreController;
use App\Models\Comment;


class CommentController extends CoreController
{
    /**
     * Affiche la page des commentaires
     *
     * @return void
     */
    public function comments()
    {
        $pageName = 'Commentaires';
        $commentList = Comment::findAll();

        $this->show('comments/comments', [
            'pageName' => $pageName,
            'commentList' => $commentList
        ]);
    }

    public function add()
    {
        $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $content = filter_input(INPUT_POST, 'content_comment', FILTER_SANITIZE_STRING);

        $errorList = [];

        if (empty($name)) {
            $errorList[] = 'Merci de renseigner un nom';
        }

        if (strlen($name) > 100) {
            $errorList[] = 'Le nom est trop long !';
        }

        if (empty($content)) {
            $errorList[] = 'Le commentaire est vide !';
        }

        if (empty($errorList)) {
            $comment = new Comment();
            $comment->setName($name);
            $comment->setContent($content);

            // Ajoute le commentaire dans la BDD
            $executed = $comment->insert();

            // Si tout s'est bien passé
            if ($executed) {
                // Redirige l'utilisateur sur la page des commentaires
                $this->redirect('comments-comments');
            } else {
                // Sinon, ajoute une erreur
                $errorList[] = 'L\'ajout du commentaire a échoué, merci de recommencer.';
            }
        }

        if(!empty($errorList)) {
            $comment = new Comment();
            $comment->setName(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
            $comment->setContent(filter_input(INPUT_POST, 'content_comment', FILTER_SANITIZE_STRING));
            $commentList = Comment::findAll();


            $this->show('comments/comments', [
                'comment' => $comment,
                'commentList' => $commentList,
                'errorList' => $errorList
            ]);
        }
    }

}
