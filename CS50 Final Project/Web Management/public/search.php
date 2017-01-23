<?php
    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("search_form.php", ["title" => "Search"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // search database for the user's desired food item
        $foods = CS50::query("SELECT * FROM food_data WHERE MATCH(Id_1, Id_2, Id_3, Id_4, Id_5, 
        Id_6, Id_7, Id_8, Id_9, Id_10, Id_11, Id_12, Id_13) AGAINST(?) LIMIT 20", $_POST["food_item"]);
        
         // render new page
        render("search_results.php", ["title" => "Search", "foods" => $foods]);
    }
?>