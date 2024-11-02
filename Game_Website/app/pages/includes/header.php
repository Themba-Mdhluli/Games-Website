<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiction Robot - <?=ucfirst($URL[0])?></title>

    <link rel="stylesheet" href="<?=ROOT?>/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/style.css?55">
</head>
<body>
    <!-- Start header -->
    <header class="main-header">
        <a href="<?=ROOT?>"><img class="logo" src="<?=ROOT?>/assets/images/Website logo.jpg" alt=""></a>
        <nav class="main-nav nav">
            <ul>
                <li><a class="active" href="<?=ROOT?>">Home</a></li>
                <li><a href="<?=ROOT?>/games">Games</a></li>


                <li><a href="<?=ROOT?>/about">About us</a></li>
                <li><a href="<?=ROOT?>/contact">Contact us</a></li>
            </ul>
        </nav>

        <?php
            // This will show after you Login
            if(isset($_SESSION['alive']))
            {
                echo('<div class="btns-holder">
                        <div class="dropdown nav bg-darkblue">
                            <a href="#">Welcome, '.$_SESSION["VISITOR"]["name"]."  ".$_SESSION["VISITOR"]["surname"].'</a>
                            <div class="dropdown-list" style="z-index: 30;">
                                <div class="nav-item"><a href="'.ROOT.'/profile">Profile</a></div>
                                <div class="nav-item"><a href="'.ROOT.'/settings">settings</a></div>
                                <div class="nav-item"><a href="'.ROOT.'/logout">Logout</a></div>
                            </div>
                        </div>
                    </div>');

            }
            
            // This will show after the admin Login
            else
            if(!empty(user('name')))
            {
                echo('<div class="btns-holder">
                        <div class="dropdown nav">
                            <a href="#">Hi, '.user('name').'</a>
                            <div class="dropdown-list" style="z-index: 30;">
                                <div class="nav-item">
                                    <a href="admin/users/edit/'.user('id').'"">Profile</a>
                                </div>
                                <div class="nav-item">
                                    <a href=" '.ROOT.'/admin/settings">Settings</a>
                                </div>
                                <div class="nav-item"><a href=" '.ROOT.'/admin-logout">Logout</a></div>
                            </div>
                        </div>
                    </div>');
            }

            // This will show before you Login
            else
            {
                echo('<div class="btns-holder">
                        <a href="'.ROOT.'/login">
                            <button class="mx-1 btn bg-darkblue">
                                <i class="icon-signin"> Login</i>
                            </button>
                        </a>
                        <a href="'.ROOT.'/signup">
                            <button class="mx-1 btn bg-darkblue">
                            <i class="icon-user"> Signup</i>
                        </button>
                        </a>
                    </div>');
            }
        ?>
    </header>
    <!-- End header -->