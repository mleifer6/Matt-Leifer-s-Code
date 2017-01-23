<?php    

    require("CS50_SQL/library50-php-5/CS50/CS50.php");
    CS50::init(__DIR__ . "/config.json");
    for ($i = 1; $i < 8790; $i++) 
	{
		$nutrition_info = ["Niacin"=> -9, "Iron, Fe"=> -9, "Cholesterol"=> -9, "Thiamin"=> -9, "Vitamin B-6"=> -9, "Carbohydrate, by difference"=> -9, "Sugars, total"=> -9, "Calcium, Ca"=> -9, "Water"=> -9, "Vitamin C, total ascorbic acid"=> -9, "Fatty acids, total monounsaturated"=> -9, "Sodium, Na"=> -9, "Phosphorus, P"=> -9, "Vitamin A, IU"=> -9, "Vitamin A, RAE"=> -9, "Potassium, K"=> -9, "Vitamin E (alpha-tocopherol)"=> -9, "Caffeine"=> -9, "Riboflavin"=> -9, "Magnesium, Mg"=> -9, "Vitamin D"=> -9, "Fiber, total dietary"=> -9, "Fatty acids, total saturated"=> -9, "Energy"=> -9, "Vitamin K (phylloquinone)"=> -9, "Fatty acids, total trans"=> -9, "Total lipid (fat)"=> -9, "Fatty acids, total polyunsaturated"=> -9, "Vitamin B-12"=> -9, "Zinc, Zn"=> -9, "Vitamin D (D2 + D3)"=> -9, "Protein"=> -9, "Folate, DFE"=> -9];
		$i=str_pad($i, 4, '0', STR_PAD_LEFT);
		$filepath = "Food_Data/food_item_".$i.".csv";
		if (!file_exists($filepath))
		{
			printf("The file does not exist at this location: %s\n", $filepath);
		    return false;
		}
		if (!is_readable($filepath))
		{
		    printf("The file, %s, is not readable.\n", $filepath);
		    return false;
		}
		$f = fopen($filepath, "r");
		if($f != false)
		{
			while(!feof($f))
			{
				if(($data = fgetcsv($f))==true)
				{
					if(isset($nutrition_info[$data[0]]))
					{
						$nutrition_info[$data[0]] = $data[2];
					}
				}
			} 
			fclose($f);
		CS50::query("INSERT INTO food_data (item_no, Water, Calories, Protein, Total_fat, Carbohydrates, Fiber, Sugars, Calcium, Iron, Magnesium, Phosphorus, Potassium, Sodium, Zinc, Vitamin_C, Thiamin, Riboflavin, Niacin, Vitamin_B_6, Folate, Vitamin_B_12, Vitamin_A_RAE, Vitamin_A_IU, Vitamin_E, Vitamin_D2_D3, Vitamin_D, Vitamin_K, Saturated_fat, Monounsaturated_fat, Polyunsaturated_fat, Trans_fat, Cholesterol, Caffeine) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $i,$nutrition_info["Water"],$nutrition_info["Energy"],$nutrition_info["Protein"],$nutrition_info["Total lipid (fat)"],$nutrition_info["Carbohydrate, by difference"],$nutrition_info["Fiber, total dietary"],$nutrition_info["Sugars, total"],$nutrition_info["Calcium, Ca"],$nutrition_info["Iron, Fe"],$nutrition_info["Magnesium, Mg"],$nutrition_info["Phosphorus, P"],$nutrition_info["Potassium, K"],$nutrition_info["Sodium, Na"],$nutrition_info["Zinc, Zn"],$nutrition_info["Vitamin C, total ascorbic acid"],$nutrition_info["Thiamin"],$nutrition_info["Riboflavin"],$nutrition_info["Niacin"],$nutrition_info["Vitamin B-6"],$nutrition_info["Folate, DFE"], $nutrition_info["Vitamin B-12"], $nutrition_info["Vitamin A, RAE"], $nutrition_info["Vitamin A, IU"],$nutrition_info["Vitamin E (alpha-tocopherol)"], $nutrition_info["Vitamin D (D2 + D3)"],$nutrition_info["Vitamin D"],$nutrition_info["Vitamin K (phylloquinone)"],$nutrition_info["Fatty acids, total saturated"],$nutrition_info["Fatty acids, total monounsaturated"],$nutrition_info["Fatty acids, total polyunsaturated"], $nutrition_info["Fatty acids, total trans"],$nutrition_info["Cholesterol"],$nutrition_info["Caffeine"]);
		}
		else
		{
			printf("Could not open %s.\n", $filepath);
		    return false;
		}
	}
?>