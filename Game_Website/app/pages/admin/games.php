<?php

    if($action == 'add') 
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $errors = [];

            //data validation
            if(empty($_POST['title']))
            {
                $errors['title'] = 'a title is required';
            }else
            if(!preg_match("/^[a-zA-Z0-9 \&\-]+$/",$_POST['title'])) {
                $errors['title'] = 'a title can only have letters, space and symbols';
            }

            if(empty($_POST['gameWebsite']))
            {
                $errors['gameWebsite'] = 'a url is required';
            }else
            if(!filter_var($_POST['gameWebsite'],FILTER_VALIDATE_URL)) {
                $errors['gameWebsite'] = 'invalid url formart, valid formart(example.com)';
            }

            //image
            if(!empty($_FILES['image']['name']))
            {
                $folder = "uploads/";
                if(!file_exists($folder))
                {
                    mkdir($folder,0777,true);
                    file_put_contents($folder."index.php","");
                }

                $allowed = ['image/jpeg', 'image/png'];
                if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
                {
                    $destination_image = $folder.$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'],$destination);

                }else {
                    $errors['image'] = 'image not valid. Allowed types are '.implode(',', $allowed);
                } 
            }else {
                $errors['image'] = 'an image is required';
            }

            //video
            if(!empty($_FILES['video']['name']))
            {
                $folder = "uploads/";
                if(!file_exists($folder))
                {
                    mkdir($folder,0777,true);
                    file_put_contents($folder."index.php","");
                }

                $allowed = ['video/mp4'];
                if($_FILES['video']['error'] == 0 && in_array($_FILES['video']['type'], $allowed))
                {
                    $destination_video = $folder.$_FILES['video']['name'];
                    move_uploaded_file($_FILES['video']['tmp_name'],$destination);

                }else {
                    $errors['video'] = 'video not valid. Allowed types are '.implode(',', $allowed);
                } 
            }else {
                $errors['video'] = 'an video is required';
            }

            if(empty($_POST['ageRating']))
            {
                $errors['ageRating'] = 'a age rating is required';
            }

            if(empty($_POST['genre_id']))
            {
                $errors['genre_id'] = 'a genre is required';
            }

            if(empty($_POST['release-date']))
            {
                $errors['release-date'] = 'a release-date is required';
            }

            if(empty($_POST['description'])) 
            {
                $errors['description'] = 'a description is required';
            }

            if(empty($errors))
            {
                $title = trim($_POST['title']);
                $image = $destination_image;
                $video = $destination_video;
                $description = $_POST['description'];
                $release_date = $_POST['release-date'];
                $game_website = $_POST['gameWebsite'];
                $ageRating = $_POST['ageRating'];
                $genre_id = $_POST['genre_id'];
                $userID = user('id'); 
                
                $query = "insert into games (title,image,releaseDate,ageRating,userID,genreID,gameWebsite,gameTrailer,description) values ('$title','$image','$release_date','$ageRating','$userID','$genre_id',$game_website,$video,$description)";

                db_query($query);
                
                message("games created successfully");
                redirect('admin/games');
            }
        }
    }else
    if($action == 'edit')
    {
        $query = "select * from games where id = '$id' limit 1";
        $result = db_query($query);
        $row = mysqli_fetch_assoc($result);
        
        if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
        {
            $errors = [];

            //data validation
            if(empty($_POST['title']))
            {
                $errors['title'] = 'a title is required';
            }else
            if(!preg_match("/^[a-zA-Z0-9 \&\-]+$/",$_POST['title'])) {
                $errors['title'] = 'a title can only have letters, space and symbols';
            }

            if(empty($_POST['gameWebsite']))
            {
                $errors['gameWebsite'] = 'a url is required';
            }else
            if(!filter_var($_POST['gameWebsite'],FILTER_VALIDATE_URL)) {
                $errors['gameWebsite'] = 'invalid url formart, valid formart(example.com)';
            }

            //image
            if(!empty($_FILES['image']['name']))
            {
                $folder = "uploads/";
                if(!file_exists($folder))
                {
                    mkdir($folder,0777,true);
                    file_put_contents($folder."index.php","");
                }

                $allowed = ['image/jpeg', 'image/png'];
                if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
                {
                    $destination_image = $folder.$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'],$destination_image);

                    //delete old file
                    if(file_exists($row['image']))
                    {
                        unlink($row['image']);
                    }

                }else {
                    $errors['image'] = 'image not valid. Allowed types are '.implode(',', $allowed);
                }
            }

            //video
            if(!empty($_FILES['video']['name']))
            {
                $folder = "uploads/";
                if(!file_exists($folder))
                {
                    mkdir($folder,0777,true);
                    file_put_contents($folder."index.php","");
                }

                $allowed = ['video/mp4'];
                if($_FILES['video']['error'] == 0 && in_array($_FILES['video']['type'], $allowed))
                {
                    $destination_video = $folder.$_FILES['video']['name'];
                    move_uploaded_file($_FILES['video']['tmp_name'],$destination_video);

                    if(file_exists($row['video']))
                    {
                        unlink($row['video']);
                    }

                }else {
                    $errors['video'] = 'video not valid. Allowed types are '.implode(',', $allowed);
                } 
            }

            if(empty($_POST['ageRating']))
            {
                $errors['ageRating'] = 'a age rating is required';
            }

            if(empty($_POST['genre_id']))
            {
                $errors['genre_id'] = 'a genre is required';
            }

            if(empty($_POST['release-date']))
            {
                $errors['release-date'] = 'a release-date is required';
            }

            if(empty($errors))
            {
                $title = trim($_POST['title']);
                $release_date = $_POST['release-date'];
                $game_website = $_POST['gameWebsite'];
                $ageRating = $_POST['ageRating'];
                $genre_id = $_POST['genre_id'];
                $userID = $_SESSION['USER']['id'];
                $pageID = $id;

                $query = "update games set title = '$title',releaseDate = '$release_date',ageRating = '$ageRating',userID = '$userID', genreID = '$genre_id',gameWebsite = '$game_website'";

                if(!empty($_POST['description'])) {
                    $description = $_POST['description'];
                    $query .= ",description = '$description' ";
                }
                
                if(!empty($destination_image)) {
                    $image = $destination_image;
                    $query .= ",image = '$image' ";
                }

                if(!empty($destination_video)) {
                    $video = $destination_video;
                    $query .= ",gameTrailer = '$video' ";
                }
                
                $query .= " where id = '$pageID' limit 1";
                db_query($query);
                
                message("game edited successfully");
                redirect('admin/games');
            }
        }
    }else
    if($action == 'delete')
    {
        $query = "select * from games where id = '$id' limit 1";
        $result = db_query($query);
        $row = mysqli_fetch_assoc($result);
        
        if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
        {
            $pageID = $id;

            $query = "delete from games where id = '$pageID' limit 1";

            db_query($query);

            //delete image
            if(file_exists($row['image']))
            {
                unlink($row['image']);
            }

            //delete video
            if(file_exists($row['video']))
            {
                unlink($row['video']);
            }
            
            message("game deleted successfully");
            redirect('admin/games');
        }
    }

    
?>

<?php require page('includes/admin-header');?>

    <section class="section-content container" style="height:auto">

        <?php if($action == 'add'):?>

            <div style="max-width: 500px;margin: auto;">
                <form method="post" enctype="multipart/form-data" class="my-2">
                    <h3>Add New Game</h3>

                    <input class="form-control my-1" value="<?=set_value('title')?>" type="text" name="title" placeholder="Enter game title">
                    <?php if(!empty($errors["title"])):?>
                        <small class="error"><?=$errors["title"]?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('ageRating',$row['ageRating'])?>" type="text" name="title" placeholder="Enter game age rating">
                    <?php if(!empty($errors["ageRating"])):?>
                        <small class="error"><?=$errors["ageRating"]?></small>
                    <?php endif;?>

                    <div class="form-control my-1">
                        <div>Image:</div>
                        <input type="file" name="image" value="<?=set_value('image')?>">
                        <?php if(!empty($errors["image"])):?>
                            <small class="error"><?=$errors["image"]?></small>
                        <?php endif;?>
                    </div>

                    <div class="form-control my-1">
                        <div>Video:</div>
                        <input type="file" name="video" value="<?=set_value('video')?>">
                        <?php if(!empty($errors["video"])):?>
                            <small class="error"><?=$errors["video"]?></small>
                        <?php endif;?>
                    </div>

                    <input class="form-control my-1" value="<?=set_value('releaseDate')?>" type="date" name="release-date">
                    <?php if(!empty($errors["release-date"])):?>
                        <small class="error"><?=$errors["release-date"]?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('gameWebsite')?>" type="url" name="gameWebsite" placeholder="Enter game url">
                    <?php if(!empty($errors["gameWebsite"])):?>
                        <small class="error"><?=$errors["gameWebsite"]?></small>
                    <?php endif;?>

                    <?php
                        $query = "select * from genres order by genreName asc";
                        $result = db_query($query);
                        $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    ?>
                    <select name="genre_id" class="form-control my-1">
                        <option value="">--Select Genre--</option>

                        <?php if(!empty($genres)):?>
                            <?php foreach($genres as $genre):?>
                                <option <?=set_select('genre_id',$genre['id'])?> value="<?=$genre['id']?>"><?=$genre['genreName']?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                    <?php if(!empty($errors["genre_id"])):?>
                        <small class="error"><?=$errors["genre_id"]?></small><div class="my-1"></div>
                    <?php endif;?>

                    <textarea class="my-1 form-control" name="description" cols="30" rows="10" placeholder="Please enter the game description..."></textarea>
                    <?php if(!empty($errors["description"])):?>
                        <small class="error"><?=$errors["description"]?></small><div class="my-1"></div>
                    <?php endif;?>

                    <button class="btn bg-green">Save</button>
                    <a href="<?=ROOT?>/admin/games/">
                        <button type="button" class="float-end btn">Back</button>
                    </a>
                </form>
            </div>
        <?php elseif($action == 'edit'):?>

            <div style="max-width: 500px;margin: auto;">
                <form method="post" enctype="multipart/form-data" class="my-2">
                    <h3>Edit Game</h3>

                    <?php if(!empty($row)):?>
                            
                        <input class="form-control my-1" value="<?=set_value('title',$row['title'])?>" type="text" name="title" placeholder="Enter game title">
                        <?php if(!empty($errors["title"])):?>
                            <small class="error"><?=$errors["title"]?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('ageRating',$row['ageRating'])?>" type="text" name="title" placeholder="Enter game age rating">
                        <?php if(!empty($errors["ageRating"])):?>
                            <small class="error"><?=$errors["ageRating"]?></small>
                        <?php endif;?>

                        <img src="<?=ROOT?>/<?=set_value('image',$row['image'])?>" style="width:200px;height:200px;object-fit:cover;">

                        <div class="form-control my-1">
                            <div>Image:</div>
                            <input  value="<?=set_value('image',$row['image'])?>" type="file" name="image">
                            <?php if(!empty($errors["image"])):?>
                                <small class="error"><?=$errors["image"]?></small>
                            <?php endif;?>
                        </div>

                        <video controls src="<?=ROOT?>/<?=set_value('gameTrailer',$row['gameTrailer'])?>" style="width:100%;height:200px;border: 2px solid #1f837e;"></video>

                        <div class="form-control my-1">
                            <div>Video:</div>
                            <input type="file" name="video" value="<?=set_value('video',$row['gameTrailer'])?>">
                            <?php if(!empty($errors["video"])):?>
                                <small class="error"><?=$errors["video"]?></small>
                            <?php endif;?>
                        </div>

                        <input class="form-control my-1" value="<?=set_value('releaseDate',$row['releaseDate'])?>" type="date" name="release-date">
                        <?php if(!empty($errors["release-date"])):?>
                            <small class="error"><?=$errors["release-date"]?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('gameWebsite',$row['gameWebsite'])?>" type="url" name="gameWebsite" placeholder="Enter game url">
                        <?php if(!empty($errors["gameWebsite"])):?>
                            <small class="error"><?=$errors["gameWebsite"]?></small>
                        <?php endif;?>

                        <?php
                            $query = "select * from genres order by genreName asc";
                            $result = db_query($query);
                            $genres = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        ?>

                        <select name="genre_id" class="form-control my-1">
                            <option value="">--Select Genre--</option>

                            <?php if(!empty($genres)):?>
                                <?php foreach($genres as $genre):?>
                                    <option <?=set_select('genre_id',$genre['id'],$row['genreID'])?> value="<?=$genre['id']?>"><?=$genre['genreName']?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                        <?php if(!empty($errors["genre_id"])):?>
                            <small class="error"><?=$errors["genre_id"]?></small><div class="my-1"></div>
                        <?php endif;?>

                        <textarea class="my-1 form-control" name="description" cols="30" rows="10" placeholder="Leave empty to keep the old game description..." value="<?=set_value('description',$row['description'])?>"></textarea>
                        <?php if(!empty($errors["description"])):?>
                            <small class="error"><?=$errors["description"]?></small><div class="my-1"></div>
                        <?php endif;?>

                        <button class="btn bg-green">Save</button>
                        <a href="<?=ROOT?>/admin/games/">
                            <button type="button" class="float-end btn">Back</button>
                        </a>

                        <?php else:?>
                            <div class="alert my-2">That record was not found</div>
                            <a href="<?=ROOT?>/admin/games/">
                                <button type="button" class="float-end btn">Back</button>
                            </a>
                    <?php endif;?>

                </form>
            </div>
        <?php elseif($action == 'delete'):?>
            
            <div style="max-width: 500px;margin: auto;">
                <form method="post" class="my-2">
                    <h3>Delete Game</h3>

                    <?php if(!empty($row)):?>
                            
                        <div class="form-control my-1"><?=set_value('title',$row['title'])?></div>

                        <button class="btn bg-red">Delete</button>
                        <a href="<?=ROOT?>/admin/games/">
                            <button type="button" class="float-end btn">Back</button>
                        </a>

                        <?php else:?>
                            <div class="alert my-2">That record was not found</div>
                            <a href="<?=ROOT?>/admin/games/">
                                <button type="button" class="float-end btn">Back</button>
                            </a>
                    <?php endif;?>

                </form>
            </div>
        <?php else:?>

            <?php

                $limit = 10;
                $offset = ($page-1) * $limit;

                $query = "select * from games order by id desc limit $limit offset $offset";

                $result = db_query($query);
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <h3 class="my-1">Games
                <a href="<?=ROOT?>/admin/games/add">
                    <button class="btn float-end bg-purple">Add New</button>
                </a>
            </h3>

            <table class="table my-2">

                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Game Website</th>
                    <th>Image</th>
                    <th>Game Trailer</th>
                    <th>Description</th>
                    <th>Genre</th>
                    <th>Release Date</th>
                    <th>Age Rating</th>
                    <th>Action</th>
                </tr>

                <?php if(!empty($rows)):?>
                    <?php foreach($rows as $row):?>
                        <tr>
                            <td><?=$row['id']?></td>
                            <td><?=$row['title']?></td>
                            <td><?=$row['gameWebsite']?></td>

                            <td><img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height:100px;object-fit:cover;"></td>

                            <td><video controls src="<?=ROOT?>/<?=$row['gameTrailer']?>" style="width:200px;height:100px;border: 2px solid #1f837e;"></video></td>

                            <td><?=$row['description']?></td>
                            <td><?=get_genre($row['genreID'])?></td>
                            <td><?=$row['releaseDate']?></td>
                            <td><?=$row['ageRating']?></td>

                            <td>
                                <a href="<?=ROOT?>/admin/games/edit/<?=$row['id']?>">
                                    <i class="icon-pencil mx-1"></i>
                                </a>
                                <a href="<?=ROOT?>/admin/games/delete/<?=$row['id']?>">
                                    <i class="icon-trash mx-1"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    <?php else:?>
                        <tr>
                            <td colspan="10" class="align-center">
                                <h3 class="game-card-title">No games are available</h3>
                            </td>
                        </tr>
                <?php endif;?>
            </table>
        <?php endif;?>
    </section>

    <div class="section-content container">
        <a href="<?=ROOT?>/admin/games?page=<?=$prev_page?>">
            <button class="btn bg-darkblue my-1" style="color: white;">Prev</button>
        </a>
        <a href="<?=ROOT?>/admin/games?page=<?=$next_page?>">
            <button class="btn bg-darkblue float-end my-1" style="color: white;">Next</button>
        </a>
    </div>

<?php require page('includes/admin-footer');?>