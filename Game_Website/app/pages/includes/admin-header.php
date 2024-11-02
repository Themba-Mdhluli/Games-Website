<?php
    if(!isset($_SESSION['login']) && !empty($_SESSION['login'])) 
    {
        message("only admin can access the admin page");
        redirect('admin-login');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiction Robot</title>

    <link rel="stylesheet" href="<?=ROOT?>/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/style.css?0">
</head>
<body>
    <!-- Start header -->
    <header class="main-header">
        <a href="<?=ROOT?>/admin"><img class="logo" src="<?=ROOT?>/assets/images/Website logo.jpg" alt=""></a>
        <nav class="main-nav nav">
            <ul>
                <li><a href="<?=ROOT?>/admin">Dashboard</a></li>
                <li><a href="<?=ROOT?>/admin/users">Users</a></li>
                <li><a href="<?=ROOT?>/admin/games">Games</a></li>
                <li><a href="<?=ROOT?>/admin/genres">Genres</a></li>
            </ul>
        </nav>

        <!-- This will show after you Login -->
        <?php
            if(!empty(user('name'))) {
                
                echo('<div class="btns-holder">
                        <div class="dropdown nav">
                            <a href="#">Hi, '.user('name').'</a>
                            <div class="dropdown-list">
                                <div class="nav-item">
                                    <a href="admin/users/edit/'.user('id').'">Profile</a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?=ROOT?>/admin/settings">Settings</a>
                                </div>
                                <div class="nav-item"><a href="'.ROOT.'/admin-logout">Logout</a></div>
                            </div>
                        </div>
                    </div>');
            }
        ?>
    </header>
    <!-- End header -->

    <?php if(message()):?>
        <div class="alert"><?=message('', true)?></div>
    <?php endif;?>