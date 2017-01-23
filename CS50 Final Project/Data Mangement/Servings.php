<?php    

    require("CS50_SQL/library50-php-5/CS50/CS50.php");
    CS50::init(__DIR__ . "/config.json");
    for ($i = 1; $i < 8790; $i++) 
	{
		$keywords = ["serving"=>true, "stick"=>true,"slice"=>true, "package"=>true,
		"wedge"=>true,"packet"=>true, "scoop"=>true,"bar"=>true, "can"=>true,
		"piece"=>true,"pieces"=>true, "leaves"=>true,"box"=>true,"breat"=>true,
		"thigh"=>true,"wing"=>true,"half"=>true];
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
		if($f = false)
		{
			printf("Could not open the file at %s.\n", $filepath);
		    return false;
		}
		$count = 1;
		while(!feof($f))
		{
			if(($data = fgetcsv($f))==true)
			{
				// Serving information always appears on the fifth line
				if($count == 5) 				
				{
					$n = sizeof($data);
					// The second to last item contains the serving keyword and the size in grams of the serving. 
					// The last item is empty (just FYI)
					$list= split(" ",$data[$n-2]); 
					$l = sizeof($list);
					if(strstr($list[$l-1],"g")==true)
					{
						$list[$l-1] = trim($list[$l-1],"g");
						// Sometimes in the data it lists 2 servings = 10g, this makes it so that it's only 1 serving. 
						$list[$l-1] = $list[$l-1] / $list[0];
						switch($list[1])
						{
							case "pieces":
								$list[1] = "piece";
								break;
							case "halves":
								$list[1] = "half";
								break;
							default:
								break;
							
						}
						$keyword = $list[1];
						$size = $list[$l-1];
					}
				}			
			}
			$count++;
		}
		fclose($f);

		if(isset($keywords[$keyword]))
		{
			CS50::query("UPDATE food_data SET serv_type = ?, serv_size = ? WHERE item_no = ?", $keyword, $size, $i);
		}
		else
		{
			CS50::query("UPDATE food_data SET serv_type = ?, serv_size = ? WHERE item_no = ?", "N/A","N/A",$i);
		}
	}
?>