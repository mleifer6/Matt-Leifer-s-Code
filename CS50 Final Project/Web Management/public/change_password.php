<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        $success = 0;
        render("change_password_form.php", ["title" => "Change Your Password","success"=>$success]);
    }
    // if data has been sent to it via change_password_form.php
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Get the user's password hash
        $user_data = CS50::query("SELECT hash FROM users WHERE id = ?",$_SESSION["id"]);
        $hash = $user_data[0]["hash"];
        
        // Get the allegedly old password the user entered 
        $old_pass = $_POST["Old"];
        
        // Checks if the old password is valid
        if(password_verify($old_pass,$hash))
        {
            $success = 1;
            CS50::query("UPDATE users SET hash = ? WHERE id = ?", password_hash($_POST["New"], PASSWORD_DEFAULT), $_SESSION["id"]);
            render("change_password_form.php", ["title" => "Change Your Password","success"=>$success]);
        }
        else
        {
            $success = -1;
            render("change_password_form.php", ["title" => "Change Your Password","success"=>$success]);
        }
    }
?>