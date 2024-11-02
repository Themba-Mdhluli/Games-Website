<?php
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $errors = [];

        //data validation
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
        }  

        if(empty($errors))
        {
            $email = trim($_POST['email']);
            $query = "select * from visitors where email = '$email' limit 1";
            $result = db_query($query);
            $row = mysqli_fetch_assoc($result);

            if(!empty($row))
            { 
                if(password_verify($_POST['password'], $row['password'])) {

                    $_SESSION['alive'] = true;
                    $_SESSION['VISITOR'] = $row;
                    $_SESSION['loginError'] = "";
                    redirect('home');

                }else {
                    $_SESSION['loginError'] = "wrong email or password";
                    redirect('login');
                }
            }else {
                $_SESSION['loginError'] = "wrong email or password";
                redirect('login');
            }
        }
    }
?>

<?php require page('includes/header');?>

<section class="section-content container">
    <div class="login-holder">
        <form method="post">

            <?php if(!empty($_SESSION['loginError'])):?>
                <div class="alert my-1"><?=$_SESSION['loginError']?></div>
            <?php endif;?>

            <center><img class="my-2 logo" src="assets/images/Website logo.jpg" style="border: solid thin #ccc;"></center>

            <h1 class="section-header">Login</h1>

            <input class="my-1 form-control" type="email" name="email" placeholder="Please enter your email">
            <?php if(!empty($errors["email"])):?>
                <small class="error"><?=$errors["email"]?></small>
            <?php endif;?>

            <input class="my-1 form-control" type="password" name="password" placeholder="Please enter your password">
            <?php if(!empty($errors["password"])):?>
                <small class="error"><?=$errors["password"]?></small>
            <?php endif;?>

            <p>Not have an account. <a href="<?=ROOT?>/signup" class="link">Click here</a> to create one</p>
            
            <center><button class="my-1 btn bg-green" type="submit">Login</button></center>

        </form>
    </div>  
</section>

<?php require page('includes/footer');?>