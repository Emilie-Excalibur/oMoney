<div>
    <?php if (!isset($_SESSION['name'])) : ?>

        <p>Bonjour cher visiteur, tu n'as encore rien vu du site mais tu veux quand même laisser un commentaire ? <br>Pourquoi pas, mais je t'invite quand même à t'inscrire pour tester toutes les fonctionnalités &#128521</p>

    <?php else : ?>
        <p>Bonjour <?= isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>, maintenant que tu as pu voir un peu ce que tu peux faire sur oMoney, ce serait vraiment sympa de ta part de me faire un retour sur ton expérience.</p>
    <?php endif; ?>

    <p>Ici tu peux me dire : </p>
    <ul>
        <li>Si tu as rencontré un bug (sur quelle page, nature du bug)</li>
        <li>Si tu aimerais qu'il y ai une autre fonctionnalité sur le site</li>
        <li>Si tu trouves qu'une fonctionnalité n'est pas pratique, et si oui pourquoi</li>
        <li>Ou si tu veux juste laisser un petit mot gentil, n'hésite pas !</li>
    </ul>

</div>


<form method="post">
    <div class="form-group">
        <label for="username">Nom</label>
        <input class="form-control" type="text" name="username" value="<?= isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>">
    </div>
    <div class="form-group">
        <label for="content_comment">Commentaire</label>
        <textarea class="form-control" id="content_comment" name="content_comment" rows="5"></textarea>
    </div>

    <button type="submit" class="btn btn-info" name="comment_submit">Envoyer</button>
</form>


<h4 class="comment">Commentaires</h4>

<div class="comment-list">
    <?php
    $pdo = Database::getPDO();
    $sql = "SELECT * FROM `comment` ORDER BY `created_at` DESC;";
    $pdoStatement = $pdo->query($sql);
    $commentList = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($commentList as $comment) :

        $date = date('d/m/Y H:i:s', strtotime($comment['created_at']))
    ?>

    <h5 class="comment-name"><?= $comment['name']; ?>
        <span class="comment-date"> le <?= $date; ?></span>
    </h5>
    <p><?= $comment['content']; ?></p>
    <?php endforeach; ?>

</div>