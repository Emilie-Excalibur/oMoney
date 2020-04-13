<?php
    $errors = updateEmail();
    if(count($errors) == 0) :

?>

    <p>Les données ont bien été modifiées.</p>
<?php
    else :
?>

    <p><?= $errors[0]; ?></p>

<?php endif; ?>