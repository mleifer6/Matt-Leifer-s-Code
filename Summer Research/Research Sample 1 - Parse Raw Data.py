import numpy as np 
import csv
import sys
import json
import Local_Guides_Analysis as LGA

# Generate a hash table for all the questions and their types (subjective vs
# factual)
def question_types():
	type_dict = {}
	with open("Data/questions.csv",'rU') as csvfile:
		for row in csv.reader(csvfile):
			type_dict[row[0]] = row[1]
	return type_dict

"""
The matrices will have the format:

[ yy yn yu ]
[ ny nn nu ]
[ uy un uu ]

"""

# Takes a row that gives the number of responses for a given response pair e.g.
# (y,y) and converts that into a joint probability distribution. 
# Returns None if there are no responses (a row of zeros) or if the row is all commas
def row_to_joint(row, row_number, debug):
	responses = row[3:]
	# Cast the responses to ints
	for index,value in enumerate(responses):
		try:
			responses[index] = int(value)
		except ValueError:
			if debug:
				print "Error at row", row_number # Reached when the row is empty (string of commas)
			return None
	n = 3
	joint = np.zeros((n,n))
	count = 0
	
	for j in range(n):
		for i in range(n):
			if i < j:
				joint[i,j] = joint[j,i]
			else:
				joint[i,j] = responses[count]
				count += 1
	if np.sum(joint) == 0:
		return None
	else:
		return joint / np.sum(joint)

def insert(dictionary, keys, values):
	if len(keys) != 3:
		raise ValueError
	place, category, question = keys["place"], keys["category"], keys["question"]
	if place not in dictionary:
		dictionary[place] = {}
	if category not in dictionary[place]:
		dictionary[place][category] = {}
	if question not in dictionary[place][category]:
		dictionary[place][category][question] = values
	else:
		raise KeyError("Duplicate set of keys occured. Yikes")


"""

(0,1,2) -> (place_hash, category_hash, question_hash)
(1,0,2) -> (category_hash, place_hash, question_hash)
In the dictionary, the layers of the dictionary will be country, category, 
question if the ordering is (0,1,2). 

"""

def build_joint_dict(filename, n, ordering = (0,1,2), debug = False):
	organized = {}
	count = 1
	err_count = 0
	with open("Data/" + filename,'rU') as csvfile:
		for row in csv.reader(csvfile):
			# Skip header row
			if count == 1:
				count += 1
				continue
			else:
				joint = row_to_joint(row, count, debug)
				if joint == None:
					err_count += 1
					continue
				if n == 2:
					# Returns none of the sum of the 2x2 joint is 0
					if LGA.reduce_to2(joint) != None:
						joint = LGA.reduce_to2(joint)
					else:
						continue
				# Put each row into the dictionary
				#if ordering == (0,1,2):
				i,j,k = ordering
				keys = {"place" : row[i], "category" : row[j], "question" : row[k]}
				insert(organized, keys, joint)
			count += 1
	print "Error Count = ", err_count
	print "Joints Calculated\n"
	csvfile.close()
	return organized

def get_delta_categorical(filename, n):
	# Load the Data 
	print "Categorical by question type " + filename + " " + str(n) + "x" + str(n)
	joint_dict = build_joint_dict(filename, n)
	type_dict = question_types()

	# Count initialization
	questions_without_types = []
	count = 1
	size = LGA.dict_size(joint_dict)
	results = {}

	# Calculate the Delta matrix
	for place in joint_dict:
		for category in joint_dict[place]:
			questions = joint_dict[place][category]
			if len(questions) > 2:
				for q in questions:
					delta = LGA.default_delta(q, questions)
					sys.stdout.write("\033[F")
					print  count, "of", size
					if q in type_dict:
						data = {
							"joint" : LGA.to_list(questions[q]),
							"delta" : LGA.to_list(delta), 
							"categorical" : str(LGA.is_categorical(delta)),
							"q_type" : type_dict[q] 
						}
						keys = {
							"place" : place,
							"category" : category,
							"question" : q
						}
						insert(results, keys, data)

					elif q not in questions_without_types:
						print q + "\n"
						questions_without_types.append(q)
					count += 1
			else:
				print "Too few questions"
				print questions

	# Write the results to the file
	with open(filename[0:(len(filename) - 4)] + " delta & categorical " + str(n) + "x" + str(n)+ ".json", 'w') as f:
		f.write(json.dumps(results))
	return results
#print len(get_delta_categorical("pairwise_v2.csv", sys.argv[1]))


# Get some basic summary statistics
type_dict = question_types()
count = 1
sub_yu, sub_nu, sub_uu = 0,0,0
fac_yu, fac_nu, fac_uu = 0,0,0
sub_count = 0
fac_count = 0
with open("Data/state_votes.csv",'rU') as csvfile:
	for row in csv.reader(csvfile):

		if count == 1:
			count += 1
			continue
		else:
			if row[2] in type_dict and (row[5] != "" or row[7] != "" or row[8] != ""):
				q_type = type_dict[row[2]]
				yu = int(row[5])
				nu = int(row[7])
				uu = int(row[8])
				if q_type == "S":
					sub_yu += yu
					sub_nu += nu
					sub_uu += uu
					sub_count += 1
				else:
					fac_yu += yu
					fac_nu += nu
					fac_uu += uu
					fac_count += 1
print sub_count, sub_yu, sub_nu, sub_uu
print fac_count, fac_yu, fac_nu, fac_uu

