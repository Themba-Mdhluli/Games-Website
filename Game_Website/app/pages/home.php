<?php require page('includes/header');?>

    <!-- Start hero -->
    <img class="hero" src="<?=ROOT?>/assets/images/bgPic.jpg" alt="">
    <div class="hero-slogan">
        <h1>Games Database At It Best</h1>
        <p>Enjoy our variety of games at a highest level</p>
    </div>
    <!-- End hero -->

    <section class="section-content container">
        <h1 class="section-header">Featured</h1>
    </section>

    <section class="section-content container content">
        <?php
            $query = "select * from games order by releaseDate desc limit 6";
            $result = db_query($query);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        ?>

        <?php if(!empty($rows)):?>
            <?php foreach($rows as $row):?>
                <div class="game-card">
                    <h3 class="game-card-title">Title: <?=$row['title']?></h3>

                    <a href="<?=ROOT?>/game/<?=$row['title']?>">
                        <img class="game-card-image" src="<?=ROOT?>/<?=$row['image']?>" alt="">
                    </a>
                    
                    <div class="game-card-details">
                        <h3>Genre: <?=get_genre($row['genreID'])?></h3>
                        <h3>Age Rating: <?=$row['ageRating']?></h3>
                        <h3>Release Date: <?=$row['releaseDate']?></h3>
                    </div>
                </div>
            <?php endforeach;?>
            <?php else:?>
                <h3 class="game-card-title">No games are available</h3>
        <?php endif;?>
    </section>

<?php require page('includes/footer');?>    