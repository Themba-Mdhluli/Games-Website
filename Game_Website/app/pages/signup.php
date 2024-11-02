<?php
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $errors = [];

        //data validation
        if(empty($_POST['name']))
        {
            $errors['name'] = 'a name is required';
        }else
        if(!preg_match("/^[a-zA-Z ]+$/",$_POST['name'])) {
            $errors['name'] = 'a name can only have letters and space';
        }

        if(empty($_POST['surname']))
        {
            $errors['surname'] = 'a surname is required';
        }else
        if(!preg_match("/^[a-zA-Z ]+$/",$_POST['surname'])) {
            $errors['surname'] = 'a surname can only have letters and space';
        }

        if(empty($_POST['gender']))
        {
            $errors['gender'] = 'a gender is required ';
        }

        if(empty($_POST['email']))
        {
            $errors['email'] = 'an email is required';
        }else
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'invalid email format, valid format:(example@email.com)';
        }else {

            $email = $_POST['email'];
            $query = "select * from visitors where email = '$email' limit 1";
            $result = db_query($query);
            $row = mysqli_fetch_assoc($result);

            if(!empty($row))
            {
                if($row['email'] == $email) {

                    $errors['email'] = 'this email is already in use';
                }
            }
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
            $values['gender'] = $_POST['gender'];

            $query = "insert into visitors (name,surname,gender,email,password) values (?,?,?,?,?)";

            $con  = db_connect();
            $preparedQuery = $con->prepare($query); 
            $preparedQuery->bind_param("sssss",$values['name'],$values['surname'],$values['gender'],$values['email'],$values['password']);
            $preparedQuery->execute();
            
            redirect('login');
        }
    }
?>

<?php require page('includes/header');?>

<section class="section-content container">
    <div class="login-holder">

        <form method="post" class="my-2">
            <h3 class="section-header">Signup</h3>
            <p style="text-align:center;">Fill in the form to create an account</p>

            <h3>Name:</h3>
            <input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Enter your name">
            <?php if(!empty($errors["name"])):?>
                <small class="error"><?=$errors["name"]?></small>
            <?php endif;?>

            <h3>Surname:</h3>
            <input class="form-control my-1" value="<?=set_value('surname')?>" type="text" name="surname" placeholder="Enter your surname">
            <?php if(!empty($errors["surname"])):?>
                <small class="error"><?=$errors["surname"]?></small>
            <?php endif;?>

            <h3>Gender:</h3>
            <span class="m-1">Male<input class="mx-1" type="radio" name="gender" <?=set_checked("gender","M")?> value="M"></span>
            <span class="m-1">Female<input class="mx-1" type="radio" name="gender" <?=set_checked("gender","F")?> value="F"></span>
            <?php if(!empty($errors["gender"])):?>
                <div><small class="error"><?=$errors["gender"]?></small></div>
            <?php endif;?>

            <h3 style="margin-top:10px;">Email:</h3>
            <input class="form-control my-1" value="<?=set_value('email')?>" type="email" name="email" placeholder="Enter your email">
            <?php if(!empty($errors["email"])):?>
                <small class="error"><?=$errors["email"]?></small>
            <?php endif;?>

            <h3>Password:</h3>
            <input class="form-control my-1" type="password" name="password" placeholder="Enter your password">
            <?php if(!empty($errors["password"])):?>
                <small class="error"><?=$errors["password"]?></small>
            <?php endif;?>

            <h3>Retype-Password:</h3>
            <input class="form-control my-1" type="password" name="retype_password" placeholder="Retype your password">

            <p>Already have an account. <a href="<?=ROOT?>/login" class="link">Login</a></p>
            
            <center><button class="my-1 btn bg-green" type="submit">Signup</button></center>
        </form>

    </div>  
</section>

<?php require page('includes/footer');?>