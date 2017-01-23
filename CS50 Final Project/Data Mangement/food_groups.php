<?php    

    require("CS50_SQL/library50-php-5/CS50/CS50.php");
    CS50::init(__DIR__ . "/config.json");
    for ($i = 0; $i < 8790; $i++) 
	{
	    $i=str_pad($i, 4, '0', STR_PAD_LEFT);
	    
		// Dairy
		if($i<251)
		{
			//print "Dairy";
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Dairy", $i);
		}
		// Meat
		// 823-1204, 1626-1774,2479-2814,3743-4122,4483-4741,5099-5562,7112-7698,8380-8418 
		else if((823<=$i && $i<=1204)||(1626<=$i && $i<=1774)||(2479<=$i && $i<=2814)||(3743<=$i && $i<=4122)||(4483<=$i && $i<=4741)||(5099<=$i && $i<=5562)||(7112<=$i && $i<=7698)||(8380<=$i && $i<=8418))
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Meat", $i);
		}
		// Oils
		// 654-754, 761-798, 800-815,
		else if((654<=$i && $i<=754)||(761<=$i && $i<=798)||(800<=$i && $i<=815))
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Oils", $i);
		}
		// Grains 
		// 1775-2119, 5563-5627, 5721-5743, 5762-5773, 5847-5853,6473-6648
		else if((1775<=$i && $i<=2119)||(5563<=$i && $i<=5627)||(5721<=$i && $i<=5743)||(5762<=$i && $i<=5773)||(5847<=$i && $i<=5853)||(6473<=$i && $i<=6648))
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Grain", $i);
		}
		// Dessert
		// 5628-5720, 5744-5761,5773-5846,6101-6352,6420-6472
		else if((5628<=$i && $i<=5720)||(5744<=$i && $i<=5761)||(5773<=$i && $i<=5846)||(6101<=$i && $i<=6352)||(6420<=$i && $i<=6472))
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Dessert", $i);
		}
		// Fruit
		// 2120-2478
		else if(2120<=$i && $i<=2478)
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Fruit", $i);
		}
		// Vegetable
		// 2815-3605, 4742-4824
		else if((2815<=$i && $i<=3605)||(4742<=$i && $i<=4824))
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Vegetable", $i);
		}
		// Nuts
		// 3632-3692, 3702-3742
		else if((3632<=$i && $i<=3692)||(3702<=$i && $i<=3742))
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Nuts", $i);
		}
		// Fast Food
		// 6649-7005, 8452-8545
		else if((6649<=$i && $i<=7005)||(8452<=$i && $i<=8545))
		{
			CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Fast Food", $i);
		}
		// Special Cases
		else
		{
			$item = CS50::query("SELECT * FROM food_data WHERE item_no  = ?",$i);
			if(stristr($item[0]["Id_1"],"Alcoholic beverage"))
			{
				CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Alcoholic beverage", $i);
			}
			else if(stristr($item[0]["Id_1"],"Beverage"))
			{
				CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Beverages", $i);
			}
			else if(stristr($item[0]["Id_1"],"KELLOGG"))
			{
				CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Grain", $i);
			}
			else if(stristr($item[0]["Id_1"],"Bread"))
			{
				CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Grain", $i);
			}
			else if(stristr($item[0]["Id_1"],"Cracker"))
			{
				CS50::query("UPDATE food_data SET food_group = ? WHERE item_no = ?", "Grain", $i);
			}
			else 
			{
				CS50::query("UPDATE food_data SET food_group = ? WHERE id = ?", "N/A",$i);
			}
		}
		print $i." ";
	}
    
?>