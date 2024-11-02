<?php require page('includes/admin-header');?>

    <!-- Start hero -->
    <img class="hero" src="<?=ROOT?>/assets/images/bgPic.jpg" alt="">
    <div class="hero-slogan">
        <h1>Admin Website</h1>
        <p>Enjoy our variety of games at a highest level</p>
    </div>
    <!-- End hero -->

    <h1 class="mx-1">Dashboard</h1>
    <section class="section-content container content" style="height:auto">
        <div class="game-card">
            <h2 class="game-card-title"><i class="icon-user"></i></h2>
            <div class="game-card-details">
                <h3>Users: <?=countRows("select * from users")?></h3>
            </div>
        </div>

        <div class="game-card">
            <h2 class="game-card-title"><i class="icon-gamepad"></i></h2>
            <div class="game-card-details">
                <h3>Games: <?=countRows("select * from games")?></h3>
            </div>
        </div>

        <div class="game-card">
            <h2 class="game-card-title"><i class="icon-folder-open"></i></h2>
            <div class="game-card-details">
                <h3>Genres: <?=countRows("select * from genres")?></h3>
            </div>
        </div>
    </section>

<?php require page('includes/admin-footer');?>