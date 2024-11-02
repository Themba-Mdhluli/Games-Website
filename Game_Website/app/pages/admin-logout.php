<?php
    if (!empty($_SESSION['login'])) {
        unset($_SESSION['login']);
        session_destroy();
        session_regenerate_id();
    }

    redirect('admin-login');