<?php

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

        if(empty($_POST['message']))
        {
            $errors['message'] = 'a message is required';
        }

        if(empty($errors))
        {
            $values = [];
            $values['name'] = trim($_POST['name']);
            $values['surname'] = trim($_POST['surname']);
            $values['email'] = trim($_POST['email']);
            $values['message'] = $_POST['message'];

            $query = "insert into messages (name,surname,email,message) values (?,?,?,?)";

            $con  = db_connect();
            $preparedQuery = $con->prepare($query); 
            $preparedQuery->bind_param("sssss",$values['name'],$values['surname'],$values['email'],$values['message']);
            $preparedQuery->execute();

            redirect('contact');
        }
    }
?>

<?php require page('includes/header');?>

    <section class="section-content container">
        <h2 class="section-header">Contacts</h2>
        <div class="content align-center my-2">
                <div>
                    <i class="contact icon-map-marker"></i>
                    <h3>Address</h3>
                    <p>5th Avenue Hartfield, Pretoria</p>
                </div>
                <div>
                    <i class="contact icon-envelope"></i>
                    <h3>Email</h3>
                    <p>fictionrobot@videogames.co.za</p>
                </div>
                <div>
                    <i class="contact icon-phone"></i>
                    <h3>Phone</h3>
                    <p>+27 997-083-0432</p>
                </div>
                <div>
                    <i class="contact icon-time"></i>
                    <h3>Time</h3>
                <p>09H00 am to 16H00 pm</p>
            </div>
        </div>
    </section>

    <section class="section-content container">
        <h2 class="section-header">Leave a message</h2>
        <form method="post">
            <div class="box-input">
                <input class="my-1 form-control" type="text" name="name" placeholder="Please enter your name" style="margin-right: 20px;">
                <?php if(!empty($errors["name"])):?>
                    <small class="error"><?=$errors["name"]?></small>
                <?php endif;?>

                <input class="my-1 form-control" type="text" name="surname" placeholder="Please enter your surname" style="margin-left: 20px;">
                <?php if(!empty($errors["surname"])):?>
                    <small class="error";><?=$errors["surname"]?></small>
                <?php endif;?>

            </div>
            <input class="my-1 form-control" type="email" name="email" placeholder="Please enter your email">
            <?php if(!empty($errors["email"])):?>
                <small class="error"><?=$errors["email"]?></small>
            <?php endif;?>

            <textarea class="my-1 form-control" name="message" cols="30" rows="10" placeholder="Please enter your message..."></textarea>
            <?php if(!empty($errors["message"])):?>
                <small class="error"><?=$errors["message"]?></small>
            <?php endif;?>

            <div class="align-center my-2">
                <input class="btn bg-green" type="submit" value="Send a message">
            </div>
        </form>
    </section>

<?php require page('includes/footer');?>