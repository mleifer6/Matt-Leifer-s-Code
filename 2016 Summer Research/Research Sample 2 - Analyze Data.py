import json
import sys
import re
import numpy as np
import matplotlib.pyplot as plt
import Local_Guides_Analysis as LGA
import Expected_Scores as ES

def data_from_json(filename, size):
	size = str(size) + "x" + str(size)
	with open("Processed_JSON/" + filename + " delta & categorical " + size + ".json") as f:
		data = json.load(f)
	for place in data:
		for category in data[place]:
			for question in data[place][category]:
				data[place][category][question]["joint"] = np.asarray(data[place][category][question]["joint"])
				data[place][category][question]["delta"] = np.asarray(data[place][category][question]["delta"])
	return data

# Currently 51 states and 4 categories per state, so 204 averages expected
def get_averages(processed):
	averages = {state : {} for state in processed}

	def average(questions, matrix_type):
		res = np.zeros((DIMENSION,DIMENSION))
		for q in questions:
			res += questions[q][matrix_type]
		return res / len(questions)

	for state in processed:
		for category in processed[state]:
			questions = processed[state][category]
			average_joint = average(questions, "joint")
			average_delta = average(questions, "delta")
			averages[state][category] = { 
				"joint" : average_joint, 
				"delta" : average_delta, 
				"categorical" : LGA.is_categorical(average_delta)
			}
	return averages

# Check if the delta matrices have a certain property
def has_property(prop, property_name):
	print property_name
	has = 0
	doesnt_have = 0
	for state in processed:
		for category in processed[state]:
			questions = processed[state][category]
			for q in questions:
				if prop(questions[q]["delta"]):
					has += 1
				else:
					doesnt_have += 1
	return has, doesnt_have
	
def get_score_function(mech):
	if mech == "CA":
		return LGA.expected_01_score
	elif mech == "Kamble":
		return LGA.expected_kamble_score
	elif mech == "RPTS":
		return LGA.expected_rpts_score
	else:
		raise ValueError("Not a valid scoring mechanism")

def get_matrix_type(mech):
	if mech == "CA":
		return "delta"
	elif mech == "Kamble" or mech == "RPTS":
		return "joint"
	else:
		raise ValueError("Not a valid scoring mechanism")

def get_paper_name(mech):
	if mech == "CA":
		return "CAH"
	elif mech == "Kamble":
		return "Kamble"
	elif mech == "RPTS":
		return "RPTS"


# Calculated the expected score if everyone is responding truthfully 
# for a given mechanism.  Calculated over all questions in a data set.
def truthful_scores(mechanism):
	def below_threshold(m, mech):
		r = False 
		threshold = 0.000001
		if mech == "Kamble":
			for i in range(np.shape(m)[0]):
				r = r or (m[i,i] < threshold)
		elif mech == "RPTS":
			marginals = LGA.marg_probs(m)
			for i in range(np.shape(m)[0]):
				r = r or (marginals[0][i] < threshold)
		return r
	matrix_type = get_matrix_type(mechanism)
	scoring = get_score_function(mechanism)

	ys_fac = []
	ys_sub = []
	for state in processed:
		for category in processed[state]:
			questions = processed[state][category]
			for q in questions:
				matrix = questions[q][matrix_type]
				if below_threshold(matrix, mech) and mech != "CA":
					continue
				if questions[q]["q_type"] == "F":
					ys_fac.append((scoring(matrix),(state,category,q)))
				else:
					ys_sub.append((scoring(matrix),(state,category,q)))
	
	# Order the results by average reward (expected score)
	ys_fac.sort()
	ys_sub.sort()
	
	for i in range(-2000,0):
		s,c,q = ys_fac[i][1]
		print s+","+c+","+q,ys_fac[i][0]
		print processed[s][c][q]['joint']
		s,c,q = ys_sub[i][1]
		print s+","+c+","+q,ys_sub[i][0]
		print processed[s][c][q]['joint']
		print "#"*80

	
	xs_fac = [i for i in range(0,len(ys_fac))]
	xs_sub = [i for i in range(0,len(ys_sub))]
	fac_avg = sum(ys_fac) / len(ys_fac)
	sub_avg = sum(ys_sub) / len(ys_sub)
	print "Number of Factual Questions: ", len(ys_fac)
	print "Average Expected Score Factual: ", fac_avg
	print "Number of Subjective Questions: ", len(ys_sub)
	print "Average Expected Score Subjective: ", sub_avg
	print ""

	fig = plt.figure()
	name = 'Expected ' + get_paper_name(mechanism) + ' Payment Given Truthfulness'
	fig.suptitle(name, fontsize = 25)#for ' + state + ", " + category, fontsize=20)
	factual = plt.scatter(xs_fac,ys_fac, color='red')
	subjective = plt.scatter(xs_sub,ys_sub, color='blue')
	plt.legend((factual, subjective), ("Factual", "Subjective"),loc = "lower right", ncol=1)
	plt.xlim([0,10600])
	plt.ylim([0,1])
	plt.ylabel('Expected Payment',fontsize = 20)
	fig.savefig("Graphs/" + name + " " + str(DIMENSION) + ".png") 
	plt.show()

def get_benefit(mech, strat, matrix, p):
	if mech == "Kamble" or mech == "RPTS":
		if start == "truth":
			benefit = ES.true_vs_random(matrix, p, mech)
		elif strat == "random":
			benefit = ES.rand_advantage(matrix, p, mech)
		else:
			benefit = ES.const_advantage(int(strat), matrix, p, mech)
	elif mech == "CA":
		if strat == "truth":
			benefit = ES.true_vs_random_CA(matrix, p)
		elif strat == "random":
			benefit = ES.rand_advantage_CA(matrix, p)
		else:
			benefit = ES.const_advantage_CA(int(strat), matrix, p)
	else:
		raise ValueError("Invalid Mechanism")

	return benefit
	
# Generate a graph that will show the advantage (incentive) gained by adopting either 
# a truthful strategy, random, or constant strategy when p percent of the population
# is responding truthfully and 1 - p percent is adopting a different strategy. 
def gen_graph(mech, matrix, place, category):
	strats = {"truth" : [], "0" : [], "1" : [],  "random":[], "2" : []}

	xs = []
	for p in range(101):
		p = p / 100.0
		for strat, scores in strats.items():
			score = get_benefit(mech, strat, matrix, p)
			scores.append(score)
		xs.append(p)
			
	fig = plt.figure()
	fig.suptitle('Advatage to be truthful using ' + mech + ' for ' + place + ", " + category, fontsize = 20)
	truth = plt.scatter(xs, strats["truth"], color = 'red')
	rand = plt.scatter(xs, strats["random"], color = 'purple')
	const_0 = plt.scatter(xs, strats["0"], color = 'blue')
	const_1 = plt.scatter(xs, strats["1"], color = 'green')
	const_2 = plt.scatter(xs, strats["2"], color = 'yellow')
	plt.legend(( const_0, const_1, rand), ("Const-0", "Const-1", "Random"), loc = "upper left", ncol=1)
	plt.ylabel("Advantage to be Truthful")
	plt.xlabel("Fraction of Truthful Population")
	plt.axhline(y=0, xmin=0, xmax=1, linewidth=2, color = 'k')
	plt.show()

# Determine the average incentives for particular state and business category
def run(file, state, category):
	processed = data_from_json("state_votes", DIMENSION)
	averages = get_averages(processed)
	mechanisms = ["Kamble", "RPTS", "CA"]
	for cat in averages[state]:
		if cat != category:
			continue
		for mech in mechanisms:
			matrix_type = get_matrix_type(mech)
			matrix = averages[state][cat][matrix_type]
			gen_graph(mech, matrix, state, cat)

