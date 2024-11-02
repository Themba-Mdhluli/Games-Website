<?php
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $game_id = $URL[2] ?? null;

        if(empty($_POST['comment']))
        {
            $errors['comment'] = 'a comment is required';
        }

        if(!empty($_POST['rating']))
        {
            $errors['rating'] = 'a rating is required';
        }

        if(empty($errors))
        {
            if(!empty($_SESSION["VISITOR"]["name"]))
            {
                $rating = $_POST['rating'];
                $comment = $_POST['comment'];
                $visitorID = "V-".$_SESSION["VISITOR"]["id"];
                
                $query = "insert into comments (visitorID,gameID,comment,rating) values ('$visitorID','$game_id','$comment','$rating')";
                db_query($query);

            }else
            if(!empty(user('name')))
            {
                $rating = $_POST['rating'];
                $comment = $_POST['comment'];
                $userID = "A-".user('id');

                $query = "insert into comments (visitorID,gameID,comment,rating) values ('$userID','$game_id','$comment','$rating')";
                db_query($query);
            }

            redirect('games');
            
        }
    }
?>

<?php require page('includes/header');?>

    <?php
        $title = $URL[1] ?? null;
        $query = "select * from games where title = '$title' limit 1";
        $result = db_query($query);
        $row = mysqli_fetch_assoc($result);

        $query = "select * from comments where gameID = '$URL[2]' limit 1";
        $result = db_query($query);
        $r = mysqli_fetch_assoc($result);
    ?>

    <section class="section-content container">
        <h1 class="section-header my-2"><?=strtoupper($row['title'])?></h1>
    </section>

    <section class="section-content container">
        <?php if(!empty($row)):?>
                <div class="game-card-full">
                    <a href="<?=ROOT?>/game/<?=$row['title']?>">
                        <img class="game-card-image-full" src="<?=ROOT?>/<?=$row['image']?>">
                    </a>
                    <div class="game-card-details-full">
                        <h3>Game trailer/Clip:</h3>
                        <video controls style="width: 100%; border: 2px solid #1f837e">
                            <source src="<?=$row['gameTrailer']?>" type="video/mp4">
                        </video>
                        <h3>Description:</h3>
                        <p> <?=$row['description']?></p>
                        <h3>Genre: <?=get_genre($row['genreID'])?></h3>
                        <h3>Release Date: <?=$row['releaseDate']?></h3>
                        <h3>Age Rating: <?=$row['ageRating']?></h3>
                        <h3>Game website: 
                            <a class="link" href="http://<?=$row['gameWebsite']?>" target="_blank" rel="noopener noreferrer"><?=$row['gameWebsite']?></a>
                        </h3>

                        <?php if(!empty($r)):?>
                            <h3>Rating: <?=$r['rating']."/5"?></h3>
                            <h3>Comment:</h3>
                            <p><?=$r['comment']?></p>

                            <?php else:?>
                                <?php if(isset($_SESSION['alive'])):?>
                                    <?='<form method="post">
                                            <select name="rating" class="form-control my-1">
                                                <option value="">--Select Rating--</option>
                                                <option '.set_select("rating","1",$r["rating"]).' value="1">1</option>
                                                <option '.set_select("rating","2",$r["rating"]).' value="2">2</option>
                                                <option '.set_select("rating","3",$r["rating"]).' value="3">3</option>
                                                <option '.set_select("rating","4",$r["rating"]).' value="4">4</option>
                                                <option '.set_select("rating","5",$r["rating"]).' value="5">5</option>
                                            </select>
                                            <h3>Comment:</h3>
                                            <textarea class="my-1 form-control" name="comment" cols="30" rows="5" placeholder="Please enter your Comment..." style="background-color: white;"></textarea>
                                            <center>
                                                <button class="btn bg-darkblue my-1" type="submit" style="color: white;">Send</button>
                                            </center>
                                        </form>'?>
                                <?php endif;?>
                        <?php endif;?>
                    </div>
                </div>
            <?php else:?>
                <h3 class="game-card-title">No games are available</h3>
        <?php endif;?>
    </section>

<?php require page('includes/footer');?>    