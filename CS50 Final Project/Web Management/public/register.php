<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // run checks to make sure the user is registering properly
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }
        else if ($_POST["password"]!=$_POST["confirmation"])
        {
            apologize("Passwords do not match");
        }
        
        // insert user into database
        $rows = CS50::query("INSERT IGNORE INTO users (username, hash) VALUES(?, ?)", $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));
        if($rows==0)
        {
            apologize("User name already exists");
        }
        // Log the user in if he has registered succesfully
        else if (count($rows)>0)
        {
            $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"];
            // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $_POST["username"];
            // redirect to portfolio
            redirect("/");
        }
    }

?>

