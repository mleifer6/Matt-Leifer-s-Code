import csv
file = 0
max_line = 0
for i in range(1,8790):
	filename = "Food_Data/food_item_" + str(i).zfill(4) +".csv"
	f = open(filename, 'r')
	with f as csvfile:
		line = csv.reader(csvfile, delimiter=',')
		line = list(line)
		#if len(line)>=max_line:
		if len(line)>43:
			#max_line = len(line)
			#file = i
			print i,#file, max_line
	f.close()

#print file, max_line


