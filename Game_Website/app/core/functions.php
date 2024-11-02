<?php
    function show($stuff) 
    {
        echo("<pre>");
        print_r($stuff);
        echo("</pre>");
        // echo("<script>alert('No match')</script>");
    }

    function page($file)
    {
        return "../app/pages/".$file.".php";
    }

    // function db_connect1()
    // {
    //     $string = DBDRIVE.":host=".DBHOST.";dbname=".DBNAME;
    //     $con = new PDO($string, DBUSER, DBPASS,);

    //     return $con;
    // }

    function db_connect()
    {
        $con = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME,PORT);

        if(!$con->connect_error) {
            return $con;
        }else {
            die("Connection failed: ".$con->connect_error);
        }
    }

    function db_query($query)
    {
        $con = db_connect();
        $result = mysqli_query($con,$query);

        if($result)
            return $result;
        else
            return mysqli_error($con);
    }

    function message($message = '', $clear = false) 
    {
        if(!empty($message)) {
            $_SESSION["message"] = $message;
        }else {

            if(!empty($_SESSION["message"]))
            {
                $msg = $_SESSION["message"];
                if($clear) {
                    unset($_SESSION["message"]);
                }
                return $msg;
            }
        }
        return false;
    }

    function redirect($page)
    {
        header("Location: ".ROOT."/".$page);
        die;
    }

    function set_value($key, $default = '')
    {
        if(!empty($_POST[$key]))
        {
            return $_POST[$key];
        }else {
            return $default;
        }
        return '';
    }

    function set_select($key, $value, $default = '')
    {
        if(!empty($_POST[$key]))
        {
            if($_POST[$key] == $value) {
                return " selected ";
            }
        }else 
        {
            if($default == $value) {
                return " selected ";
            }
        }
        return '';
    }

    function set_checked($key, $value, $default = '')
    {
        if(!empty($_POST[$key]))
        {
            if($_POST[$key] == $value) {
                return " checked ";
            }
        }else 
        {
            if($default == $value) {
                return " checked ";
            }
        }
        return '';
    }

    function get_date($date)
    {
        return date("jS M, Y", strtotime($date));
    }

    function access_allowed($email, $password)
    {
        if(!empty($email) && !empty($password)) 
        {
            $con  = db_connect();
            $query = "select * from users where email = ? limit 1";
            
            $preparedQuery = $con->prepare($query);
            $preparedQuery->bind_param("s",$email);
            $preparedQuery->execute();
            $result = $preparedQuery->get_result();
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if(!empty($rows))
            {
                for ($i=0; $i < count($rows); $i++) { 
                    if(password_verify($password, $rows[$i]['password'])) {

                        $_SESSION['login'] = true ?? 'alive';
                        $_SESSION['USER'] = $rows[$i];
                        message("login successful");
                        redirect("admin");

                    }else {
                        message("wrong email or password");
                        redirect("admin-login");
                    }
                }
            }
            message("wrong email or password");
            redirect("admin-login");
        }
    }

    function user($column)
    {
        if(!empty($_SESSION['USER'][$column])) {
            return $_SESSION['USER'][$column];
        }
    }

    function countRows($query)
    {
        $result = db_query($query);
        $num = mysqli_num_rows($result);

        if($num > 0)
            return $num;
        else
            return 0;
    }

    function get_genre($id)
    {
        $query = "select genreName from genres where id = '$id' limit 1";
        $result = db_query($query);
        $row = mysqli_fetch_assoc($result);

        if(!empty($row['genreName']))
        {
            return $row['genreName'];
        }

        return "unknown";
    }