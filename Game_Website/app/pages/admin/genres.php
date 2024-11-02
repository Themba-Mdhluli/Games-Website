<?php

    if($action == 'add') 
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $errors = [];

            //data validation
            if(empty($_POST['genreName']))
            {
                $errors['genreName'] = 'a genreName is required';
            }else
            if(!preg_match("/^[a-zA-Z \&\-]+$/",$_POST['genreName'])) {
                $errors['genreName'] = 'a genreName can only have letters, space and symbols';
            }

            if(empty($errors))
            {
                $values = [];
                $values['genreName'] = trim($_POST['genreName']);
                $values['disable'] = trim($_POST['disable']);
                
                $query = "insert into genres (genreName,disable) values (?,?)";

                $con  = db_connect();
                $preparedQuery = $con->prepare($query); 
                $preparedQuery->bind_param("si",$values['genreName'],$values['disable']);
                $preparedQuery->execute();
                
                message("genre created successfully");
                redirect('admin/genres');
            }
        }
    }else
    if($action == 'edit')
    {
        $con  = db_connect();
        $query = "select * from genres where id = ? limit 1";
        
        $preparedQuery = $con->prepare($query);
        $preparedQuery->bind_param('i',$id);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        if($_SERVER['REQUEST_METHOD'] == "POST" && $rows)
        {
            $errors = [];

            //data validation
            if(empty($_POST['genreName']))
            {
                $errors['genreName'] = 'a genreName is required';
            }else
            if(!preg_match("/^[a-zA-Z \&\-]+$/",$_POST['genreName'])) {
                $errors['genreName'] = 'a genreName can only have letters, space and symbols';
            }

            if(empty($errors))
            {
                // $genreName       = trim($_POST['genreName']);
                // $disable    = trim($_POST['disable']);

                // $query = "update genres set genreName = '$genreName', disable = '$disable' where id = '$genreID' limit 1";

                $values = [];
                $values['genreName'] = trim($_POST['genreName']);
                $values['disable'] = trim($_POST['disable']);
                $values['id'] = $id;

                $query = "update genres set genreName = ?, disable = ? where id = ? limit 1";

                // db_query($query);
                $con  = db_connect();
                $preparedQuery = $con->prepare($query); 
                $preparedQuery->bind_param('sii',$values['genreName'],$values['disable'],$values['id']);
                $preparedQuery->execute();
                
                message("genre edited successfully");
                redirect('admin/genres');
            }
        }
    }else
    if($action == 'delete')
    {
        $con  = db_connect();
        $query = "select * from genres where id = ? limit 1";
        
        $preparedQuery = $con->prepare($query);
        $preparedQuery->bind_param('i',$id);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        if($_SERVER['REQUEST_METHOD'] == "POST" && $rows)
        {
            // $enreName       = trim($_POST['enreName']);
            // $disable    = trim($_POST['disable']);
            // $genreID     = $id;

            // $query = "update genres set enreName = '$enreName', disable = '$disable' where id = '$genreID' limit 1";

            $values = [];
            $values['id'] = $id;

            $query = "delete from genres where id = ? limit 1";

            // db_query($query);
            $con  = db_connect();
            $preparedQuery = $con->prepare($query); 
            $preparedQuery->bind_param('i',$values['id']);
            $preparedQuery->execute();
            
            message("genre deleted successfully");
            redirect('admin/genres');
        }
    }

    
?>

<?php require page('includes/admin-header');?>

    <section class="section-content container" style="height:500px;">

        <?php if($action == 'add'):?>

            <div style="max-width: 500px;margin: auto;">
                <form method="post" class="my-2">
                    <h3>Add New Genre</h3>

                    <input class="form-control my-1" value="<?=set_value('genreName')?>" type="text" name="genreName" placeholder="Enter your genreName">
                    <?php if(!empty($errors["genreName"])):?>
                        <small class="error"><?=$errors["genreName"]?></small>
                    <?php endif;?>

                    <select name="disable" class="form-control my-1">
                        <option value="">--Select disabled--</option>
                        <option <?=set_select("disable","1")?> value="1">Yes</option>
                        <option <?=set_select("disable","0")?> value="0">No</option>
                    </select>

                    <button class="btn bg-green">Save</button>
                    <a href="<?=ROOT?>/admin/genres/">
                        <button type="button" class="float-end btn">Back</button>
                    </a>
                </form>
            </div>
        <?php elseif($action == 'edit'):?>

            <div style="max-width: 500px;margin: auto;">
                <form method="post" class="my-2">
                    <h3>Edit Genre</h3>

                    <?php if(!empty($rows)):?>
                            
                        <input class="form-control my-1" value="<?=set_value('genreName',$rows[0]['genreName'])?>" type="text" name="genreName" placeholder="Enter your genreName">
                        <?php if(!empty($errors["genreName"])):?>
                            <small class="error"><?=$errors["genreName"]?></small>
                        <?php endif;?>

                        <select name="disable" class="form-control my-1">
                            <option value="">--Select disabled--</option>
                            <option <?=set_select("disable","1",$rows[0]['disable'])?> value="1">Yes</option>
                            <option <?=set_select("disable","0",$rows[0]['disable'])?> value="0">No</option>
                        </select>

                        <button class="btn bg-green">Save</button>
                        <a href="<?=ROOT?>/admin/genres/">
                            <button type="button" class="float-end btn">Back</button>
                        </a>

                        <?php else:?>
                            <div class="alert my-2">That record was not found</div>
                            <a href="<?=ROOT?>/admin/genres/">
                                <button type="button" class="float-end btn">Back</button>
                            </a>
                    <?php endif;?>

                </form>
            </div>
        <?php elseif($action == 'delete'):?>
            
            <div style="max-width: 500px;margin: auto;">
                <form method="post" class="my-2">
                    <h3>Delete Genre</h3>

                    <?php if(!empty($rows)):?>
                            
                        <div class="form-control my-1"><?=set_value('genreName',$rows[0]['genreName'])?></div>

                        <button class="btn bg-red">Delete</button>
                        <a href="<?=ROOT?>/admin/genres/">
                            <button type="button" class="float-end btn">Back</button>
                        </a>

                        <?php else:?>
                            <div class="alert my-2">That record was not found</div>
                            <a href="<?=ROOT?>/admin/genres/">
                                <button type="button" class="float-end btn">Back</button>
                            </a>
                    <?php endif;?>

                </form>
            </div>
        <?php else:?>

            <?php
                $query = "select * from genres order by id desc limit 20";
                $con  = db_connect();
                $preparedQuery = $con->prepare($query);
                $preparedQuery->execute();
                $result = $preparedQuery->get_result();
                $rows =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <h3 class="my-1">Genres 
                <a href="<?=ROOT?>/admin/genres/add">
                    <button class="btn float-end bg-purple">Add New</button>
                </a>
            </h3>

            <table class="table my-2">

                <tr>
                    <th>ID</th>
                    <th>GenreName</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>

                <?php if(!empty($rows)):?>
                    <?php for ($i=0; $i < count($rows); $i++):?>
                        <tr>
                            <td><?=$rows[$i]['id']?></td>
                            <td><?=$rows[$i]['genreName']?></td>
                            <td><?=$rows[$i]['disable'] ? 'No':'Yes'?></td>
                            <td>
                                <a href="<?=ROOT?>/admin/genres/edit/<?=$rows[$i]['id']?>">
                                    <i class="icon-pencil mx-1"></i>
                                </a>
                                <a href="<?=ROOT?>/admin/genres/delete/<?=$rows[$i]['id']?>">
                                    <i class="icon-trash mx-1"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endfor;?>
                <?php endif;?>
            </table>
        <?php endif;?>

    </section>

<?php require page('includes/admin-footer');?>