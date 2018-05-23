<?php
    session_start();

    unset($_SESSION);

    session_destroy();

    header('location: index.php?msg=Je bent succesvol uitgelogd.');
?>