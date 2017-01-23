values = {}

def pent(n):
	return int(.5 * n * (3 * n - 1))

def sign(x):
	return (-1) ** (abs(x) - 1)

def p(x):
	if x < 0:
		return 0 
	elif x == 0:
		return 1
	else:
		i = 1
		res = 0
		while x - pent(i) >= 0:
			stored = values.get(x - pent(i))
			if stored != None:
				res = res + sign(i) * stored
			else: 
				res = res + (sign(i) * p(x - pent(i)))
			i *= -1
			if i > 0: 
				i += 1
		values[x] = res
		return res 

i = 0 
#while True:
#	if p(i) % 1000000 == 0:
#		print "Found it!"
#		print i 
#		print p(i)
#		break
#	i += 1
print p(100)
