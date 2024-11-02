<?php require page('includes/header');?>

    <?php
        $query = "select * from genres order by genreName asc";
        $result = db_query($query);
        $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <section class="section-content container content">
        <h1 class="section-header">Games</h1>
        <span>Filter By:
        <div class="dropdown nav">
            <a href="#" class="btn-genre my-1">Genre</a>

            <?php
                $query = "select * from genres order by genreName asc";
                $result = db_query($query);
                $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <div class="dropdown-list" style="z-index: 20;">
                <?php if(!empty($genres)):?>
                    <?php foreach($genres as $genre):?>
                        <div>
                            <a href="<?=ROOT?>/genre/<?=strtolower($genre['genreName'])?>"><?=$genre['genreName']?></a>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>
        </span> 
    </section>

    <section class="section-content container content">

        <?php
            $limit = 12;
            $offset = ($page-1) * $limit;

            $query = "select * from games limit $limit offset $offset";
            $result = db_query($query);

            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        ?>

        <?php if(!empty($rows)):?>
            <?php foreach($rows as $row):?>
                <div class="game-card">
                    <h3 class="game-card-title">Title: <?=$row['title']?></h3>
                    <a href="<?=ROOT?>/game/<?=$row['title']?>/<?=$row['id']?>">
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
                <h3 class="game-card-title">No games are available</h3>
        <?php endif;?>
    </section>

    <div class="section-content container">
        <a href="<?=ROOT?>/games?page=<?=$prev_page?>">
            <button class="btn bg-darkblue my-1" style="color: white;">Prev</button>
        </a>
        <a href="<?=ROOT?>/games?page=<?=$next_page?>">
            <button class="btn bg-darkblue float-end my-1" style="color: white;">Next</button>
        </a>
    </div>

<?php require page('includes/footer');?>    