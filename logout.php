<?php
    session_start();
    //Gooi de sessie weg
    unset($_SESSION);

    session_destroy();
    // Stuur terug naar de index
    header('location: index.php?msg=Je bent succesvol uitgelogd.');
?>