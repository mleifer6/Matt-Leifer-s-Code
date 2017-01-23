read_this= "Problem_81_Data.txt"
file_in = open(read_this, 'r')  #open is a function
all_lines= file_in.readlines()  # .readlines is a 'method.' Like a function but comes at the end.  
file_in.close() #important to close the file
with open(read_this, 'r') as file_in:
	lines = file_in.readlines()
	file_in.close()

values=[]
for a in range(0,len(lines)):
	lines[a].split(",") #makes each line an entry
	lines[a].strip('\n') #removes \n
	values.append(lines[a].strip('\n'))
for a in range(0,len(values)):
	values[a]=values[a].split(",") #makes each entry in each line its own string
for a in range(0,len(values)):
	for b in range(0,len(values[a])):
		values[a][b]=int(values[a][b]) #turns them from strings into integers

#import sys
#for i in values:
#	for j in i:
#		sys.stdout.write("%3d " % j)
#		print("%3d " % j, end ="")
#	print ""

# MINIMAL Path Sum
N = len(values) - 1
row = N
col = N
while 0 <= row:
	while 0 < col:
		i = row
		if col == 0:
			j = 0
		else:
			j = col - 1

		while j <= row:
			down = None
			right = None
			if i < N:
				down = values[i + 1][j] 
			if j < N:
				right = values[i][j + 1]

			if (down < right and down != None) or right == None:
				values[i][j] += down
			else:
				values[i][j] += right
			#print i,j
			i -= 1
			j += 1
		col -= 1
	col = 1
	row -= 1

print values[0][0]
#print ""
#for i in values:
#	for j in i:
#		sys.stdout.write("%3d " % j)
#		print("%3d " % j, end ="")
#	print ""

