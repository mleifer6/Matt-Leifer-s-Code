<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("add_item_form.php", ["title" => "Add Food"]);
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Adds a food to the database if it was selected from a search result
        if(isset($_POST["item_no"]) && $_POST["amount"] != 0)
        {
            // for protection  
            $amount = htmlspecialchars($_POST["amount"]);
            
            // converting $amount into grams
            if($_POST["Units"]=="Oz")
            {
                $amount = $amount * 28.3495; 
            }
            // converting $amount into grams
            else if($_POST["Units"]=="serv_type")
            {
                $size = CS50::query("SELECT serv_size FROM food_data WHERE item_no = ?", $_POST["item_no"]);
                $amount = $amount*$size[0]["serv_size"];
            }
            // insert user's entered food into the food_log table
            CS50::query("INSERT INTO food_logs (user_id, item_no, amount) VALUES(?,?,?)", $_SESSION["id"],htmlspecialchars($_POST["item_no"]),$amount);
            render("search_form_success.php",["title" => "Successfully Added","item_no"=>$_POST["item_no"]]);
        }
        // A user submitted result
        else if(isset($_POST["Id_1"]))
        {
            // for protection
            $Id_1 = htmlspecialchars($_POST["Id_1"]);
            $Id_2 = htmlspecialchars($_POST["Id_2"]);
            $amount = htmlspecialchars($_POST["amount"]);
            // converting $amount into grams
            if($_POST["Units"]=="Oz")
            {
                $amount = $amount * 28.3495; 
            }
            // find calories per 100g
            $calories = htmlspecialchars($_POST["calories"])/100*$amount;
            $food_group = $_POST["food_group"];
            
            
            // inserting user input into food data
            CS50::query("INSERT INTO food_data (Id_1, Id_2, Calories, item_no, food_group) VALUES (?,?,?,?,?)", $Id_1, $Id_2,$calories, "N/A",$food_group);
            CS50::query("UPDATE food_data SET item_no = id WHERE item_no = ?", "N/A");
            
            // enters the food into the user's food log
            // MAX(id) is selected because that's the most recent entry which is
            // what the user just submitted 
            $data = CS50::query("SELECT MAX(id) FROM food_data");
            $item_no = $data[0]["MAX(id)"];
            CS50::query("INSERT INTO food_logs (item_no,amount,user_id) VALUES(?,?,?)",$item_no,$amount,$_SESSION["id"]);
            
            // render form
            render("add_item_success_form.php",["title" => "Successfully Added","item_no"=>$item_no]);
        }
    }
?>