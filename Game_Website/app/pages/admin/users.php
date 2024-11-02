<?php

    if($action == 'add') 
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $errors = [];

            //data validation
            if(empty($_POST['name']))
            {
                $errors['name'] = 'a name is required';
            }else
            if(!preg_match("/^[a-zA-Z]+$/",$_POST['name'])) {
                $errors['name'] = 'a name can only have letters and no-space';
            }

            if(empty($_POST['surname']))
            {
                $errors['surname'] = 'a surname is required';
            }else
            if(!preg_match("/^[a-zA-Z ]+$/",$_POST['surname'])) {
                $errors['surname'] = 'a surname can only have letters and white-space';
            }

            if(empty($_POST['email']))
            {
                $errors['email'] = 'an email is required';
            }else
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'invalid email format, valid format:(example@email.com)';
            }

            if(empty($_POST['password']))
            {
                $errors['password'] = 'a password is required';
            }else
            if(!preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/",$_POST['password'])) {
                    $errors['password'] = 'a password must contain at least one uppercase, lowercase, number, symbol and must have 8 or more characters.';
            }else
            if($_POST['password'] != $_POST['retype_password']) {
                $errors['password'] = 'passwords do not match';
            }   

            if(empty($errors))
            {
                $values = [];
                $values['name'] = trim($_POST['name']);
                $values['surname'] = trim($_POST['surname']);
                $values['email'] = trim($_POST['email']);
                $values['password'] = password_hash($_POST['password'], PASSWORD_ARGON2I);
                $values['date'] = date("Y-m-d H:i:s");

                $query = "insert into users (name,surname,email,password,date) values (?,?,?,?,?)";

                $con  = db_connect();
                $preparedQuery = $con->prepare($query); 
                $preparedQuery->bind_param("sssss",$values['name'],$values['surname'],$values['email'],$values['password'],$values['date']);
                $preparedQuery->execute();
                
                message("user created successfully");
                redirect('admin/users');
            }
        }
    }else
    if($action == 'edit')
    {
        $con  = db_connect();
        $query = "select * from users where id = ? limit 1";
        
        $preparedQuery = $con->prepare($query);
        $preparedQuery->bind_param('i',$id);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        if($_SERVER['REQUEST_METHOD'] == "POST" && $rows)
        {
            $errors = [];

            //data validation
            if(empty($_POST['name']))
            {
                $errors['name'] = 'a name is required';
            }else
            if(!preg_match("/^[a-zA-Z]+$/",$_POST['name'])) {
                $errors['name'] = 'a name can only have letters and no-space';
            }

            if(empty($_POST['surname']))
            {
                $errors['surname'] = 'a surname is required';
            }else
            if(!preg_match("/^[a-zA-Z ]+$/",$_POST['surname'])) {
                $errors['surname'] = 'a surname can only have letters and white-space';
            }

            if(empty($_POST['email']))
            {
                $errors['email'] = 'an email is required';
            }else
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'invalid email format, valid format:(example@email.com)';
            }

            if(!empty($_POST['password']))
            {
                if(!preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/",$_POST['password'])) {
                        $errors['password'] = 'a password must contain at least one uppercase, lowercase, number, symbol and must have 8 or more characters.';
                }else
                if($_POST['password'] != $_POST['retype_password']) {
                    $errors['password'] = 'passwords do not match';
                }
            }  

            if(empty($errors))
            {
                // $name       = trim($_POST['name']);
                // $surname    = trim($_POST['surname']);
                // $email      = trim($_POST['email']);
                // $userID     = $id;

                // $query = "update users set name = '$name', surname = '$surname', email = '$email' where id = '$userID' limit 1";

                $values = [];
                $values['name'] = trim($_POST['name']);
                $values['surname'] = trim($_POST['surname']);
                $values['email'] = trim($_POST['email']);
                $values['id'] = $id;

                $query = "update users set name = ?, surname = ?, email = ? where id = ? limit 1";

                if(!empty($_POST['password']))
                {
                    // $password = password_hash($_POST['password'], PASSWORD_ARGON2I);
                    // $query = "update users set name = '$name', surname = '$surname', email = '$email', password = '$password' where id = '$userID' limit 1";

                    // db_query($query);

                    $values['password'] = password_hash($_POST['password'], PASSWORD_ARGON2I);
                    $query = "update users set name = ?, surname = ?, email = ?, paswword = ? where id = ? limit 1";
                    
                    $con  = db_connect();
                    $preparedQuery = $con->prepare($query); 
                    $preparedQuery->bind_param('ssssi',$values['name'],$values['surname'],$values['email'],$values['password'],$values['id']);
                    $preparedQuery->execute();

                }else {

                    // db_query($query);
                    $con  = db_connect();
                    $preparedQuery = $con->prepare($query); 
                    $preparedQuery->bind_param('sssi',$values['name'],$values['surname'],$values['email'],$values['id']);
                    $preparedQuery->execute();
                }
                message("user edited successfully");
                redirect('admin/users');
            }
        }
    }else
    if($action == 'delete')
    {
        $con  = db_connect();
        $query = "select * from users where id = ? limit 1";
        
        $preparedQuery = $con->prepare($query);
        $preparedQuery->bind_param('i',$id);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        if($_SERVER['REQUEST_METHOD'] == "POST" && $rows)
        {
            if($rows[0]['id'] == 0)
            {
                message("the main admin cannot be deleted");
                redirect('admin/users');
            }

            if(empty($errors))
            {
                // $name       = trim($_POST['name']);
                // $surname    = trim($_POST['surname']);
                // $email      = trim($_POST['email']);
                // $userID     = $id;

                // $query = "update users set name = '$name', surname = '$surname', email = '$email' where id = '$userID' limit 1";

                $values = [];
                $values['id'] = $id;

                $query = "delete from users where id = ? limit 1";

                // db_query($query);
                $con  = db_connect();
                $preparedQuery = $con->prepare($query); 
                $preparedQuery->bind_param('i',$values['id']);
                $preparedQuery->execute();
                
                message("user deleted successfully");
                redirect('admin/users');
            }
        }
    }

    
?>

<?php require page('includes/admin-header');?>

    <section class="section-content container" style="height:500px;">

        <?php if($action == 'add'):?>

            <div style="max-width: 500px;margin: auto;">
                <form method="post" class="my-2">
                    <h3>Add New User</h3>

                    <input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Enter your name">
                    <?php if(!empty($errors["name"])):?>
                        <small class="error"><?=$errors["name"]?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('surname')?>" type="text" name="surname" placeholder="Enter your surname">
                    <?php if(!empty($errors["surname"])):?>
                        <small class="error"><?=$errors["surname"]?></small>
                    <?php endif;?>

                    <input class="form-control my-1" value="<?=set_value('email')?>" type="email" name="email" placeholder="Enter your email">
                    <?php if(!empty($errors["email"])):?>
                        <small class="error"><?=$errors["email"]?></small>
                    <?php endif;?>

                    <input class="form-control my-1" type="password" name="password" placeholder="Enter your password">
                    <?php if(!empty($errors["password"])):?>
                        <small class="error"><?=$errors["password"]?></small>
                    <?php endif;?>

                    <input class="form-control my-1" type="password" name="retype_password" placeholder="Retype your password">

                    <button class="btn bg-green">Save</button>
                    <a href="<?=ROOT?>/admin/users/">
                        <button type="button" class="float-end btn">Back</button>
                    </a>
                </form>
            </div>
        <?php elseif($action == 'edit'):?>

            <div style="max-width: 500px;margin: auto;">
                <form method="post" class="my-2">
                    <h3>Edit User</h3>

                    <?php if(!empty($rows)):?>
                            
                        <input class="form-control my-1" value="<?=set_value('name',$rows[0]['name'])?>" type="text" name="name" placeholder="Enter your name">
                        <?php if(!empty($errors["name"])):?>
                            <small class="error"><?=$errors["name"]?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('surname',$rows[0]['surname'])?>" type="text" name="surname" placeholder="Enter your surname">
                        <?php if(!empty($errors["surname"])):?>
                            <small class="error"><?=$errors["surname"]?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('email',$rows[0]['email'])?>" type="email" name="email" placeholder="Enter your email">
                        <?php if(!empty($errors["email"])):?>
                            <small class="error"><?=$errors["email"]?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('password')?>" type="password" name="password" placeholder="Password (leave empty to keep the old one)">
                        <?php if(!empty($errors["password"])):?>
                            <small class="error"><?=$errors["password"]?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('retype_password')?>" type="password" name="retype_password" placeholder="Retype your password">

                        <button class="btn bg-green">Save</button>
                        <a href="<?=ROOT?>/admin/users/">
                            <button type="button" class="float-end btn">Back</button>
                        </a>

                        <?php else:?>
                            <div class="alert my-2">That record was not found</div>
                            <a href="<?=ROOT?>/admin/users/">
                                <button type="button" class="float-end btn">Back</button>
                            </a>
                    <?php endif;?>

                </form>
            </div>
        <?php elseif($action == 'delete'):?>
            
            <div style="max-width: 500px;margin: auto;">
                <form method="post" class="my-2">
                    <h3>Delete User</h3>

                    <?php if(!empty($rows)):?>
                            
                        <div class="form-control my-1"><?=set_value('name',$rows[0]['name'])?></div>

                        <div class="form-control my-1"><?=set_value('surname',$rows[0]['surname'])?></div>

                        <div class="form-control my-1"><?=set_value('email',$rows[0]['email'])?></div>

                        <button class="btn bg-red">Delete</button>
                        <a href="<?=ROOT?>/admin/users/">
                            <button type="button" class="float-end btn">Back</button>
                        </a>

                        <?php else:?>
                            <div class="alert my-2">That record was not found</div>
                            <a href="<?=ROOT?>/admin/users/">
                                <button type="button" class="float-end btn">Back</button>
                            </a>
                    <?php endif;?>

                </form>
            </div>
        <?php else:?>

            <?php
                $query = "select * from users order by id desc limit 20";
                $con  = db_connect();
                $preparedQuery = $con->prepare($query);
                $preparedQuery->execute();
                $result = $preparedQuery->get_result();
                $rows =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <h3 class="my-1">Users 
                <a href="<?=ROOT?>/admin/users/add">
                    <button class="btn float-end bg-purple">Add New</button>
                </a>
            </h3>

            <table class="table my-2">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>

                <?php if(!empty($rows)):?>
                    <?php for ($i=0; $i < count($rows); $i++):?>
                        <tr>
                            <td><?=$rows[$i]['id']?></td>
                            <td><?=$rows[$i]['name']?></td>
                            <td><?=$rows[$i]['surname']?></td>
                            <td><?=$rows[$i]['email']?></td>
                            <td><?=get_date($rows[$i]['date'])?></td>
                            <td>
                                <a href="<?=ROOT?>/admin/users/edit/<?=$rows[$i]['id']?>">
                                    <i class="icon-pencil mx-1"></i>
                                </a>
                                <a href="<?=ROOT?>/admin/users/delete/<?=$rows[$i]['id']?>">
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