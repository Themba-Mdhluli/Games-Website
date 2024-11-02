<?php require page('includes/header');?>

    <?php
        $title = $_GET['find'] ?? null;
        if(!empty($title)) {

            $title = "%$title%";
            $query = "select * from games where title like '$title' order by id asc limit 12";
            $result = db_query($query);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    ?>

    <section class="section-content container">
        <h1 class="section-header">Search</h1>

        <?php if(!empty($rows)):?>
            <h3 class="game-card-title">Result: <?=count($rows)?> Match(es) found</h3>
        <?php endif;?>
    </section>

    <section class="section-content container content">

        <?php if(!empty($rows)):?>
            <?php foreach($rows as $row):?>
                <div class="game-card">
                    <h3 class="game-card-title">Title: <?=$row['title']?></h3>
                    <a href="<?=ROOT?>/game/<?=$row['title']?>">
                        <img class="game-card-image" src="<?=ROOT?>/<?=$row['image']?>">
                    </a>
                    <div class="game-card-details">
                        <h3>Genre: <?=get_genre($row['genreID'])?></h3>
                        <h3>Age Rating: <?=$row['ageRating']?></h3>
                        <h3>Release Date: <?=$row['releaseDate']?></h3>
                    </div>
                </div>
            <?php endforeach;?>
            <?php else:?>
                <h3 class="game-card-title">Result: No match(es) found</h3>
        <?php endif;?>
    </section>

<?php require page('includes/footer');?>    