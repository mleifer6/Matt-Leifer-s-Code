<?php

    // configuration
    require("../includes/config.php"); 
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $id = $_SESSION["id"];
        
        //Get the user's food
        $header = CS50::query("SELECT * FROM food_logs WHERE user_id = ?", $id);
        
        // If the user has a food history
        if(count($header)>0)
        {
            // iterate through header and get the relevant information to be displayed in a table
            $log = [];
            foreach ($header as $row)
            {
                // query database for information for particular food item
                $log_row = CS50::query("SELECT * FROM food_data WHERE item_no = ?", $row["item_no"]);

                $log_row[0]["amount"] = $row["amount"];
                $log_row[0]["time"] = $row["time"];
                $log_row[0]["amt_adjusted_calories"] = $log_row[0]["Calories"]/100*$log_row[0]["amount"];
                $log_row[0]["amt_adjusted_calories"] = round($log_row[0]["amt_adjusted_calories"],1);
                $log = array_merge($log, $log_row);
            }
            render("food_log_result.php", ["title" => "Your Food", "log"=>$log, "success"=>"1"]);
        }
        // If the user has no food, send a "success code"  of 0 to food_log.php
        else
        {
            render("food_log_result.php", ["title" => "Your Food", "success"=>"0"]);
        }
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        render("food_log_item.php");
    }
?>
