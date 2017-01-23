<?php    

    require("CS50_SQL/library50-php-5/CS50/CS50.php");
    CS50::init(__DIR__ . "/config.json");
    for ($i = 1; $i < 8790; $i++) 
	{
		$ids = ["N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A","N/A"];
		$j=str_pad($i, 4, '0', STR_PAD_LEFT);
		$filepath = "Food_Data/food_item_".$j.".csv";
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
		if($f = false)
		{
			printf("Could not open the file at %s.\n", $filepath);
		    return false;
		}
		while(!feof($f))
		{
			if(($data = fgetcsv($f))==true)
			{
				if(strstr($data[0],"Nutrient data for:")==true)
				{
					$list= split(",",$data[0]); 
					for($k = 1; $k < sizeof($list); $k++)
					{
						$ids[$k-1] = $list[$k];
					}
					break;
				}
								
			}
		}
		fclose($f);
		CS50::query("UPDATE food_data SET Id_1=?,Id_2=?,Id_3=?,Id_4=?,Id_5=?,Id_6=?,Id_7=?,Id_8=?,Id_9=?,Id_10=?,Id_11=?,Id_12=?, Id_13=? WHERE item_no =?", $ids[0],$ids[1],$ids[2],$ids[3],$ids[4],$ids[5],$ids[6],$ids[7],$ids[8],$ids[9],$ids[10],$ids[11],$ids[12],$j);
	}
?>