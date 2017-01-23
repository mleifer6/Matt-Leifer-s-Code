<?php

    // configuration
    require("../includes/config.php"); 
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("nutrition_history.php", ["title" => "Nutrition History", "option"=>"0"]);
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $id = $_SESSION["id"];
        // Get the start of the range
        if(empty($_POST["start_date"]))
        {
            $start = "2015-12-01 00:00:00";
        }
        else
        {
            $start = htmlspecialchars($_POST["start_date"])." 00:00:00";
        }
        if(empty($_POST["end_date"]))
        {
            $end = date("Y-m-d H:i:s");
        }
        else
        {
            $end = htmlspecialchars($_POST["end_date"])." 23:59:59";
        }
        
        //we should account for user_id, right? this will grab everyones food 
        //Get the user's food
        $results = CS50::query("SELECT * FROM food_logs WHERE ? <= time AND time <= ? AND user_id = ?", $start, $end,$id);
        
        $start = date_create($start);
        $end = date_create($end);
        // If the user has a food history
        if(count($results)>0)
        {
            // array of key value pairs that holds all the recommended daily values
            $recommended_amts = ["Total_fat"=>65, "Saturated_fat"=>20,"Water"=>"N/A","Cholesterol"=>300,
            "Sodium"=> 2400, "Potassium"=>3500,"Carbohydrates"=>300,"Fiber"=>25,"Protein"=>50,
            "Vitamin_A_IU"=>5000,"Vitamin_C"=>60,"Calcium"=>1000,"Iron"=>18,"Vitamin_D"=>400,
            "Vitamin_E"=>30,"Vitamin_K"=>80,"Thiamin"=>1.5,"Riboflavin"=>1.7,"Niacin"=>20,
            "Vitamin_B_6"=>2,"Folate"=>400,"Vitamin_B_12"=>6,"Phosphorus"=>1000,
            "Magnesium"=>400,"Zinc"=>15,"Calories"=>2000, "Sugars"=>"N/A",
            "Vitamin_A_RAE"=>"N/A","Vitamin_D2_D3"=>"N/A","Monounsaturated_fat"=>"N/A",
            "Polyunsaturated_fat"=>"N/A","Trans_fat"=>"N/A","Caffeine"=>"N/A"]; 
            // array that holds units
            // &#x3BC this is  µ
            $units = ["Calories"=>"kcal","Water"=>"g","Total_fat"=>"g", "Saturated_fat"=>"g",
            "Monounsaturated_fat"=>"g","Polyunsaturated_fat"=>"g","Trans_fat"=>"g",
            "Cholesterol"=>"mg", "Sodium"=> "mg", "Potassium"=>"mg","Carbohydrates"=>"g",
            "Sugars"=>"g","Fiber"=>"g","Protein"=>"g", "Vitamin_A_IU"=>"IU", "Vitamin_A_RAE"=>"&#x3BCg", 
            "Vitamin_B_6"=>"mg","Vitamin_B_12"=>"&#x3BCg","Vitamin_C"=>"mg",
            "Vitamin_D"=>"IU","Vitamin_D2_D3"=>"&#x3BCg","Vitamin_E"=>"IU", "Vitamin_K"=>"&#x3BCg",
            "Calcium"=>"mg","Folate"=>"&#x3BCg","Iron"=>"mg", "Magnesium"=>"mg","Niacin"=>"mg",
            "Phosphorus"=>"mg", "Riboflavin"=>"mg","Thiamin"=>"mg","Zinc"=>"mg", 
            "Caffeine"=>"mg"]; 

            // find number of days between the dates entered
            $interval = date_diff($start, $end);
            $day = $interval->days;
            if($day <= 0)
            {
                $day = 1;
            }
            $log = [];
            $nutrition=[];
            $nutrition_daily=[];
            $calories = 0;
            $water = 0;
            $protein = 0;
            $total_fat = 0;
            $carbohydrates = 0;
            $fiber = 0;
            $sugars = 0;
            $calcium = 0;
            $iron = 0;
            $magnesium = 0;
            $phosphorus = 0;
            $potassium = 0;
            $sodium = 0;
            $zinc = 0;
            $vitamin_C = 0;
            $thiamin = 0;
            $riboflavin = 0;
            $niacin = 0;
            $vitamin_B_6 = 0;
            $folate = 0;
            $vitamin_B_12 = 0;
            $vitamin_A_RAE = 0;
            $vitamin_A_IU = 0;
            $vitamin_E = 0;
            $vitamin_D2_D3 = 0;
            $vitamin_D = 0;
            $vitamin_K = 0;
            $saturated_fat = 0;
            $monounsaturated_fat = 0;
            $polyunsaturated_fat = 0;
            $trans_fat = 0;
            $cholesterol = 0;
            $caffeine = 0;
            foreach ($results as $row)
            {
                $log_row = CS50::query("SELECT * FROM food_data WHERE item_no = ?", $row["item_no"]);
                $log_row[0]["amount"] = $row["amount"];
                $log_row[0]["time"] = $row["time"];
                // Gather totals for nutrition info
                if($log_row[0]["Calories"]>0)
                {
                    $calories += $log_row[0]["Calories"]/100*$log_row[0]["amount"];
                    $nutrition["Calories"] = $calories;
                    $nutrition_daily["Calories"] = $calories/$day;
                }
                if($log_row[0]["Total_fat"]>0)
                {
                    $total_fat += $log_row[0]["Total_fat"]/100*$log_row[0]["amount"];
                    $nutrition["Total_fat"] = $total_fat;
                    $nutrition_daily["Total_fat"] = $total_fat/$day;
                }
                if($log_row[0]["Saturated_fat"]>0)
                {
                    $saturated_fat += $log_row[0]["Saturated_fat"]/100*$log_row[0]["amount"];
                    $nutrition["Saturated_fat"] = $saturated_fat;
                    $nutrition_daily["Saturated_fat"] = $saturated_fat/$day;
                }
                if($log_row[0]["Monounsaturated_fat"]>0)
                {
                    $monounsaturated_fat += $log_row[0]["Monounsaturated_fat"]/100*$log_row[0]["amount"];
                    $nutrition["Monounsaturated_fat"] = $monounsaturated_fat;
                    $nutrition_daily["Monounsaturated_fat"] = $monounsaturated_fat/$day;
                }
                if($log_row[0]["Polyunsaturated_fat"]>0)
                {
                    $polyunsaturated_fat += $log_row[0]["Polyunsaturated_fat"]/100*$log_row[0]["amount"];
                    $nutrition["Polyunsaturated_fat"] = $polyunsaturated_fat;
                    $nutrition_daily["Polyunsaturated_fat"] = $polyunsaturated_fat/$day;
                }
                if($log_row[0]["Trans_fat"]>0)
                {
                    $trans_fat += $log_row[0]["Trans_fat"]/100*$log_row[0]["amount"];
                    $nutrition["Trans_fat"] = $trans_fat;
                    $nutrition_daily["Trans_fat"] = $trans_fat/$day;
                }
                if($log_row[0]["Water"]>0)
                {
                    $water += $log_row[0]["Water"]/100*$log_row[0]["amount"];
                    $nutrition["Water"] = $water;
                    $nutrition_daily["Water"] = $water/$day;
                }
                if($log_row[0]["Cholesterol"]>0)
                {
                    $cholesterol += $log_row[0]["Cholesterol"]/100*$log_row[0]["amount"];
                    $nutrition["Cholesterol"] = $cholesterol;
                    $nutrition_daily["Cholesterol"] = $cholesterol/$day;
                }
                if($log_row[0]["Sodium"]>0)
                {
                    $sodium += $log_row[0]["Sodium"]/100*$log_row[0]["amount"];
                    $nutrition["Sodium"] = $sodium;
                    $nutrition_daily["Sodium"] = $sodium/$day;
                }
                if($log_row[0]["Potassium"]>0)
                {
                    $potassium += $log_row[0]["Potassium"]/100*$log_row[0]["amount"];
                    $nutrition["Potassium"] = $potassium;
                    $nutrition_daily["Potassium"] = $potassium/$day;
                }
                if($log_row[0]["Carbohydrates"]>0)
                {
                    $carbohydrates += $log_row[0]["Carbohydrates"]/100*$log_row[0]["amount"];
                    $nutrition["Carbohydrates"] = $carbohydrates;
                    $nutrition_daily["Carbohydrates"] = $carbohydrates/$day;
                }
                if($log_row[0]["Sugars"]>0)
                {
                    $sugars += $log_row[0]["Sugars"]/100*$log_row[0]["amount"];
                    $nutrition["Sugars"] = $sugars;
                    $nutrition_daily["Sugars"] = $sugars/$day;
                }
                if($log_row[0]["Fiber"]>0)
                {
                    $fiber += $log_row[0]["Fiber"]/100*$log_row[0]["amount"];
                    $nutrition["Fiber"] = $fiber;
                    $nutrition_daily["Fiber"] = $fiber/$day;
                }
                if($log_row[0]["Protein"]>0)
                {
                    $protein += $log_row[0]["Protein"]/100*$log_row[0]["amount"];
                    $nutrition["Protein"] = $protein;
                    $nutrition_daily["Protein"] = $protein/$day;
                }
                if($log_row[0]["Vitamin_A_IU"]>0)
                {
                    $vitamin_A_IU += $log_row[0]["Vitamin_A_IU"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_A_IU"] = $vitamin_A_IU;
                    $nutrition_daily["Vitamin_A_IU"] = $vitamin_A_IU/$day;
                }
                if($log_row[0]["Vitamin_A_RAE"]>0)
                {
                    $vitamin_A_RAE += $log_row[0]["Vitamin_A_RAE"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_A_RAE"] = $vitamin_A_RAE;
                    $nutrition_daily["Vitamin_A_RAE"] = $vitamin_A_RAE/$day;
                }
                if($log_row[0]["Vitamin_B_6"]>0)
                {
                    $vitamin_B_6 += $log_row[0]["Vitamin_B_6"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_B_6"] = $vitamin_B_6;
                    $nutrition_daily["Vitamin_B_6"] = $vitamin_B_6/$day;
                }
                if($log_row[0]["Vitamin_B_12"]>0)
                {
                    $vitamin_B_12 += $log_row[0]["Vitamin_B_12"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_B_12"] = $vitamin_B_12;
                    $nutrition_daily["Vitamin_B_12"] = $vitamin_B_12/$day;
                }
                if($log_row[0]["Vitamin_C"]>0)
                {
                    $vitamin_C += $log_row[0]["Vitamin_C"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_C"] = $vitamin_C;
                    $nutrition_daily["Vitamin_C"] = $vitamin_C/$day;
                }
                if($log_row[0]["Vitamin_D"]>0)
                {
                    $vitamin_D += $log_row[0]["Vitamin_D"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_D"] = $vitamin_D;
                    $nutrition_daily["Vitamin_D"] = $vitamin_D/$day;
                }
                if($log_row[0]["Vitamin_D2_D3"]>0)
                {
                    $vitamin_D2_D3 += $log_row[0]["Vitamin_D2_D3"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_D2_D3"] = $vitamin_D2_D3;
                    $nutrition_daily["Vitamin_D2_D3"] = $vitamin_D2_D3/$day;
                }
                if($log_row[0]["Vitamin_E"]>0)
                {
                    $vitamin_E += $log_row[0]["Vitamin_E"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_E"] = $vitamin_E;
                    $nutrition_daily["Vitamin_E"] = $vitamin_E/$day;
                }
                if($log_row[0]["Vitamin_K"]>0)
                {
                    $vitamin_K += $log_row[0]["Vitamin_K"]/100*$log_row[0]["amount"];
                    $nutrition["Vitamin_K"] = $vitamin_K;
                    $nutrition_daily["Vitamin_K"] = $vitamin_K/$day;
                }
                if($log_row[0]["Calcium"]>0)
                {
                    $calcium += $log_row[0]["Calcium"]/100*$log_row[0]["amount"];
                    $nutrition["Calcium"] = $calcium;
                    $nutrition_daily["Calcium"] = $calcium/$day;
                }
                if($log_row[0]["Folate"]>0)
                {
                    $folate += $log_row[0]["Folate"]/100*$log_row[0]["amount"];
                    $nutrition["Folate"] = $folate;
                    $nutrition_daily["Folate"] = $folate/$day;
                }
                if($log_row[0]["Iron"]>0)
                {
                    $iron += $log_row[0]["Iron"]/100*$log_row[0]["amount"];
                    $nutrition["Iron"] = $iron;
                    $nutrition_daily["Iron"] = $iron/$day;
                }
                if($log_row[0]["Magnesium"]>0)
                {
                    $magnesium += $log_row[0]["Magnesium"]/100*$log_row[0]["amount"];
                    $nutrition["Magnesium"] = $magnesium;
                    $nutrition_daily["Magnesium"] = $magnesium/$day;
                }
                if($log_row[0]["Niacin"]>0)
                {
                    $niacin += $log_row[0]["Niacin"]/100*$log_row[0]["amount"];
                    $nutrition["Niacin"] = $niacin;
                    $nutrition_daily["Niacin"] = $niacin/$day;
                }
                if($log_row[0]["Phosphorus"]>0)
                {
                    $phosphorus += $log_row[0]["Phosphorus"]/100*$log_row[0]["amount"];
                    $nutrition["Phosphorus"] = $phosphorus;
                    $nutrition_daily["Phosphorus"] = $phosphorus/$day;
                }
                if($log_row[0]["Riboflavin"]>0)
                {
                    $riboflavin += $log_row[0]["Riboflavin"]/100*$log_row[0]["amount"];
                    $nutrition["Riboflavin"] = $riboflavin;
                    $nutrition_daily["Riboflavin"] = $riboflavin/$day;
                }
                if($log_row[0]["Thiamin"]>0)
                {
                    $thiamin += $log_row[0]["Thiamin"]/100*$log_row[0]["amount"];
                    $nutrition["Thiamin"] = $thiamin;
                    $nutrition_daily["Thiamin"] = $thiamin/$day;
                }
                if($log_row[0]["Zinc"]>0)
                {
                    $zinc += $log_row[0]["Zinc"]/100*$log_row[0]["amount"];
                    $nutrition["Zinc"] = $zinc;
                    $nutrition_daily["Zinc"] = $zinc/$day;
                }
                if($log_row[0]["Caffeine"]>0)
                {
                    $caffeine += $log_row[0]["Caffeine"]/100*$log_row[0]["amount"];
                    $nutrition["Caffeine"] = $caffeine;
                    $nutrition_daily["Caffeine"] = $caffeine/$day;
                }
                
                $log = array_merge($log, $log_row);
            }
            render("nutrition_history.php", ["title" => "Food History", "log"=>$log,
            "nutrition"=>$nutrition, "nutrition_daily"=>$nutrition_daily, "units"=>$units,
            "recommended_amts"=>$recommended_amts, "option"=>"1","start"=>$start->format('Y-m-d'),"end"=>$end->format('Y-m-d')]);
        }
        // If the user has no food, send a "success code"  of -1 to food_log.php
        else
        {
            render("nutrition_history.php", ["title" => "Food History", "option"=>"-1"]);
        }
    }
?>
