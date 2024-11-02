<?php
    if (isset($_SESSION['alive'])) {

        unset($_SESSION['alive']);
        $_SESSION['alive'] = null;
        session_destroy();
        session_regenerate_id();

        redirect('home');
    }