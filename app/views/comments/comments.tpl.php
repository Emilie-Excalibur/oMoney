<div>
    <?php if (!$connectedUser) : ?>

        <p>Bonjour cher visiteur, tu n'as encore rien vu du site mais tu veux quand même laisser un commentaire ? <br>Pourquoi pas, mais je t'invite quand même à t'inscrire pour tester toutes les fonctionnalités &#128521</p>

    <?php else : ?>
        <p>Bonjour <?= isset($_SESSION['connectedUser']) ? $_SESSION['connectedUser']->getName() : ''; ?>, maintenant que tu as pu voir un peu ce que tu peux faire sur oMoney, ce serait vraiment sympa de ta part de me faire un retour sur ton expérience.</p>
    <?php endif; ?>

    <p>Ici tu peux me dire : </p>
    <ul>
        <li>Si tu as rencontré un bug (sur quelle page, nature du bug)</li>
        <li>Si tu aimerais qu'il y ai une autre fonctionnalité sur le site</li>
        <li>Si tu trouves qu'une fonctionnalité n'est pas pratique, et si oui pourquoi</li>
        <li>Ou si tu veux juste laisser un petit mot gentil, n'hésite pas !</li>
    </ul>

</div>

<?php include __DIR__ . '/../partials/errorlist.tpl.php'; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="username">Nom</label>
        <input 
        class="form-control" 
        type="text" 
        name="username" 
        value="<?php 
            // isset($_SESSION['connectedUser']) ? $_SESSION['connectedUser']->getName() : ''; 
            // isset($comment) ? $comment->getName() : '';
            if(isset($comment)) {
                echo $comment->getName();
            } else if(isset($_SESSION['connectedUser'])) {
                echo $_SESSION['connectedUser']->getName();
            } else {
                echo '';
            }
        ?>"
        >
    </div>
    <div class="form-group">
        <label for="content_comment">Commentaire</label>
        <textarea class="form-control" id="content_comment" name="content_comment" rows="5"><?= isset($comment) ? $comment->getContent() : ''; ?></textarea>
    </div>

    <button type="submit" class="btn btn-info">Envoyer</button>
</form>


<h4 class="comment">Commentaires</h4>

<div class="comment-list">
    <?php
    foreach ($commentList as $comment) :

        $date = date('d/m/Y H:i:s', strtotime($comment->getCreatedAt()));
    ?>

    <h5 class="comment-name"><?= $comment->getName(); ?>
        <span class="comment-date"> le <?= $date; ?></span>
    </h5>
    <pre><?= $comment->getContent(); ?></pre>
    <?php endforeach; ?>

</div>