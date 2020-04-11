<?php

// Déconnecte l'utilisateur
function logout() {

    // Vide complètement la session de l'utilisateur courant
    session_unset();

    // Redirige ensuite l'utilisateur vers la page home
    header('Location:' . $_SERVER['BASE_URI'] .'/');

}