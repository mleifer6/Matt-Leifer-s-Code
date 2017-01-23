import csv

for i in range(1,3):
	nutrition_info = {"Niacin": -9, "Iron, Fe": -9, "Cholesterol": -9, "Thiamin": -9, "Vitamin B-6": -9, "Carbohydrate, by difference": -9, "Sugars, total": -9, "Calcium, Ca": -9, "Water": -9, "Vitamin C, total ascorbic acid": -9, "Fatty acids, total monounsaturated": -9, "Sodium, Na": -9, "Phosphorus, P": -9, "Vitamin A, IU": -9, "Vitamin A, RAE": -9, "Potassium, K": -9, "Vitamin E (alpha-tocopherol)": -9, "Caffeine": -9, "Riboflavin": -9, "Magnesium, Mg": -9, "Vitamin D": -9, "Fiber, total dietary": -9, "Fatty acids, total saturated": -9, "Energy": -9, "Vitamin K (phylloquinone)": -9, "Fatty acids, total trans": -9, "Total lipid (fat)": -9, "Fatty acids, total polyunsaturated": -9, "Vitamin B-12": -9, "Zinc, Zn": -9, "Vitamin D (D2 + D3)": -9, "Protein": -9, "Folate, DFE": -9}
	
	filename = "Food_Data/food_item_" + str(i).zfill(4) +".csv"
	f = open(filename, 'r')
	with f as csvfile:
		line = csv.reader(csvfile, delimiter=',')
		line = list(line)
		# Nutrition data doesn't start until the sixth line. 
		k=5
		nutrition_dict = {}
		while(k<len(line)):
			if(len(line[k])>2): #or nutrition_info.has_key(nutrition_info[line[k][0]])):
				nutrition_info[line[k][0]] = line[k][2]
			k+=1
		print nutrition_info
	f.close()