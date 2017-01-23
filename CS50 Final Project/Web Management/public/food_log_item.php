<?php

    // configuration
    require("../includes/config.php"); 
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["q"]) )
    {
        $item_no = htmlspecialchars($_GET["q"]);
        // get all the information for a given item
        $data = CS50::query("SELECT * FROM food_data WHERE item_no = ?",$item_no);
        
        // assign each value a unit
        $units = ["Calories"=>"kcal","Water"=>"g","Total_fat"=>"g", "Saturated_fat"=>"g",
            "Monounsaturated_fat"=>"g","Polyunsaturated_fat"=>"g","Trans_fat"=>"g",
            "Cholesterol"=>"mg", "Sodium"=> "mg", "Potassium"=>"mg","Carbohydrates"=>"g",
            "Sugars"=>"g","Fiber"=>"g","Protein"=>"g", "Vitamin_A_IU"=>"IU", "Vitamin_A_RAE"=>"&#x3BCg", 
            "Vitamin_B_6"=>"mg","Vitamin_B_12"=>"&#x3BCg","Vitamin_C"=>"mg",
            "Vitamin_D"=>"IU","Vitamin_D2_D3"=>"&#x3BCg","Vitamin_E"=>"IU", "Vitamin_K"=>"&#x3BCg",
            "Calcium"=>"mg","Folate"=>"&#x3BCg","Iron"=>"mg", "Magnesium"=>"mg","Niacin"=>"mg",
            "Phosphorus"=>"mg", "Riboflavin"=>"mg","Thiamin"=>"mg","Zinc"=>"mg", 
            "Caffeine"=>"mg"];
        // assign each value its recommended daily intake to be used to calculate Percent of Daily Value
        $recommended_amts = ["Total_fat"=>65, "Saturated_fat"=>20,"Cholesterol"=>300,
            "Sodium"=> 2400, "Potassium"=>3500,"Carbohydrates"=>300,"Fiber"=>25,"Protein"=>50,
            "Vitamin_A_IU"=>5000,"Vitamin_C"=>60,"Calcium"=>1000,"Iron"=>18,"Vitamin_D"=>400,
            "Vitamin_E"=>30,"Vitamin_K"=>80,"Thiamin"=>1.5,"Riboflavin"=>1.7,"Niacin"=>20,
            "Vitamin_B_6"=>2,"Folate"=>400,"Vitamin_B_12"=>6,"Phosphorus"=>1000,
            "Magnesium"=>400,"Zinc"=>15,"Calories"=>2000, "Water"=>"N/A","Sugars"=>"N/A",
            "Vitamin_A_RAE"=>"N/A","Vitamin_D2_D3"=>"N/A","Monounsaturated_fat"=>"N/A",
            "Polyunsaturated_fat"=>"N/A","Trans_fat"=>"N/A","Caffeine"=>"N/A"]; 
        
        // render the pop-up window and pass in the relevant information, some of it capitalized for aesthetics    
        render_pop_up("food_log_item_result.php", ["title" => ucwords($data[0]["Id_1"].":".$data[0]["Id_2"]), "data"=>$data[0], "units"=>$units,"recommended_amts"=>$recommended_amts]);
    }
    else
    {
        redirect("/");
    }
?>