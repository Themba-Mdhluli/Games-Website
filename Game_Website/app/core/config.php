<?php

    if($_SERVER['SERVER_NAME'] = 'localhost')
    {

        //for local server
        define('ROOT', 'http://localhost/game_website/public');

        define("DBDRIVE", "mysql");
        define("DBHOST", "localhost");
        define("DBUSER", "root");
        define("DBPASS", "root");
        define("DBNAME", "game_website_db");
        define("PORT", "3307");

    }else {

        //for online server
        define('ROOT', 'http://www.fictiorobot.com');

        define("DBHOST", "localhost");
        define("DBUSER", "root");
        define("DBPASS", "root");
        define("DBNAME", "game_website_db");
        define("PORT", "3307");
    }
    
    