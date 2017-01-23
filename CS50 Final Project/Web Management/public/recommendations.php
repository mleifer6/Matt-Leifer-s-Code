<?php
    // configuration
    require("../includes/config.php");

    // Get the food the user has logged 
    $id = $_SESSION["id"];
    $query = CS50::query("SELECT item_no FROM food_logs WHERE user_id = ?", $id);
    
    // This array stores how many times they've eaten from a particular food group
    $food_group_results = ["Dairy"=>0, "Meat"=>0,"Oils"=>0,"Dessert"=>0,"Fruit"=>0,
    "Vegetable"=>0,"Nuts"=>0,"Fast Food"=>0,"Alcoholic beverage"=>0,"Beverages"=>0,"Grain"=>0];
    
    // Count the number of times a food group appears
    foreach($query as $key=>$value)
    {
        $result = CS50::query("SELECT food_group FROM food_data WHERE item_no = ?", $value["item_no"]);
        foreach($result as $key=>$value)
        {
            if(isset($food_group_results[$value["food_group"]]))
            {
                $food_group_results[$value["food_group"]] +=1;
            }
        }
    }
    // Find the most and second most consumed food groups
    $most = 0;
    $type1 = "";
    $second = 0;
    $type2 = "";
    
    $success1 = 1;
    $success2 = 1;
    foreach($food_group_results as $key=>$value)
    {
        if($value > $most)
        {
            $most = $value;
            $type1 = $key;
        }
        if($second < $value && $value < $most)
        {
            $second = $value;
            $type2 = $key;
        }
    }

    // Get the full nutrition data for the entries in the most consumed group 
    if ($type1 != "Fast Food" && $type1 != "Alcoholic beverage" && $type1 !="")
    {
        $suggestion1 = CS50::query("SELECT * FROM food_data WHERE food_group = ? ORDER BY rand() LIMIT 3", $type1);
    }
    else if ($type1 == "Fast Food")
    {
        $suggestion1 = CS50::query("SELECT * FROM food_data WHERE food_group = ? OR food_group = ?
        ORDER BY rand() LIMIT 3","Fruit","Vegetable");
    }
    else if($type1 == "Alcoholic beverage")
    {
        $suggestion1 = CS50::query("SELECT * FROM food_data WHERE food_group = ?
        ORDER BY rand() LIMIT 3","Beverages");
    }
    // If there is no favorite group
    else
    {
        $suggestion1 = CS50::query("SELECT * FROM food_data WHERE food_group = ? OR food_group = ?
        ORDER BY rand() LIMIT 3","Fruit", "Vegetable");
        $type1 = "Fruit";
        $success1 = 0;
    }
    
    
    // Get the full nutrition data for the entries in the second most consumed group 
    if ($type2 != "Fast Food" && $type2 != "Alcoholic beverage" && $type2 != "")
    {
        $suggestion2 = CS50::query("SELECT * FROM food_data WHERE food_group = ? ORDER BY rand() LIMIT 3", $type2);
    }
    else if ($type2 == "Fast Food")
    {
        $suggestion2 = CS50::query("SELECT * FROM food_data WHERE food_group = ? OR food_group = ?
        ORDER BY rand() LIMIT 3","Fruit","Vegetable");
    }
    else if($type2 == "Alcoholic beverage")
    {
        $suggestion2 = CS50::query("SELECT * FROM food_data WHERE food_group = ?
        ORDER BY rand() LIMIT 3","Beverages");
    }
    // If there is no second favorite group
    else
    {
        $suggestion2 = CS50::query("SELECT * FROM food_data WHERE food_group = ?
        ORDER BY rand() LIMIT 3","Vegetable");
        $type2 = "Vegetable";
        $success2 = 0;
    }
    render("recommendations_view.php", ["title" => "Recommendations","suggestion1"=>$suggestion1,
        "suggestion2"=>$suggestion2, "type1"=>$type1,"type2"=>$type2, "success1"=>$success1,"success2"=>$success2]);
?>