<?php

    $section    = $URL[1] ?? 'dashboard';
    $action     = $URL[2] ?? null;
    $id         = $URL[3] ?? null;

    switch ($section) {
        case 'dashboard':
            require page('admin/dashboard');
            break;

        case 'users':
            require page('admin/users');
            break;
        
        case 'games':
            require page('admin/games');
            break;

        case 'genres':
            require page('admin/genres');
            break;

        default:
            require page('admin/404');
            break;
    }

